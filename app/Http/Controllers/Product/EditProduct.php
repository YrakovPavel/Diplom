<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\product\EditRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditProduct extends Controller
{
    public function __invoke(EditRequest $request){
        $user_id = Auth::id();
        $data = $request->validated();
        $product = Product::find($data['id']);

        if ($user_id == $product->seller_id){
            $product->name = $data['name'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->category_id = $data['category_id'];

            if ($request->has('image')){
                $old_image = 'public/avatarImage/' .$product->image;
                if (Storage::exists($old_image)){
                    Storage::delete($old_image);
                }
                $image = $request->file('image');
                Storage::disk('local')->put('public/avatarImage', $image);
                $product->image = $image->hashName();
            }

            if ($request->has('images_0')){
                $old_images = 'public/otherImages/' .$product->images_folder;
                if (Storage::exists($old_images)){
                    Storage::deleteDirectory($old_images);
                }

                $images_count = $request->images_count;
                $folderName = time() .'';
                for ($i = 0; $i < $images_count; $i++){
                    $images = $request->file('images_'.$i);
                    Storage::disk('local')->put('public/otherImages/'.$folderName, $images);
                }
                $product->images_folder = $folderName;
            }
            $product->save(); 
        }
    }
}
