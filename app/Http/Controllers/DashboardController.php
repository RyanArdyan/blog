<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
	 {
		// jika yang login bukan admin maka abort 404
		if (!Gate::allows('admin')) {
			abort(404);
		};
		return view('dashboard.index');
	 }
}
