<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class Product extends Model
{
    protected $fillable = [
    'name',
    'slug',
    'hero_image',
    'sku',
    'category_id',
    'sub_category_id',
    'brand_id',
    'old_price',
    'price',
    'short_description',
    'description',
    'additional_information',
    'shipping_returns',
    'status',
    'created_by',
    'updated_by',
];


static public function getProduct($category_id = '', $subcategory_id = ''){
    $return = Product::join('users','users.name','=', 'products.created_by')
                        ->join('categories','categories.id', '=', 'products.category_id')
                        ->join('sub__categories','sub__categories.id', '=' , 'products.sub_category_id');

    if(!empty($category_id)){
        $return = $return->where('products.category_id',$category_id);
    }
    if(!empty($subcategory_id)){
        $return = $return->where('products.sub_category_id',$subcategory_id);
    }

    // //filter code start
     if (!empty(request()->get('get_sub_cate_ids'))) {
        $sub_category_id = rtrim(request()->get('get_sub_cate_ids'), ",");
        $sub_category_id_array = explode(",", $sub_category_id);

        $return = $return->whereIn('products.sub_category_id', $sub_category_id_array);
    }

    if(!empty(request()->get('get_size_ids'))){
        $size_id = rtrim(request()->get('get_size_ids'),',');
        $size_id_array = explode(",",$size_id);

        $return->join('product_sizes','product_sizes.product_id','=','products.id')
                ->whereIn('product_sizes.product_id',$size_id_array);
    }
    if(!empty(request()->get('get_color_ids'))){
        $color_id = rtrim(request()->get('get_color_ids'),',');
        $color_id_array = explode(",",$color_id);

        $return->join('product__colors','product__colors.product_id','=','products.id')
                ->whereIn('product__colors.product_id',$color_id_array);
    }
    if(!empty(request()->get('brand_ids'))){
        $brand_id = rtrim(request()->get('brand_ids'),',');
        $brand_id_array = explode(",",$brand_id);

        $return->whereIn('products.brand_id',$brand_id_array);
    }
    //price filter

    if(!empty(request()->get('get_start_price')) && !empty(request()->get('get_end_price'))){
        $start_price = str_replace('$','', request()->get('get_start_price'));
        $end_price = str_replace('$','', request()->get('get_end_price'));

        $return = $return->where('products.price', '>=', $start_price);
        $return = $return->where('products.price', '<=', $end_price);
    }
    else{
        if(!empty(request()->get('old_cate_id'))){
            $old_cat_id = request()->get('old_cate_id');
            $return = $return->where('products.category_id','=' ,$old_cat_id);
        }
        if(!empty(request()->get('old_sub_cate_id'))){
            $old_sub_cat_id = request()->get('old_sub_cate_id');
            $return = $return->where('products.sub_category_id','=',$old_sub_cat_id);
        }

    }

    // //filter code end

    $return = $return->select('products.*',
                'categories.name as category_name', 'categories.slug as category_slug',
                'sub__categories.name as sub_category_name' , 'sub__categories.slug as sub_category_slug')->where('products.status',0)->orderBy('products.id','desc')->simplePaginate(1);

    return $return;
}




static public function getSingleImage($product_id){
        return ProductImage::where('product_id','=',$product_id)->orderBy('order_by','asc')->first();
}

public function getImage(){
    return $this->hasMany(ProductImage::class,'product_id')->orderBy('order_by','asc')->first();
}






}
