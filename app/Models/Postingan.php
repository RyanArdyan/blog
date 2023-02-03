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

	// 1 postingan ditulis oleh 1 penulis
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	// 1 postingan punya banyak komentar bersarang
    public function comments()
    {
        // jadi 'comentarable' akan mengurus value table postingan columnd id dan menulis App\Models\postingan di column komentarable_id dan komentarable_type
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }
}
