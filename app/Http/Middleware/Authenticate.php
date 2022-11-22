<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return string|null
	 */
	protected function redirectTo($request)
	{
		if (!$request->expectsJson()) {
			// jika user ada di halaman beranda dalam keadaan belum login, kemudian dia memaksa masuk ke url dashboard maka arahkan user ke halaman login.
			return route('tampilan_login');
		}
	}
}
