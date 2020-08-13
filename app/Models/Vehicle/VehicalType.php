<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;

class VehicalType extends Model
{
    protected $table = 'vehical_types';

    protected $fillable = [
        'vehical_name','description','vehical_img','status'
    ];
}
