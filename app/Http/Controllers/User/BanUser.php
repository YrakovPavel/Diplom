<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BannedUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BanUser extends Controller
{
    public function __invoke(Request $request){
        $user = User::where('email', $request->email)->first();
        $admin = Auth::user();
        if ($admin->id != $user->id && $admin->role === 'admin'){
            if (BannedUsers::where('user_id', $user->id)->exists()){
                return false;
            }
            else{
                BannedUsers::create(['user_id' => $user->id, 'email' => $request->email]);
            }
        }
    }
}
