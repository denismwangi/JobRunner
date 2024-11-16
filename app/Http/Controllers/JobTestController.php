<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class JobTestController extends Controller
{
    public function testJob()
    {
        Log::info("Started TestJob is running with parameters");

        runBackgroundJob("App\Jobs\TestJob", 'execute', [10, k]);

        return response()->json(['status' => 'Job dispatched successfully']);
    }
}
