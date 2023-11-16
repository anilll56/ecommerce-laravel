<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\buyOrder;
use Illuminate\Support\Facades\DB;

class buyOrderController extends Controller
{
    public function addBuyOrder(Request $request){
        $produckId = $request->input('produckId');
        $buyOrderModal = new buyOrder();
        $response = $buyOrderModal->addBuyOrder($request);
        if($response->success){
            return response()->json([
                'success' => true,
                'message' => 'Order Added',
            ], 200);

        DB::table('seller_produck')->where('id', $produckId)->decrement('stock', $request->input('produckPieces'));

        }else{
            return response()->json([
                'success' => false,
                'message' => 'Order Not Added',
                "error" => $response->error
            ], 401);
        }
    }
}
