@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Log Viewer</h1>

    <!-- Filter Buttons -->
    <div class="flex gap-4 mb-6">
        <a href="{{ route('logs.index', ['level' => 'debug']) }}" class="bg-blue-500 text-white px-3 py-2 rounded">Debug</a>
        <a href="{{ route('logs.index', ['level' => 'info']) }}" class="bg-green-500 text-white px-3 py-2 rounded">Info</a>
        <a href="{{ route('logs.index', ['level' => 'warning']) }}" class="bg-yellow-500 text-white px-3 py-2 rounded">Warning</a>
        <a href="{{ route('logs.index', ['level' => 'error']) }}" class="bg-red-500 text-white px-3 py-2 rounded">Error</a>
    </div>

    <!-- Log Table -->
    <table class="table-auto w-full text-left">
        <thead>
            <tr>
                <th class="px-4 py-2">Time</th>
                <th class="px-4 py-2">Level</th>
                <th class="px-4 py-2">Message</th>
                <th class="px-4 py-2">Context</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr class="@if($log['level'] == 'error') bg-red-100 @elseif($log['level'] == 'warning') bg-yellow-100 @elseif($log['level'] == 'info') bg-blue-100 @else bg-gray-100 @endif">
                    <td class="px-4 py-2">{{ $log['date'] }}</td>
                    <td class="px-4 py-2">{{ ucfirst($log['level']) }}</td>
                    <td class="px-4 py-2">{{ $log['message'] }}</td>
                    <td class="px-4 py-2">{{ json_encode($log['context']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
