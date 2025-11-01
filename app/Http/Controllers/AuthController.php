<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
        return view('backend.admin.auth.login');
    }

    public function adminRegister(){
        $data['admin'] = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'is_admin' => 1,
        ]);
    }

    public function dashboard(){
        return view('backend.admin.dashboard');
    }

    public function adminAuth(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $email = $request->email;
        $password = $request->password;

        try{

            if(Auth::attempt(['email'=> $email, 'password' => $password, 'is_admin' => 1])){

            return redirect()->route('admin.dashboard');

        }else{
            return redirect()->back()->with('errors','Please Enter your Correct Email and Password');
        }

        }catch(Exception $e){
            return back()->with('errors', $e->getMessage());
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login.admin');
    }

    public function read(){

        $data['admin_list'] = User::getAdmin();
        // $data['header_title'] = 'Admin';

        return view('Backend.admin.list',$data);
    }

    public function index(){
        return view('Backend.admin.form');
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'status' => 'required',
        ]);


        $data['admin'] = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'is_admin' => 1,
        ]);

        return redirect()->route('admin.read')->with('status','New User Created Successfully');
    }

    public function delete($id){

        try{

            $delete = User::findOrFail($id)->delete();

            return redirect()->route('admin.read')->with('status','New User Delete Successfully');

        }catch(Exception $e){
            return back()->with('errors', $e->getMessage());
        }
    }

    public function edit($id){

        $data['admin'] = User::findOrFail($id);
        $data['data'] = User::all();

        // dd($data);

        return view('Backend.admin.edit',$data);
    }

    public function update(Request $request,string $id){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'status' => 'required',
        ]);

        try{

            User::where(['id'=> $id])->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.read')->with('status','The User Edited Successfully');

        }catch(Exception $e){
            return back()->with('errors',$e->getMessage());
        }
    }
}
