<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class GetReviews extends Controller
{
    public function __invoke(Request $request){
        
        return Review::where('seller_id', $request->id)
            ->join('users', 'reviews.buyer_id', '=', 'users.id')
            ->select('reviews.id', 'reviews.product_name', 'users.name', 'reviews.comment', 'reviews.grade')->paginate(5);
    }
}
