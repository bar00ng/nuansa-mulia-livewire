<?php

use App\Livewire\Clients\{
    ListClient,
    CreateClient
};
use Illuminate\Support\Facades\Route;

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
    return view('app');
});

Route::prefix('client')
    ->name('client.')
    ->group(function () {
        Route::get('/', ListClient::class)
            ->name('index');
        Route::get('/create', CreateClient::class)
            ->name('create');
    });

    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);