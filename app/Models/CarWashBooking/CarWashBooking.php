<?php

namespace App\Models\CarWashBooking;

use Illuminate\Database\Eloquent\Model;
use App\Models\UsersList\UserList;

class CarWashBooking extends Model
{
    protected $table = 'car_wash_bookings';

    public function getBooingDateAttribute()
    {
        // Carbon::now()->timezone('EST')->format('h:i');
        return "$this->date"."asda";
    }
    
    public function user()
    {
        return $this->hasOne(UserList::class, 'id', 'user_id');
    }

    public function washer()
    {
        return $this->hasOne(UserList::class, 'id', 'accepted_by');
    }

    
}
