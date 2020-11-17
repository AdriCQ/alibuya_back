<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
	public function list()
	{
	}

	public function allProducts(int $id)
	{
	}

	public function addProduct(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[]
		);
	}
}
