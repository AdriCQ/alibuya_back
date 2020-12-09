<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

	/**
	 * products
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function products(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'category' => ['required', 'string'],
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
			$categoryTag = $validated['category'];
			// Find Category products
			$category = Category::query()->where('tag', $categoryTag)->first();
			if ($category && count($category->products)) {
				$this->API_RESPONSE['DATA'] = $category->products->toQuery()->orderBy('rating', 'desc')->simplePaginate($max, Product::tableFields());
				$this->API_RESPONSE['STATUS'] = true;
			} else {
				$this->API_RESPONSE['ERRORS'] = ['No Category'];
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * suggestedProducts
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function suggestedProducts(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'category' => ['required', 'string'],
			'max' => ['nullable', 'integer']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$category = Category::query()->where('tag', $validator['category'])->first();
			if ($category) {
				$products = $category->products->toQuery()->where('suggested', true)->orderBy('rating', 'desc');
				if (isset($validator['max'])) {
					$this->API_RESPONSE['DATA'] = $products->take($validator['max'])->get(Product::tableFields(['rating']));
				} else {
					$this->API_RESPONSE['DATA'] = $products->take(8)->get(Product::tableFields(['rating']));
				}
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * categories
	 *
	 * @return void
	 */
	public function categories()
	{
		$categories = Category::query()->with('types')->get();
		$this->API_RESPONSE['DATA'] = $categories;
		$this->API_RESPONSE['STATUS'] = true;
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * productsByTypeTag
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function productsByTypeTag(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'type' => ['required', 'string'],
			'max' => ['nullable', 'integer']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$max = 12;
			if (isset($validator['max']))
				$max = $validator['max'];
			$query = ProductType::query()->where('tag', $validator['type']);
			if ($query->count() > 0) {
				$type  = $query->first();
				if (count($type->products)) {
					$products = $type->products->toQuery()->orderBy('rating', 'desc')->simplePaginate($max, Product::tableFields());
					$this->API_RESPONSE['DATA'] = $products;
					$this->API_RESPONSE['STATUS'] = true;
				}
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * getCategoriesByRating
	 *
	 * @return void
	 */
	public function getCategoriesByRating()
	{
		$categories = Category::query()->orderBy('rating', 'desc')->get();
		$this->API_RESPONSE['DATA'] = $categories;
		$this->API_RESPONSE['STATUS'] = true;
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * getTypesByRating
	 *
	 * @return void
	 */
	public function getTypesByRating()
	{
		$categories = ProductType::query()->orderBy('rating', 'desc')->get();
		$this->API_RESPONSE['DATA'] = $categories;
		$this->API_RESPONSE['STATUS'] = true;
		return response()->json($this->API_RESPONSE);
	}
}
