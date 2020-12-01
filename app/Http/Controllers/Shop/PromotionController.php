<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller
{
	public function availablePromotions()
	{
		$promotions = Promotion::query()->orderBy('priority', 'desc')->simplePaginate(10);
		$this->API_RESPONSE['STATUS'] = true;
		$this->API_RESPONSE['DATA'] = $promotions;
		return response()->json($this->API_RESPONSE);
	}

	public function promotions(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'tags' => ['required', 'array'],
			'tags.*' => ['required', 'string']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$promotions = Promotion::query()->whereJsonContains('tags', $validator['tags'])->with('products')->orderBy('priority', 'desc')->simplePaginate(2);
		}
	}
}
