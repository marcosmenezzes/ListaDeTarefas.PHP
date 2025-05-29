<!-- INÍCIO: SCRIPT DE CRUD NO BANCO DE DADOS. -->

<?php 

	class tarefaServiceCrudClass { /* CRIAÇÃO DA CLASSE DE CRUD. */
		/*As VARIÁVEIS abaixo foram definidas no SCRIPT RECEBE_TAREFA.PHP.*/
		private $conexao_instanciada;
		private $tarefa_instanciada;

		public function __construct($conexao_instanciada, $tarefa_instanciada) {
			$this->conexao_instanciada = $conexao_instanciada->conectar_bd();
			$this->tarefa_instanciada = $tarefa_instanciada;
		}



		/* CRIAÇÃO DA FUNÇÃO DE CADASTRO. */		public function inserir() {
			try {
				// Validação dos dados
				if (!$this->tarefa_instanciada->__get('tarefa') || !$this->tarefa_instanciada->__get('id_usuario')) {
					throw new Exception("Dados da tarefa incompletos");
				}

				$query_inserir = 'insert into tb_tarefas(tarefa, id_usuario, id_status)values(:tarefa, :id_usuario, 1)';

				$var_inserir = $this->conexao_instanciada->prepare($query_inserir);

				$var_inserir->bindValue(':tarefa', $this->tarefa_instanciada->__get('tarefa'));
				$var_inserir->bindValue(':id_usuario', $this->tarefa_instanciada->__get('id_usuario'));

				return $var_inserir->execute();
			} catch (Exception $e) {
				error_log('Erro ao inserir tarefa: ' . $e->getMessage());
				return false;
			}
		}
		/* TÉRMINO DA FUNÇÃO DE CADASTRO. */





		/* CRIAÇÃO DA FUNÇÃO DE LEITURA DO BANCO DE DADOS. */		public function recuperar() { 
			try {
				if (!$this->tarefa_instanciada->__get('id_usuario')) {
					error_log('ID do usuário não fornecido');
					return [];
				}

				$query_recuperar = '
					select
						t.id, t.tarefa, t.id_status, s.status
					from
						tb_tarefas as t
						left join tb_status as s on (t.id_status = s.id)
					where
						t.id_usuario = :id_usuario
					order by 
						t.data_cadastrado desc
				';

				error_log('Query sendo executada: ' . $query_recuperar);
				error_log('ID do usuário: ' . $this->tarefa_instanciada->__get('id_usuario'));

				$var_recuperar = $this->conexao_instanciada->prepare($query_recuperar);
				$var_recuperar->bindValue(':id_usuario', $this->tarefa_instanciada->__get('id_usuario'));
				$executou = $var_recuperar->execute();

				if (!$executou) {
					error_log('Erro ao executar query: ' . print_r($var_recuperar->errorInfo(), true));
					return [];
				}

				$resultado = $var_recuperar->fetchAll(PDO::FETCH_OBJ);
				
				error_log('Recuperando tarefas para usuário: ' . $this->tarefa_instanciada->__get('id_usuario'));
				error_log('Número de tarefas encontradas: ' . count($resultado));
				if (count($resultado) > 0) {
					error_log('Primeira tarefa encontrada: ' . print_r($resultado[0], true));
				}
				
				return $resultado;
			} catch (Exception $e) {
				error_log('Erro ao recuperar tarefas: ' . $e->getMessage());
				error_log('Stack trace: ' . $e->getTraceAsString());
				return [];
			}
		}
		/* TÉRMINO DA FUNÇÃO DE LEITURA DO BANCO DE DADOS. */





		public function atualizar() {
			//print_r($this->tarefa_instanciada);

			$query_atualizar = "update tb_tarefas set tarefa = :tarefa where id = :id and id_usuario = :id_usuario";
			$var_atualizar = $this->conexao_instanciada->prepare($query_atualizar);
			$var_atualizar->bindValue(':tarefa', $this->tarefa_instanciada->__get('tarefa'));
			$var_atualizar->bindValue(':id', $this->tarefa_instanciada->__get('id'));
			$var_atualizar->bindValue(':id_usuario', $this->tarefa_instanciada->__get('id_usuario'));
			return $var_atualizar->execute();
		}





		public function remover() {
			$query_remover = 'delete from tb_tarefas where id = :id and id_usuario = :id_usuario';
			$var_remover = $this->conexao_instanciada->prepare($query_remover);
			$var_remover->bindValue(':id', $this->tarefa_instanciada->__get('id'));
			$var_remover->bindValue(':id_usuario', $this->tarefa_instanciada->__get('id_usuario'));
			$var_remover->execute();
		}





		public function recuperarTarefasPendentes() {
			try {
				if (!$this->tarefa_instanciada->__get('id_usuario')) {
					error_log('ID do usuário não fornecido');
					return [];
				}

				$query_recuperar = '
					select
						t.id, t.tarefa, t.id_status, s.status
					from
						tb_tarefas as t
						left join tb_status as s on (t.id_status = s.id)
					where
						t.id_usuario = :id_usuario
						and t.id_status = 1
					order by 
						t.data_cadastrado desc
				';

				error_log('Query sendo executada (tarefas pendentes): ' . $query_recuperar);
				error_log('ID do usuário: ' . $this->tarefa_instanciada->__get('id_usuario'));

				$var_recuperar = $this->conexao_instanciada->prepare($query_recuperar);
				$var_recuperar->bindValue(':id_usuario', $this->tarefa_instanciada->__get('id_usuario'));
				$executou = $var_recuperar->execute();

				if (!$executou) {
					error_log('Erro ao executar query: ' . print_r($var_recuperar->errorInfo(), true));
					return [];
				}

				$resultado = $var_recuperar->fetchAll(PDO::FETCH_OBJ);
				
				error_log('Recuperando tarefas pendentes para usuário: ' . $this->tarefa_instanciada->__get('id_usuario'));
				error_log('Número de tarefas pendentes encontradas: ' . count($resultado));
				
				return $resultado;
			} catch (Exception $e) {
				error_log('Erro ao recuperar tarefas pendentes: ' . $e->getMessage());
				error_log('Stack trace: ' . $e->getTraceAsString());
				return [];
			}
		}

		public function marcarRealizada() {
			try {
				$query = 'update tb_tarefas set id_status = 2 where id = :id and id_usuario = :id_usuario';
				$stmt = $this->conexao_instanciada->prepare($query);
				$stmt->bindValue(':id', $this->tarefa_instanciada->__get('id'));
				$stmt->bindValue(':id_usuario', $this->tarefa_instanciada->__get('id_usuario'));
				return $stmt->execute();
			} catch (Exception $e) {
				error_log('Erro ao marcar tarefa como realizada: ' . $e->getMessage());
				return false;
			}
		}

		public function marcarPendente() {
			try {
				$query = 'update tb_tarefas set id_status = 1 where id = :id and id_usuario = :id_usuario';
				$stmt = $this->conexao_instanciada->prepare($query);
				$stmt->bindValue(':id', $this->tarefa_instanciada->__get('id'));
				$stmt->bindValue(':id_usuario', $this->tarefa_instanciada->__get('id_usuario'));
				return $stmt->execute();
			} catch (Exception $e) {
				error_log('Erro ao marcar tarefa como pendente: ' . $e->getMessage());
				return false;
			}
		}
	}

?>

<!-- TÉRMINO: SCRIPT DE CRUD NO BANCO DE DADOS. -->