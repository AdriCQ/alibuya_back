<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Image;
use App\Models\Shop\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'image' => ['nullable', 'file'],
			'title' => ['required', 'string'],
			'description' => ['required', 'string'],
			'tags' => ['required', 'array'],
			'tags.*' => ['required', 'string']
		]);
		// return response()->json($request);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$_validator = $validator->validate();
			$user = auth()->user();
			//? Check if User has vendor
			if (!$user->vendors->count()) {
				$imageFile = $request->file('image');
				// return response()->json($imageFile);

				$imageModel = new Image();
				$imageModel->uploadImage($imageFile, 'vendor');
				$imageModel->title = $_validator['title'] . '-image';
				$imageModel->tags = $_validator['tags'];
				// Save Image
				if ($imageModel->save()) {
					$vendorModel = new Vendor([
						'user_id' => $user->id,
						'title' => $_validator['title'],
						'description' => $_validator['description'],
						'tags' => $_validator['tags'],
						'img_id' => $imageModel->id
					]);
					// Save Vendor
					if ($vendorModel->save()) {
						$this->API_RESPONSE['DATA'] = [
							'id' => $vendorModel->id,
							'active' => $vendorModel->active,
							'title' => $vendorModel->title,
							'tags' => $vendorModel->tags,
							'description' => $vendorModel->description,
							'image' => [
								'title' => $imageModel->title,
								'paths' => $imageModel->paths
							]
						];
						$this->API_RESPONSE['STATUS'] = true;
					}
					//! Save Vendor Error
					else {
						$this->API_RESPONSE['ERRORS'] = $vendorModel->errors;
					}
					//! Save Image Error
				} else {
					$this->API_RESPONSE['ERRORS'] = $imageModel->errors;
				}
			}
			//! Catch User has vendor Error
			else {
				$this->API_RESPONSE['ERRORS'] = ['Ya tiene una tienda configurada'];
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * 
	 */
	public function getByAuth()
	{
		$user = auth()->user();
		$vendors = $user->vendors->first();
		if ($vendors) {
			$image = $vendors->image;
			unset($vendors['image']);
			$vendors['image'] = [
				'title' => $image->title,
				'paths' => $image->urls,
				'tags' => $image->tags
			];
		}
		$this->API_RESPONSE['STATUS'] = true;
		$this->API_RESPONSE["DATA"] = $vendors;
		return response()->json($this->API_RESPONSE);
	}
}
