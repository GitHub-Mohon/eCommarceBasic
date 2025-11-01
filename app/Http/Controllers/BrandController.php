<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(){
        $data['brand'] = Brand::all();
        return view('Backend.brand.form',$data);
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required | unique:brands,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'status'  => 'required',
            'meta_title'  => 'required',
            'meta_description'  => 'required',
            'meta_keyword'  => 'required',

        ]);

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = time(). '.' . $ext;

        $path = $image->move(public_path(). '/brandImages',$imageName);

        $slg = $request->name;
        $slug = Str::slug($slg);


        try{
            $data['brand'] = Brand::create([
            'name' => $request->name,
            'slug'=> $slug,
            'image' => $imageName,
            'status' => $request->status,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keyword,
            'created_by' => Auth::user()->name,
            ]);

            return redirect()->route('brand.read')->with('status','New Brand created Successfully');
        }catch(Exception $e){
            return back()->with('errors', $e->getMessage());
        }
    }

    public function read(){

        $data['brand'] = Brand::orderByDesc('id')->get();

        // dd($data);

        return view('Backend.brand.read',$data);
    }

    public function delete($id){

        $imagePath = Brand::select('image')->where('id',$id)->get();
        $filePath = public_path(). '/brandImages/' . $imagePath[0]['image'];

        unlink($filePath);

        try{
            Brand::where('id',$id)->delete();

            return redirect()->route('brand.read')->with('status','The Brand Deleted Successfully');
        }catch(Exception $e){
            return back()->with('errors',$e->getMessage());
        }
    }

    public function edit($id){
        $data['brand'] = Brand::findOrFail($id);

        return view('Backend.brand.edit',$data);
    }


    public function update(Request $request, $id){

    $request->validate([
            'name' => 'required ',
            'image' => 'image|mimes:jpeg,png,jpg,gif',
            'status'  => 'required',
            'meta_title'  => 'required',
            'meta_description'  => 'required',
            'meta_keywords'  => 'required',

    ]);

    $brandImage = Brand::findOrFail($id);

    if ($request->hasFile('image')) {
        $path = public_path('./brandImages');
        if ($brandImage->image != '' && $brandImage->image != null) {
            $old_file = $path . '/' . $brandImage->image;
            if (file_exists($old_file)) {
                unlink($old_file);
            }
        }

        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $image->move($path, $imageName);
    } else {
        $imageName = $brandImage->image;
    }

    $slg = $request->name;
    $slug = Str::slug($slg);

    try {
        Brand::where('id', $id)->update([
            'name' => $request->name,
            'slug'=> $slug,
            'image' => $imageName,
            'status' => $request->status,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'created_by' => Auth::user()->name,
        ]);

        return redirect()->route('brand.read')->with('status','The Brand Updated Successfully');
    } catch (Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
  }

}
