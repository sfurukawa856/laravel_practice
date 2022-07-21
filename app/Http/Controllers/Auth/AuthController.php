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
	// IoCコンテナに基づく設計　※詳細は参考サイト参照
	/**
	 * __construct method
	 * @param
	 * @return void
	 */
	public function __construct(User $user) {
		$this->user = $user;
	}

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
		$user = $this->user->getUserByEmail($credentials['email']);

		if (!is_null($user)) {

			if ($this->user->isAccountLocked($user)) {
				return back()->withErrors([
					'danger' => 'アカウントがロックされています。'
				]);
			}

			if (Auth::attempt($credentials)) {
				$this->user->resetErrorCount($user);
				// セッション再生成
				$request->session()->regenerate();

				return redirect()->route('home')->with('success', 'ログイン成功しました。');
			}

			$user->error_count++;

			if ($this->user->lockAccount($user)) {
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
