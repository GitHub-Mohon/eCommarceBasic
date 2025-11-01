<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
            'name',
            'slug',
            'image',
            'status',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'created_by',
    ];


    static public function categoryMenu(){
        return Category::join('users' , 'users.name', '=' , 'categories.created_by')
        ->where('categories.status', '=', 0)
        ->select('categories.*')
        ->get();
    }

    public function subCategoryMenu(){
        return $this->hasMany(Sub_Category::class,'category_id')->where('sub__categories.status',0)
        ->get();
    }



}

