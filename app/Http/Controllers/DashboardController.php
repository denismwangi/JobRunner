<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Job;


class DashboardController extends Controller
{
    public function showJobs(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Job::query();

        if ($status === 'active') {
            $query->where('status', 'scheduled');
        } elseif ($status === 'completed') {
            $query->where('status', 'completed');
        } elseif ($status === 'failed') {
            $query->where('status', 'failed');
        }

        $jobs = $query->paginate(10);

        $allJobsCount = Job::count();
        $activeJobsCount = Job::where('status', 'scheduled')->count();
        $completedJobsCount = Job::where('status', 'completed')->count();
        $failedJobsCount = Job::where('status', 'failed')->count();

        return view('index', compact('jobs', 'allJobsCount', 'activeJobsCount', 'completedJobsCount', 'failedJobsCount'));
    }

    public function allJobs(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Job::query();

        if ($status === 'active') {
            $query->where('status', 'scheduled');
        } elseif ($status === 'completed') {
            $query->where('status', 'completed');
        } elseif ($status === 'failed') {
            $query->where('status', 'failed');
        }

        $jobs = $query->paginate(10);
        return view('jobs', compact('jobs'));
    }



    public function allLogs(Request $request)
    {
        $status = $request->get('status', 'all');
        $logs = [];

        $logFilePath = storage_path('logs/laravel.log');

        if (File::exists($logFilePath)) {
            $logContents = File::get($logFilePath);
            $logLines = explode("\n", $logContents);

            foreach ($logLines as $line) {
                if (empty($line)) {
                    continue;
                }

                preg_match('/\[(.*?)\] (.*?): (.*)/', $line, $matches);
                if (count($matches) === 4) {
                    $time = $matches[1];
                    $level = $matches[2];
                    $description = $matches[3];

                    $env = app()->environment();

                    if ($status === 'error' && strtolower($level) !== 'error') {
                        continue;
                    }

                    $logs[] = [
                        'level' => $level,
                        'time' => $time,
                        'env' => $env,
                        'description' => $description,
                    ];
                }
            }
        }

        return view('logs', compact('logs'));
    }


}

