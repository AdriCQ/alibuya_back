<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property array $description
 * @property string $type
 */
class Vendor extends Model
{
	use HasFactory;

	protected $table = 'shop_vendors';

	protected $guarded = ['id'];

	protected $casts = [
		'description' => 'array'
	];

	/**
	 * -----------------------------------------
	 *	Eloquent Relations
	 * -----------------------------------------
	 */

	/**
	 * 
	 */
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function products()
	{
		return $this->hasMany(Product::class, 'vendor_id', 'id');
	}
}
