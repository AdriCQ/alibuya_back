<?php

namespace App\Models\Shop\Pivot;

use App\Models\Shop\Pack;
use App\Models\Shop\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackProduct extends Model
{
	use HasFactory;
	protected $table = 'shop_pack_products';
	protected $casts = [
		'shop_details' => 'array'
	];

	public static $STATUS =  ["created", "requested", "waiting", "ready", "canceled"];


	/**
	 * -----------------------------------------
	 *	Eloquent Relations
	 * -----------------------------------------
	 */

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_id', 'id');
	}

	public function pack()
	{
		return $this->belongsTo(Pack::class, 'pack_id', 'id');
	}
}
