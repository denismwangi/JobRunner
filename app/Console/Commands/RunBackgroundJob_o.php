<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\TestJob;
use Illuminate\Support\Facades\Log;


class RunBackgroundJob extends Command
{
    protected $signature = 'custom:background-job {className} {method} {parameters}';
    protected $description = 'Run a custom background job';

    public function handle()
    {
        $className = $this->argument('className');
        $method = $this->argument('method');
        $parameters = json_decode($this->argument('parameters'), true);

        try {
            $job = new $className(...$parameters);
            if (!method_exists($job, $method)) {
                throw new \Exception("Method {$method} does not exist in class {$className}.");
            }

            call_user_func_array([$job, $method], $parameters);

            $this->info("Job executed successfully: {$className}@{$method}");
            Log::info("Job executed successfully: {$className}@{$method}");

        } catch (\Exception $e) {
            $this->error("Job execution failed: {$e->getMessage()}");
        }
    }
}

