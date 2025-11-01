<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{

    protected $fillable = ['product_id', 'name', 'price'];

    static public function deleteRecord($id){
        self::where('product_id','=',$id)->delete();
    }

    static public function getSizeFilter(){
        return ProductSize::all();
    }
}
