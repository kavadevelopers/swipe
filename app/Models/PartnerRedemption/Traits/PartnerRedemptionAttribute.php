<?php

namespace App\Models\PartnerRedemption\Traits;

/**
 * Class PartnerRedemptionAttribute.
 */
trait PartnerRedemptionAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-partnerredemption", "admin.partnerredemptions.edit")}
                {$this->getDeleteButtonAttribute("delete-partnerredemption", "admin.partnerredemptions.destroy")}
                </div>';
    }
}
