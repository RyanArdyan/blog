<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Postingan;
use App\Models\Kategori;
use App\Models\Komentar;

class BerandaController extends Controller
{	
	public function index(Request $request)
	{
		// jgn lupa gunakan relasi pemuatan bersemangat
		$semua_postingan = Postingan::with(['kategori'])->where([
			['judul', '!=', Null],
			[function ($query) use ($request) {
				// jika user mencari judul maka simpan judulnya ke dalam $judul
				if (($judul = $request->judul)) {
					$query->orWhere('judul', 'LIKE', '%' . $judul . '%')->get();
				}
			}]
		])
			->orderBy('updated_at', 'desc')
			->paginate(6);

			// $postingan_dan_kategori = Postingan::with(['kategori'])->orderBy('updated_at', 'desc')->get();


		$semua_kategori = Kategori::select('id', 'nama_kategori', 'slug')->orderBy('nama_kategori', 'asc')->get();
		// $semua_postingan = Postingan::with(['kategori'])->latest()->get();
		return view('beranda.index', [
			'semua_kategori' => $semua_kategori,
			'semua_postingan' => $semua_postingan
		]);
	}

	// jangan hapus $slug_kategori
	public function detail($slug_kategori, $slug_postingan)
	{
		$semua_kategori = Kategori::select('id', 'nama_kategori', 'slug')->orderBy('nama_kategori', 'asc')->get();
		$detail_postingan = Postingan::where('slug', $slug_postingan)->first();
		// ambil semua komentar yg column parent_id nya berisi null, itu artinya aku hanya mengambil komentar-komentar parent
		// $postingan_comments = Komentar::whereNull('parent_id')->get();
		$postingan_comments = $detail_postingan->komentar->whereNull('parent_id');

		// $postingan_comments = $tes->all();
		// kirim semua kategori, detail postingan dan semua komentar disuatu postingan  pada postingan
		return view('beranda.detail', [
			'semua_kategori' => $semua_kategori,
			'detail_postingan' => $detail_postingan,
			'postingan_comments' => $postingan_comments,
		]);
	}

	public function kategori($kategori_id)
	{
		$semua_kategori = Kategori::select('id', 'nama_kategori', 'slug')->orderBy('nama_kategori', 'asc')->get();
		// paginasi tidak bisa menggunakan relasi
		// ambil postingan yang sesuai kategori
		$semua_postingan_yg_sesuai_kategori = Postingan::with(['user'])->where('kategori_id', $kategori_id)->orderBy('updated_at', 'desc')->paginate(10);
		return view('beranda.kategori', [
			'semua_kategori' => $semua_kategori,
			'semua_postingan_yg_sesuai_kategori' => $semua_postingan_yg_sesuai_kategori
		]);
	}
}
