<?php
    class tarefaClass {
        private $id;
        private $id_status;
        private $id_usuario;
        private $tarefa;
        private $data_cadastro;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }
    }
?>
