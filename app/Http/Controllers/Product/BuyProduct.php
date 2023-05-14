<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyProduct extends Controller
{
    public function __invoke(Request $request){
        $product = Product::find($request->id);
        $user_id = Auth::id();
        $user = User::find($user_id);
        if ($product->seller_id != $user->id && $user->balance >= $product->price){
            $seller = User::find($product->seller_id);
            $category = Category::find($product->category_id);

            $user->balance -= $product->price;
            $seller->balance += $product->price - ($category->sell_percent / 100) * $product->price;
            $product->buyer_id = $user->id;

            $product->save();
            $seller->save();
            $user->save();
            return true; 
        }
    }
}
