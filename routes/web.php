<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::post('/store-quiz-test-data',[QuizController::class,'storeQuizTestData'])->middleware('auth');
Route::get('/show-cv-link/{file}', [HomeController::class, 'showCvLink'])->middleware('auth');

Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function () {
    // Route::get('user-edit/{user}',[UserController::class,'editUser'])->name('user-edit');
    Route::resource('users', UserController::class);
    Route::get('dashboard',[DashboardController::class,'index']);
    Route::resource('quizzes', QuizController::class);
    
    
});