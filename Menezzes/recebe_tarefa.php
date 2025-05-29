<!-- 05::: ATUALIZANDO REGISTROS DO BANCO DE DADOS -->
<?php
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	
	// Verificação de autenticação
	if(!isset($_SESSION['id'])) {
		header('Location: ../ini_lista_tarefas_public/login.php');
		exit();
	}
	
	require "../ini_lista_tarefas/tarefa_class.php";
	require "../ini_lista_tarefas/conexao.php";
	require "../ini_lista_tarefas/tarefa_service_crud.php";

	$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

	// Debug
	error_log('Ação solicitada: ' . $acao);
	error_log('ID do usuário: ' . $_SESSION['id']);

	// Criar instâncias base que serão usadas em todas as operações
	$conexao_instanciada = new conexaoClass();
	$tarefa_instanciada = new tarefaClass();
	$tarefa_instanciada->__set('id_usuario', $_SESSION['id']);

	if($acao == 'inserir') {
		try {
			if (!isset($_POST['nova_tarefa']) || trim($_POST['nova_tarefa']) === '') {
				throw new Exception('Tarefa não pode estar vazia');
			}
			
			$tarefa_instanciada->__set('tarefa', trim($_POST['nova_tarefa']));

			$crud_tarefa_instanciada = new tarefaServiceCrudClass($conexao_instanciada, $tarefa_instanciada);
			
			if($crud_tarefa_instanciada->inserir()) {
				if(isset($_GET['pagina']) && $_GET['pagina'] == 'index') {
					header('Location: ../ini_lista_tarefas_public/index.php?sucesso=1');
				} else {
					header('Location: ../ini_lista_tarefas_public/nova_tarefa.php?inclusao=1');
				}
			} else {
				throw new Exception('Erro ao inserir tarefa');
			}
		} catch (Exception $e) {
			error_log('Erro no processo de inserção: ' . $e->getMessage());
			header('Location: ../ini_lista_tarefas_public/nova_tarefa.php?erro=1');
		}
		exit();
	} 
	
	else if ($acao == 'recuperar' || $acao == 'recuperarTarefasPendentes') {
		try {
			$crud_tarefa_instanciada = new tarefaServiceCrudClass($conexao_instanciada, $tarefa_instanciada);
			
			if ($acao == 'recuperarTarefasPendentes') {
				$tarefas = $crud_tarefa_instanciada->recuperarTarefasPendentes();
			} else {
				$tarefas = $crud_tarefa_instanciada->recuperar();
			}
            
			error_log('Tarefas recuperadas: ' . print_r($tarefas, true));
            
            if (!is_array($tarefas)) {
                $tarefas = [];
            }
		} catch (Exception $e) {
			error_log('Erro ao recuperar tarefas: ' . $e->getMessage());
			$tarefas = [];
		}
	} 
	
	else if($acao == 'remover') {
		try {
			if (!isset($_GET['id'])) {
				throw new Exception('ID da tarefa não fornecido');
			}

			$tarefa_instanciada->__set('id', $_GET['id']);
			
			$crud_tarefa_instanciada = new tarefaServiceCrudClass($conexao_instanciada, $tarefa_instanciada);
			$crud_tarefa_instanciada->remover();

			if(isset($_GET['pagina']) && $_GET['pagina'] == 'index') {
				header('Location: ../ini_lista_tarefas_public/index.php');
			} else {
				header('Location: ../ini_lista_tarefas_public/todas_tarefas.php');
			}
		} catch (Exception $e) {
			error_log('Erro ao remover tarefa: ' . $e->getMessage());
			header('Location: ' . (isset($_GET['pagina']) && $_GET['pagina'] == 'index' ? '../ini_lista_tarefas_public/index.php' : '../ini_lista_tarefas_public/todas_tarefas.php') . '?erro=1');
		}
		exit();
	} 
	
	else if ($acao == 'marcarRealizada' || $acao == 'marcarPendente') {
		try {
			if (!isset($_GET['id'])) {
				throw new Exception('ID da tarefa não fornecido');
			}

			$tarefa_instanciada->__set('id', $_GET['id']);
			
			$crud_tarefa_instanciada = new tarefaServiceCrudClass($conexao_instanciada, $tarefa_instanciada);
			
			if ($acao == 'marcarRealizada') {
				$crud_tarefa_instanciada->marcarRealizada();
			} else {
				$crud_tarefa_instanciada->marcarPendente();
			}

			if(isset($_GET['pagina']) && $_GET['pagina'] == 'index') {
				header('Location: ../ini_lista_tarefas_public/index.php');
			} else {
				header('Location: ../ini_lista_tarefas_public/todas_tarefas.php');
			}
		} catch (Exception $e) {
			error_log('Erro ao atualizar status da tarefa: ' . $e->getMessage());
			header('Location: ' . (isset($_GET['pagina']) && $_GET['pagina'] == 'index' ? '../ini_lista_tarefas_public/index.php' : '../ini_lista_tarefas_public/todas_tarefas.php') . '?erro=1');
		}
		exit();
	}
?>
<!-- 05 FIM::: ATUALIZANDO REGISTROS DO BANCO DE DADOS -->