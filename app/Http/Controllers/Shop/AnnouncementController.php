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

	public function loadHomeAnnouncements()
	{
		$home = [];
		// Suggested Products
		$products = Product::query()->orderBy('rating', 'desc')->with('image:id,title,paths');
		$home['suggested'] = [
			'title' => ['es' => 'Lo más comprado', 'en' => 'Lo más comprado'],
			'products' => $products->take(4)->get(Product::tableFields())
		];

		$home['special_offer'] = [
			'title' => ['es' => 'Oferta Especial', 'en' => 'Special Offer'],
			'product' => $products->first(Product::tableFields())
		];

		// Home Grids
		$home['grids'] = [];
		array_push($home['grids'], [
			[
				'title' => ['es' => 'Rebajas de Ropas', 'en' => 'Special Offer'],
				'products' => $products->take(4)->get(Product::tableFields()),
				'options' => [
					'type' => 'beauty.male_clothes'
				]
			],
			[
				'title' => ['es' => 'Mascotas', 'en' => 'Pets'],
				'products' => $products->take(4)->get(Product::tableFields()),
				'options' => [
					'type' => 'home.pets'
				]
			],
			[
				'title' => ['es' => 'Deportes', 'en' => 'Sports'],
				'products' => $products->take(4)->get(Product::tableFields()),
				'options' => [
					'type' => 'sport.run'
				]
			]
		]);

		$home['sliders'] = [];
		array_push($home['sliders'], [
			[
				'title' => ['es' => 'Electrodomésticos', 'en' => 'Sports'],
				'products' => $products->take(12)->get(Product::tableFields())
			],
			[
				'title' => ['es' => 'Salud y Bienestar', 'en' => 'Health'],
				'products' => $products->take(12)->get(Product::tableFields())
			],
			[
				'title' => ['es' => 'Autos y Piezas', 'en' => 'Sports'],
				'products' => $products->take(12)->get(Product::tableFields())
			], [
				'title' => ['es' => 'Informática y Celulares', 'en' => 'Sports'],
				'products' => $products->take(12)->get(Product::tableFields())
			],
		]);

		$this->API_RESPONSE['DATA'] = $home;
		$this->API_RESPONSE['STATUS'] = true;
		return response()->json($this->API_RESPONSE);
	}
}
