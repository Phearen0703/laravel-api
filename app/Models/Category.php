<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    Use HasFactory;
   protected $table = 'categorys';

    protected $fillable = [
        'name',
    ];

}
