<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVerificationCode extends Model
{
	use HasFactory;
	protected $table = 'email_verification_codes';
	protected $guarded = ['id'];


	/**
	 * -----------------------------------------
	 *	Eloquent Relations
	 * -----------------------------------------
	 */

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
