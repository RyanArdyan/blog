<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DataTables;

class PengaturanController extends Controller
{
	public function index()
	{
		return view('pengaturan.index');
	}

	public function data()
	{
		// ambil semua user, dipesan oleh column updated_at secara descending
		$semua_user = User::orderBy('level', 'desc')->get();

		// syntax milik laravel datatables
		return DataTables::of($semua_user)
			->addColumn('checkbox', function($user) {
				return '<input type="checkbox" value="' . $user->id . '" name="id">';
			})
			// beri nomor di setiap user
			->addIndexColumn()
			->addColumn('status', function($user) {
				if ($user->level === 1) {
					return '<span class="badge text-bg-success">Admin</span>';
				} else if($user->level === 0) {
					return '<span class="badge text-bg-warning">User</span>';
				};
			})
			->rawColumns(['checkbox', 'status'])
			->make(true);
	}

	public function jadikan_admin(Request $request)
	{
		// ambil semua user yang memiliki value id yang dikirimkan
		$user_terpilih = User::whereIn('id', $request->semua_id)->get();
		foreach($user_terpilih as $user) {
			// Ulangi perintah update
			// perbarui value dari column level
			User::where('id', $user->id)->update([
				'level' => 1
			]);
		};
		

		return response()->json([
			'status' => 200,
			'message' => 'Berhasil menjadikan data-data yang terpilih sebagai admin.'
		]);
	}

	public function jadikan_user(Request $request)
	{
		// ambil semua user yang memiliki value id yang dikirimkan
		$user_terpilih = User::whereIn('id', $request->semua_id)->get();
		foreach($user_terpilih as $user) {
			// Ulangi perintah update
			// perbarui value dari column level
			User::where('id', $user->id)->update([
				'level' => 0
			]);
		};
		

		return response()->json([
			'status' => 200,
			'message' => 'Berhasil menjadikan data-data yang terpilih sebagai user.'
		]);
	}
}
