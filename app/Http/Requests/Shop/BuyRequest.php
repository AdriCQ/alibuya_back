<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class BuyRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'products' => ['array', 'required'],
			'product.*.id' => ['required', 'integer'],
			'delivery_method' => ['required', 'string'],
			'persons_info' => ['required', 'array'],
			'persons_info.*.name' => ['required', 'string'],
			'persons_info.*.last_name' => ['required', 'string'],
			'persons_info.*.address' => ['required', 'string'],
		];
	}
}
