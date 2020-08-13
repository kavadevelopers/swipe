<?php

namespace App\Models\PushNotification;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    public function __construct()
    {
        $this->table = config('access.push_notifications_table');
    }
}
