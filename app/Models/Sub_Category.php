<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sub_Category extends Model
{
    protected $fillable = [
            'name',
            'category_id',
            'slug',
            'image',
            'status',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'create_by',
    ];

    public function Category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    static public function getRecordSubCate($cat_id){
        return Sub_Category::select('sub__categories.*')
                            ->join('users','users.name','=','sub__categories.create_by')
                            ->join('categories','categories.id','=','sub__categories.category_id')
                            ->where('sub__categories.category_id','=',$cat_id)
                            ->where('sub__categories.status','=',0)
                            ->orderBy('sub__categories.name','asc')->get();
    }
    public function totalProduct(){
        return $this->hasMany(Product::class,'sub_category_id')->where('status','=',0)->count();
    }




}
