<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Announcement;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
	/**
	 * announcements
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function announcements(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'tags' => ['nullable', 'array'],
			'tags.*' => ['nullable', 'string'],
			'count' => ['nullable', 'integer']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$get = 5;
			if (isset($validator['count'])) {
				$get = $validator['count'];
			}

			if (isset($validator['tags'])) {
				$query = Announcement::query()->where('active', true)->whereJsonContains('tags', $validator['tags'])->with('image:id,title,paths')->orderBy('priority', 'desc')->simplePaginate($get);
			} else {
				$query = Announcement::query()->where('active', true)->with('image:id,title,paths')->orderBy('priority', 'desc')->simplePaginate($get);
			}
			$this->API_RESPONSE['DATA'] = $query;
			$this->API_RESPONSE['STATUS'] = true;
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * getById
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function getById(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'ann' => ['required', 'integer']
		]);
		if ($validator->fails()) {
			$this->API_RESPONSE['ERRORS'] = $validator->errors();
		} else {
			$validator = $validator->validate();
			$announcement = Announcement::query()->where('id', $validator['ann'])->with(['image:id,title,paths', 'products.image:id,title,paths'])->get();
			$this->API_RESPONSE['DATA'] = $announcement;
			$this->API_RESPONSE['STATUS'] = true;
		}
		return response()->json($this->API_RESPONSE);
	}

	/**
	 * 
	 */
	public function loadHomeAnnouncements()
	{
		$products = Product::query()->take(12)->get(Product::tableFields());
		$home = [];
		for ($i = 0; $i < 4; $i++) {
			array_push(
				$home,
				['type' => 'slider', 'title' => ['es' => 'Title'], 'products' => $products],
				['type' => 'row', 'cols' => [
					['type' => 'offer', 'title' => ['es' => 'Title'], 'products' => $products->toArray()[0]],
					['type' => 'grid', 'title' => ['es' => 'Title'], 'products' => array_slice($products->toArray(), 0, 4)],
					['type' => 'offer', 'title' => ['es' => 'Title'], 'products' => $products->toArray()[0]],
					['type' => 'grid', 'title' => ['es' => 'Title'], 'products' => array_slice($products->toArray(), 0, 4)]
				]],
				['type' => 'group', 'title' => ['es' => 'Title'], 'products' => $products],
			);
		}

		$this->API_RESPONSE['DATA'] = $home;
		$this->API_RESPONSE['STATUS'] = true;
		return response()->json($this->API_RESPONSE);
	}
}
