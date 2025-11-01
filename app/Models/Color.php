<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    Protected $fillable = [
        'name',
        'code',
        'status',
        'created_by',
        'updated_by',
    ];

    static public function getColorFilter(){
        return self::select('colors.*')->join('users','users.name','=','colors.created_by')->where('colors.status','=',0)->get();
    }
}
