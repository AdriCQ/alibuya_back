<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller
{
	/**
	 * availablePromotions
	 *
	 * @return void
	 */
	public function availablePromotions()
	{
		$promotions = Promotion::query()->orderBy('priority', 'desc')->simplePaginate(10);
		$this->API_RESPONSE['STATUS'] = true;
		$this->API_RESPONSE['DATA'] = $promotions;
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * promotionsByTags
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function promotionsByTags(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'tags' => ['required', 'array'],
			'tags.*' => ['required', 'string'],
			'cant' => ['nullable', 'integer']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$cant = 1;
			if (isset($validator['cant'])) {
				$cant = $validator['cant'];
			}
			$promotions = Promotion::query()->whereJsonContains('tags', $validator['tags'])->orderBy('priority', 'desc')->with(['products:id,title,price,weight,rating,img_id', 'products.image:id,title,paths'])->take($cant)->get();
			$this->API_RESPONSE['DATA'] = $promotions;
			$this->API_RESPONSE['STATUS'] = true;
		}
		return response()->json($this->API_RESPONSE);
	}
}
