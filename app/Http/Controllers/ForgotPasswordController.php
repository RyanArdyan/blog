<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm()
	 {
		return view('auth.forgetPassword');
	 }

	 public function submitForgetPasswordForm(Request $request)
	 {
		$request->validate([
			'email' => 'required|email|exists:users'
		]);

		$token = Str::random(64);

		DB::table('password_resets')->insert([
			'email' => $request->email,
			'token' => $token,
			'created_at' => Carbon::now()
		]);

		Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request) {
			$message->to($request->email);
			$message->subject('Reset Password');
		});

		return back()->with('message', 'Kami Telah Mengirim Email Tautan Reset Password Anda!');
	 }

	 public function showResetPasswordForm()
	 {
		return view('auth.forgetPasswordLink', ['token' => $token]);
	 }

	 public function submitResetPasswordForm(Request $request)
	 {
		$request->validate([
			'email' => 'validate|email|exists:users',
			'password' => 'required|string|min:6|confirmed',
			'password_confirmation' => 'required'
		]);

		$updatePassword = DB::table('password_resets')
			->where(['email' => $request->email])->delete();

		return redirect()->route('tampilan_login')->with('message', 'Password Anda Telah Diubah');
	 }
}
