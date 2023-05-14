<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetRole extends Controller
{
    public function __invoke(){
        $user = Auth::user();
        return response(["role" => $user->role, "id" => $user->id]);
    }
}
