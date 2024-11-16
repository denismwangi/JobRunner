<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Job;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $logFiles = File::files(storage_path('logs'));

        $logs = [];
        foreach ($logFiles as $file) {
            $logs = array_merge($logs, $this->parseLogFile($file->getRealPath()));
        }

        if ($request->has('level')) {
            $level = $request->input('level');
            $logs = array_filter($logs, fn($log) => $log['level'] === $level);
        }

        return view('index', ['logs' => $logs]);
    }

    private function parseLogFile($filePath)
    {
        $logs = [];
        $content = File::get($filePath);

        preg_match_all('/\[(.*?)\] (.*?): (.*?)(\n|\Z)/s', $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $logs[] = [
                'date' => $match[1],
                'level' => strtolower($match[2]),
                'message' => $match[3],
                'context' => $this->extractContext($match[3])
            ];
        }

        return $logs;
    }

    private function extractContext($message)
    {
        $context = [];
        if (preg_match('/\{(.*)\}/', $message, $contextMatch)) {
            $context = json_decode($contextMatch[1], true);
        }
        return $context;
    }

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

}

