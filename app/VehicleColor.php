<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleColor extends Model
{
    protected $table = "vehicle_colors";
    protected $primaryKey = "id";
    protected $guarded = [ 'id' ];

    protected $hidden = [];
}
