<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::resource('index', PostController::class);
// Route::get('index/search/{subject}',[PostController::class,'search']);

//Public Routes
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::get('/index', [PostController::class,'index']);
Route::get('/index/{id}', [PostController::class,'show']);



//Protected Routes
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::get('/index/search/{subject}',[PostController::class,'search']);
    Route::post('/index',[PostController::class,'store']);   
    Route::put('/index/{id}',[PostController::class,'update']);
    Route::delete('/index/{id}',[PostController::class,'destroy']);
    Route::post('/logout',[AuthController::class,'logout']);
});