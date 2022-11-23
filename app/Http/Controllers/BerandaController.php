<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Postingan;

class BerandaController extends Controller
{
	public function index()
	{
		$semua_postingan = Postingan::select('gambar', 'judul', 'slug', 'updated_at')->orderBy('updated_at', 'desc')->get();
		return view('beranda.index', ['semua_postingan' => $semua_postingan]);
	}

	public function detail($slug)
	{
		$detail_postingan = Postingan::where('slug', $slug)->first();
		return view('beranda.detail', ['detail_postingan' => $detail_postingan]);
	}
}
