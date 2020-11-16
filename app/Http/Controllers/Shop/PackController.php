<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Pack;
use App\Models\Shop\Pivot\VendorProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackController extends Controller
{
	/**
	 * Store individual pack
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'delivery_method' => ['required', 'string'],
			// Products info
			'products' => ['required', 'array'],
			'products.*.id' => ['required', 'integer'],
			'products.*.cant' => ['required', 'integer'],
			// Persons Info
			'persons_info' => ['required', 'array'],
			'persons_info.*.first_name' => ['required', 'string'],
			'persons_info.*.last_name' => ['required', 'string'],
			'persons_info.*.address' => ['required', 'string']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validated = $validator->validate();

			// Search products and check availability
			$reqProducts = $validated['products'];
			$reqProductsIdArray = [];
			foreach ($reqProducts as $product) {
				array_push($reqProductsIdArray, $product['id']);
			}
			$productsQuery = VendorProduct::query()->whereIn('product_id', $reqProductsIdArray)->with('product:id,price,weight')->get();
			$this->API_RESPONSE['DATA'] = $productsQuery;
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * Get Packs not bought by authenticated user
	 */
	public function userNoBought()
	{
		$user = auth()->user();
		$packsQuery = Pack::query()->where([['buy', 0], ['user_id', $user->id]])->with('products')->get();
		$this->API_RESPONSE['DATA'] = $packsQuery;
		$this->API_RESPONSE['STATUS'] = true;
		return response()->json($this->API_RESPONSE);
	}
}
