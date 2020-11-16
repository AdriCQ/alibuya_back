<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $brand
 * @property string $colors
 * @property float $tax
 * @property array $description
 * @property int $img_id
 * @property float $price
 * @property int $rating
 * @property int $weight
 * @property string $size
 * @property boolean $suggested
 * @property array $tags
 * 
 * @property mixed $vendors
 * @property mixed $img
 * @property mixed $packs
 */
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
		'description' => 'array',
		'tags' => 'array',
		"colors" => 'array'
	];


	public static function validationRules()
	{
		return [
			'title' => ['required', 'string'],
			'description' => ['required', 'array'],
			'description.*' => ['required', 'string'],
			'brand' => ['nullable', 'string'],
			'colors' => ['nullable', 'array'],
			'colors.*' => ['nullable', 'string'],
			'tax' => ['required', 'numeric'],
			'img_id' => ['nullable', 'integer'],
			'price' => ['required', 'numeric'],
			'weight' => ['required', 'integer'],
			'size' => ['nullable', 'string'],
			'tags' => ['required', 'array'],
			'tags.*' => ['required', 'string']
		];
	}

	/**
	 * 
	 */
	public static function tableFields($extraFields = [])
	{
		$fields = ['id', 'tax', 'price', 'weight', 'tags'];
		if (count($extraFields))
			array_push($fields, $extraFields);
		return $fields;
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

	public function vendors()
	{
		return $this->belongsToMany(Vendor::class, 'shop_vendor_products');
	}

	public function img()
	{
		return $this->hasOne(Image::class, 'img_id', 'id');
	}

	public function packs()
	{
		return $this->belongsToMany(Pack::class, 'shop_pack_products');
	}
}
