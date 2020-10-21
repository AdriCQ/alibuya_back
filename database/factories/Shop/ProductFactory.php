<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Image;
use App\Models\Shop\Product;
use App\Models\Shop\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Product::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$vendorMax = Vendor::query()->count();
		$imgMax = Image::query()->count();
		return [
			// 'vendor_id' => $this->faker->numberBetween(1, $vendorMax),
			'img_id' => $this->faker->numberBetween(1, $imgMax),
			'title' => $this->faker->words(3, true),
			'description' => json_encode($this->faker->words(8)),
			'price' => $this->faker->randomFloat(2, 0, 5000),
			'rating' => $this->faker->numberBetween(0, 5),
			'weight' => $this->faker->numberBetween(0, 1000),
			'size' => $this->faker->numberBetween(1, 100) . ';' . $this->faker->numberBetween(1, 100) . ';' . $this->faker->numberBetween(1, 100),
			'suggested' => $this->faker->boolean,
			'tags' => json_encode(['clothes', 'cars', 'electrodomestic'])
		];
	}
}
