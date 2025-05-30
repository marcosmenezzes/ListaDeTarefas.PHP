<!-- INÍCIO: RECEBE OS COMANDOS DO FRONT-END E DIRECIONA PARA O SCRIPT PRIVADO NO BACK-END QUE CONCENTRARÁ AS REQUISIÇÕES DO FRONT-END -->

<?php
    // Verifica se já existe uma sessão ativa antes de iniciar
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if(!isset($_SESSION['id'])) {
        header('Location: login.php');
        exit();
    }

    // Se a ação for inserir, verifica se o campo nova_tarefa está presente e não está vazio
    if (isset($_GET['acao']) && $_GET['acao'] == 'inserir') {
        if (!isset($_POST['nova_tarefa']) || trim($_POST['nova_tarefa']) === '') {
            header('Location: nova_tarefa.php?erro=1');
            exit();
        }
    }

    // Define a ação antes de incluir o arquivo principal
    $acao = isset($_GET['acao']) ? $_GET['acao'] : '';
    
    // Certifica-se de que a ação é válida
    $valid_actions = ['inserir', 'recuperar', 'recuperarTarefasPendentes', 'atualizar', 'remover', 'marcarRealizada', 'marcarPendente'];
    if (!empty($acao) && !in_array($acao, $valid_actions)) {
        header('Location: index.php');
        exit();
    }
    
    // Importa o arquivo principal que processa as tarefas
    require_once "../Menezzes/recebe_tarefa.php";

    // Se ocorreu algum erro na execução, redireciona com mensagem de erro
    if (isset($error)) {
        $redirect = isset($_GET['pagina']) && $_GET['pagina'] == 'index' ? 'index.php' : 'nova_tarefa.php';
        header("Location: $redirect?erro=1");
        exit();
    }
?>