<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable=[
    	'car_category','brand_id','car_model','car_img','car_desc','status'
    ];
}
