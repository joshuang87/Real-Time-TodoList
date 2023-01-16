<?php

use App\Models\Item;
use App\Events\ItemPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemsController;
use App\Models\User;

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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/todoList',[ItemsController::class,'index'])->name('index');

Route::get('/fetchItem',[ItemsController::class,'fetchItems'])->name('fetchItems');

Route::post('/postItem',[ItemsController::class,'postItem'])->name('postItem');

Route::delete('/deleteItem/{id}',[ItemsController::class,'deleteItem'])->name('deleteItem');

// Route::get('/test',function(){
//     dd(Item::with('user')->where('user_id',Auth::id())->get());
// });
