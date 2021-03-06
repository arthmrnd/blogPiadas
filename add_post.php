<?php
	session_start();
	include("includes/connection.php");
	include("includes/classes/Post.php");

	$userLoggedIn = null;
	//verifica e Redireciona se o user não estiver logado
	if (isset($_SESSION['userLoggedIn'])) {
		$userLoggedIn = $_SESSION['userLoggedIn'];
	} else {
		header("Location: index.php");
	}

	$result = false;
	$post = new Post();

	include("includes/post-handler.php");
	
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<title>New Post</title>

	<!-- Bootstrap core CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="assets/css/font.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="assets/css/real.css" rel="stylesheet">

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

</head>
<body>
	<div class="container">
		<header class="blog-header py-3">
			<div class="row flex-nowrap justify-content-between align-items-center">
				<span class="m-title">Adicionar nova piada</span>

				<div class="col-4 d-flex justify-content-end align-items-center">
					<a class='btn btn-sm btn-outline-secondary' href='index.php' style="margin-right: 2px;">Início</a>
					<a class='btn btn-sm btn-outline-secondary' href='logout.php'>Sair</a>
				</div>
			</div>
		</header>
  	</div>

	<main role="main" class="container">
		<div class="row">
			<div class="col-md-12 blog-main">
			<?php if ($result == true)	echo '<div class="alert alert-success" role="alert">Adicionado com Sucesso!</div>';?>
				<form action="add_post.php" method="POST" style="margin-top: 10px;">
					<div class="form-group">
						<label for="title">Título</label>
						<input name="title" type="text" class="form-control" placeholder="Título" required>
					</div>
					<div class="form-group">
						<label for="detail">Texto</label>
						<textarea name="details" class="form-control" rows="3" placeholder="Texto" required></textarea>
					</div>

					<button class="btn btn-lg btn-primary btn-block" type="submit" name="addButton">Adicionar piada</button>
				</form>
			</div>
		</div><!-- /.row -->
	</main><!-- /.container -->

	<script src="assets/js/jquery-3.3.1.min.js"/>
	</html>
