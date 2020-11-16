<?php

namespace App\Models\Shop\Pivot;

use App\Models\Shop\Product;
use App\Models\Shop\Vendor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $vendor_id
 * @property int $product_id
 * @property int $cant
 */
class VendorProduct extends Model
{
	use HasFactory;
	protected $table = 'shop_vendor_products';
	protected $guarded = ['id'];

	/**
	 * -----------------------------------------
	 *	Relations
	 * -----------------------------------------
	 */

	public function vendor()
	{
		return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
	}

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_id', 'id');
	}
}
