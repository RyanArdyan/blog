<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
	use HasFactory;

	protected $table = 'komentar';
	protected $fillable = ['user_id', 'komentarable_id', 'komentarable_type', 'parent_id', 'isi'];

	// 1 komentar akan mengambil value column nama dari table user yg berkomentar
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	// table komentar berelasi dengan dirinya sendiri
	// 1 komentar boleh punya banyak balasan
	public function balas()
	{
		return $this->hasMany(Komentar::class, 'parent_id');
	}
}
