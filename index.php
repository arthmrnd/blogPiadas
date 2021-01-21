<?php
	session_start();
	include("includes/connection.php");
	include("includes/classes/Post.php");
	include("includes/classes/User.php");

	$userLoggedIn = false;

	if (isset($_SESSION['userLoggedIn'])) {
		$userLoggedIn = $_SESSION['userLoggedIn'];
	}

	$result = false;

	$post_ = new Post();
	$user = new User();
	$allPosts = $post_->getAllPosts();

	if (isset($_POST['delete_id'])) {
		$delete_id = $_POST['delete_id'];

		$result = $post_->deletePost($delete_id);
	}

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<title>Piadas</title>

	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<!-- Templates customizados-->
	<link href="assets/css/font.css" rel="stylesheet">
	<!-- Templates customizados -->
	<link rel="stylesheet" href="assets/css/real.css">

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
				<span class="m-title">Blog de piadas</span>
				<br><br>

				<div class="col-4 d-flex justify-content-end align-items-center">
					<?php if ($userLoggedIn != null) {
						echo "<a class='btn btn-sm btn-outline-secondary' href='add_post.php' 
						style='margin-right:3px;'>Adicionar piadas</a>
						<a class='btn btn-sm btn-outline-secondary' href='logout.php' 
						>Sair</a>";
					} else {
						//echo '<p class="classentrar">Entre para adicionar piadas.</p>';
						 echo '<a class="btn btn-sm btn-outline-secondary" href="login.php">Entrar</a>';
					} ?>
					
				</div>
			</div>
			
		</header>

  	</div>
	<br>
	<main role="main" class="container">
		<div class="row">
			<div class="col-md-12 blog-main">

				<?php
				
				if ($result != false) {
					echo "<div class='alert alert-danger' role='alert'>Apagado com sucesso</div>";
				}

				foreach ($allPosts as $post) { ?>
					<div class="blog-post">
						<div class="title">
							<h2 class="blog-post-title"><?php echo $post->title ?></h2>
							<?php
								if (($userLoggedIn != null) && ($post->user_id == $userLoggedIn->id)) {
									$pegas = $post->id;
									echo "<button class='btn btn-danger' onclick='deletePost($pegas)'>X</button>";
								}
							?>
						</div>

						<p class="blog-post-meta">
						<?php
							$date = strtotime($post->created_at);
							$converted_date = date('d F, Y', $date);
							echo $converted_date;
						?>
							<a href="#">
									<?php echo $user->getName($post->user_id) ?>
							</a>
						</p>
						<p><?php echo $post->details ?></p>
					</div><!-- /.blog-post -->

				<?php } ?>				

			</div><!-- /.blog-main -->

		</div><!-- /.row -->

		<form action="index.php" method="POST" id="deletePost">
			<input type="hidden" id="delete_id" name="delete_id" value="">
		</form>

	</main><!-- /.container -->
	
	<footer class="container-fluid text-center backfoot margin">
            <p>Made by Arthur Nascimento <a href="https://github.com/arthmrnd" > arthmrnd</a></p>
        </footer>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


	<script src="assets/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
		function deletePost(id) {
			Swal.fire({
				title: 'Tem certeza?',
				text: "Esta ação não pode ser revertida!",
				icon: 'Cuidado',
				showCancelButton: false,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Sim, apague!'
			}).then((result) => {
				if (result.isConfirmed) {
					document.getElementById("delete_id").value = id;
					document.getElementById("deletePost").submit();
				}
			})
		}
	</script>
</body>
</html>
