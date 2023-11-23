<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class buyOrder extends Model
{
    use HasFactory;

    protected $table = 'buy_order';

    protected $fillable = [
        'buyer_id', 
        'seller_id', 
        'produck_id', 
        'produckName', 
        'produckPrice', 
        'produckImage', 
        'produckColor', 
        'produckPieces', 
        'status'
    ];


    public function buyer()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function addBuyOrder(Request $request)
    {
        try{
            $data = $request->only(['buyer_id', 'seller_id', 'produck_id', 'produckName', 'produckPrice', 'produckImage', 'produckColor', 'produckPieces', 'status']);
            $buyOrder = new buyOrder();
            $buyOrder = buyOrder::create($data);
            $Buyeruser=User::where('id',$request->input('buyer_id'))->first();
            $Buyeruser->balance=$Buyeruser->balance-$request->input('produckPrice');
            $Buyeruser->save();
            $Produck=sellerProduck::where('id',$request->input('produck_id'))->first();
            $Produck->stock=$Produck->stock-$request->input('produckPieces');
            $Produck->save();
            
            if($buyOrder){
                return (object) ['success' => true , 'message' => 'Order Added' ];
            }else{
                return (object) ['success' => false , 'message' => 'Order Not Added'  , 'error' => "Error adding order"];
            }
        }catch(\Exception $e){
            return (object) ['success' => false , 'message' => 'Error adding order'  , 'error' => $e->getMessage()];
        }
    }
    public function updateOrderStatus(Request $request)
    {
        try{
            $id = $request->input('id');
            $status = $request->input('status');
            $buyOrder = DB::table('buy_order')->where('id', $id)->update([
                'status' => $status,
            ]);
            if($buyOrder){
                return (object) ['success' => true , 'message' => 'Order Status Updated' ];
            }else{
                return (object) ['success' => false , 'message' => 'Order Status Not Updated'  , 'error' => "Error updating order status"];
            }
        }catch(\Exception $e){
            return (object) ['success' => false , 'message' => 'Error updating order status'  , 'error' => $e->getMessage()];
        }
    }
}
