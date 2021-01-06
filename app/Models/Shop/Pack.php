<?php

namespace App\Models\Shop;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $delivery_method
 * @property array $persons_info
 * @property boolean $buy
 * 
 * @property array $products
 * @property User $user
 */
class Pack extends Model
{
	use HasFactory;

	protected $table = 'shop_packs';
	protected $guarded = ['id'];
	protected $casts = ['persons_info' => 'array'];

	public static $STATUS =  ["created", "requested", "waiting", "ready", "canceled"];

	/**
	 * 
	 */
	public static function tableFields($extraFields = [])
	{
		$fields = ['id', 'delivery_method', 'persons_info'];
		if (count($extraFields))
			array_push($fields, $extraFields);
		return $fields;
	}

	public function price()
	{
		$price = 0;
		foreach ($this->products as $product) {
			$price += $product->price;
		}
		return $price;
	}

	/**
	 * -----------------------------------------
	 *	Relations
	 * -----------------------------------------
	 */

	public function products()
	{
		return $this->belongsToMany(Product::class, 'shop_pack_products')->withPivot(['cart_cant', 'options_details']);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
