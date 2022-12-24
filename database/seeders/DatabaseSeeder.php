<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		\App\Models\Kategori::create([
			'nama_kategori' => 'sport',
			'slug' => 'sport',
			'keterangan' => '-',
		]);
		\App\Models\Kategori::create([
			'nama_kategori' => 'ekonomi',
			'slug' => 'ekonomi',
			'keterangan' => '-',
		]);
		\App\Models\Kategori::create([
			'nama_kategori' => 'otomotif',
			'slug' => 'otomotif',
			'keterangan' => '-',
		]);
		\App\Models\Kategori::create([
			'nama_kategori' => 'Tekno',
			'slug' => 'tekno',
			'keterangan' => '-',
		]);
		\App\Models\Kategori::create([
			'nama_kategori' => 'Kuliner',
			'slug' => 'kuliner',
			'keterangan' => '-',
		]);

		// \App\Models\User::factory(10)->create();
		\App\Models\Postingan::factory(1000)->create();
	}
}
