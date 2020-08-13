<?php

namespace App\Models\Liability\Traits;

/**
 * Class LiabilityAttribute.
 */
trait LiabilityAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-liability", "admin.liabilities.edit")}
                {$this->getDeleteButtonAttribute("delete-liability", "admin.liabilities.destroy")}
                </div>';
    }
}
