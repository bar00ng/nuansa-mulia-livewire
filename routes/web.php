<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Index::class)
    ->name('dashboard');

Route::prefix('client')
    ->name('client.')
    ->group(function() {
        Route::get('/', \App\Livewire\Clients\ListClient::class)
            ->name('index');
        Route::get('/create', \App\Livewire\Clients\CreateClient::class)
            ->name('create');
        Route::get('/edit/{client:uuid}', \App\Livewire\Clients\UpdateClient::class)
            ->name('edit');
    });

Route::prefix('vendors')
    ->name('vendor.')
    ->group(function() {
        Route::get('/', \App\Livewire\Vendors\ListVendor::class)
            ->name('index');
        Route::get('/create', \App\Livewire\Vendors\CreateVendor::class)
            ->name('create');
        Route::get('/edit/{vendor:uuid}', \App\Livewire\Vendors\UpdateVendor::class)
            ->name('edit');
    });

Route::prefix('project')
    ->name('project.')
    ->group(function() {
        Route::get('/', \App\Livewire\Project\ListProject::class)
            ->name('index');
        Route::get('/create', \App\Livewire\Project\CreateProject::class)
            ->name('create');
        Route::get('/{project:uuid}', \App\Livewire\Project\ShowProject::class)
            ->name('show');
        Route::get('/{job_detail:uuid}/{vendor:uuid}/{readonly?}', \App\Livewire\Rab\CreateRab::class)
            ->name('rab');
    });

Route::get('rab-export', [\App\Http\Controllers\Exports\Rab::class, 'index']);
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
