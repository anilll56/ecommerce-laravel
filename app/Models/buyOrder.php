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
        'buyerId',
        'sellerId',
        'sellerPhone',
        'produckName',
        'produckPrice',
        'produckImage',
        'produckColor',
        'produckPieces',
        'status',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyerId');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'sellerId');
    }

    public function addBuyOrder(Request $request)
    {
        try{
            $buyOrder = DB::table('buy_order')->insert([
                'buyerId' => $request->input('buyerId'),
                'sellerId' => $request->input('sellerId'),
                'produckId' => $request->input('produckId'),
                'produckName' => $request->input('produckName'),
                'produckPrice' => $request->input('produckPrice'),
                'produckImage' => $request->input('produckImage'),
                'produckColor' => $request->input('produckColor'),
                'produckPieces' => $request->input('produckPieces'),
                'status' => $request->input('status'),
            ]);
            $Buyeruser=User::where('id',$request->input('buyerId'))->first();
            $Buyeruser->balance=$Buyeruser->balance-$request->input('produckPrice');
            $Buyeruser->save();
            $Produck=sellerProduck::where('id',$request->input('produckId'))->first();
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
}
