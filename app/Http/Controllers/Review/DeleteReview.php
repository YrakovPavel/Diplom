<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteReview extends Controller
{
    public function __invoke(Request $request){
        $review = Review::find($request->id);
        $user = Auth::user();
        if ($user->role === 'admin'){
            $review->delete();
            return true;
        }
        return false;
    }
}
