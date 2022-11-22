<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Postingan;

class BerandaController extends Controller
{
	public function index()
	{
		$semua_postingan = Postingan::select('id', 'judul', 'isi', 'updated_at')->orderBy('updated_at', 'desc')->get();
		return view('beranda.index', ['semua_postingan' => $semua_postingan]);
	}
}
