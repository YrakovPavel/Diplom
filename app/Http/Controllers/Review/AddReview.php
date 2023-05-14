<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\review\AddRequest;
use App\Models\Product;
use App\Models\Review;

class AddReview extends Controller
{
    public function __invoke(AddRequest $request){
        $data = $request->validated();
        $product = Product::find($data['product_id']);
        $data['product_name'] = $product['name'];
        $data['buyer_id'] = $product['buyer_id'];
        $data['seller_id'] = $product['seller_id']; 
        Review::create($data); 
        return true;
    }
}
