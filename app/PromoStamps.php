<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoStamps extends Model
{
    protected $table = "promo_stamps";
    protected $primaryKey = "id";
    protected $guarded = [ 'id' ];

    protected $hidden = [];
}
