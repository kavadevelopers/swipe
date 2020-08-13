<?php

namespace App\Models\RewardsTC;

use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\RewardsTC\Traits\RewardsTCAttribute;
use App\Models\RewardsTC\Traits\RewardsTCRelationship;

class RewardsTC extends Model
{
    use ModelTrait,
        RewardsTCAttribute,
    	RewardsTCRelationship {
            // RewardsTCAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * NOTE : If you want to implement Soft Deletes in this model,
     * then follow the steps here : https://laravel.com/docs/6.x/eloquent#soft-deleting
     */

    /**
     * The database table used by the model.
     * @var string
     */
    protected $table = 'rewards-terms-and-conditions';

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
}
