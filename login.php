<?php

	session_start();
	include("includes/connection.php");
	include("includes/classes/User.php");
	//Redirecionar a pagina se o usuario estiver logado
	if (isset($_SESSION['userLoggedIn'])) {
		header("Location: index.php");
	}

	$user = new User();

	include("includes/loginHandler.php");

	if (isset($_POST['registerButton'])) {
		//Registro de novos usuarios
		$name = $_POST['inputFirstName'];
		$surname = $_POST['inputLastName'];
		$email = $_POST['registerEmail'];
		$password = $_POST['registerPassword'];

		$result = $user->register($name, $surname, $email, $password);

		if ($result != null) {
			$_SESSION['userLoggedIn'] = $result;
			header("Location: index.php");
		}
	}

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<title>Login Page</title>

	<!-- Bootstrap core CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">


	<style>
	.bd-placeholder-img {
		font-size: 1.125rem;
		text-anchor: middle;
	}

	@media (min-width: 768px) {
		.bd-placeholder-img-lg {
			font-size: 3.5rem;
		}
	}
	</style>
	<!-- Custom styles for this template -->
	<link href="assets/css/signin.css" rel="stylesheet">
	<script src="assets/js/jquery-3.3.1.min.js"></script>
</head>

<?php

	if (isset($_POST['registerButton'])){
		echo "<script>
			$(document).ready(function() {
				$('#loginForm').hide();
				$('#registerForm').show();
				$('#inputFirstName').val('$name');
				$('#inputLastName').val('$surname');
				$('#registerEmail').val('$email');
				$('#registerPassword').val('$password');
			});
			</script>";
	} else if (isset($_POST['loginButton'])) {
		echo "<script>
			$(document).ready(function() {
				$('#loginForm').show();
				$('#registerForm').hide();
				$('#loginEmail').val('$email');
				$('#loginPassword').val('$password');
			});
			</script>";
	}
?>

<body class="text-center">
	<img src="" alt="">
	<form id="loginForm" class="form-signin" action="login.php" method="POST">
		<h1>Entrar</h1>
		<?php
			echo $user ->getLoginErrors();
		?>
		<label for="inputEmail" class="sr-only">Endereço de Email</label>
		<input id="loginEmail" name="loginEmail" type="email" class="form-control" placeholder="Email" required>
		<label for="inputPassword" class="sr-only">Senha</label>
		<input id="loginPassword" name="loginPassword" type="password" class="form-control" placeholder="Senha" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit" name="loginButton">Entrar</button>
		<div class="hasAccountText">
			<span id="hideLogin" onclick="hide('login')">Não tem uma conta ainda? Entre aqui.</span>
		</div>
	</form>

	<form id="registerForm" style="display:none" class="form-signin" action="login.php" method="POST">
		<h1>Registrar</h1>
		<?php
			foreach ($user->getRegisterErrors() as $error) {
				echo "<div class='alert alert-danger' role='alert'>$error</div>";
			}
		?>

		<label for="inputFirstName" class="sr-only">Nome</label>
		<input id="inputFirstName" name="inputFirstName" type="text" class="form-control" placeholder="Nome" required>
		<label for="inputLastName" class="sr-only">Sobrenome</label>
		<input id="inputLastName" name="inputLastName" type="text" class="form-control" placeholder="Sobrenome" required>
		<label for="inputEmail" class="sr-only">Email</label>
		<input id="registerEmail" name="registerEmail" type="email" class="form-control" placeholder="Email" required>
		<label for="inputPassword" class="sr-only">Senha</label>
		<input id="registerPassword" name="registerPassword" type="password" class="form-control" placeholder="Senha" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit" name="registerButton">Registrar</button>
		<div class="hasAccountText">
			<span id="hideRegister" onclick="hide('register')">Já tem uma conta? Entre aqui.</span>
		</div>
	</form>
</body>
<script type="text/javascript">
	
	function hide(hide) {
		console.log(hide);

		if(hide === 'login') {
			$("#registerForm").show();
			$("#loginForm").hide();
		} else {
			$("#loginForm").show();
			$("#registerForm").hide();			
		}
	}
</script>
</html>
