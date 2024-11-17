<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

$app->make(Kernel::class)->bootstrap();

$className = $argv[1] ?? null;
$methodName = $argv[2] ?? null;
$params = json_decode($argv[3] ?? '[]', true);
$maxRetries = 3;
$retryDelay = 5;
$priority = $argv[4] ?? null; // Optional priority passed as argument

// Allowed jobs
$allowedJobs = [
    'App\Jobs\TestJob' => ['execute'], // test class and function
    'App\Http\Controllers\JobTestController' => ['secondTest'],
    'App\Http\Controllers\JobTestController' => ['functTest'],
];

function isAllowedJob(string $className, string $methodName, array $allowedJobs): bool
{
    return isset($allowedJobs[$className]) && in_array($methodName, $allowedJobs[$className]);
}

if (!isAllowedJob($className, $methodName, $allowedJobs)) {
    Log::channel('background_jobs_errors')->error("Unauthorized class or method: $className::$methodName");
    exit(1);
}

if (!class_exists($className)) {
    Log::channel('background_jobs_errors')->error("Class $className does not exist.");
    exit(1);
}

$job = new $className(...$params);
if (!method_exists($job, $methodName)) {
    Log::channel('background_jobs_errors')->error("Method $methodName does not exist in $className.");
    exit(1);
}

$jobId = DB::table('jobs')->insertGetId([
    'class_name' => $className,
    'method_name' => $methodName,
    'params' => json_encode($params),
    'priority' => $priority,
    'status' => 'running',
]);

$attempts = 0;

do {
    $attempts++;
    Log::info("Job $className::$methodName is running. Attempt: $attempts", [
        'parameters' => $params,
    ]);

    try {
        call_user_func([$job, $methodName]);

        DB::table('jobs')->where('id', $jobId)->update([
            'status' => 'completed',
            'retry_count' => $attempts,
            'updated_at' => now(),
        ]);

        Log::info("Job $className::$methodName executed successfully with parameters: " . json_encode($params));
        exit(0);
    } catch (Exception $e) {
        Log::channel('background_jobs_errors')->error("Job execution error: " . $e->getMessage(), [
            'class' => $className,
            'method' => $methodName,
            'parameters' => $params,
        ]);

        DB::table('jobs')->where('id', $jobId)->update([
            'retry_count' => $attempts,
            'updated_at' => now(),
        ]);

        if ($attempts < $maxRetries) {
            Log::info("Job $className::$methodName failed. Retrying in $retryDelay seconds...");
            sleep($retryDelay);
        } else {
            DB::table('jobs')->where('id', $jobId)->update([
                'status' => 'failed',
                'updated_at' => now(),
            ]);
            Log::error("Job $className::$methodName failed after $maxRetries attempts.");
            exit(1);
        }
    }
} while ($attempts < $maxRetries);

