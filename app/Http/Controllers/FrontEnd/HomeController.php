<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        $data['meta_title'] = 'eCommerce Website';
        return view("Frontend.home",$data);
    }
}
