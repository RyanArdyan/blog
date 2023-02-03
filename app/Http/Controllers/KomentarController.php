<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;
use App\Models\Postingan;
use App\Models\Kategori;

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
        $semua_kategori = Kategori::select('id', 'nama_kategori', 'slug')->orderBy('nama_kategori', 'asc')->get();
		$detail_postingan = Postingan::where('id', $request->postingan_id)->first();
		// ambil semua Commentyg column parent_id nya berisi null, itu artinya aku hanya mengambil Commentparent
		// $parent_comments = Comment::whereNull('parent_id')->get();// ambil semua Commentyg column parent_id nya berisi null, itu artinya aku hanya mengambil Commentparent
        

		$comment = new Comment;
        
        $comment->comment = $request->comment;
        // mengisi column user_id
        $comment->user()->associate($request->user());
        
        $post = Postingan::find($request->postingan_id);
        // mengisi column comentarable_id dan comentarble type
        $post->comments()->save($comment);
        
		$parent_comments = $detail_postingan->comments->whereNull('parent_id');
        // $postingan_Comments = $tes->all();
		// kirim semua kategori untuk navigasi header, detail postingan dan semua Commentparent disuatu postingan
		return view('beranda.detail', [
			'semua_kategori' => $semua_kategori,
			'detail_postingan' => $detail_postingan,
			'parent_comments' => $parent_comments,
		]);
	}

	public function balas(Request $request)
	{
        $semua_kategori = Kategori::select('id', 'nama_kategori', 'slug')->orderBy('nama_kategori', 'asc')->get();
		$detail_postingan = Postingan::where('id', $request->postingan_id)->first();
		// ambil semua Commentyg column parent_id nya berisi null, itu artinya aku hanya mengambil Commentparent
		$parent_comments = Comment::whereNull('parent_id')->get();// ambil semua Commentyg column parent_id nya berisi null, itu artinya aku hanya mengambil Commentparent
		// $postingan_Comments = $detail_postingan->Comment>whereNull('parent_id');

		$komentar = new Comment();
		$komentar->comment = $request->comment;
		// $komentar->user()->associate($request->user());
		$komentar->user_id = Auth::id();
		$komentar->parent_id = $request->parent_id;
		$detail_postingan = Postingan::find($request->postingan_id);

		$detail_postingan->comments()->save($komentar);
		// ambil komentar berdasarkan

        // $postingan_Comments = $tes->all();
		// kirim semua kategori untuk navigasi header, detail postingan dan semua Commentparent disuatu postingan
		return view('beranda.detail', [
			'semua_kategori' => $semua_kategori,
			'detail_postingan' => $detail_postingan,
			'parent_comments' => $parent_comments,
		]);
	}
}
