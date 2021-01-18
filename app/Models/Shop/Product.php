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
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */

	/**
	 * 
	 */
	public static function tableFields($extraFields = [])
	{
		$fields = ['id', 'title', 'price', 'weight', 'tags', 'rating'];
		if (count($extraFields))
			$fields = array_merge($fields, $extraFields);
		return $fields;
	}

	/**
	 * -----------------------------------------
	 *	Eloquent Relationships
	 * -----------------------------------------
	 */

	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id', 'id');
	}

	public function type()
	{
		return $this->belongsTo(ProductType::class, 'type_id', 'id');
	}

	public function vendors()
	{
		return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
	}

	public function image()
	{
		return $this->belongsTo(Image::class, 'img_id', 'id');
	}

	public function images()
	{
		return $this->belongsToMany(Image::class, 'shop_product_images');
	}

	public function packs()
	{
		return $this->belongsToMany(Pack::class, 'shop_pack_products');
	}

	public function announcements()
	{
		return $this->belongsToMany(Announcement::class, 'shop_announcement_products');
	}

	public function coloImages()
	{
		return $this->belongsToMany(Image::class, 'shop_product_option_color_images');
	}
}
