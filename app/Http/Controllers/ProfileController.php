<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
	public function index()
	{
		$detail_user_auth = Auth()->user();
		return view('profile.index', ['detail_user_auth' => $detail_user_auth]);
	}

	public function update(Request $request)
	{
		// detail user
		$detail_user = User::where('id', $request->id)->first();

		// jika nilai input nama sama dengan nilai column nama dari $detail_user
		if ($request->nama === $detail_user->nama) {
			 $validasi_nama = 'min:4|max:20';
		} else if($request->nama !== $detail_user->nama) {
			 $validasi_nama = 'min:4|max:20|unique:users';
		};

		// validasi
		$validator = Validator::make($request->all(), [
			 'nama' => $validasi_nama,
			 'gambar' => 'image|max:512'
		], [
			 'nama.unique' => 'Orang lain sudah menggunakan nama itu'
		]);

		// jika validasi gagal
		if ($validator->fails()) {
			 return response()->json([
				  'status' => 0,
				  'errors' => $validator->errors()->toArray()
			 ]);
		// jika validasi berhasil
		} else {
			// jika user memiliki gambar
			if ($request->hasFile('gambar')) {
				if ($detail_user->gambar === 'pp_default.jpg') {
					// nama gambar baru
					$nama_gambar_baru = time() . '_' . $request->id . '.' . $request->file('gambar')->extension();
					// upload gambar dan ganti nama gambar
					Storage::putFileAs('public/photo_profile/', $request->file('gambar'), $nama_gambar_baru);
				} else if ($detail_user->gambar !== 'pp_default.jpg') {
					// hapus gambar lama
					Storage::delete('public/photo_profile/' . $detail_user->gambar);
					// nama gambar baru
					$nama_gambar_baru = time() . '_' . $request->id . '.' . $request->file('gambar')->extension();
					// upload gambar dan ganti nama gambar
					Storage::putFileAs('public/photo_profile/', $request->file('gambar'), $nama_gambar_baru);
				};
				
		  // jika user tidak mengupload gambar
		  } else if (!$request->hasFile('gambar')) {
				$nama_gambar_baru = $detail_user->gambar;
		  };

			 // perbarui user
			 $detail_user->gambar = $nama_gambar_baru;
			 $detail_user->nama = $request->nama;
			 $detail_user->save();

			 return response()->json([
				  'status' => 200
			 ]);
		};
	}
}
