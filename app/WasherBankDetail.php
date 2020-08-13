<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WasherBankDetail extends Model
{
    protected $primaryKey = "id";
    protected $guarded = [ 'id' ];

    protected $hidden = [];
}
