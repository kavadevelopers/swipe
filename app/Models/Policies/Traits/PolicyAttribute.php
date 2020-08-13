<?php

namespace App\Models\Policies\Traits;

/**
 * Class PolicyAttribute.
 */
trait PolicyAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-policy", "admin.policies.edit")}
                {$this->getDeleteButtonAttribute("delete-policy", "admin.policies.destroy")}
                </div>';
    }
}
