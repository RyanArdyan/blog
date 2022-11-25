<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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

		// jika nilai input name sama dengan nilai column name dari $detail_user
		if ($request->nama === $detail_user->nama) {
			 $validasi_nama = 'min:4|max:20';
		} else if($request->nama !== $detail_user->nama) {
			 $validasi_nama = 'min:4|max:20|unique:users';
		};

		// validasi
		$validator = Validator::make($request->all(), [
			 'nama' => $validasi_nama,
		], [
			 'name.unique' => 'Orang lain sudah menggunakan nama itu'
		]);

		// jika validasi gagal
		if ($validator->fails()) {
			 return response()->json([
				  'status' => 0,
				  'errors' => $validator->errors()->toArray()
			 ]);
		// jika validasi berhasil
		} else {
			 // perbarui user
			 $detail_user->nama = $request->nama;
			 $detail_user->save();

			 return response()->json([
				  'status' => 200,
				  'detail_user' => $detail_user
			 ]);
		};
	}
}
