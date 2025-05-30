<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Tarefas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <!-- Estilo Personalizado -->
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="img/logo.png" width="35" height="35" class="me-2" alt="Logo">
                <span>Lista de Tarefas</span>
            </a>
            <div class="d-flex align-items-center">
                <span class="navbar-text me-3">
                    <i class="fas fa-user-circle me-2"></i>
                    <?php echo htmlspecialchars($_SESSION['nome']); ?>
                </span>
                <a href="logout.php" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-sign-out-alt me-2"></i>Sair
                </a>
            </div>
        </div>
    </nav>

    <!-- Alerta de Sucesso -->
    <?php if(isset($_GET['inclusao']) && $_GET['inclusao']==1) { ?>
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Sucesso!</strong> &nbsp;Sua tarefa foi adicionada com sucesso.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    <?php } ?>

    <!-- Conteúdo Principal -->
    <div class="container app my-4">
        <div class="row">
            <!-- Menu Lateral -->
            <div class="col-md-3 menu">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-list me-2"></i>Menu
                        </h5>
                        <ul class="list-group list-group-flush">
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

            <!-- Formulário de Nova Tarefa -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            <i class="fas fa-plus-circle me-2"></i>
                            Nova Tarefa
                        </h4>
                        <form method="post" action="recebe_tarefa_public.php?acao=inserir">
                            <div class="mb-3">
                                <label for="nova_tarefa" class="form-label">Descrição da Tarefa:</label>
                                <textarea class="form-control" id="nova_tarefa" name="nova_tarefa" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-new-task">
                                <i class="fas fa-plus me-2"></i>
                                Adicionar Nova Tarefa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS (inclui Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
