<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postingan;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DataTables;

class PostinganController extends Controller
{
	public function index()
	{
		return view('postingan.index');
	}

	public function data()
	{
		// ambil semua postingan dipesan oleh column updated_at secara descending
		// aku menyebutnya relasi dan pemuatan bersemangat
		$postingan_dan_kategori = Postingan::with(['kategori'])->orderBy('updated_at', 'desc')->get();

		// syntax milik laravel datatables
		return DataTables::of($postingan_dan_kategori)
			->addColumn('checkbox', function(Postingan $postingan) {
				return '<input type="checkbox" value="' . $postingan->id . '" name="checkbox">';
			})
			// beri nomor di setiap postingan
			->addIndexColumn()
			->addColumn('gambar', function(Postingan $postingan) {
				return "<img src='/storage/gambar_postingan/$postingan->gambar' width='50px'>";
			})
			// setiap detai postingan
			->addColumn('kategori', function(Postingan $postingan) {
				return $postingan->kategori->nama_kategori;
			})
			->addColumn('fitur', function(Postingan $postingan) {
				return 
				'<button class="tombol_edit btn btn-sm btn-warning" data-id="' . $postingan->id . '">
					Edit
				</button>';
			})
			->rawColumns(['checkbox', 'gambar', 'fitur'])
			->make(true);
	}

	public function create()
	{
		$semua_kategori = Kategori::select('id', 'nama_kategori')->get();
		return response()->json([
			'status' => 200,
			'semua_kategori' => $semua_kategori
		]);
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'judul' => ['required', 'unique:postingan', 'min:3', 'max:150'],
			'isi' => ['required'],
			'gambar' => ['required', 'image', 'max:512']
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 0,
				'message' => 'Validasi formulir laravel menemukan errors',
				'errors' => $validator->errors()
			]);
		};

		// simpan gambar postingan
		// nama gambar baru
		$nama_gambar_baru = time() . '.' . $request->file('gambar')->extension();
		// upload gambar dan ganti nama gambar
		Storage::putFileAs('public/gambar_postingan/', $request->file('gambar'), $nama_gambar_baru);

		// simpan postingan
		Postingan::create([
			'user_id' => Auth::id(),
			'kategori_id' => $request->kategori_id,
			'gambar' => $nama_gambar_baru,
			'judul' => $request->judul,
			'slug' => Str::slug($request->judul, '-'),
			// 'isi' => strip_tags($request->isi),
			'isi' => $request->isi
		]);		

		return response()->json([
			'status' => 200,
			'message' => 'Postingan berhasil disimpan'
		]);
	}

	public function show(Request $request)
	{
		$detail_postingan = Postingan::where('id', $request->id)->first();
		$semua_kategori = Kategori::select('id', 'nama_kategori')->get();
		return response()->json([
			'detail_postingan' => $detail_postingan,
			'semua_kategori' => $semua_kategori
		]);
	}

	public function update(Request $request)
	{
		// detail postingan
		$detail_postingan = Postingan::where('id', $request->id)->first();

		// jika nilai input judul sama dengan nilai column judul
		if ($request->judul === $detail_postingan->judul) {
			 $validasi_judul = 'string|min:3|max:150';
		} else if($request->judul !== $detail_postingan->judul) {
			 $validasi_judul = 'string|min:3|max:150|unique:postingan';
		};

		// validasi
		$validator = Validator::make($request->all(), [
			 'judul' => $validasi_judul,
			 'isi' => ['required'],
			 'gambar' => ['image', 'max:512']
		], [
			 'judul.unique' => 'Postingan sudah ada',
		]);

		// jika validasi gagal
		if ($validator->fails()) {
			 return response()->json([
				  'status' => 0,
				  'errors' => $validator->errors()
			 ]);
		// jika validasi berhasil
		} else {
			// jika user memiliki gambar
			if ($request->hasFile('gambar')) {
				// hapus gambar lama
				Storage::delete('public/gambar_postingan/' . $detail_postingan->gambar);
				// nama gambar baru
				$nama_gambar_baru = $detail_postingan->id . '_' . time()  . '.' . $request->file('gambar')->extension();
				// upload gambar
				Storage::putFileAs('public/gambar_postingan/', $request->file('gambar'), $nama_gambar_baru);
			// jika user tidak mengupload gambar
			} else if(!$request->hasFile('gambar')) {
				// nama gambar lama
				$nama_gambar_baru = $detail_postingan->gambar;
			};

			 // Perbarui _postingan
			 $detail_postingan->user_id = Auth::id();
			 $detail_postingan->kategori_id = $request->kategori_id;
			 $detail_postingan->gambar = $nama_gambar_baru;
			 $detail_postingan->judul = $request->judul;
			 $detail_postingan->slug = Str::slug($request->judul, '-');
			 $detail_postingan->isi = $request->isi;
			 $detail_postingan->save();

			 return response()->json([
				  'status' => 200,
				  'pesan' => "Postingan berhasil diperbarui.",
				  'detail_postingan' => $detail_postingan,
				  'judul' => $request->judul
			 ]);
		};
	}

	public function destroy(Request $request)
	{
		// $ids berisi array
		$ids = $request->ids;
		// hapus gambar dulu	
		$postingan_terpilih = Postingan::whereIn('id', $ids)->get();
		foreach($postingan_terpilih as $postingan) {
			// Ulangi perintah hapus
			Storage::delete('public/gambar_postingan/' . $postingan->gambar);
		};

		Postingan::whereIn('id', $ids)->delete();
		return response()->json([
			'status' => 200,
			'pesan' => 'Berhasil menghapus data terpilih.'
		]);
	}
}
