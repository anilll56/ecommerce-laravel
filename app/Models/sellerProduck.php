<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class sellerProduck extends Model
{
    use HasFactory;

    protected $table = 'seller_produck';

    protected $fillable = [
        'name',
        'seller_id',
        'stock',
        'price',
        'colors',
        'pruduckImage',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function addProduck(Request $request)
    {
        try {
            $data = $request->only(['name', 'seller_id', 'stock', 'price', 'colors', 'pruduckImage']);
             $sellerProduck = new sellerProduck();
             $sellerProduck = sellerProduck::create($data);

            if ($sellerProduck) {
                return (object) ['success' => true, 'message' => 'Product Added', 'sellerProduck' => $sellerProduck];
            } else {
                return (object) ['success' => false, 'message' => 'Product Not Added'];
            }
        } catch (\Exception $e) {
            return (object) ['success' => false, 'message' => 'Error adding product'  , 'error' => $e->getMessage()];
        }
    }

    public function updateProduck(Request $request)
    {
        try {
            $id = $request->input('id');
            $name = $request->input('name');
            $sellerId = $request->input('sellerId');
            $stock = $request->input('stock');
            $price = $request->input('price');
            $colors = $request->input('colors');
            $pruduckImage = $request->input('pruduckImage');
            $data=[];
            if(!empty($name)){
                $data['name'] = $name;
            }
            if(!empty($sellerId)){
                $data['sellerId'] = $sellerId;
            }
            if(!empty($stock)){
                $data['stock'] = $stock;
            }
            if(!empty($price)){
                $data['price'] = $price;
            }
            if(!empty($colors)){
                $data['colors'] = $colors;
            }
            if(!empty($pruduckImage)){
                $data['pruduckImage'] = $pruduckImage;
            }
            $sellerProduck = DB::table('seller_produck')->where('id', $id)->update($data);
            if ($sellerProduck) {
                return (object) ['success' => true, 'message' => 'Product Updated', 'sellerProduck' => $sellerProduck];
            } else {
                return (object) ['success' => false, 'message' => 'Product Cant Find' , 'error' => "Error updating product" ];
            }
        } catch (\Exception $e) {
            return (object) ['success' => false, 'message' => 'Error updating product'  , 'error' => $e->getMessage()];
        }
    }

    public function getAllProduck()
    {
        try {
            $sellerProduck = DB::table('seller_produck')->get();
            if ($sellerProduck) {
                return (object) ['success' => true, 'message' => 'Product Found', 'sellerProduck' => $sellerProduck];
            } else {
                return (object) ['success' => false, 'message' => 'Product Not Found'];
            }
        } catch (\Exception $e) {
            return (object) ['success' => false, 'message' => 'Error getting product'  , 'error' => $e->getMessage()];
        }
    }

}
