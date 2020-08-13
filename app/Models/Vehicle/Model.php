<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $table = 'carmodels';
    
    protected $fillable = [
        'model_name','model_img','model_desc','status','brand_id','vehicletype_id'
    ];
}
