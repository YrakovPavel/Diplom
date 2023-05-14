<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class GetUser extends Controller
{
    public function __invoke(Request $request){
        $user = User::select('name', 'email', 'date_of_birth')->find($request->id);
        $grade = Review::where('seller_id', $request->id)->avg('grade');
        if ($grade){
            $user['grade'] = ceil($grade);
        }
        else{
            $user['grade'] = 0;
        }   
        return $user;
    }
}
