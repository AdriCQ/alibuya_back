<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $type
 * @property string $path
 */
class Image extends Model
{
	use HasFactory;
	protected $table = 'shop_images';
	protected $guarded = ['id'];
}
