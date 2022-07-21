<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
// Authファサードをインポート
use Illuminate\Support\Facades\Auth;
// Userモデルをインポート
use App\Models\User;

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

		// ログインユーザーが存在するかチェック
		$user = User::where('email', '=', $credentials['email'])->first();

		if (!is_null($user)) {

			if ($user->locked_flg === 1) {
				return back()->withErrors([
					'danger' => 'アカウントがロックされています。'
				]);
			}

			if (Auth::attempt($credentials)) {
				if ($user->error_count > 0) {
					$user->error_count = 0;
					$user->save();
				}
				// セッション再生成
				$request->session()->regenerate();

				return redirect()->route('home')->with('success', 'ログイン成功しました。');
			}

			$user->error_count++;
			if ($user->error_count > 5) {
				$user->locked_flg = 1;
				$user->save();
				return back()->withErrors([
					'danger' => 'アカウントがロックされました。'
				]);
			}
			$user->save();
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
