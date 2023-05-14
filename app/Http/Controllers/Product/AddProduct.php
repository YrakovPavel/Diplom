<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\product\AddRequest;
use App\Models\BannedUsers;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AddProduct extends Controller
{
    public function __invoke(AddRequest $request){
        $user_id = Auth::id();
        if (BannedUsers::where('user_id', $user_id)->exists()){
            return false;
        }
        else{
            $data = $request->validated();
            $image = $request->file('image');
            Storage::disk('local')->put('public/avatarImage', $image);

            $images_count = $request->images_count;
            $folderName = time() .'';
            for ($i = 0; $i < $images_count; $i++){
                $images = $request->file('images_'.$i);
                Storage::disk('local')->put('public/otherImages/'.$folderName, $images);
            }

            $data['seller_id'] = $user_id;
            $data['image'] = $image->hashName();
            $data['images_folder'] = $folderName;
            $product = Product::create($data);  

            return response($product->id);
        }
    }
}
