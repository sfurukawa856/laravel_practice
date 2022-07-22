<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFormRequest;
use App\Models\User;

class CreateController extends Controller
{
	/**
	 * __construct method
	 * @param
	 * @return void
	 */
	public function __construct(User $user) {
		$this->user = $user;
	}

	/**
	 * showCreate method
	 * @param
	 * @return View
	 */
	public function showCreate() {
		return view('create.create_form');
	}

	/**
	 * create method
	 * @param
	 * @return void
	 */
	public function create(CreateFormRequest $request) {
		$createData = $request->only('name', 'email', 'password');

		// すでに同じアカウントが存在しないか
		$user = $this->user->getUserByEmail($createData['email']);

		if(is_null($user)){
			// TODO:要確認
			$this->user->name = $createData['name'];
			$this->user->email = $createData['email'];
			$this->user->password = $createData['password'];

			$this->user->save();

			return redirect()->route('home')->with('success', 'アカウント登録に成功しました。');
		}

		return back()->withErrors([
			'danger' => '既に同一アカウントが登録済みです。'
		]);
	}
}
