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
				'title' => 'Deportes',
				'types' => [
					['tag' => 'sport.run', 'title' => 'Caminar y Correr'],
					['tag' => 'sport.energic', 'title' => 'Energizantes y Suplementos'],
					['tag' => 'sport.fitness', 'title' => 'Ejercicios y Fitness'],
					['tag' => 'sport.cyclysm', 'title' => 'Ciclismo'],
					['tag' => 'sport.tenis', 'title' => 'Tenis'],
					['tag' => 'sport.golf', 'title' => 'Golf'],
					['tag' => 'sport.water', 'title' => 'Deportes Acuáticos'],
					['tag' => 'sport.camping', 'title' => 'Acampada y Senderismo'],
					['tag' => 'sport.yoga', 'title' => 'Yoga'],
					['tag' => 'sport.clothes', 'title' => 'Ropa Deportiva'],
					['tag' => 'sport.electronic', 'title' => 'GPS y Electrónica'],
				]
			],
			// Kids
			[
				'tag' => 'kid',
				'title' => 'Niños y Juguetes',
				'types' => [
					['tag' => 'kid.toy', 'title' => 'Juguetes'],
					['tag' => 'kid.baby', 'title' => 'Bebés'],
					['tag' => 'kid.clothes', 'title' => 'Ropa de niños'],
				]
			],
			// Home
			[
				'tag' => 'home',
				'title' => 'Hogar, Jardinería, Bricolaje y Mascotas',
				'types' => [
					['tag' => 'home.kitchen', 'title' => 'Cocina y Comedor'],
					['tag' => 'home.bedroom', 'title' => 'Dormitorio'],
					['tag' => 'home.bathroom', 'title' => 'Baño'],
					['tag' => 'home.garden', 'title' => 'Jardín'],
					['tag' => 'home.light', 'title' => 'Iluminación'],
					['tag' => 'home.clima', 'title' => 'Clima'],
					['tag' => 'home.electrodomestic', 'title' => 'Electrodomésticos'],
					['tag' => 'home.clean', 'title' => 'Limpieza'],
					['tag' => 'home.security', 'title' => 'Seguridad'],
					['tag' => 'home.pets', 'title' => 'Mascotas'],
					['tag' => 'home.electric', 'title' => 'Instalación Eléctrica'],
				]
			],
			// Transport
			[
				'tag' => 'transport',
				'title' => 'Autos, motos, motirinas',
				'types' => [
					['tag' => 'transport.car', 'title' => 'Autos y piezas'],
					['tag' => 'transport.moto', 'title' => 'Motores'],
					['tag' => 'transport.electric', 'title' => 'Equipos eléctricos'],
					['tag' => 'transport.tools', 'title' => 'Herramientas'],
					['tag' => 'transport.pieces', 'title' => 'Piezas'],
				]
			],
			// Food
			[
				'tag' => 'food',
				'title' => 'Alimentos y Bebidas',
				'types' => [
					['tag' => 'food.drink-alcohol', 'title' => 'Bebidas Alcohólicas'],
					['tag' => 'food.drink', 'title' => 'Bebidas'],
				]
			],
			// Health
			[
				'tag' => 'health',
				'title' => 'Salud y Bienestar',
				'types' => [
					['tag' => 'health.pills', 'title' => 'Medicaments'],
					['tag' => 'health.natural', 'title' => 'Medicina Natural'],
					['tag' => 'health.tools', 'title' => 'Instrumentos de Salud'],
				]
			],
			// Tech
			[
				'tag' => 'tech',
				'title' => 'Informática y Celulares',
				'types' => [
					['tag' => 'tech.laptop', 'title' => 'Laptop'],
					['tag' => 'tech.pc', 'title' => 'PC de Escitorio'],
					['tag' => 'tech.pieces', 'title' => 'Piezas de Computadoras'],
					['tag' => 'tech.cell', 'title' => 'Celulares y Accesorios'],
				]
			],
			// Beauty
			[
				'tag' => 'beauty',
				'title' => 'Ropas y Belleza',
				'types' => [
					['tag' => 'beauty.male_clothes', 'title' => 'Ropa de Hombre'],
					['tag' => 'beauty.female_clothes', 'title' => 'Ropa de Mujer'],
					['tag' => 'beauty.cosmetic', 'title' => 'Cosméticos'],
					['tag' => 'beauty.accessories', 'title' => 'Collares, Anillos y Accesorios'],
				]
			],
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
						'title' => $type['title'],
						'category_id' => $cat->id
					]);
				}
				ProductType::query()->insert($types);
			}
		}
	}
}
