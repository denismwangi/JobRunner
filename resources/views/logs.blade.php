@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
   @include('includes.sidenav')
    <div class="h-screen flex-grow-1 overflow-y-lg-auto">
        <header class="bg-surface-primary border-bottom pt-6">
            <div class="container-fluid">
                <div class="mb-npx">
                    <div class="row align-items-center">
                        <div class="col-sm-6 col-12 mb-4 mb-sm-0">
                            <h1 class="h2 mb-0 ls-tight">Logs</h1>
                        </div>
                    </div>
                
                </div>
            </div>
        </header>
        <main class="py-6 bg-surface-secondary">
            <div class="container-fluid">
                <div class="card shadow border-0 mb-7 m-5">
                    <div class="card-header">
                        <h5 class="mb-0">Log Entries</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Level</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Env</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td>{{ $log['level'] }}</td>
                                        <td>{{ $log['time'] }}</td>
                                        <td>{{ $log['env'] }}</td>
                                        <td>{{ $log['description'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer border-0 py-5">
                        <span class="text-muted text-sm">Showing {{ count($logs) }} log entries</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
