<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Kategori;
use PDO;

class KategoriController extends Controller
{
	public function index()
	{
		return view('kategori.index');
	}

	public function data()
	{
		$semua_kategori = Kategori::orderBy('updated_at', 'desc')->get();
		$table = '
		<table class="table table-bordered table-hover">
			<thead class="table-warning">
				<tr>
					<th width="5%">
						<input type="checkbox" id="pilih_semua">
					</th>
					<th width="5%">No</th>
					<th>Kategori</th>
					<th>Keterangan</th>
					<th width="8%">Fitur</th>
				</tr>
			</thead>
			<tbody>
			';
			$nomor = 1;
			foreach($semua_kategori as $kategori) {
				$table .=
				'<tr>
					<td width="5%">
						<input type="checkbox" name="checkbox" data-id="' . $kategori->id . '" class="pilih checkbox">
					</td>
					<td>' . 
						$nomor++ . '
					</td>
					<td>' . $kategori->nama_kategori . '</td>
					<td>' . $kategori->keterangan . '</td>
					<td>
						<button class="tombol_edit btn btn-sm btn-warning" data-id="' . $kategori->id . '">
							Edit
						</button>
					</td>
				</tr>';
			};
			$table .=
			'</tbody>
		</table>
		';

		return response()->json([
			'status' => 200,
			'message' => 'Berhasil mengambil semua kategori',
			'data' => $table
		]);
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama_kategori' => ['required', 'min:2', 'max:20', 'unique:kategori'],
			'keterangan' => ['required']
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 404,
				'message' => 'Validasi menemukan error.',
				'errors' => $validator->errors()
			]);
		// jika validasi berhasil
		} else {
			// simpan kategori
			$detail_kategori = Kategori::create($request->all());
			return response()->json([
				'status' => 200,
				'message' => 'Berhasil menyimpan kategori.',
				'nama_kategori' => $detail_kategori->nama_kategori
			]);
		};		
	}

	public function show(Request $request)
	{
		// ambil nama_kategori dan keterangan secara satu persatu
		$detail_kategori = Kategori::where('id', $request->id)->first();

		return response()->json($detail_kategori);
	}

	public function update(Request $request)
	{
		$detail_kategori = Kategori::where('id', $request->id)->first();

		if ($detail_kategori->nama_kategori === $request->nama_kategori) {
			$validasi_nama_kategori = ['required', 'min:2', 'max:20'];
		} else {
			$validasi_nama_kategori = ['unique:kategori', 'required', 'min:2', 'max:20'];
		};

		$validator = Validator::make($request->all(), [
			'nama_kategori' => $validasi_nama_kategori,
			'keterangan' => ['required']
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 0,
				'pesan' => 'Validasi error',
				'errors' => $validator->errors()
			]);
		} else {
			// update kategori
			Kategori::where('id', $request->id)->update([
				'nama_kategori' => $request->nama_kategori,
				'keterangan' => $request->keterangan
			]);

			return response()->json([
				'status' => 200,
				'message' => 'Berhasil update kategori'
			]);
		};
	}

	public function destroy(Request $request)
	{
		// $ids berisi array
		$ids = $request->ids;
		Kategori::whereIn('id', $ids)->delete();
		return response()->json([
			'status' => 200,
			'pesan' => 'Berhasil menghapus data terpilih.'
		]);
	}
}
