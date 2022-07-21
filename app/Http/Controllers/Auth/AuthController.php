<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
// Authファサードをインポート
use Illuminate\Support\Facades\Auth;

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
		$credentials = $request->only('email', 'password');
		if (Auth::attempt($credentials)) {
			// セッション再生成
			$request->session()->regenerate();

			return redirect('home')->with('login_success', 'ログイン成功しました。');
		}
		return back()->withErrors([
			'login_error' => 'メールアドレスかパスワードが間違っています。'
		]);
	}
}
