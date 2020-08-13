<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon as Carbon;;

class Booking extends Model
{
    protected $table = 'car_wash_bookings';


    public function userDetail()
    {
        return $this->belongsTo('App\Models\UsersList\UserList', 'user_id');
    }
    
    public function partenerDetail()
    {
        return $this->belongsTo('App\Models\UsersList\UserList', 'accepted_by');
    }
    
    
}
