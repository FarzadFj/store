<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

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


Route::get('/home',[ProductController::class,'show_products']);

// User
Route::post('/register',[UserController::class,'register']);

Route::post('/login',[UserController::class,'login']);

Route::put('/dashboard/{id}',[UserController::class,'update_dashboard'])->middleware('auth:api');

// Admin
Route::post('/admin/login',[AdminController::class,'login']);

Route::get('/admin/users',[AdminController::class,'show_users'])->middleware('auth:api');

Route::get('/admin/users_pagination',[AdminController::class,'get_users'])->middleware('admin_check');

Route::put('/admin/user_profile/{id}',[UserController::class,'admin_update_user_profile']);

// Product
Route::post('/admin/add_product',[ProductController::class,'add_product']);

Route::put('/admin/update_product/{id}',[ProductController::class,'update_product']);

Route::delete('/admin/delete_product/{id}',[ProductController::class,'delete_product']);

Route::post('/filter_product/{data}',[ProductController::class,'filter_product']);

//cart
Route::get('/cart',[CartController::class,'show_cart'])->middleware('auth:api');

Route::post('/add_to_cart/{id}',[CartController::class,'add_to_cart'])->middleware('auth:api');

Route::delete('/delete_from_cart/{id}',[CartController::class,'delete_from_cart'])->middleware('auth:api');










