<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;
use Exception;

class TestJob
{
    protected $param1;
    protected $param2;

    public function __construct($param1, $param2)
    {
        $this->param1 = $param1;
        $this->param2 = $param2;
    }

    public function execute()
    {
        try {
            Log::info("TestJob is running with parameters: {$this->param1} and {$this->param2}");

            // Perform a simple operation
            $result = $this->param1 + $this->param2;
            Log::info("TestJob result: {$result}");

            return $result;
        } catch (Exception $e) {
            Log::error("TestJob failed: " . $e->getMessage());
            throw $e;
        }
    }
}
