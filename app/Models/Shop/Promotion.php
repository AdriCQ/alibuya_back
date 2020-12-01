<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
	use HasFactory;

	protected $table = 'shop_promotions';
	protected $guarded = ['id'];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'tags' => 'array'
	];

	/**
	 * -----------------------------------------
	 *	Eloquent Relationships
	 * -----------------------------------------
	 */

	public function products()
	{
		return $this->belongsToMany(Category::class, 'shop_promotion_products');
	}
}
