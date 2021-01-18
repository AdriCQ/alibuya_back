<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Pack;
use App\Models\Shop\Pivot\PackProduct;
use App\Models\Shop\Pivot\VendorProduct;
use App\Models\Shop\Product;
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
			'products.*.cart_cant' => ['required', 'integer'],
			// TODO: Validate
			'products.*.options_details' => ['nullable', 'array'],
			'products.*.options_details.color' => ['nullable', 'string'],
			'products.*.options_details.size' => ['nullable', 'string'],
			// Persons Info
			'destinataries' => ['required', 'array'],
			'destinataries.*.first_name' => ['required', 'string'],
			'destinataries.*.last_name' => ['required', 'string'],
			'destinataries.*.address' => ['required', 'string']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();

			// Search products and check availability
			$pack = new Pack([
				'user_id' => auth()->user()->id,
				'delivery_method' => $validator['delivery_method'],
				'destinataries' => json_encode($validator['destinataries']),
			]);
			if ($pack->save()) {
				// Link pack products
				$packProductsArray = [];
				for ($i = 0; $i < count($validator['products']); $i++) {
					array_push($packProductsArray, [
						'pack_id' => $pack->id,
						'product_id' => $validator['products'][$i]['id'],
						'cart_cant' => $validator['products'][$i]['cart_cant'],
						'options_details' => json_encode($validator['products'][$i]['options_details']),
					]);
				}
				PackProduct::query()->insert($packProductsArray);
				$this->API_RESPONSE['DATA'] = $pack;
				$this->API_RESPONSE['STATUS'] = true;
			} else {
				$this->API_RESPONSE['ERRORS'] = $pack->errors;
			}
		}
		return response()->json($this->API_RESPONSE);
	}

	public function getProductsById(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'pack_id' => ['required', 'integer']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			// Find Pack
			$pack = Pack::query()->find($validator['pack_id']);
			if ($pack !== null) {
				$resp = [];
				foreach ($pack->products as $product) {
					array_push($resp, $product->pivot);
				}
				$this->API_RESPONSE['DATA'] = $resp;
			} else {
				$this->API_RESPONSE['ERRORS'] = ['No founded'];
			}
		}
		return response()->json($this->API_RESPONSE);
	}
}
