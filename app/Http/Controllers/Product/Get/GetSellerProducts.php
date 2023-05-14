<?php

namespace App\Http\Controllers\Product\Get;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetSellerProducts extends Controller
{
    public function __invoke(){
        $user_id = Auth::id();
        $products = Product::all()->where('seller_id', $user_id)->where('buyer_id', null)->values();

        foreach($products as &$product){
            $product['image_path'] = asset('storage/avatarImage/'.$product['image']);
        }
        return response($products);
    }
}
