<?php

namespace App\Events\Backend\Access\Role;

use Illuminate\Queue\SerializesModels;

/**
 * Class RoleCreated.
 */
class RoleCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $role;

    /**
     * @param $role
     */
    public function __construct($role)
    {
        \Log::info("Roll ---> ".json_encode($role));
        $this->role = $role;
    }
}
