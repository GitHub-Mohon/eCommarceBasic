<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
            'name',
            'slug',
            'image',
            'status',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'created_by',
    ];

    static public function getBrandFilter(){
        return self::select('brands.*')->join('users','users.name','=','brands.created_by')->where('brands.status','=',0)->get();
    }
}
