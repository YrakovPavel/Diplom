<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BannedUsers;
use Illuminate\Http\Request;

class IfBanned extends Controller
{
    public function __invoke(Request $request){
        if (BannedUsers::where('email', $request->email)->exists()){
            return true;
        }
        else{
            return false;
        }
    }
}
