<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'shop_categories';

	protected $guarded = ['id'];

	protected $appends = ['rating'];

	protected $casts = [
		'rating' => 'integer',
		'title' => 'object'
	];

	public $timestamps = false;

	public static $CATEGORIES = ['sport', 'kid', 'home', 'transport', 'food', 'health', 'tech', 'beauty'];

	public function getRatingAttribute()
	{
		$catProducts = $this->products;
		$rating = 0;
		if (count($catProducts)) {
			$allRating = $catProducts->toQuery()->get('rating');
			$counter = 0;
			foreach ($allRating as $value) {
				$rating += $value->rating;
				$counter++;
			}
			$rating = $rating / $counter;
		}
		unset($this['products']);
		return round($rating);
	}

	/**
	 * -----------------------------------------
	 *	Eloquent Relations
	 * -----------------------------------------
	 */

	public function products()
	{
		return $this->hasMany(Product::class, 'category_id', 'id');
	}

	public function types()
	{
		return $this->hasMany(ProductType::class, 'category_id', 'id');
	}
}
