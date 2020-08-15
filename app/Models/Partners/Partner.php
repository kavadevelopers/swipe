<?php

namespace App\Models\Partners;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Partners\Traits\PartnerAttribute;
use App\Models\Partners\Traits\PartnerRelationship;

class Partner extends Model
{
    use ModelTrait,
        PartnerAttribute,
    	PartnerRelationship {
            // PartnerAttribute::getEditButtonAttribute insteadof ModelTrait;
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
        'id',
        'activation_code'
    ];

    /**
     * Constructor of Model
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
    
    function bankDetail(){
        return $this->hasOne('App\Models\Partners\PartnersBankdetails', 'user_id', 'id');
    }

    function adminDetail(){
        return $this->belongsTo('App\Models\Access\User\User','admin_id','id');
    }

}
