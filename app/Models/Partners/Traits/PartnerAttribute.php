<?php

namespace App\Models\Partners\Traits;

/**
 * Class PartnerAttribute.
 */
trait PartnerAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-partner", "admin.partners.edit")}
                {$this->getDeleteButtonAttribute("delete-partner", "admin.partners.destroy")}
                </div>';
    }
}
