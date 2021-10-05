<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class HomeSiteController extends Controller
{
    public function productByCategory($id){
        $category=MainCategory::find($id);
        $subcategories=$category->subCategories()->get();
//       return  $products=[];
        foreach ($subcategories as $subcategory){
            $products=$subcategory->products()->get();
        }
        $producys[]=$products;

        return view('site.home_site.index',compact(['category','subcategories','producys']));
    }
}
