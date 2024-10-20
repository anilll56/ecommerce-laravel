<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Facades\JWTAuth; 
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    public function UserLogin(Request $request)
    {
        // Kullanıcı giriş bilgilerini doğrulayın
        $credentials = $request->only('email', 'password');

        // Eğer giriş bilgileri doğruysa, JWT token oluşturulacak
        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid login credentials',
            ], 401);
        }
        return response()->json([
            'success' => true,
            'message' => 'Login Successful',
            'user' => Auth::user(),
            'token' => $token, // JWT Token buraya ekleniyor
        ], 200);
    }
    public function getUserInfo()
    {
        $user = new User();
        return $user->userInfo();
    }
    function UserRegister(Request $request)
    {
        $userModal = new User();
        $response = $userModal->addUser($request);
    
        
        if ($response->success) {
            
            return response()->json([
                'success' => true,
                'message' => 'User registered successfully.',
            ], 200);
        } else {
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to register user.',
                "error" => $response->error
            ], 401);
        }
    }
    
    public function getUserProducts (Request $request) {
        $userId = $request->input('userId');
        {
        $user = User::find($userId);
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        $products = $user->products()->get();
    
        return response()->json($products);
    }
}
    public function getSellerOrders (Request $request) {
        $userId = $request->input('userId');
        {
        $user = User::find($userId);
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        $orders = $user->sellerOrders()->get();
    
        return response()->json($orders);
    }
}
    public function getBuyerOrders (Request $request) {
        $userId = $request->input('userId');
        {
        $user = User::find($userId);
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        $orders = $user->buyerOrders()->get();
    
        return response()->json($orders);
    }
}
    public function UpdateUser(Request $request){
        $userModal = new User();
        $response = $userModal->updateUser($request);
        if($response->success){
            return response()->json([
                'success' => true,
                'message' => 'User Updated',
                "user" => $response->user
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User Not Updated',
                "error" => $response->error
            ], 401);
        }
        
    }

    public function findUser(Request $request)
    {
        $email = $request->input('email');
        $user = DB::table('users')->where('email', $email)->first();
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User Found',
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User Not Found',
            ], 401);
        }
    }
    public function changePassword(Request $request)
    {
        $userModal = new User();
        $response = $userModal->changePassword($request);
        if($response->success){
            return response()->json([
                'success' => true,
                'message' => 'Password Changed',
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Password Not Changed',
                "error" => $response->error
            ], 401);
        }
    }
}
