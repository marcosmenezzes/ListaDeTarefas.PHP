<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

require_once "tarefa_class.php";
require_once "conexao.php";
require_once "tarefa_service_crud.php";

try {
    $conexao = new conexaoClass();
    $tarefa = new tarefaClass();
    $tarefa->__set('id_usuario', $_SESSION['id']);

    $tarefaService = new tarefaServiceCrudClass($conexao, $tarefa);
    $tarefas = $tarefaService->recuperarTarefasPendentes();
} catch (Exception $e) {
    $tarefas = [];
}

if (!isset($tarefas)) {
    $tarefas = [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Tarefas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <!-- Estilo Personalizado -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-light border-bottom">
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

    <!-- Conteúdo Principal -->
    <div class="container my-4">
        <div class="row">
            <!-- Menu Lateral -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-list me-2"></i>Menu
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item active">
                                <i class="fas fa-tasks me-2"></i>
                                <a href="index.php" class="text-white text-decoration-none">Tarefas Pendentes</a>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-plus-circle me-2"></i>
                                <a href="nova_tarefa.php" class="text-decoration-none">Nova Tarefa</a>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-clipboard-list me-2"></i>
                                <a href="todas_tarefas.php" class="text-decoration-none">Todas Tarefas</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Área de Tarefas -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            <i class="fas fa-clipboard-check me-2"></i>
                            Tarefas Pendentes
                        </h4>

                        <?php if(isset($_GET['sucesso']) && $_GET['sucesso'] == 1) { ?>
                            <div class="alert alert-success" role="alert">
                                Tarefa adicionada com sucesso!
                            </div>
                        <?php } ?>

                        <?php if(count($tarefas) > 0) { ?>
                            <div class="list-group">
                                <?php foreach($tarefas as $tarefa) { ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <?php echo htmlspecialchars($tarefa->tarefa); ?>
                                        </div>
                                        <div>
                                            <button class="btn btn-sm btn-success me-2" onclick="marcarRealizada(<?= $tarefa->id ?>)">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning me-2" onclick="marcarPendente(<?= $tarefa->id ?>)">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="removerTarefa(<?= $tarefa->id ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-info" role="alert">
                                Nenhuma tarefa pendente encontrada.
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/scripts.js"></script>
    <!-- Bootstrap Bundle JS (inclui Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>
function marcarRealizada(id) {
    if (confirm('Marcar tarefa como realizada?')) {
        window.location.href = 'marcar_realizada.php?id=' + id;
    }
}