<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\sellerProducks;
use App\Http\Controllers\buyOrderController;
use App\Models\sellerProduck;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post("/register", [UserController::class, 'userRegister']);
Route::post("/login", [UserController::class, 'userLogin']);
Route::post("/changePassword", [UserController::class, 'changePassword']);
Route::post("/addProduck", [sellerProducks::class, 'addProduck']);
Route::post("/updateProduck", [sellerProducks::class, 'updateProduck']);
Route::post("/getUserProducts", [UserController::class, 'getUserProducts']);
Route::post("/updateUser", [UserController::class, 'updateUser']);
Route::post("/addBuyOrder", [buyOrderController::class, 'addBuyOrder']);
Route::post("/getSellerOrders", [UserController::class, 'getSellerOrders']);
Route::post("/getBuyerOrders", [UserController::class, 'getBuyerOrders']);
Route::get("/getAllProduck", [sellerProduck::class, 'getAllProduck']);
Route::post("/deleteProduck", [sellerProducks::class, 'deleteProduck']);
Route::post("/updateOrderStatus", [buyOrderController::class, 'updateOrderStatus']);
