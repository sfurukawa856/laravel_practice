<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ログインフォーム</title>
	<script src="{{ asset('js/app.js') }}" defer></script>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<link rel="stylesheet" href="{{ asset('css/signin.css') }}">
</head>

<body>
	<form class="form-signin" method="post" action="{{ route('login') }}">
		<h1 class="h3 mb-3 font-weight-normal">ログインフォーム</h1>
		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>

		<button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
	</form>

</body>

</html>