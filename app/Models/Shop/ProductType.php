<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
	use HasFactory;
	protected $table = 'shop_product_types';
	public $timestamps = false;


	/**
	 * -----------------------------------------
	 *	Relations
	 * -----------------------------------------
	 */

	public function products()
	{
		return $this->hasMany(Product::class, 'type_id', 'id');
	}

	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id', 'id');
	}
}
