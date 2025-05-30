<?php
session_start();

require_once "../Menezzes/conexao.php";
require_once "../Menezzes/usuario_class.php";
require_once "../Menezzes/usuario_service_crud.php";

$usuario = new usuarioClass();
$usuario->__set('nome', $_POST['usuario']);
$usuario->__set('senha', $_POST['senha']);

$conexao = new conexaoClass();
$usuarioService = new usuarioServiceCrudClass($conexao, $usuario);

try {
    $usuarioService->inserir();
    header('Location: login.php');
} catch(Exception $e) {
    header('Location: registro.php?cadastro=erro');
}
?>
