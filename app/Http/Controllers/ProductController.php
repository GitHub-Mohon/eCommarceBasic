<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Product_Color;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\Sub_Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(){
        $data['product'] = Product::all();
        $data['category'] = Category::all();
        $data['brand'] = Brand::all();
        $data['Color'] = Color::all();

        return view('Backend.product.form',$data);
    }


    public function findSubCategory(Request $request){

        $cat_id = $request->category_id;
        $sub_category = Sub_Category::with('Category')->where('category_id',$cat_id)->get();


        return response()->json([
            'status' => true,
            'sub_category' => $sub_category
        ],201);

        // dd($sub_category);
    }


    public function store(Request $request){


        // dd($request);
        // $request->validate([
        //     'name' => 'required',
        //     'sku' => 'required',
        //     'category_id' => 'required',
        //     'sub_category_id' => 'required',
        //     'brand_id' => 'required',
        //     'old_price' => 'required',
        //     'price' => 'required',
        //     'short_description' => 'required',
        //     'description' => 'required',
        //     'additional_information' => 'required',
        //     'shipping_returns' => 'required',
        //     'status' => 'required',
        // ]);

        $image = $request->hero_image;
        $ext = $image->getClientOriginalExtension();
        $imageName = time(). '.' .$ext;

        $path = $image->move(public_path(). '/productHeroImages',$imageName);



        $slug = Str::slug($request->name);


            try{
            $data['product'] = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'hero_image' => $imageName,
            'sku' => $request->sku,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'brand_id' => $request->brand_id,
            'old_price' => $request->old_price,
            'price' => $request->price,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'additional_information' => $request->additional_information,
            'shipping_returns' => $request->shipping_returns,
            'status' => $request->status,
            'created_by' => Auth::user()->name,
        ]);

        $product_id = $data['product']->id;

        if(!empty($request->color_id)){
            foreach ($request->color_id as $color_id) {

                $data['product_color'] = Product_Color::create([
                    'product_id' => $product_id,
                    'color_id' => $color_id,
                ]);

        }

        if(!empty($request->size)){
            foreach($request->input('size',[]) as $size){
                if(!empty($size['name'])){
                    ProductSize::create([
                        'name' => $size['name'],
                        'price' => !empty($size['price']) ? $size['price'] : 0,
                        'product_id' => $product_id,
                    ]);
                }
            }
        }

        if ($request->hasFile('image_name')) {


    $images = $request->file('image_name');

    // Make sure it's treated as an array
    if (!is_array($images)) {
        $images = [$images];
    }

    foreach ($images as $image) {
        if ($image->isValid()) {
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . rand(1, 9999) . '.' . $ext;

            $image->move(public_path('productGallery'), $imageName);

            ProductImage::create([
                'product_id' => $product_id,
                'image_name' => $imageName,
                'image_extension' => $ext,
            ]);
        }
    }
        }

        }





        return redirect()->route('product.read')->with('status','The Product Successfully Added');
        }catch(Exception $e){
            return back()->with('errors',$e->getMessage());
        }
    }

    public function read(){
        $data['product'] = Product::all();
        return view('backend.product.read',$data);
    }

    public function delete($id){
        $imagePath = Product::select('hero_image')->where('id',$id)->get();

        $filePath = public_path(). '/productHeroImages/'. $imagePath[0]['hero_image'];

        unlink($filePath);

        try{
            Product::where('id',$id)->delete();


            if(is_array($id)){
                foreach($id as $productId){
                Product_Color::where('product_id',$productId)->delete();
                ProductSize::where('product_id',$productId)->delete();
            }
            }else{
                ProductSize::where('product_id',$id)->delete();
                Product_Color::where('product_id',$id)->delete();
            }



            return redirect()->route('product.read')->with('status','The Product Successfully Delete');
        }catch(Exception $e){
            return back()->with('errors',$e->getMessage());
        }
    }

    public function edit($id){

        $data['product'] = Product::findOrFail($id);
        $data['category'] = Category::all();
        $data['brand'] = Brand::all();
        $data['Color'] = Color::all();
        $data['product_color'] = Product_Color::where('product_id',$id)->get();
        $data['product_size'] = ProductSize::where('product_id',$id)->get();
        $data['product_gallery'] = ProductImage::where('product_id',$id)->orderBy('order_by','asc')->get();

        // dd($data);

        return view('backend.product.edit',$data);
    }

     public function update(Request $request, $id){

        // dd($request->image_name);
        // $request->validate([
        //     'name' => 'required',
        //     'sku' => 'required',
        //     'category_id' => 'required',
        //     'sub_category_id' => 'required',
        //     'brand_id' => 'required',
        //     'old_price' => 'required',
        //     'price' => 'required',
        //     'short_description' => 'required',
        //     'description' => 'required',
        //     'additional_information' => 'required',
        //     'shipping_returns' => 'required',
        //     'status' => 'required',
        // ]);



    $productImage = Product::findOrFail($id);

    if ($request->hasFile('hero_image')) {
        $path = public_path('./productHeroImages');
        if ($productImage->hero_image != '' && $productImage->hero_image != null) {
            $old_file = $path . '/' . $productImage->hero_image;
            if (file_exists($old_file)) {
                unlink($old_file);
            }
        }

        $image = $request->file('hero_image');
        $ext = $image->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $image->move($path, $imageName);
    } else {
        $imageName = $productImage->hero_image;
    }

    $slg = $request->name;
    $slug = Str::slug($slg);

    try {
        Product::where('id', $id)->update([
            'name' => $request->name,
            'slug' => $slug,
            'hero_image' => $imageName,
            'sku' => $request->sku,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'brand_id' => $request->brand_id,
            'old_price' => $request->old_price,
            'price' => $request->price,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'additional_information' => $request->additional_information,
            'shipping_returns' => $request->shipping_returns,
            'status' => $request->status,
            'updated_by' => Auth::user()->name,
        ]);



        if(!empty($request->color_id)){
            foreach ($request->color_id as $color_id) {
                Product_Color::where('product_id', $id)->delete();

                $data['product_color'] = Product_Color::create([
                    'product_id' => $id,
                    'color_id' => $color_id,
                ]);

        }


        if (!empty($request->size)) {
            if(is_array($request->size)){
            foreach ($request->size as $size) {
                ProductSize::deleteRecord($id);
                if (!empty($size['name'])) {
                    ProductSize::create([
                        'product_id' => $id,
                        'name' => $size['name'],
                        'price' => !empty($size['price']) ? $size['price'] : 0,
                    ]);
                }
            }
         }else{
            if (!empty($size['name'])) {
                ProductSize::deleteRecord($id);
                    ProductSize::create([
                        'product_id' => $id,
                        'name' => $request->size['name'],
                        'price' => !empty($request->size['price']) ? $request->size['price'] : 0,
                    ]);
                }
         }
        }



    if ($request->hasFile('image_name')) {

    // Delete existing images once before the loop
    ProductImage::where('product_id', $id)->delete();

    $images = $request->file('image_name');

    // Make sure it's treated as an array
    if (!is_array($images)) {
        $images = [$images];
    }

    foreach ($images as $image) {
        if ($image->isValid()) {
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . rand(1, 9999) . '.' . $ext;

            $image->move(public_path('productGallery'), $imageName);

            ProductImage::create([
                'product_id' => $id,
                'image_name' => $imageName,
                'image_extension' => $ext,
            ]);
        }
    }
        }

    }

        return redirect()->route('product.read')->with('status','The Product Updated Successfully');
    } catch (Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
  }


  public function deleteImage($id){

        $imagePath = ProductImage::select('image_name')->where('id',$id)->get();

        $filePath = public_path(). '/productGallery/'. $imagePath[0]['image_name'];

        unlink($filePath);

        try{
            ProductImage::where('id',$id)->delete();

            return redirect()->route('product.read')->with('status','The Product Updated Successfully');

        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
  }


public function imageSortable(Request $request)
{
    $photo_ids = $request->photo_id;
    $i = 1;

    if (is_array($photo_ids)) {
        foreach ($photo_ids as $id) {
            ProductImage::where('id', $id)->update([
                'order_by' => $i,
            ]);
            $i++;
        }

        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error'], 400);
}


}


