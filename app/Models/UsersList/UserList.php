<?php

namespace App\Models\UsersList;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\UsersList\Traits\UserListAttribute;
use App\Models\UsersList\Traits\UserListRelationship;
use App\Models\CarWashBooking\CarWashBooking;

class UserList extends Model
{
    use ModelTrait,
        UserListAttribute,
    	UserListRelationship {
            // UserListAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'users';

    /**
     * Mass Assignable fields of model
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * Default values for model fields
     * @var array
     */
    protected $attributes = [

    ];

    /**
     * Dates
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Guarded fields of model
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Constructor of Model
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function bookinglist()
    {
        if ($this->user_type == 'washer') {
            return $this->hasMany(CarWashBooking::class, 'accepted_by');
        }
        return $this->hasMany(CarWashBooking::class, 'user_id');
    }

    public function mycar()
    {
        return $this->hasMany('App\Models\Mycar' ,'user_id','id');
    }
   
    
    public function rewards()
    {
        return $this->hasMany('App\Models\Booking' ,'user_id','id')
                    ->where(function ($query) {
                        $query->where('booking_promp', '=', '$7 off')
                            ->orWhere('booking_promp', '=', '$3 off');
                    });
    }


}
