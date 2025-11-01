<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(){
        return view('Backend.category.categoryForm');
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required | unique:categories,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'status'  => 'required',
            'meta_title'  => 'required',
            'meta_description'  => 'required',
            'meta_keyword'  => 'required',

        ]);

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = time(). '.' . $ext;

        $path = $image->move(public_path(). '/categoryImages',$imageName);

        $slg = $request->name;
        $slug = Str::slug($slg);

        try{
            $data['category'] = Category::create([
            'name' => $request->name,
            'slug'=> $slug,
            'image' => $imageName,
            'status' => $request->status,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,
            'created_by' => Auth::user()->name,
            ]);

            return redirect()->route('category.read')->with('status','New Category Created Successfully');
        }catch(Exception $e){
            return back()->with('errors', $e->getMessage());
        }
    }

    public function read(){
        $data['category'] = Category::orderByDesc('id')->get();
        return view('Backend.category.category',$data);
    }

    public function delete($id){

        $imagePath = Category::select('image')->where('id',$id)->get();
        $filePath = public_path(). '/categoryImages/' . $imagePath[0]['image'];

        unlink($filePath);

        try{
            Category::where('id',$id)->delete();

            return redirect()->route('category.read')->with('status','The Category Deleted Successfully');
        }catch(Exception $e){
            return back()->with('errors',$e->getMessage());
        }
    }

    public function edit($id){
        $data['category'] = Category::findOrFail($id);

        return view('Backend.category.edit',$data);
    }


 public function update(Request $request, $id){

    $request->validate([
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif',
            'status'  => 'required',
            'meta_title'  => 'required',
            'meta_description'  => 'required',
            'meta_keyword'  => 'required',

        ]);

    $cateImage = Category::findOrFail($id);

    if ($request->hasFile('image')) {
        $path = public_path('./categoryImages');
        if ($cateImage->image != '' && $cateImage->image != null) {
            $old_file = $path . '/' . $cateImage->image;
            if (file_exists($old_file)) {
                unlink($old_file);
            }
        }

        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $image->move($path, $imageName);
    } else {
        $imageName = $cateImage->image;
    }

    $slg = $request->name;
    $slug = Str::slug($slg);

    try {
        Category::where('id', $id)->update([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $imageName,
            'status' => $request->status,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,
            'created_by' => Auth::user()->name,
        ]);

        return redirect()->route('category.read')->with('status','The Category Updated Successfully');
    } catch (Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
  }
}
