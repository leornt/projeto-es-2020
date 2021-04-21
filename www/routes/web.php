<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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

Auth::routes();

Route::redirect('/', '/budget/')->middleware('auth');
Route::get('/budget/{date?}', [DashboardController::class, 'index'])->middleware('auth');
Route::post('/budget/{date}', [DashboardController::class, 'save'])->middleware('auth');
Route::delete('/budget/{date}', [DashboardController::class, 'delete'])->middleware('auth');
