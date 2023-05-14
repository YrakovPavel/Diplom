<?php

namespace App\Http\Controllers\Characteristic;

use App\Http\Controllers\Controller;
use App\Models\Characteristic;
use Illuminate\Http\Request;

class DeleteCharacteristics extends Controller
{
    public function __invoke(Request $request){
        Characteristic::where('product_id', $request->product_id)->delete();
    }
}
