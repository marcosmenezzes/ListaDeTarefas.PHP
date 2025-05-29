<?php
require_once "../ini_lista_tarefas/conexao.php";

try {
    $conexao = new conexaoClass();
    $pdo = $conexao->conectar_bd();
    
    echo "<h2>Verificação do Banco de Dados</h2>";
    
    // Verifica se o banco existe
    $query = $pdo->query("SELECT DATABASE()");
    $db = $query->fetchColumn();
    echo "<p>Banco de dados atual: " . $db . "</p>";
    
    // Verifica tabelas
    $tables = array('usuarios', 'tb_status', 'tb_tarefas');
    foreach ($tables as $table) {
        $query = $pdo->query("SHOW TABLES LIKE '$table'");
        $exists = $query->rowCount() > 0;
        echo "<p>Tabela $table: " . ($exists ? "existe" : "não existe") . "</p>";
        
        if ($exists) {
            $count = $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
            echo "<p>Número de registros em $table: $count</p>";
        }
    }
    
    // Verifica se há usuários logados na sessão
    session_start();
    if (isset($_SESSION['id'])) {
        echo "<p>Usuário logado - ID: " . $_SESSION['id'] . "</p>";
        
        // Verifica tarefas do usuário
        $query = $pdo->prepare("SELECT COUNT(*) FROM tb_tarefas WHERE id_usuario = ?");
        $query->execute([$_SESSION['id']]);
        $taskCount = $query->fetchColumn();
        echo "<p>Número de tarefas do usuário: $taskCount</p>";
    } else {
        echo "<p>Nenhum usuário logado</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red'>Erro: " . $e->getMessage() . "</p>";
}
?>
