<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Sub_Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index(){
        $data['category'] = Category::all();
        return view('Backend.subCategory.form',$data);
    }

    public function store(Request $request){

        $request->validate([
            'category_id' => 'required',
            'name' => 'required | unique:sub__categories,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'status'  => 'required',
            'meta_title'  => 'required',
            'meta_description'  => 'required',
            'meta_keyword'  => 'required',

        ]);

        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = time(). '.' . $ext;

        $path = $image->move(public_path(). '/subCategoryImages',$imageName);

        $slg = $request->name;
        $slug = Str::slug($slg);


        try{
            $data['subcategory'] = Sub_Category::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug'=> $slug,
            'image' => $imageName,
            'status' => $request->status,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keyword,
            'create_by' => Auth::user()->name,
            ]);

            return redirect()->route('sub-category.read')->with('status','New Sub Category Created Successfully');
        }catch(Exception $e){
            return back()->with('errors', $e->getMessage());
        }
    }

    public function read(){

        $data['subcategory'] = Sub_Category::orderByDesc('id')->with('Category')->paginate(1);

        // dd($data);

        return view('Backend.subCategory.read',$data);
    }

    public function delete($id){

        $imagePath = Sub_Category::select('image')->where('id',$id)->get();
        $filePath = public_path(). '/subCategoryImages/' . $imagePath[0]['image'];

        unlink($filePath);

        try{
            Sub_Category::where('id',$id)->delete();

            return redirect()->route('sub-category.read')->with('status','The Sub Category Deleted Successfully');
        }catch(Exception $e){
            return back()->with('errors',$e->getMessage());
        }
    }

    public function edit($id){
        $data['subcategory'] = Sub_Category::with('Category')->findOrFail($id);
        $data['category'] = Category::select('id','name')->get();

        return view('Backend.subCategory.edit',$data);
    }

    public function update(Request $request, $id){

    $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif',
            'status'  => 'required',
            'meta_title'  => 'required',
            'meta_description'  => 'required',
            'meta_keyword'  => 'required',

    ]);

    $subCateImage = Sub_Category::findOrFail($id);

    if ($request->hasFile('image')) {
        $path = public_path('./subCategoryImages');
        if ($subCateImage->image != '' && $subCateImage->image != null) {
            $old_file = $path . '/' . $subCateImage->image;
            if (file_exists($old_file)) {
                unlink($old_file);
            }
        }

        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $image->move($path, $imageName);
    } else {
        $imageName = $subCateImage->image;
    }

    $slg = $request->name;
    $slug = Str::slug($slg);

    try {
        Sub_Category::where('id', $id)->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug'=> $slug,
            'image' => $imageName,
            'status' => $request->status,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keyword,
            'create_by' => Auth::user()->name,
        ]);

        return redirect()->route('sub-category.read')->with('status','The Sub Category Updated Successfully');
    } catch (Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
  }

}
