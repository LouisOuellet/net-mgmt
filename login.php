<?php
session_start();

require dirname(__FILE__,1).'/src/lib/api.php';

$API = new API();

if((!empty($_POST))&&(isset($_POST['username'],$_POST['password']))){
	if($API->Status){
		$API->login($_POST['username'],$_POST['password']);
	} else {
		$API->genUser($_POST['username'],$_POST['password'],$_POST['password']);
		$API->init();
	}
}

if($API->Login){
	header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
} else { ?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?=$API->Config['description']?>">
		<meta name="author" content="Louis Ouellet, https://github.com/LouisOuellet">
		<title><?=$API->Config['title']?> | Login</title>
		<link rel="shortcut icon" href="/dist/img/favicon.ico" />
		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="./dist/css/login.css">
		<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script src="https://kit.fontawesome.com/4f8426d3cf.js" crossorigin="anonymous"></script>
	</head>
	<body class="text-center">
		<form class="form-signin" method="post">
      <img class="mb-4" src="/dist/img/logo.png" alt="" width="72" height="72">
			<?php if($API->Status){ ?>
      	<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
			<?php } else { ?>
				<h1 class="h3 mb-3 font-weight-normal">Create your first User</h1>
			<?php } ?>
      <label for="inputUsername" class="sr-only">Username</label>
      <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
			<?php if($API->Status){ ?>
      	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			<?php } else { ?>
				<button class="btn btn-lg btn-success btn-block" type="submit">Create</button>
			<?php } ?>
      <p class="mt-5 mb-3 text-muted">
				<strong>Copyright &copy; 2020-<?= date('Y') ?> <a href="<?=$API->Config['copyright']['link']?>"><?=$API->Config['copyright']['text']?></a></strong> All rights reserved.
			</p>
    </form>
	</body>
</html>
<?php } ?>
