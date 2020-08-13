<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $table = 'wallet_transaction';
    protected $hidden = ['created_at', 'updated_at'];
}
