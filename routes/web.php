<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Index::class)->name('dashboard');

Route::prefix('client')
    ->name('client.')
    ->group(function () {
        Route::get('/', \App\Livewire\Clients\ListClient::class)->name('index');
        Route::get('/create', \App\Livewire\Clients\CreateClient::class)->name('create');
        Route::get('/edit/{client}', \App\Livewire\Clients\UpdateClient::class)->name('edit');
    });

Route::prefix('vendors')
    ->name('vendor.')
    ->group(function () {
        Route::get('/', \App\Livewire\Vendors\ListVendor::class)->name('index');
        Route::get('/create', \App\Livewire\Vendors\CreateVendor::class)->name('create');
        Route::get('/edit/{vendor}', \App\Livewire\Vendors\UpdateVendor::class)->name('edit');
    });

Route::prefix('project')
    ->name('project.')
    ->group(function () {
        Route::get('/', \App\Livewire\Project\ListProject::class)->name('index');
        Route::get('/create', \App\Livewire\Project\CreateProject::class)->name('create');
        Route::prefix('/{project}')
            ->name('show.')
            ->group(function () {
                Route::get('/', \App\Livewire\Project\ShowProject::class)->name('dashboard');
                Route::prefix('/cashflows')
                    ->name('cashflow.')
                    ->group(function () {
                        Route::get('/', \App\Livewire\Project\Cashflows\ListCashflow::class)->name('index');
                        Route::get('/create', \App\Livewire\Project\Cashflows\CreateCashflow::class)->name('create');
                        Route::get('/update', \App\Livewire\Project\Cashflows\UpdateCashflow::class)->name('update');
                    });
            });
        Route::get('/create-rab/job-detail/{job_detail}/vendor/{vendor}/{readonly?}', \App\Livewire\Rab\CreateRab::class)->name('rab');
    });

Route::get('/report-rab/{project}/vendor/{vendor}', [\App\Http\Controllers\ExportController::class, 'RabExport'])->name('report');
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
