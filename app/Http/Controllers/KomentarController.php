<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Komentar;
use App\Models\Postingan;

class KomentarController extends Controller
{
	public function data(Request $request)
	{
		$detail_postingan = Postingan::find($request->postingan_id);

		return response()->json([
			'postingan_comments' => $detail_postingan->komentar,
			'postingan_id' => $detail_postingan->id
		]);
	}

	public function store(Request $request)
	{
		// jika user tidak login
		if (!Auth::check()) {
			// kembali ke url sebelumnya dan kirimkan sessi
			return back()->with('user_blm_login', 'Anda Harus Login Terlebih Dahulu.');
		};

		$validator = Validator::make($request->all(), [
			'isi_komentar' => ['max:500'],
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 0,
				'message' => 'Validasi formulir laravel menemukan errors',
				'errors' => $validator->errors()
			]);
		};	

		// simpan data ke dalam table komentar
		$komentar = new Komentar();
		// id user yg login
		$komentar->user_id = Auth::id();
		$komentar->isi = $request->isi_komentar;
		// model komentar, method user, simpan
		// $komentar->user()->associate(Auth::user());
		$detail_postingan = Postingan::find($request->postingan_id);
		// 1 postingan boleh punya banyak komentar
		// panggil method komentar di dalam model postingan, simpan komentar baru
        // column komentarable_id dan komentarable_type diurus oleh code dibawah
		$detail_postingan->komentar()->save($komentar);

		return response()->json([
			'status' => 200,
			'message' => 'Komentar berhasil ditambahkan',
			'komentar_user_nama' => Auth::user()->nama,
			'komentar_isi' => $request->isi_komentar,
			'komentar_id' => $komentar->id
		]);
	}

	public function balas(Request $request)
	{
		$komentar = new Komentar();
		$komentar->isi = $request->komentar_isi;
		// $komentar->user()->associate($request->user());
		$komentar->user_id = Auth::id();
		$komentar->parent_id = $request->komentar_id;
		$detail_postingan = Postingan::find($request->postingan_id);

		$detail_postingan->komentar()->save($komentar);
		// ambil komentar berdasarkan

		return response()->json([
			'status' => 200,
			'message' => 'Komentar berhasil ditambahkan',
			'komentar_user_nama' => Auth::user()->nama,
			'komentar_isi' => $request->komentar_isi,
			'komentar_id' => $komentar->id
		]);
	}
}
