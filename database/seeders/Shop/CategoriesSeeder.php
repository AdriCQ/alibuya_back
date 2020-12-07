<?php

namespace Database\Seeders\Shop;

use App\Models\Shop\Category;
use App\Models\Shop\ProductType;
use Illuminate\Database\Seeder;

/**
 * ShopSeeder
 */
class CategoriesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->seedCategories();
	}

	/**
	 * seed Categories
	 *
	 * @return void
	 */
	private function seedCategories()
	{
		$categories = [
			// Sport
			[
				'tag' => 'sport',
				'title' => ['es' => 'Deportes', 'en' => 'Sports'],
				'types' => [
					['tag' => 'sport.run', 'title' => ['es' => 'Caminar y Correr', 'en' => 'Walk and Run']],
					['tag' => 'sport.energic', 'title' => ['es' => 'Energizantes y Suplementos', 'en' => 'Supplements']],
					['tag' => 'sport.fitness', 'title' => ['es' => 'Ejercicios y Fitness', 'en' => 'Fitness']],
					['tag' => 'sport.cyclysm', 'title' => ['es' => 'Ciclismo', 'en' => 'Cyclysm']],
					['tag' => 'sport.water', 'title' => ['es' => 'Deportes Acuáticos', 'en' => 'Water']],
					['tag' => 'sport.camping', 'title' => ['es' => 'Acampada', 'en' => 'Camping']],
					['tag' => 'sport.yoga', 'title' => ['es' => 'Yoga', 'en' => 'Yoga']],
					['tag' => 'sport.clothes', 'title' => ['es' => 'Ropa Deportiva', 'en' => 'Sporting Clothes']],
					['tag' => 'sport.electronic', 'title' => ['es' => 'GPS y Electrónica', 'en' => 'Electronic & GPS']],
				]
			],
			// Kids
			[
				'tag' => 'kid',
				'title' => ['es' => 'Niños y Juguetes', 'en' => 'Kids & Toys'],
				'types' => [
					['tag' => 'kid.toy', 'title' => ['es' => 'Juguetes', 'en' => 'Toys']],
					['tag' => 'kid.baby', 'title' => ['es' => 'Bebés', 'en' => 'Baby']],
					['tag' => 'kid.clothes', 'title' => ['es' => 'Ropa de Niños', 'en' => "Kid's Clothes"]],
				]
			],
			// Home
			[
				'tag' => 'home',
				'title' => ['es' => 'Hogar, Jardinería, Bricolaje y Mascotas', 'en' => 'Hogar, Jardinería, Bricolaje y Mascotas'],
				'types' => [
					['tag' => 'home.kitchen', 'title' => ['es' => 'Cocina y Comedor', 'en' => 'Kitchen & Dinner Room']],
					['tag' => 'home.bedroom', 'title' => ['es' => 'Dormitorio', 'en' => 'Bedroom']],
					['tag' => 'home.bathroom', 'title' => ['es' => 'Baño', 'en' => 'Badroom']],
					['tag' => 'home.garden', 'title' => ['es' => 'Jardín', 'en' => 'Garden']],
					['tag' => 'home.light', 'title' => ['es' => 'Iluminación', 'en' => 'Lights']],
					['tag' => 'home.clima', 'title' => ['es' => 'Clima', 'en' => 'Clima']],
					['tag' => 'home.electrodomestic', 'title' => ['es' => 'Electrodomésticos', 'en' => 'Electrodomestics']],
					['tag' => 'home.clean', 'title' => ['es' => 'Limpieza', 'en' => 'Clean']],
					['tag' => 'home.security', 'title' => ['es' => 'Seguridad', 'en' => 'Security']],
					['tag' => 'home.pets', 'title' => ['es' => 'Mascotas', 'en' => 'Pets']],
					['tag' => 'home.electric', 'title' => ['es' => 'Instalación Eléctrica', 'en' => 'Electricity']],
					['tag' => 'home.floor', 'title' => ['es' => 'Azulejos', 'en' => 'Azulejos']],
				]
			],
			// Transport
			[
				'tag' => 'transport',
				'title' => ['es' => 'Auto, Motores, Motorinas', 'en' => 'Cars & Motors'],
				'types' => [
					['tag' => 'transport.car', 'title' => ['es' => 'Autos y Piezas', 'en' => 'Cars & Pieces']],
					['tag' => 'transport.moto', 'title' => ['es' => 'Motores', 'en' => 'Motors']],
					['tag' => 'transport.electric', 'title' => ['es' => 'Eléctricos', 'en' => 'Electrical']],
					['tag' => 'transport.tools', 'title' => ['es' => 'Taller', 'en' => 'Garage']],
					['tag' => 'transport.pieces', 'title' => ['es' => 'Piezas', 'en' => 'Pieces']],
				]
			],
			// Food
			[
				'tag' => 'food',
				'title' => ['es' => 'Alimentos y Bebidas', 'en' => 'Foods & Drinks'],
				'types' => [
					['tag' => 'food.confiture', 'title' => ['es' => 'Dulces y Confituras', 'en' => 'Candies & Confiture']],
					['tag' => 'food.drink', 'title' => ['es' => 'Bebidas', 'en' => 'Drinks']],
				]
			],
			// Health
			[
				'tag' => 'health',
				'title' => ['es' => 'Salud y Bienestar', 'en' => 'Health'],
				'types' => [
					['tag' => 'health.pills', 'title' => ['es' => 'Medicamentos', 'en' => 'Pills']],
					[
						'tag' => 'health.natural', 'title' => ['es' => 'Medicina Natural', 'en' => 'Natural Medicine'],
						['tag' => 'health.tools', 'title' => ['es' => 'instrumentos de Salud', 'en' => 'Tools']],
					]
				],
				// Tech
				[
					'tag' => 'tech',
					'title' => ['es' => 'Informática y Celulares', 'en' => 'Phones & PC'],
					'types' => [
						['tag' => 'tech.laptop', 'title' => ['es' => 'Laptop', 'en' => 'Laptop']],
						['tag' => 'tech.pc', 'title' => ['es' => 'PC', 'en' => 'Desktop PC']],
						['tag' => 'tech.pieces', 'title' => ['es' => 'Piezas de Computadoras', 'en' => 'PC pieces']],
						['tag' => 'tech.cell', 'title' => ['es' => 'Celulares y Accesorios', 'en' => 'Phones & Accesories']],
					]
				],
			],
			// Beauty
			[
				'tag' => 'beauty',
				'title' => ['es' => 'Ropas y Belleza', 'en' => 'Clothes & Beauty'],
				'types' => [
					['tag' => 'beauty.male_clothes', 'title' => ['es' => 'Ropa de Hombre', 'en' => 'Male Clothes']],
					['tag' => 'beauty.female_clothes', 'title' => ['es' => 'Ropa de Mujer', 'en' => 'Female Clothes']],
					['tag' => 'beauty.cosmetic', 'title' => ['es' => 'Cosméticos', 'en' => 'Cosmetics']],
					['tag' => 'beauty.accessories', 'title' => ['es' => 'Accesorios de Moda', 'en' => 'Moda']],
				]
			]
		];

		foreach ($categories as $category) {
			$cat = new Category();
			$cat->title = $category['title'];
			$cat->tag = $category['tag'];
			if ($cat->save()) {
				$types = [];
				foreach ($category['types'] as $type) {
					array_push($types, [
						'tag' => $type['tag'],
						'title' => json_encode($type['title']),
						'category_id' => $cat->id
					]);
				}
				ProductType::query()->insert($types);
			}
		}
	}
}
