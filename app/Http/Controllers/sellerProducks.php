<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\sellerProduck; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class sellerProducks extends Controller
{
    public function addProduck(Request $request)
    {
        $name = $request->input('name');
        $sellerId = $request->input('sellerId');
        $stock = $request->input('stock');
        $price = $request->input('price');
        $colors = $request->input('colors');
        $pruduckImage = $request->input('pruduckImage');
            $sellerProduck = DB::table('sellers_producks')->insert([
                'name' => $name,
                'sellerId' => $sellerId,
                'stock' => $stock,
                'price' => $price,
                'colors' => $colors,
                'pruduckImage' => $pruduckImage,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Produck Added',
            ], 200);
             if($sellerProduck){
                 return response()->json([
                     'success' => true,
                     'message' => 'Produck Added',
                 ], 200);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Produck Not Added',
                    ], 401);
                }
        
    }


    public function addProduck2222(Request $request){
        $produckModal = new sellerProduck();

        $response = $produckModal->addProduck($request);
        if($response->success){
            return response()->json([
                'success' => true,
                'message' => $response->message,
                "sellerProduck" => $response->sellerProduck
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => $response->message,
                "error" => $response->error
            ], 401);
        }

    }

    public function getProduckByEmail(Request $request)
    {
        $sellerEmail = $request->input('sellerEmail');
        $sellerProduck = DB::table('sellers_producks')->where('sellerEmail', $sellerEmail)->get();
        if ($sellerProduck) {
            return response()->json([
                'success' => true,
                'message' => 'Produck Found',
                'sellerProduck' => $sellerProduck
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Produck Not Found',
            ], 401);
        }
    }
    public function deleteProduck(Request $request)
    {
        $id = $request->input('id');
        $sellerProduck = DB::table('sellerProduck')->where('id', $id)->delete();
        if ($sellerProduck) {
            return response()->json([
                'success' => true,
                'message' => 'Produck Deleted',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Produck Not Found',
            ], 401);
        }
    }

    public function updateProduck(Request $request){
        $produckModal = new sellerProduck();
        $response = $produckModal->updateProduck($request);
        if($response->success){
            return response()->json([
                'success' => true,
                'message' => $response->message,
                "sellerProduck" => $response->sellerProduck
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => $response->message,
                "error" => $response->error
            ], 401);
        }
    }

    public function buyProduck(Request $request)
    {
        $id = $request->input('id');
        $buyerEmail = $request->input('buyerEmail');
        $sellerEmail = $request->input('sellerEmail');
        $produckName = $request->input('produckName');
        $stock = $request->input('stock');
        $price = $request->input('price');
        $colors = $request->input('colors');
        $pruduckImage = $request->input('pruduckImage');
            $addProduck= DB::table('buy_order')->insert([
                'name' => $produckName->name,
                'buyerEmail' => $buyerEmail,
                'sellerEmail' => $sellerEmail,
                'stock' => $stock,
                'price' => $price,
                'colors' => $colors,
                'pruduckImage' => $pruduckImage,
            ]);
            if ($addProduck) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produck successfully Added',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Produck Not Added',
                ], 401);
            }
    }
}
