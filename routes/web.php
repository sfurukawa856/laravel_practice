<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CreateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// ログイン前
Route::middleware(['guest'])->group(
	function () {
		// ログインフォーム表示
		Route::get('/', [AuthController::class, 'showLogin'])->name('showLogin');
		// ログイン処理
		Route::post('login', [AuthController::class, 'login'])->name('login');

		// 新規登録画面表示
		Route::get('showCreate', [CreateController::class, 'showCreate'])->name('showCreate');
		// 新規登録処理
		Route::post('create', [CreateController::class, 'create'])->name('create');
	}
);

// ログイン後
Route::middleware(['auth'])->group(
	function () {
		// ホーム画面表示
		Route::get('home', function () {
			return view('home');
		})->name('home');
		// ログアウト
		Route::post('logout', [AuthController::class, 'logout'])->name('logout');
	}
);
