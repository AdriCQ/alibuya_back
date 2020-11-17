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
		$this->API_RESPONSE['DATA'] = Product::simplePaginate(10, Product::tableFields());
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * 
	 */
	public function suggestedByTag(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'tags' => ['required', 'array'],
			'tags.*' => ['required', 'string']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validated = $validator->validate();
			$suggested = Product::query()->where('suggested', 1);
			foreach ($validated['tags'] as $key => $tag) {
				if ($key === 0)
					$suggested = $suggested->where('tags', 'like', '%' . $tag . '%');
				else {
					$suggested = $suggested->orWhere('tags', 'like', '%' . $tag . '%');
				}
			}
			$this->API_RESPONSE['DATA'] =
				$suggested->simplePaginate(10, Product::tableFields());
			$this->API_RESPONSE['STATUS'] = true;
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * 
	 */
	public function suggested()
	{
		$suggested = Product::query()->where('suggested', 1)->orderBy('rating', 'desc');
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
			$product = Product::query()->where('id', $validated['product_id'])->first();
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
	 * 
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
			$product = Product::query()->where('type_id', $validated['type_id'])->simplePaginate(20, Product::tableFields());
			if ($product) {
				$this->API_RESPONSE['STATUS'] = true;
				$this->API_RESPONSE['DATA'] = $product;
			} else {
				$this->API_RESPONSE['ERRORS'] = ['No encontrado'];
			}
		}
		return response()->json($this->API_RESPONSE);
	}
}
