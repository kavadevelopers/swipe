<?php

namespace App\Models\PartnerPricing\Traits;

/**
 * Class PartnerPricingAttribute.
 */
trait PartnerPricingAttribute
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
                $this->getEditButtonAttribute("edit-partnerpricing", "admin.partnerpricings.edit").
                $this->getDeleteButtonAttribute("delete-partnerpricing", "admin.partnerpricings.destroy").
                '</div>';
        // '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-partnerpricing", "admin.partnerpricings.edit")}
        //         {$this->getDeleteButtonAttribute("delete-partnerpricing", "admin.partnerpricings.destroy")}
                // </div>';
    }
}
