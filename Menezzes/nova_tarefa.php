<!-- INÍCIO: CADASTRANDO TAREFAS -->

<?php
    session_start();
    
    // Check if user is authenticated
    if(!isset($_SESSION['id'])) {
        header('Location: login.php');
        exit();
    }
?>

<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Lista Tarefas</title>
		<link rel="stylesheet" href="css/estilo.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
	</head>

	<body style="background-color: #f5f6fa;">
		<nav class="navbar navbar-expand-lg" style="background-color: white; box-shadow: 0 2px 15px rgba(0,0,0,0.1);">
			<div class="container">
				<a class="navbar-brand d-flex align-items-center" href="#">
					<img src="img/logo.png" width="35" height="35" class="d-inline-block align-top me-2" alt="">
					<span style="color: var(--primary-color); font-weight: 600;">Lista Tarefas</span>
				</a>
				<div class="d-flex align-items-center">
					<span class="navbar-text me-3" style="color: var(--text-dark);">
						<i class="fas fa-user-circle me-2"></i>
						<?php echo htmlspecialchars($_SESSION['nome']); ?>
					</span>
					<a href="logout.php" class="btn btn-outline-danger btn-sm" style="border-radius: 20px; padding: 0.5rem 1.5rem;">
						<i class="fas fa-sign-out-alt me-2"></i>Sair
					</a>
				</div>
			</div>
		</nav>

		<?php if(isset($_GET['inclusao']) && $_GET['inclusao']==1) { ?>
			<div class="alert alert-success alert-dismissible fade show m-3" role="alert" style="border-radius: 10px; background-color: var(--success-color); border: none;">
				<div class="d-flex align-items-center">
					<i class="fas fa-check-circle me-2"></i>
					<strong>Sucesso!</strong> &nbsp;Sua tarefa foi adicionada com sucesso.
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php } ?>

		<div class="container app">
			<div class="row">
				<div class="col-md-3 menu">
					<div class="card shadow-sm" style="border-radius: 15px; border: none;">
						<div class="card-body">
							<h5 class="card-title mb-3" style="color: var(--primary-color); font-weight: 600;">
								<i class="fas fa-list me-2"></i>Menu
							</h5>
							<ul class="list-group list-group-flush" style="border-radius: 10px;">
								<li class="list-group-item">
									<i class="fas fa-tasks me-2"></i>
									<a href="index.php">Tarefas Pendentes</a>
								</li>
								<li class="list-group-item active">
									<i class="fas fa-plus-circle me-2"></i>
									<a href="nova_tarefa.php">Nova Tarefa</a>
								</li>
								<li class="list-group-item">
									<i class="fas fa-clipboard-list me-2"></i>
									<a href="todas_tarefas.php">Todas Tarefas</a>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div class="col-md-9">
					<div class="card shadow-sm" style="border-radius: 15px; border: none;">
						<div class="card-body">
							<h4 class="card-title mb-4">
								<i class="fas fa-plus-circle me-2"></i>
								Nova Tarefa
							</h4>
							<form method="post" action="recebe_tarefa_public.php?acao=inserir">
								<div class="form-group">
									<label class="form-label">Descrição da Tarefa:</label>
									<textarea class="form-control" name="nova_tarefa" style="height: 120px; border-radius: 10px; padding: 1rem;" required></textarea>
								</div>
								<div class="mt-4">
									<button class="btn-new-task" type="submit">
										<i class="fas fa-plus me-2"></i>
										Adicionar Nova Tarefa
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Bootstrap 5 JavaScript Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	</body>
</html>

<!-- TÉRMINO: CADASTRANDO TAREFAS -->