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
		'title' => 'array',
		'rating' => 'integer'
	];

	public $timestamps = false;

	public static $CATEGORIES = ['automotriz', 'cell', 'clothes', 'health', 'home', 'kids', 'pets'];

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
		return $this->belongsToMany(Product::class, 'shop_category_products');
	}
}
