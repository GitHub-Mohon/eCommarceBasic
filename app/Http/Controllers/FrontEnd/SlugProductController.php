<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Color;
use App\Models\ProductSize;
use App\Models\Sub_Category;
use Illuminate\Http\Request;

class SlugProductController extends Controller
{
    public function getCategoryMain($category,$subcategory = ''){
        $getCategory = Category::where('slug',$category)->where('status','=',0)->first();
        $getSubCategory = Sub_Category::where('slug',$subcategory)->where('status','=',0)->first();


        if(!empty($getCategory) && !empty($getSubCategory)){

            $data['productSizeFilter'] = ProductSize::getSizeFilter();
            $data['filterColor'] = Color::getColorFilter();
            $data['brandFilter'] = Brand::getBrandFilter();

            $data['subCateFilter'] = Sub_Category::getRecordSubCate($getCategory->id);

            $data['meta_title'] = $getSubCategory->meta_title;
            $data['meta_description'] = $getSubCategory->meta_description;
            $data['meta_keyword'] = $getSubCategory->meta_keyword;
            $data['created_by'] = $getSubCategory->created_by;

            $data['getCategory'] = $getCategory;
            $data['getSubCategory'] = $getSubCategory;

            $getProduct = Product::getProduct($getCategory->id,$getSubCategory->id);


            //pagination
            $page = 0;
            if(!empty($getProduct->nextPageUrl())){
                $page_url = parse_url($getProduct->nextPageUrl());
                if(!empty($page_url['query'])){
                    parse_str($page_url['query'], $get_array);
                    $page = !empty($get_array['page']) ? $get_array['page'] : 0 ;
                }
            }
            dd([
    'current' => $getProduct->currentPage(),
    'next_url' => $getProduct->nextPageUrl(),
    'has_more' => $getProduct->hasMorePages(),
    'last_page' => method_exists($getProduct, 'lastPage') ? $getProduct->lastPage() : 'N/A',
]);
            $data['page'] = $page;

            $data['getProduct'] = $getProduct;

            return view('frontend.product.list',$data);

        }elseif(!empty($getCategory)){
            $data['productSizeFilter'] = ProductSize::getSizeFilter();
            $data['filterColor'] = Color::getColorFilter();
            $data['brandFilter'] = Brand::getBrandFilter();
            $data['subCateFilter'] = Sub_Category::getRecordSubCate($getCategory->id);


            $data['meta_title'] = $getCategory->meta_title;
            $data['meta_description'] = $getCategory->meta_description;
            $data['meta_keyword'] = $getCategory->meta_keyword;
            $data['created_by'] = $getCategory->created_by;

            $data['getCategory'] = $getCategory;

            $getProduct = Product::getProduct($getCategory->id);

            //pagination
            $page = 0;
            if(!empty($getProduct->nextPageUrl())){
                $page_url = parse_url($getProduct->nextPageUrl());
                if(!empty($page_url['query'])){
                    parse_str($page_url['query'], $get_array);
                    $page = !empty($get_array['page']) ? $get_array['page'] : 0 ;
                }
            }
            $data['page'] = $page;

            $data['getProduct'] = $getProduct;

            return view('frontend.product.list',$data);

        }else{
            abort(404);
        }

    }

    public function getCategory($category, $subcategory = '')
{
    $getCategory = Category::where('slug', $category)->where('status', 0)->first();
    $getSubCategory = Sub_Category::where('slug', $subcategory)->where('status', 0)->first();

    if (!empty($getCategory) && !empty($getSubCategory)) {
        $data['productSizeFilter'] = ProductSize::getSizeFilter();
        $data['filterColor'] = Color::getColorFilter();
        $data['brandFilter'] = Brand::getBrandFilter();
        $data['subCateFilter'] = Sub_Category::getRecordSubCate($getCategory->id);

        $data['meta_title'] = $getSubCategory->meta_title;
        $data['meta_description'] = $getSubCategory->meta_description;
        $data['meta_keyword'] = $getSubCategory->meta_keyword;
        $data['created_by'] = $getSubCategory->created_by;

        $data['getCategory'] = $getCategory;
        $data['getSubCategory'] = $getSubCategory;

        $getProduct = Product::getProduct($getCategory->id, $getSubCategory->id);

    } elseif (!empty($getCategory)) {
        $data['productSizeFilter'] = ProductSize::getSizeFilter();
        $data['filterColor'] = Color::getColorFilter();
        $data['brandFilter'] = Brand::getBrandFilter();
        $data['subCateFilter'] = Sub_Category::getRecordSubCate($getCategory->id);

        $data['meta_title'] = $getCategory->meta_title;
        $data['meta_description'] = $getCategory->meta_description;
        $data['meta_keyword'] = $getCategory->meta_keyword;
        $data['created_by'] = $getCategory->created_by;

        $data['getCategory'] = $getCategory;

        $getProduct = Product::getProduct($getCategory->id);

    } else {
        abort(404);
    }

    // ✅ Pagination handled properly
    $data['page'] = $getProduct->hasMorePages()
        ? $getProduct->currentPage() + 1
        : 0;

    $data['getProduct'] = $getProduct;

    return view('frontend.product.list', $data);
}


    public function getFilterProductAjax(Request $request){
        $getProduct = Product::getProduct();

        //pagination
            $page = 0;
            if(!empty($getProduct->nextPageUrl())){
                $page_url = parse_url($getProduct->nextPageUrl());
                if(!empty($page_url['query'])){
                    parse_str($page_url['query'], $get_array);
                    $page = !empty($get_array['page']) ? $get_array['page'] : 0 ;
                }
            }


        return response()->json([
            "status" => true,
            "success" => view('frontend.product._list',[
                "getProduct" => $getProduct,
            ])->render(),
        ],200);
    }


    public function getCategoryAjax(Request $request, $category, $subcategory = '')
{
    // Get Category
    $getCategory = Category::where('slug', $category)
        ->where('status', 0)
        ->first();

    if (!$getCategory) {
        return response()->json([
            'status' => false,
            'message' => 'Category not found'
        ], 404);
    }

    // Get Subcategory (optional)
    $getSubCategory = null;
    if (!empty($subcategory)) {
        $getSubCategory = Sub_Category::where('slug', $subcategory)
            ->where('status', 0)
            ->first();
    }

    // Fetch Products (paginate!)
    $getProduct = Product::getProduct(
        $getCategory->id,
        $getSubCategory ? $getSubCategory->id : null
    );

    // Return JSON response (with rendered HTML + pagination info)
    return response()->json([
        'status'    => true,
        'products'  => view('frontend.product.list', [
            'getProduct' => $getProduct
        ])->render(),
        'next_page' => $getProduct->hasMorePages()
            ? $getProduct->currentPage() + 1
            : 0
    ]);
}





}
