<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
	use HasFactory;

	protected $table = 'shop_announcements';
	protected $guarded = ['id'];
	protected $casts = ['tags' => 'array', 'title' => 'object', 'text' => 'object'];

	public static $TYPES = ['banner', 'product-group', 'offer', 'discount'];

	/**
	 * -----------------------------------------
	 *	Eloquent Relations
	 * -----------------------------------------
	 */

	public function products()
	{
		return $this->belongsToMany(Product::class, 'shop_announcement_products');
	}

	public function image()
	{
		return $this->belongsTo(Image::class, 'image_id', 'id');
	}
}
