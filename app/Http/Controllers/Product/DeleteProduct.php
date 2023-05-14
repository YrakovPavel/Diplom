<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Characteristic;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeleteProduct extends Controller
{
    public function __invoke(Request $request){
        $user = Auth::user();
        $product = Product::find($request->id);
        if ($user->role === 'admin' || $user->id === $product->seller_id){
            $image = 'public/avatarImage/' .$product->image;
            if (Storage::exists($image)){
                Storage::delete($image);
            }
            $images = 'public/otherImages/' .$product->images_folder;
            if (Storage::exists($images)){
                Storage::deleteDirectory($images);
            }
            Characteristic::where('product_id', $product->id)->delete();
            $product->delete();
            return true;
        }
    }
}
