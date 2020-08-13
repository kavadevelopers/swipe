<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallet_money_add';
    protected $hidden = ['created_at', 'updated_at'];
}
