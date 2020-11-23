<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
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
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validated = $validator->validate();
			$categoryTag = $validated['category'];
			// Find Category products
			$category = Category::query()->where('tag', $categoryTag)->first();
			if ($category) {
				$this->API_RESPONSE['DATA'] = $category->products->toQuery()->simplePaginate(10, Product::tableFields());
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
			'products_cant' => ['nullable', 'integer']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$category = Category::query()->where('tag', $validator['category'])->first();
			if ($category) {
				$products = $category->products->toQuery()->where('suggested', true)->orderBy('rating', 'desc');
				if (isset($validator['products_cant'])) {
					$this->API_RESPONSE['DATA'] = $products->take($validator['products_cant'])->get(Product::tableFields(['rating']));
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
		$categories = Category::all();
		$this->API_RESPONSE['DATA'] = $categories;
		return response()->json($this->API_RESPONSE);
	}
}
