<?php


use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Log;

if (!function_exists('runBackgroundJob')) {
    function runBackgroundJob($className, $methodName, $params = [], $retryAttempts = 3) {
        $paramsString = implode(' ', array_map('escapeshellarg', $params));
        $command = PHP_BINARY . " " . base_path('background_job_runner.php') . " $className $methodName $paramsString";

        if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
            $process = new Process(["cmd", "/c", "start", "/B", $command]);
        } else {
            $process = new Process([$command]);
            $process->setTty(false);
        }

        for ($attempt = 0; $attempt < $retryAttempts; $attempt++) {
            try {
                $process->start();
                Log::info("Started job: $className::$methodName");
                return true;
            } catch (\Exception $e) {
                Log::error("Failed to start job: {$e->getMessage()}");
                if ($attempt === $retryAttempts - 1) {
                    Log::error("Max retry attempts reached for job: $className::$methodName");
                    return false;
                }
            }
        }
    }
}
