<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    
    public function UserLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $userType = $request->input('userType');
        $user = DB::table('users')->where('email', $email)->first();
        if ($user) {
            if ($user->password == $password && $user->userType == $userType) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login Successful',
                    'user' => $user
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Credentials',
                ], 401);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials',
            ], 401);
        }   
    }

    public function UserLogin3333(Request $request)
    {
        $userModal = new User();
        $response = $userModal->userLogin($request);
        if ($response->success) {
            return response()->json([
                'success' => true,
                'message' => 'Login Successful',
                'user' => $response->user
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => $response->error,
            ], 401);
        }
    }

    public function userRegister(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $userType = $request->input('userType');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $balance = $request->input('balance');
        $user = DB::table('users')->where('email', $email)->first();
        if ($user) {
            return response()->json([
                'success' => false,
                'message' => 'Email already exists',
            ], 401);
        } else {
            if ($userType == "buyer") {
                $user = DB::table('users')->insert([
                    'name' => $name,
                    'email' => $email,
                    'userType' => $userType,
                    'password' => Hash::make($password),
                    'address' => $address,
                    'phone' => $phone,
                    'balance' => $balance,
                ]);
            } else {
                $user = DB::table('users')->insert([
                    'name' => $name,
                    'email' => $email,
                    'userType' => $userType,
                    'password' => Hash::make($password),
                ]);
            }
            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registration Successful',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration Failed',
                ], 401);
            }
        }
    }
    function UserRegister111(Request $request)
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
}
