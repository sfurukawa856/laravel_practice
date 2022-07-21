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

			return redirect()->route('home')->with('success', 'ログイン成功しました。');
		}
		return back()->withErrors([
			'danger' => 'メールアドレスかパスワードが間違っています。'
		]);
	}

	/**
	 * ユーザーをアプリケーションからログアウトさせる
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request) {
		Auth::logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return redirect()->route('showLogin')->with('danger', 'ログアウトしました。');
	}
}
