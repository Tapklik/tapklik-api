<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id', 'first_name', 'last_name', 'phone', 'email', 'password',
    ];

    // Relationships

    public function account() {

        return $this->HasMany(Account::class);
    }

    // Mehtods

    public static function findByUuId($uuid)
    {
        return self::where([
            'uuid' => $uuid
        ])->firstOrFail();
    }
}
