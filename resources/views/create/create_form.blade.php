<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>新規登録画面</title>
	<script src="{{ asset('js/app.js') }}" defer></script>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" href="{{ asset('css/signin.css') }}">
</head>

<body>
	<form class="form-signin" method="post" action="{{ route('login') }}">
		@csrf
		<h1 class="h3 mb-3 font-weight-normal">新規登録画面</h1>

		@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif

		<x-alert type="danger" :session="session('danger')" />

		<label for="inputName" class="sr-only">Name</label>
		<input type="text" name="name" id="inputName" class="form-control" placeholder="Name" required autofocus>
		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required>
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>

		<button class="btn btn-lg btn-primary btn-block" type="submit">登録する</button>
		<div class="link">
			<a href="{{ route('showLogin') }}" class="link-primary">ログイン画面へ</a>
		</div>
	</form>

</body>

</html>