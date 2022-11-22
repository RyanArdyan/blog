<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postingan extends Model
{
	use HasFactory;
	// package trix editor laravel

	protected $table = 'postingan';

	protected $fillable = [
		'user_id', 'kategori_id', 'gambar', 'judul', 'slug', 'isi'
	];

	public function kategori()
	{
		return $this->belongsTo(Kategori::class, 'kategori_id');
	}
}
