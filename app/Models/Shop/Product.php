<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use HasFactory;

	protected $table = 'shop_products';
	protected $guarded = ['id'];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'tags' => 'array',
		'options' => 'object'
	];

	/**
	 * 
	 */
	public static function tableFields($extraFields = [])
	{
		$fields = ['id', 'title', 'price', 'weight', 'tags'];
		if (count($extraFields))
			$fields = array_merge($fields, $extraFields);
		return $fields;
	}

	public function getImagesAttribute()
	{
		return $this->images;
	}

	/**
	 * -----------------------------------------
	 *	Eloquent Relationships
	 * -----------------------------------------
	 */

	public function category()
	{
		return $this->belongsToMany(Category::class, 'shop_category_products');
	}

	public function type()
	{
		return $this->belongsTo(ProductType::class, 'type_id', 'id');
	}

	public function vendors()
	{
		return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
	}

	public function images()
	{
		return $this->belongsToMany(Image::class, 'shop_product_images');
	}

	public function packs()
	{
		return $this->belongsToMany(Pack::class, 'shop_pack_products');
	}

	public function promotions()
	{
		return $this->belongsToMany(Category::class, 'shop_promotion_products');
	}
}
