<?php

namespace App\Models\Access\User;

use App\Models\Access\User\Traits\Attribute\UserAttribute;
use App\Models\Access\User\Traits\Relationship\UserRelationship;
use App\Models\Access\User\Traits\Scope\UserScope;
use App\Models\Access\User\Traits\UserAccess;
use App\Models\Access\User\Traits\UserSendPasswordReset;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User.
 */
class User extends Authenticatable
{
    // protected $table = "admin";
    use UserScope,
        UserAccess,
        Notifiable,
        SoftDeletes,
        UserAttribute,
        UserRelationship,
        UserSendPasswordReset,
        HasApiTokens;

    /**
     * The database table used by the model.
     *
     * @var string
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'designation',
        'contact_no',
        'status',
        'emergency_name',
        'emergency_relationship',
        'emergency_contact',
        'email',
        'status',
        'confirmation_code',
        'confirmed',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'admin';
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'id'          => $this->id,
            'first_name'  => $this->first_name,
            'last_name'   => $this->last_name,
            'email'       => $this->email,
            'picture'     => $this->getPicture(),
            'confirmed'   => $this->confirmed,
            'role'        => optional($this->roles()->first())->name,
            'permissions' => $this->permissions()->get(),
            'status'      => $this->status,
            'created_at'  => $this->created_at->toIso8601String(),
            'updated_at'  => $this->updated_at->toIso8601String(),
        ];
    }

    public function fullname()
    {
        return "$this->first_name $this->last_name";
    }
}
