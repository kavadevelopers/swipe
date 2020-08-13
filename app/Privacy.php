<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    protected $primaryKey = "id";
    protected $guarded = [ 'id' ];

    protected $hidden = [];
}
