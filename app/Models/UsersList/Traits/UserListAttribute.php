<?php

namespace App\Models\UsersList\Traits;

/**
 * Class UserListAttribute.
 */
trait UserListAttribute
{
    // Make your attributes functions here
    // Further, see the documentation : https://laravel.com/docs/6.x/eloquent-mutators#defining-an-accessor


    /**
     * Action Button Attribute to show in grid
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn"> {$this->getEditButtonAttribute("edit-userlist", "admin.userlists.edit")}
                {$this->getDeleteButtonAttribute("delete-userlist", "admin.userlists.destroy")}
                </div>';
    }
}
