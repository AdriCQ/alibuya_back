<?php

namespace App\Models\Shop;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property float $price
 * 
 * @property mixed $packs
 */
class Buy extends Model
{
	use HasFactory;

	protected $table = 'shop_buy';
	protected $guarded = ['id'];

	public static $STATUS =  ["created", "requested", "waiting", "ready", "canceled"];

	/**
	 * 
	 */
	public static function tableFields($extraFields = [])
	{
		$fields = ['id', 'price'];
		if (count($extraFields))
			array_push($fields, $extraFields);
		return $fields;
	}

	/**
	 * -----------------------------------------
	 *	Relations
	 * -----------------------------------------
	 */

	public function packs()
	{
		return $this->belongsToMany(Pack::class, 'shop_buy_packs');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
