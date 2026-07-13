<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SitemapController;
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

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/play', [PlayController::class, 'index'])->name('play.index');
Route::get('/play/download/{id}', [PlayController::class, 'download'])->name('play.download');
Route::post('/play/track/{id}', [PlayController::class, 'track'])->name('play.track');

Route::get('/schedule', [ScheduleController::class, 'getWeek']);

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// Перехватчик постов по слагу (СТРОГО В САМОМ НИЗУ)
Route::get('/{slug}', [PostController::class, 'show'])->where('slug', '.*');

require __DIR__.'/auth.php';
