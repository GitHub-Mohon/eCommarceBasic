<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class ColorController extends Controller
{
    public function index(){
        $data['color'] = Color::all();
        return view('Backend.color.form',$data);
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required | unique:colors,name',
            'code' => 'required',
            'status'  => 'required',

        ]);

        try{
            $data['color'] = Color::create([
            'name' => $request->name,
            'code'=> $request->code,
            'status'=> $request->status,
            'created_by' => Auth::user()->name,
            ]);

            return redirect()->route('color.read')->with('status','New Color created Successfully');
        }catch(Exception $e){
            return back()->with('errors', $e->getMessage());
        }
    }

    public function read(){

        $data['color'] = Color::orderByDesc('id')->get();

        // dd($data);

        return view('Backend.color.read',$data);
    }

    public function delete($id){

        try{
            Color::where('id',$id)->delete();

            return redirect()->route('color.read')->with('status','The Color Deleted Successfully');
        }catch(Exception $e){
            return back()->with('errors',$e->getMessage());
        }
    }

    public function edit($id){
        $data['color'] = Color::findOrFail($id);

        return view('Backend.color.edit',$data);
    }

    public function update(Request $request, $id){

    $request->validate([
            'name' => 'required ',
            'code' => 'required',
            'status'  => 'required',

    ]);
    try {
        Color::where('id', $id)->update([
            'name' => $request->name,
            'code'=> $request->code,
            'status' => $request->status,
            'updated_by' => Auth::user()->name,
        ]);

        return redirect()->route('color.read')->with('status','The Color Updated Successfully');
    } catch (Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
  }
}
