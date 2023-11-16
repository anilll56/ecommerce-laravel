<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\sellerProducks;
use App\Http\Controllers\buyOrderController;

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



Route::post("/register", [UserController::class, 'userRegister111']);
Route::post("/login", [UserController::class, 'userLogin3333']);
Route::post("/addProduck", [sellerProducks::class, 'addProduck2222']);
Route::post("/updateProduck", [sellerProducks::class, 'updateProduck']);
Route::post("/getUserProducts", [UserController::class, 'getUserProducts']);

Route::post("/addBuyOrder", [buyOrderController::class, 'addBuyOrder']);
Route::post("/getSellerOrders", [UserController::class, 'getSellerOrders']);
Route::post("/getBuyerOrders", [UserController::class, 'getBuyerOrders']);
