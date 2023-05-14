<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Routing\Controller;

class GetCategories extends Controller
{
    public function __invoke(){
        return Category::all();
    }
}
