<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
	public function tampilan_login()
	{
		return view('login');
	}

	public function logika_login(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => ['required', 'email'],
			'password' => ['required', 'min:6', 'max:20']
		]);

		// jika validasi biasa gagal
		if ($validator->fails()) {
			return response()->json([
				'status' => 0,
				'message' => 'Validasi Biasa Errors',
				// berisi object2x, key berisi value dalam bentuk array
				'errors' => $validator->errors()
			]);
		};

		// ambil semua input yang lolos validasi
		$kredensial = $validator->validated();

		// jika validasi lolos maka cek apakah email dan password yang di input ada di database
		if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
			$request->session()->regenerate();

			$nama = User::where('email', $request->email)->value('nama');
			$level = User::where('email', $request->email)->value('level');

			return response()->json([
				'status' => 200,
				'message' => 'User Berhasil Login',
				// aku mengirim 1 atau 0 dalam bentuk type string awoakwaok
				'level' => $level,
				'nama' => $nama
			]);
		} else {
			// jika email dan password yang di input tidak ada di database
			// kirimkan pesan validasi error
			return response()->json([
				'status' => 0,
				'message' => 'Email Atau Password Salah'
			]);
		};
	}

	public function tampilan_registrasi()
	{
		return view('registrasi');
	}

	public function logika_registrasi(Request $request)
	{
		// validasi biasa
		$validator = Validator::make($request->all(), [
			'nama' => ['required', 'unique:users', 'min:4', 'max:20'],
			'email' => ['unique:users', 'required'],
			'password' => ['required', 'min:6', 'max:20']
		], [
			'nama.unique' => "Nama $request->nama sudah digunakan orang lain",
			'email.unique' => "Email sudah di registrasikan, silahkan login"
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 0,
				'message' => 'Validasi Errors',
				'errors' => $validator->errors()
			]);
		} else {
			User::create([
				'level' => 0,
				'gambar' => 'pp_default.jpg',
				'nama' => $request->nama,
				'email' => $request->email,
				'password' => Hash::make($request->password)
			]);

			return response()->json([
				'status' => 200,
				'message' => 'Berhasil Registrasi, Silahkan Login'
			]);
		}
	}

	public function logout()
	{
		// keluarkan auth
		Auth::logout();
		// batalkan session
		session()->invalidate();
		// buat ulang token
		session()->regenerateToken();
		return redirect()->route('beranda.index');
	}
}
