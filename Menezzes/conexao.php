<!-- INÍCIO: SCRIPT DE CONEXÃO COM BANCO DE DADOS POR MEIO DO PDO. -->

<?php
	/*Conexão é feita por meio de classe com funções específicas.*/
	class conexaoClass {
		private $host = "localhost";
		private $dbname = "bd_tarefas_php_pdo";
		private $user = "root";
		private $pass = "";
	

		/*CONSTRUÇÃO DO PDO.*/
		public function conectar_bd() {
			try {
				$conexao_instanciada = new PDO(
					"mysql:host=$this->host;dbname=$this->dbname",
					"$this->user",
					"$this->pass"
				);
					return $conexao_instanciada;
				}
				catch (PDOException $erro_conectar) {
					echo '<p>'.$erro_conectar->getMessage().'</p>';
				}
			}
	}
?>

<!-- TÉRMINO: SCRIPT DE CONEXÃO COM BANCO DE DADOS POR MEIO DO PDO. -->
