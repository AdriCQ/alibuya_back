<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $vendor_id
 * @property string $title
 * @property array $description
 * @property int $img_id
 * @property float $price
 * @property int $rating
 * @property int $weight
 * @property string $size
 * @property boolean $suggested
 * @property array $tags
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
	];


	/**
	 * -----------------------------------------
	 *	Eloquent Relationships
	 * -----------------------------------------
	 */

	public function vendor()
	{
		return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
	}

	public function img()
	{
		return $this->hasOne(Image::class, 'img_id', 'id');
	}
}
