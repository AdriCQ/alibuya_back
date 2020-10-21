<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
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
			$suggested = Product::query()->where('suggested', 1);
			foreach ($validated['tags'] as $key => $tag) {
				if ($key === 0)
					$suggested = $suggested->where('tags', 'like', '%' . $tag . '%');
				else {
					$suggested = $suggested->orWhere('tags', 'like', '%' . $tag . '%');
				}
			}
			$this->API_RESPONSE['DATA'] = $suggested->get();
			$this->API_RESPONSE['STATUS'] = true;
		}
		return response()->json($this->API_RESPONSE);
	}
}
