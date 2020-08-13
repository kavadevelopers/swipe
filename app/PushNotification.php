<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    protected $primaryKey = "id";
    protected $guarded = [ 'id' ];

    protected $hidden = [];
}
