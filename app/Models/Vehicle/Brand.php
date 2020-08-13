<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    protected $fillable = [
        'brand_name','description','brand_img','status'
    ];
}
