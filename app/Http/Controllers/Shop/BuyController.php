<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Buy;
use App\Models\Shop\Pack;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BuyController extends Controller
{
	/**
	 * 
	 */
	public function buy(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'packs' => ['array', 'required'],
			'packs.*.id' => ['required', 'integer'],
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validated = $validator->validate();
			$packs = $validated['packs'];

			$price = 0;
			$packsWhereIn = [];
			foreach ($packs as $key => $value) {
				array_push($packsWhereIn, $value);
			}
			$dbPacks = Pack::query()->whereIn('id', $packsWhereIn);
			// Calculate Price
			foreach ($dbPacks->get('id', 'price') as $pack) {
				$price += $pack->price();
			}
			$buy = new Buy([
				'user_id' => auth()->user()->id,
				'price' => $price
			]);
			// TODO: Store pivot table
			$this->API_RESPONSE['DATA'] = $buy;
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * 
	 */
	public function userBuyList()
	{
		$user = auth()->user();
		$buyList = Buy::query()->where('user_id', $user->id)->get(Buy::tableFields());
		$this->API_RESPONSE['STATUS'] = true;
		$this->API_RESPONSE['validated'] = $buyList;
		return response()->json($this->API_RESPONSE);
	}
}
