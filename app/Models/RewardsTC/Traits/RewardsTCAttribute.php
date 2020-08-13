<?php

namespace App\Models\RewardsTC\Traits;

/**
 * Class RewardsTCAttribute.
 */
trait RewardsTCAttribute
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
                '.$this->getEditButtonAttribute("edit-rewardstc", "admin.rewardstcs.edit").'
                '.$this->getDeleteButtonAttribute("delete-rewardstc", "admin.rewardstcs.destroy") .'
                </div>';
    }
}
