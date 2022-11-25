<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Postingan;
use App\Models\Kategori;

class BerandaController extends Controller
{
	public function index()
	{
		$semua_kategori = Kategori::select('id', 'nama_kategori', 'slug')->orderBy('nama_kategori', 'asc')->get();
		$semua_postingan = Postingan::with(['kategori'])->latest()->get();
		return view('beranda.index', [
			'semua_kategori' => $semua_kategori,
			'semua_postingan' => $semua_postingan
		]);
	}

	public function detail($slug_kategori, $slug_postingan)
	{
		$semua_kategori = Kategori::select('id', 'nama_kategori', 'slug')->orderBy('nama_kategori', 'asc')->get();
		$detail_postingan = Postingan::where('slug', $slug_postingan)->first();
		return view('beranda.detail', [
			'semua_kategori' => $semua_kategori,
			'detail_postingan' => $detail_postingan
		]);
	}

	public function kategori($slug_kategori)
	{
		$semua_kategori = Kategori::select('id', 'nama_kategori', 'slug')->orderBy('nama_kategori', 'asc')->get();
		$detail_kategori = Kategori::where('slug', $slug_kategori)->first();
		$semua_postingan_yg_sesuai_kategori = $detail_kategori->postingan;
		return view('beranda.kategori', [
			'semua_kategori' => $semua_kategori,
			'semua_postingan_yg_sesuai_kategori' => $semua_postingan_yg_sesuai_kategori
		]);
	}
}
