<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(SettingController::class)->group(function(){
  Route::get('/setting/{setting?}', 'index')->middleware('auth')->name('setting');
  Route::put('/setting/{user}/update', 'update')->middleware('auth');
  Route::post('/user/token/change', 'setToken')->middleware('auth');
});

Route::get('/about', function(){return view('components.about.index');});

Route::controller(PostController::class)->group(function () {  
  Route::post('/post/search', 'search')->middleware('auth');
  Route::get('/post','index');
  Route::get('/mypost', 'myindex')->middleware('auth')->name('mypostindex');
  Route::get('/post/create', 'create')->middleware('auth');
  Route::get('/post/show/{uuid}', 'show'); 
  Route::post('/post/store', 'store')->middleware('auth');
  Route::post('/post/delete', 'delete')->middleware('auth'); 
  Route::post('/post/rate', 'setRatingValue');
});

Route::controller(CommentController::class)->group(function(){
  Route::post('comment/{post}/push', 'store')->middleware('auth');
  Route::get('/comment/{comment}/delete', 'destroy')->middleware('auth');

  Route::get('/more_comment', 'more_comment');
  Route::get('/load_view', 'load_view');
});

require __DIR__.'/auth.php';



// TIDAK DIPAKAI
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('test', function(){
  return view('test', [
    'par' => asset('storage/ferdisap.jpg'),
  ]);
});