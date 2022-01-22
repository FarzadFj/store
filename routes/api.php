<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// User
Route::post('/register',[UserController::class,'register']);

Route::post('/login',[UserController::class,'login']);

Route::put('/dashboard/{id}',[UserController::class,'update_dashboard'])->middleware('user_check');

// Admin
Route::post('/admin/login',[AdminController::class,'login']);

Route::get('/admin/users',[AdminController::class,'show_users'])->middleware('admin_check');

Route::get('/admin/users_pagination',[AdminController::class,'get_users'])->middleware('admin_check');

Route::put('/admin/user_profile/{id}',[AdminController::class,'update_user_profile'])->middleware('admin_check');

// Product
Route::get('/admin/home',[ProductController::class,'show_products']);

Route::post('/admin/add_product',[ProductController::class,'add_product']);

Route::put('/admin/update_product',[ProductController::class,'update_product']);

Route::delete('/admin/delete_product',[ProductController::class,'delete_product']);









