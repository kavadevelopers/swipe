<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;

class CarWashBooking extends Model
{
    //
    // public function User()
    // {
    //     return $this->hasOne('App\User','id' , 'user_id');
    // }
    protected $appends = ['distance'];
    public function getDistanceAttribute()
    {
        // return "{$this->first_name} {$this->last_name}";
        $dataLat = Config::get('lat');
        $dataLon = Config::get('lon');
        // dump($dataLat);
        // dd($dataLon);
        $unit = "K";
        $lat1 = $this->lat;
        $lat2 = $dataLat;
        $lon1 = $this->lon;
        $lon2 = $dataLon;
        if(is_null($lat1) || is_null($lat2) || is_null($lon1) ||is_null($lon2)){
            return 0;
        }
        elseif(empty($lat1) && empty($lon1)){
            return 0;
        }elseif (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }elseif (!is_numeric($lat1) || !is_numeric($lat2) || !is_numeric($lon1) || !is_numeric($lon2)) {
            return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
            return  ($miles * 0.8684);
            } else {
            return  $miles;
            }
        }
    }

    public function washer_profile()
    {
        return $this->hasOne('App\Profile', 'user_id', 'accepted_by');
    }
    public function washers()
    {
        return $this->hasOne('App\User', 'id', 'accepted_by');
    }

    public function unread_message_user(){
        return $this->hasMany('App\BookingChat','booking_id','id')->where('flag','unread');
    }

    public function unread_message_washer(){
        return $this->hasMany('App\BookingChat','booking_id','id')->where('washer_flag','unread');
    }

}
