<?php

namespace App\Http\Controllers\Site;

//use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SubCategory;

class CategoryController extends Controller
{
    public function productsBySlug($slug)
    {
        $data = [];
        $data['category'] = SubCategory::where('slug', $slug)->first();

        if ($data['category'])
            $data['products'] = $data['category']->products;

        return view('front.products', $data);
    }

}
