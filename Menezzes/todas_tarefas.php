<!-- 04::: EXIBE TODAS AS TAREFAS DO BANCO DE DADOS -->

<!-- Necessita direcionar o fluxo da página para o script de encaminhamento à tomada de decisão.-->
<?php
    session_start();
    
    // Verificação de autenticação
    if(!isset($_SESSION['id'])) {
        header('Location: login.php');
        exit();
    }

    error_log('=== Início do processamento de todas_tarefas.php ===');
    error_log('ID do usuário na sessão: ' . $_SESSION['id']);

    // Definindo a ação para recuperar todas as tarefas
    $acao = 'recuperar';
    
    require_once "../Menezzes/tarefa_class.php";
    require_once "../Menezzes/conexao.php";
    require_once "../Menezzes/tarefa_service_crud.php";

    try {
        $conexao = new conexaoClass();
        $tarefa = new tarefaClass();
        $tarefa->__set('id_usuario', $_SESSION['id']);

        $tarefaService = new tarefaServiceCrudClass($conexao, $tarefa);
        $tarefas = $tarefaService->recuperar();

        error_log('Tarefas recuperadas: ' . print_r($tarefas, true));
    } catch (Exception $e) {
        error_log('Erro ao recuperar tarefas: ' . $e->getMessage());
        $tarefas = [];
    }

    // Garantindo que $tarefas está definida
    if (!isset($tarefas)) {
        error_log('$tarefas não está definida, inicializando como array vazio');
        $tarefas = [];
    }
?>

<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App Lista Tarefas</title>
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
                                <li class="list-group-item">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    <a href="nova_tarefa.php">Nova Tarefa</a>
                                </li>
                                <li class="list-group-item active">
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
                                <i class="fas fa-clipboard-list me-2"></i>
                                Todas as Tarefas
                            </h4>

                            <?php if(count($tarefas) > 0) { ?>
                                <div class="list-group">
                                    <?php foreach($tarefas as $tarefa) { ?>
                                        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= $tarefa->status == 'realizado' ? 'bg-light' : '' ?>" style="border-radius: 10px; margin-bottom: 8px;">
                                            <div>
                                                <span class="<?= $tarefa->status == 'realizado' ? 'text-decoration-line-through' : '' ?>">
                                                    <?php echo htmlspecialchars($tarefa->tarefa); ?>
                                                </span>
                                            </div>
                                            <div>
                                                <?php if($tarefa->status == 'pendente') { ?>
                                                    <button class="btn btn-sm btn-success me-2" onclick="marcarRealizada(<?= $tarefa->id ?>)" style="border-radius: 20px;">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                <?php } else { ?>
                                                    <button class="btn btn-sm btn-warning me-2" onclick="marcarPendente(<?= $tarefa->id ?>)" style="border-radius: 20px;">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                <?php } ?>
                                                <button class="btn btn-sm btn-danger" onclick="removerTarefa(<?= $tarefa->id ?>)" style="border-radius: 20px;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Nenhuma tarefa encontrada.
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function marcarRealizada(id) {
                if(confirm('Tem certeza que deseja marcar esta tarefa como realizada?')) {
                    window.location.href = '../Menezzes/recebe_tarefa.php?acao=marcarRealizada&id=' + id;
                }
            }

            function marcarPendente(id) {
                if(confirm('Tem certeza que deseja marcar esta tarefa como pendente?')) {
                    window.location.href = '../Menezzes/recebe_tarefa.php?acao=marcarPendente&id=' + id;
                }
            }

            function removerTarefa(id) {
                if(confirm('Tem certeza que deseja remover esta tarefa?')) {
                    window.location.href = '../Menezzes/recebe_tarefa.php?acao=remover&id=' + id;
                }
            }
        </script>
    </body>
</html>
<!-- 04 FIM::: EXIBE TODAS AS TAREFAS DO BANCO DE DADOS -->






