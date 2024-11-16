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
                            <h1 class="h2 mb-0 ls-tight">Jobs</h1>
                        </div>

                    </div>
                    <ul class="nav nav-tabs mt-4 overflow-x border-0">
                        <li class="nav-item">
                            <a href="{{ route('jobs.all', ['status' => 'all']) }}" class="nav-link {{ request('status') == 'all' ? 'active' : '' }}">All Jobs</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('jobs.all', ['status' => 'active']) }}" class="nav-link {{ request('status') == 'active' ? 'active' : '' }}">Active</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('jobs.all', ['status' => 'completed']) }}" class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}">Completed</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('jobs.all', ['status' => 'failed']) }}" class="nav-link {{ request('status ') == 'failed' ? 'active' : '' }}">Failed</a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <main class="py-6 bg-surface-secondary">
            <div class="container-fluid">

                <div class="card shadow border-0 mb-7 m-5">
                    <div class="card-header">
                        <h5 class="mb-0">Jobs</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Class Name</th>
                                    <th scope="col">Method</th>
                                    <th scope="col">Number Retries</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobs as $job)
                                    <tr>
                                        <td>{{ $job->class_name }}</td>
                                        <td>{{ $job->method_name }}</td>
                                        <td>{{ $job->retry_count }}</td>
                                        <td>
                                            @if($job->status == 'scheduled')
                                                <span class="badge badge-lg badge-dot"><i class="bg-success"></i> Scheduled</span>
                                            @elseif($job->status == 'completed')
                                                <span class="badge badge-lg badge-dot"><i class="bg-info"></i> Completed</span>
                                            @elseif($job->status == 'failed')
                                                <span class="badge badge-lg badge-dot"><i class="bg-danger"></i> Failed</span>
                                            @else
                                                <span class="badge badge-lg badge-dot"><i class="bg-warning"></i> Pending</span>
                                            @endif
                                        </td>
                                        <td class="">
                                            <a href="#" class="btn btn-sm btn-neutral">Retry</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer border-0 py-5">
                        <span class="text-muted text-sm">Showing {{ $jobs->count() }} items out of {{ $jobs->total() }} results found</span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection