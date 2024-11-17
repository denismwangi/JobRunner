<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class JobTestController extends Controller
{
    public function testJob()
    {
        Log::info("Started TestJob is running with parameters");

        runBackgroundJob("App\Jobs\TestJob", 'execute', [10, 1]);

        return response()->json(['status' => 'Job dispatched successfully']);
    }

    public function secondTest(){
        Log::info("Started TestJob is running with parameters");
        runBackgroundJob("App\Http\Controllers\JobTestController", 'functTest', ["john", "hello","How are you you"]);
        return response()->json(['status' => 'Job dispatched successfully']);
    }

    public function functTest($params){
        Log::info("Started TestJob is running with parameters");
        Log::info($params);
        return response()->json(['status' => 'Job dispatched successfully']);


    }
}
