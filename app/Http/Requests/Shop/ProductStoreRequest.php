<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return $this->user()->can('products.create');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return
			[
				'title' => ['required', 'string'],
				'description' => ['required', 'array'],
				'description.*' => ['required', 'string'],
				'brand' => ['nullable', 'string'],
				'colors' => ['nullable', 'array'],
				'colors.*' => ['nullable', 'string'],
				'tax' => ['required', 'numeric'],
				'img_id' => ['nullable', 'integer'],
				'price' => ['required', 'numeric'],
				'weight' => ['required', 'integer'],
				'size' => ['nullable', 'string'],
				'tags' => ['required', 'array'],
				'tags.*' => ['required', 'string']
			];
	}
}
