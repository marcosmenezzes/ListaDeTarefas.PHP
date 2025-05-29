<?php
session_start();

require_once "INI_LISTA_TAREFAS/conexao.php";
require_once "INI_LISTA_TAREFAS/usuario_class.php";
require_once "INI_LISTA_TAREFAS/usuario_service_crud.php";

$usuario = new usuarioClass();
$usuario->__set('nome', $_POST['usuario']);
$usuario->__set('senha', $_POST['senha']);

$conexao = new conexaoClass();
$usuarioService = new usuarioServiceCrudClass($conexao, $usuario);

if($usuarioService->autenticar()) {
    header('Location: index.php');
} else {
    header('Location: login.php?login=erro');
}
?>
<?php