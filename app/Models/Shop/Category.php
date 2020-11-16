<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'shop_categories';

	protected $guarded = ['id'];

	protected $casts = [
		'title' => 'array'
	];

	public static $CATEGORIES = ['clothes', 'automotriz', 'cell', 'home', 'kids', 'health'];


	/**
	 * -----------------------------------------
	 *	Eloquent Relations
	 * -----------------------------------------
	 */

	public function products()
	{
		return $this->belongsToMany(Product::class, 'shop_category_products');
	}
}
