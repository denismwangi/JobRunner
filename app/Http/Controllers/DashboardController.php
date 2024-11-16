<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

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
}

