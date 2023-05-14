<?php

namespace App\Http\Controllers\Characteristic;

use App\Http\Controllers\Controller;
use App\Models\Characteristic;
use App\Models\Product;
use Illuminate\Http\Request;

class AddCharacteristics extends Controller
{
    public function __invoke(Request $request){

        $charact_count = intval($request->charact_count);
        
        for ($i = 0; $i < $charact_count; $i++){
            $char_name = $request->get('charact_'.$i);
            $char_value = $request->get('value_'.$i);

            Characteristic::create([
                'name' => $char_name,
                'value' => $char_value,
                'product_id' => intval($request->product_id)
            ]); 
        }  
    }
}
