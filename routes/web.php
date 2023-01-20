<?php

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
});

Route::get('/about', function(){return view('components.about.index');});

Route::controller(PostController::class)->group(function () {
  Route::get('/post','index');
  Route::get('/mypost', 'myindex')->middleware('auth');
  Route::get('/post/{uuid}', 'show');
  Route::get('/post/create', 'create')->middleware('auth');
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
  // dd('foo');
  // asset('storage/ferdisap.jpg');
  return view('test', [
    'par' => asset('storage/ferdisap.jpg'),
  ]);
});