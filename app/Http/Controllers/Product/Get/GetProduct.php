<?php

namespace App\Http\Controllers\Product\Get;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class GetProduct extends Controller
{
    public function __invoke(Request $request){
        return Product::find($request->id);
    }
}
