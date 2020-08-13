<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logistic extends Model
{
    protected $table = "logistics";
    protected $primaryKey = "id";
    protected $guarded = [ 'id' ];

    protected $hidden = [];
}
