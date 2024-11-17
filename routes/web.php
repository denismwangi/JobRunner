<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobTestController;
use App\Http\Controllers\DashboardController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-job', [JobTestController::class, 'testJob'])->name('job.test');
Route::get('/logs', [DashboardController::class, 'index'])->name('logs.index');
Route::get('/secondTest', [JobTestController::class, 'secondTest'])->name('logs.functTest');
Route::get('/', [DashboardController::class, 'showJobs'])->name('jobs.index');
Route::get('jobs', [DashboardController::class, 'allJobs'])->name('jobs.all');
Route::get('logs', [DashboardController::class, 'allLogs'])->name('logs.all');




