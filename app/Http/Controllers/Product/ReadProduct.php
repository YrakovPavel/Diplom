<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Characteristic;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReadProduct extends Controller
{
    public function __invoke(Request $request){
        $product = Product::find($request->id);
        $image = asset('storage/avatarImage/'.$product->image);
        $images = collect(Storage::files('public/otherImages/'.$product->images_folder))->map(function($file) {
            return asset(Storage::url($file));
        });

        $characteristics = Characteristic::all()->where('product_id', $request->id)->map->only(['name', 'value']);

        return response([
            'name' => $product['name'],
            'description' => $product['description'],
            'price' => $product['price'],
            'seller_id' => $product['seller_id'],
            'image' => $image,
            'images' => $images,
            'characteristics' => $characteristics
        ]); 
    }
}
