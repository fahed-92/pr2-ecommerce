<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Enumerations\CategoryType;
use App\Http\Requests\GeneralProductRequest;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Requests\ProductPriceValidation;
use App\Http\Requests\ProductStockRequest;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\Product_photo;
use App\Models\Product;
//use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{

    public function index()
    {
        $products = Product::select('id','slug','price', 'created_at')->paginate(PAGINATION_COUNT);
        return view('admin.products.general.index', compact('products'));
    }
    public function show($id)
    {
        $product = Product::find($id);
        return view('admin.products.general.show', compact('product'));
    }

    public function create()
    {
        $data = [];
        $brands = Brand::active()->get();
//        $data['tags'] = Tag::select('id')->get();
        $categories = SubCategory::active()->get();
        return view('admin.products.general.create',compact(['brands','categories']));
    }

    public function store(Request $request)
    {
//return $request;

        try {
//            try {

            $products = collect($request->product);

         $filter = $products->filter(function ($value, $key) {
                return $value['abbr'] == get_default_lang();
            });

             $default_product = array_values($filter->all()) [0];

            DB::beginTransaction();

            $default_product_id = Product::insertGetId([
                'translation_lang' => $default_product['abbr'],
                'translation_of' => 0,
                'name' => $default_product['name'],
                'active' => $default_product['active'],
                'description' => $default_product['description'],
                'slug' => $default_product['name'],
                'price' => $default_product['price'],
                'sub_category_id' => $default_product['sub_category_id'],
                'brand_id' => $default_product['brand_id'],
            ]);

            $tproducts = $products->filter(function ($value, $key) {
                return $value['abbr'] != get_default_lang();
            });


            if (isset($tproducts) && $tproducts->count()) {

                $tproduct_arr = [];
                foreach ($tproducts as $tproduct) {
                    $tproduct_arr[] = [
                        'translation_lang' => $tproduct['abbr'],
                        'translation_of' => $default_product_id,
                        'name' => $tproduct['name'],
                        'active' => $tproduct['active'],
                        'description' => $tproduct['description'],
                        'slug' => $tproduct['slug'],
                        'price' => $tproduct['price'],
                        'sub_category_id' => $tproduct['sub_category_id'],
                        'brand_id' => $tproduct['brand_id']
                    ];
                }

                Product::insert($tproduct_arr);
            }

            DB::commit();

            return redirect()->route('admin.products')->with(['success' => 'تم الحفظ بنجاح']);

        }
        catch (\Exception $ex) {
            DB::rollback();
return $ex->getMessage();
            return redirect()->route('admin.products')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

//        DB::beginTransaction();
//
//        //validation
//
//        if (!$request->has('is_active'))
//            $request->request->add(['is_active' => 0]);
//        else
//            $request->request->add(['is_active' => 1]);
//
//        $product = Product::create([
//            'slug' => $request->slug,
//            'brand_id' => $request->brand_id,
//            'is_active' => $request->is_active,
//        ]);
//        //save translations
//        $product->name = $request->name;
//        $product->description = $request->description;
//        $product->short_description = $request->short_description;
//        $product->save();
//
//        //save product categories
//
//        $product->categories()->attach($request->categories);
//
//        //save product tags
//
//        DB::commit();
//        return redirect()->route('admin.products')->with(['success' => 'تم ألاضافة بنجاح']);


    }



    public function getPrice($product_id){

        return view('dashboard.products.prices.create') -> with('id',$product_id) ;
    }

    public function saveProductPrice(ProductPriceValidation $request){

        try{

            Product::whereId($request -> product_id) -> update($request -> only(['price','special_price','special_price_type','special_price_start','special_price_end']));

            return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);
        }catch(\Exception $ex){

        }
    }



    public function getStock($product_id){

        return view('dashboard.products.stock.create') -> with('id',$product_id) ;
    }

    public function saveProductStock (Request $request){


            Product::whereId($request -> product_id) -> update($request -> except(['_token','product_id']));

            return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);

    }

    public function addImages($product_id){
        return view('admin.products.images.create')->withId($product_id);
    }

    //to save images to folder only
    public function saveProductImages(Request $request ){

        $file = $request->file('dzfile');
        $filename = uploadImage('products', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);

    }

    public function saveProductImagesDB(Request $request){

        try {
            // save dropzone images
            if ($request->has('document') && count($request->document) > 0) {
                foreach ($request->document as $image) {
                    Product_photo::create([
                        'product_id' => $request->product_id,
                        'photo' => $image,
                        'is_cover'=>0
                    ]);
                }
            }

            return redirect()->route('admin.products')->with(['success' => 'تم التحديث بنجاح']);

        }catch(\Exception $ex){

        }
    }
    public function edit($id)
    {

        //get specific categories and its translations
        $category = Category::orderBy('id', 'DESC')->find($id);

        if (!$category)
            return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود ']);

        return view('dashboard.categories.edit', compact('category'));

    }


    public function update($id, MainCategoryRequest $request)
    {
        try {
            //validation

            //update DB


            $category = Category::find($id);

            if (!$category)
                return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود']);

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category->update($request->all());

            //save translations
            $category->name = $request->name;
            $category->save();

            return redirect()->route('admin.maincategories')->with(['success' => 'تم ألتحديث بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {

        try {
            //get specific categories and its translations
            $category = Category::orderBy('id', 'DESC')->find($id);

            if (!$category)
                return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجود ']);

            $category->delete();

            return redirect()->route('admin.maincategories')->with(['success' => 'تم  الحذف بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.maincategories')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

}
