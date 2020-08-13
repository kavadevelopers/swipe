<?php

namespace App\Models\Revenue\Traits;

/**
 * Class RevenueAttribute.
 */
trait RevenueAttribute
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
                $this->getShowButtonAttribute("show-revenue", "admin.revenues.show").
               
                '</div>';
        // return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-revenue", "admin.revenues.edit")}
        //         {$this->getDeleteButtonAttribute("delete-revenue", "admin.revenues.destroy")}
        //         </div>';
    }
}
