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
	 * Get All products on category
	 */
	public function products(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'category' => ['required', 'string']
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
}
