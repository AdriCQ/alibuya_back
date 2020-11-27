<?php

namespace Database\Factories\Shop;

use App\Models\Shop\Category;
use App\Models\Shop\Image;
use App\Models\Shop\Product;
use App\Models\Shop\ProductType;
use App\Models\Shop\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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
		$maxVendor = Vendor::query()->count();
		$colors = [];
		for ($i = 0; $i < 10; $i++) {
			array_push($colors, $this->faker->colorName);
		}
		$maxType = ProductType::query()->count();
		return [
			// 'vendor_id' => $this->faker->numberBetween(1, $maxVendor),
			'title' => $this->faker->words(3, true),
			'brand' => $this->faker->word,
			'options' => [
				'colors' => $this->faker->randomElements($colors, 3),
				'size' => $this->faker->numberBetween(1, 100) . 'cm;' . $this->faker->numberBetween(1, 100) . 'cm;' . $this->faker->numberBetween(1, 100) . 'cm',
				'sizes' => $this->faker->randomElements(['25', '26', '27', '28', '29', '30', '31'], 3)
			],
			'tax' => $this->faker->randomFloat(2, 0, 200),
			'description' => "<p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vel iste eaque debitis facilis ducimus eveniet earum, quod veritatis,</p><p>nam incidunt quis culpa voluptates reiciendis aliquid! Iste itaque quibusdam reprehenderit voluptatibus!</p>",
			'price' => $this->faker->randomFloat(2, 0, 5000),
			'rating' => $this->faker->numberBetween(0, 5),
			'weight' => $this->faker->numberBetween(0, 1000),
			'tags' => $this->faker->randomElements(Category::$CATEGORIES),
			'suggested' => $this->faker->boolean(),
			'type_id' => $this->faker->numberBetween(1, $maxType),
			'active' => $this->faker->boolean(),
		];
	}
}
