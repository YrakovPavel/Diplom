<?php

namespace App\Http\Controllers\Characteristic;

use App\Http\Controllers\Controller;
use App\Models\Characteristic;
use Illuminate\Http\Request;

class GetCharacteristics extends Controller
{
    public function __invoke(Request $request){
        return Characteristic::all()->where('product_id', $request->id)->map->only(['name', 'value'])->values();
    }
}
