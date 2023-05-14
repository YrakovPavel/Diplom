<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangeComission extends Controller
{
    public function __invoke(Request $request){

        $categories = Category::get();
        $user = Auth::user();
        
        if ($user->role === 'admin'){
            for ($i = 0; $i < sizeof($categories); $i++){
                $categories[$i]['sell_percent'] = $request->get($i)['sell_percent'];
                $categories[$i]->save();
            };
        }
    }
}
