<?php namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Lcobucci\JWT\Builder;

class User extends Authenticatable implements Uuidable
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

        return $this->HasOne(Account::class, 'id', 'account_id');
    }

    // Mehtods

    public static function findByUuId(string $uuid)
    {
        return self::where([
            'uuid' => $uuid
        ])->firstOrFail();
    }

    // Setters

    public function getNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function apiToken(User $user)
    {
        return (new Builder)->setIssuer(
            'http://api.tapklik.com'
        )->setAudience(
            'http://api.tapklik.com'
        )->setId(
            12345, true
        )->setIssuedAt(
            Carbon::now()->timestamp
        )->setExpiration(
            Carbon::now()->addDays(30)->timestamp
        )->set(
            'email', $user->email
        )->set(
            'id', $user->id
        )->set(
            'uuid', $user->uuid
        )->set(
            'accountId', $user->account_id
        )->set(
            'accountUuId', $user->account->uuid
        )->set(
            'name', $user->name
        )->set(
            'campaigns', Campaign::findByAccountId($user->account_id)->pluck('id')
        )->getToken();
    }
}
