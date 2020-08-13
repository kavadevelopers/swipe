<?php

namespace App\Models\PromoCodes\Traits;

/**
 * Class PromoCodeAttribute.
 */
trait PromoCodeAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">
                '.$this->getEditButtonAttribute("edit-promocode", "admin.promocodes.edit").'
                '.$this->getDeleteButtonAttribute("delete-promocode", "admin.promocodes.destroy").'
                </div>';
    }
}
