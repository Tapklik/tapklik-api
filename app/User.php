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
		'account_id', 'first_name', 'last_name', 'phone', 'email', 'password', 'status', 'tutorial'
	];

	// Relationships

	public function account()
	{

		return $this->HasOne(Account::class, 'id', 'account_id');
	}

	public function messages()
	{

		return $this->belongsToMany(Message::class)->withPivot(['user_id', 'message_id', 'status']);
	}

	// Methods

	public static function findByUuId(string $uuid)
	{
		return self::where([
			'uuid' => $uuid
		])->firstOrFail();
	}

	public static function findByAccountId(int $id) {
		return User::selectRaw('users.*')
        ->where(['account_id' => $id])
        ->get();
	}

	// Setters

	public function getNameAttribute()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	public static function apiToken(User $user)
	{
		return (new Builder)->setIssuer(
			'https://api.tapklik.com'
		)->setAudience(
			'https://api.tapklik.com'
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
			'role', $user->is_admin ?: 'user'
		)->set(
			'tutorial', $user->tutorial
		)->set(
			'campaigns', Campaign::findByAccountId($user->account_id)->pluck('uuid')
		)->getToken();
	}
}
