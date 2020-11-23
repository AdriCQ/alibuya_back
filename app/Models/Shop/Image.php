<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageIntervention;

class Image extends Model
{
	use HasFactory;
	protected $table = 'shop_images';
	protected $guarded = ['id'];

	protected $casts = [
		'tags' => 'array',
		'paths' => 'array'
	];

	public $STORAGE_PATH = "/public/shop/images";
	public $PUBLIC_PATH = "/storage/shop/images";

	public function getUrlsAttribute()
	{
		$urls = [];
		foreach ($this->paths as $key => $path) {
			$urls[$key] = config('app.url') . $path;
		}
		return $urls;
	}

	/**
	 * Upload images 
	 * @example uploadImage($image, 'product', ['md', 'sm'])
	 * @param $image
	 * @param $type
	 * @param $sizes
	 */
	public function uploadImage($image, $type = 'product', $sizes = ['sm', 'md', 'lg'])
	{
		$filename =  sha1($image->getClientOriginalName()) . '_' . sha1(time()) . '.' . $image->getClientOriginalExtension();
		$storage_path = $this->STORAGE_PATH;
		$public_path = $this->PUBLIC_PATH;
		switch ($type) {
			case 'product':
				$storage_path .= '/product';
				$public_path .= '/product';
				break;
			case 'vendor':
				$storage_path .= '/vendor';
				$public_path .= '/vendor';
				break;
			default:
				$storage_path .= '/';
				$public_path .= '/';
		}
		$paths = [];
		for ($i = 0; $i < count($sizes); $i++) {
			$resizeName = $filename;
			switch ($sizes[$i]) {
				case 'sm':
					$resizeName = 'sm_' . $resizeName;
					break;
				case 'md':
					$resizeName = 'md_' . $resizeName;
					break;
				case 'lg':
					$resizeName = 'lg_' . $resizeName;
					break;
			}
			if ($resizeName !== $filename) {
				$pathCpy = $storage_path  . '/' . $resizeName;
				$paths[$sizes[$i]] = $public_path . '/' . $resizeName;
				Storage::put($pathCpy, '');
				$imageFile = ImageIntervention::make($image)
					->resize(150, null, function ($constraints) {
						$constraints->aspectRatio();
					})->save(storage_path('/app' . $pathCpy));
			}
		}
		$this->paths = $paths;
		return $this;
	}
}
