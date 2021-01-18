<?php

namespace App\Models\User;

use App\Models\Shop\Vendor;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property string $gender
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $address
 * @property string $lang
 */
class User extends Authenticatable
{
	use HasFactory, Notifiable, HasRoles, HasApiTokens;

	protected $table = 'users';
	protected $guarded = ['id'];


	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	 * -----------------------------------------
	 *	Relations
	 * -----------------------------------------
	 */

	public function vendors()
	{
		return $this->hasMany(Vendor::class, 'user_id', 'id');
	}

	public function emailVerificationCode()
	{
		return $this->hasOne(EmailVerificationCode::class, 'user_id', 'id');
	}

	public function contacts()
	{
		return $this->hasMany(Contacts::class, 'user_id', 'id');
	}
}
