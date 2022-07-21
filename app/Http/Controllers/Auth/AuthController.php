<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;

class AuthController extends Controller {
	/**
	 * showLogin method
	 * @param
	 * @return View
	 */
	public function showLogin() {
		return view('login.login_form');
	}
	/**
	 * login method
	 * @param App\Http\Requests\LoginFormRequest
	 * @return void
	 */
	public function login(LoginFormRequest $request) {
		dd($request->all());
	}
}
