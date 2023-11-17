<?php

use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::resource('downloads', DownloadController::class);
    Route::get('downloads/{download}/info', [DownloadController::class, 'info'])->name('downloads.info');
    Route::get('downloads/{download}/thumbnail/{quality}', [DownloadController::class, 'thumbnail'])->name('downloads.thumbnail');
    Route::get('downloads/{download}/stream', [DownloadController::class, 'stream'])->name('downloads.stream');
});

Auth::routes();

Route::get(RouteServiceProvider::HOME, [HomeController::class, 'index'])->name('home');
