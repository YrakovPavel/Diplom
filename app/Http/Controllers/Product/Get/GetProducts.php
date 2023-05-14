<?php

namespace App\Http\Controllers\Product\Get;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class GetProducts extends Controller
{
    public function store(Request $request){
    
        $products = Product::all()->where('buyer_id', null);
        
        if ($request->name){
            $name = $request->name;
            $products = $products->filter(function ($item) use ($name) {
                return false !== stristr($item->name, $name);
            });;
        }
        if ($request->category_id){
            $products = $products->where('category_id', $request->category_id);
        }
        if ($request->price_from){
            $products = $products->where('price', '>=', $request->price_from);
        }
        if ($request->price_to){
            $products = $products->where('price', '<=', $request->price_to);
        } 
        
        $products->map->only(['id', 'seller_id', 'name', 'description', 'price', 'image'])->all();
        
        foreach($products as &$product){
            $product['image_path'] = asset('storage/avatarImage/'.$product['image']);
        } 

        return response()->json($this->paginate($products));
    }

    public function paginate($items, $perPage = 9, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
