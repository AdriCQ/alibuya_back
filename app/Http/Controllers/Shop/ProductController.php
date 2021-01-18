<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Image;
use App\Models\Shop\Product;
use App\Models\Shop\ProductType;
use App\Models\Shop\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
	/**
	 * store
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'title' => ['required', 'string', 'max:255'],
			'brand' => ['nullable', 'string', 'max:63'],
			'description' => ['required', 'string'],
			'price' => ['required', 'numeric', 'min:0'],
			'weight' => ['nullable', 'integer', 'min:0'],
			'tags' => ['required', 'array'],
			'tags.*' => ['required', 'string', 'max:63'],
			'options' => ['nullable', 'array'],
			'options.colors' => ['nullable', 'array'],
			'options.colors.*' => ['nullable', 'string'],
			'vendor_id' => ['required', 'integer', 'min:1'],
			'type_id' => ['required', 'integer', 'min:1'],
			'available_cant' => ['required', 'integer'],
			'image' => ['required', 'image'],
			'category' => ['required', 'string'],
			'type' => ['required', 'string']
			// 'images' => ['required', 'array'],
			// 'images.*' => ['required', 'image']
		]);
		// return response()->json($request);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$user = auth()->user();
			// Get Vendor
			$vendor = Vendor::query()->where([['id', $validator['vendor_id']], ['user_id', $user->id]])->first();

			// Get category
			$type = ProductType::query()->where('tag', $validator['type']);
			if ($type->exists()) {
				$type = $type->first();
				$category = $type->category;

				//? Check if user has permissions
				if ($vendor || $user->hasRole('Admin')) {
					// Save product
					$productModel = new Product();
					$productModel->type_id = $type->id;
					$productModel->category_id = $category->id;
					$productModel->title = $validator['title'];
					if (isset($validator['brand']))
						$productModel->brand = $validator['brand'];
					$productModel->description = $validator['description'];
					$productModel->price = $validator['price'];
					if (isset($validator['weight']))
						$productModel->weight = $validator['weight'];
					$productModel->tags = $validator['tags'];
					if (isset($validator['options'])) {
						$options = [];
						if (isset($validator['options']['colors']))
							$options['colors'] = $validator['options']['colors'];
						$productModel->options = $options;
					}
					$productModel->vendor_id = $validator['vendor_id'];
					$productModel->type_id = $validator['type_id'];
					$productModel->available_cant = $validator['available_cant'];

					$imageCoverFile = $validator['image'];
					$imageCoverModel = new Image();
					$imageCoverModel->uploadImage($imageCoverFile, 'product');
					$imageCoverModel->tags = $validator['tags'];
					$imageCoverModel->title = $validator['title'] . '-cover';
					$imageCoverModel->save();

					$productModel->img_id = $imageCoverModel->id;
					//? Check if save roduct
					if ($productModel->save()) {
						// Start Save images

						// $imageFiles = $validator['images'];
						// $imageModels = [];
						// $counter = 0;
						// foreach ($imageFiles as $imageFile) {
						// 	$imageModels[$counter] = new Image();
						// 	$imageModels[$counter]->uploadImage($imageFile, 'product');
						// 	$imageModels[$counter]->tags = $validator['tags'];
						// 	$imageModels[$counter]->title = $validator['title'] . '-image';
						// 	$counter++;
						// }
						// return response()->json($imageModels);
						// if ($m) {
						$this->API_RESPONSE['STATUS'] = true;
						// $productModel->images;
						$this->API_RESPONSE['DATA'] = $productModel;
					} else {
						$this->API_RESPONSE['ERRORS'] = $productModel->errors;
					}
				} else {
					$this->API_RESPONSE['ERRORS'] = ['No type found'];
				}
			}
			//! Catch user has permissions
			else {
				$this->API_RESPONSE['ERRORS'] = ['No existe'];
			}
		}

		return response()->json($this->API_RESPONSE);
	}

	/**
	 * 
	 */
	public function allPaginated()
	{
		$this->API_RESPONSE['STATUS'] = true;
		$this->API_RESPONSE['DATA'] = Product::query()->with('image')->simplePaginate(10, Product::tableFields());
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * 
	 */
	public function suggestedByTag(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'tags' => ['required', 'array'],
			'tags.*' => ['required', 'string'],
			'max' => ['nullable', 'integer']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validated = $validator->validate();
			$max = 12;
			if (isset($validated['max'])) {
				$max = $validated['max'];
			}
			$suggested = Product::query()->where('suggested', 1);
			foreach ($validated['tags'] as $key => $tag) {
				if ($key === 0)
					$suggested = $suggested->where('tags', 'like', '%' . $tag . '%');
				else {
					$suggested = $suggested->orWhere('tags', 'like', '%' . $tag . '%');
				}
			}
			$this->API_RESPONSE['DATA'] =
				$suggested->with('image')->simplePaginate($max, Product::tableFields());
			$this->API_RESPONSE['STATUS'] = true;
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * 
	 */
	public function suggested()
	{
		$suggested = Product::query()->where('suggested', 1)->with('image')->orderBy('rating', 'desc');
		$this->API_RESPONSE['DATA'] =
			$suggested->simplePaginate(10, Product::tableFields());
		$this->API_RESPONSE['STATUS'] = true;
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * 
	 */
	public function getById(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'product_id' => ['required', 'integer']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validated = $validator->validate();
			$product = Product::query()->where('id', $validated['product_id'])->with(['image', 'images'])->first();
			if ($product) {
				$this->API_RESPONSE['STATUS'] = true;
				$this->API_RESPONSE['DATA'] = $product;
			} else {
				$this->API_RESPONSE['ERRORS'] = ['No encontrado'];
			}
		}
		return response()->json($this->API_RESPONSE);
	}


	/**
	 * getByTypeId
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function getByTypeId(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'type_id' => ['required', 'number']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validated = $validator->validate();
			$product = Product::query()->where('type_id', $validated['type_id'])->with('image')->simplePaginate(20, Product::tableFields());
			if ($product) {
				$this->API_RESPONSE['STATUS'] = true;
				$this->API_RESPONSE['DATA'] = $product;
			} else {
				$this->API_RESPONSE['ERRORS'] = ['No encontrado'];
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * search
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function search(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'search' => ['required', 'string']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$query = Product::query()->whereJsonContains('tags', $validator['search'])
				->orWhere('title', 'like', '%' . $validator['search'] . '%')
				->orWhere('description', 'like', '%' . $validator['search'] . '%')
				->orWhere('brand', 'like', '%' . $validator['search'] . '%');
			$this->API_RESPONSE['DATA'] = $query->orderBy('rating', 'desc')->with('image')->simplePaginate(10, Product::tableFields(['rating']));
			$this->API_RESPONSE['STATUS'] = true;
		}
		return response()->json($this->API_RESPONSE);
	}
}
