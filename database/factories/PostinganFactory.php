<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Postingan>
 */
class PostinganFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		$judul = Str::random(10);
		return [
			'user_id' => 1,
			'kategori_id' => fake()->numberBetween(1, 5),
			'gambar' => '1669349747.png',
			'judul' => $judul,
			'slug' => Str::slug($judul, '-'),
			'isi' => Str::random(175),
		];
	}
}
