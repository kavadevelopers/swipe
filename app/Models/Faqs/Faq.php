<?php

namespace App\Models\Faqs;

use App\Models\BaseModel;
use App\Models\Faqs\Traits\Attribute\FaqAttribute;
use App\Models\ModelTrait;


class Faq extends BaseModel
{
    use ModelTrait,
        
        FaqAttribute {
            // FaqAttribute::getEditButtonAttribute insteadof ModelTrait;
        }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['question', 'answer', 'status'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'faqs';
    }
}
