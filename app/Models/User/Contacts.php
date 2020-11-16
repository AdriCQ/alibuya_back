<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
	use HasFactory;

	protected $table = 'user_contacts';
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
