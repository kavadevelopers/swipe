<?php

namespace App\Models\Partnerfaq\Traits;

/**
 * Class PartnerfaqAttribute.
 */
trait PartnerfaqAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">'.
                $this->getEditButtonAttribute("edit-partnerfaq", "admin.partnerfaqs.edit").
                $this->getDeleteButtonAttribute("delete-partnerfaq", "admin.partnerfaqs.destroy").
                '</div>';
        // return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-partnerfaq", "admin.partnerfaqs.edit")}
                // {$this->getDeleteButtonAttribute("delete-partnerfaq", "admin.partnerfaqs.destroy")}
                // </div>';
    }
}
