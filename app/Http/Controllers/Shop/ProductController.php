<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\ProductStoreRequest;
use App\Models\Shop\Pivot\VendorProduct;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
	public function store(ProductStoreRequest $request)
	{
		$data = $request->validate();
	}

	/**
	 * 
	 */
	public function allPaginated()
	{
		$this->API_RESPONSE['STATUS'] = true;
		$this->API_RESPONSE['DATA'] = Product::simplePaginate(10);
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * 
	 */
	public function suggested(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'tags' => ['required', 'array'],
			'tags.*' => ['required', 'string']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validated = $validator->validate();
			$suggestedProductsId = VendorProduct::query()->where('suggested', 1)->get('product_id');
			$productsIdArray = [];
			foreach ($suggestedProductsId as $key) {
				array_push($productsIdArray, $key->product_id);
			}
			$suggested = Product::query()->whereIn('id', $productsIdArray);
			foreach ($validated['tags'] as $key => $tag) {
				if ($key === 0)
					$suggested = $suggested->where('tags', 'like', '%' . $tag . '%');
				else {
					$suggested = $suggested->orWhere('tags', 'like', '%' . $tag . '%');
				}
			}
			$this->API_RESPONSE['DATA'] = $suggested->simplePaginate(10);
			$this->API_RESPONSE['STATUS'] = true;
		}
		return response()->json($this->API_RESPONSE);
	}
}
