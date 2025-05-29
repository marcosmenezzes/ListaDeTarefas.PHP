<?php
class usuarioServiceCrudClass {
    private $conexao_instanciada;
    private $usuario_instanciado;

    public function __construct($conexao_instanciada, $usuario_instanciado) {
        $this->conexao_instanciada = $conexao_instanciada->conectar_bd();
        $this->usuario_instanciado = $usuario_instanciado;
    }

    public function inserir() {
        $query_inserir = 'insert into usuarios(nome, senha) values(:nome, :senha)';
        $var_inserir = $this->conexao_instanciada->prepare($query_inserir);
        $var_inserir->bindValue(':nome', $this->usuario_instanciado->__get('nome'));
        $var_inserir->bindValue(':senha', password_hash($this->usuario_instanciado->__get('senha'), PASSWORD_DEFAULT));
        $var_inserir->execute();
    }

    public function autenticar() {
        $query = 'select id, nome, senha from usuarios where nome = :nome';
        $stmt = $this->conexao_instanciada->prepare($query);
        $stmt->bindValue(':nome', $this->usuario_instanciado->__get('nome'));
        $stmt->execute();
        
        $usuario = $stmt->fetch(PDO::FETCH_OBJ);
        
        if($usuario && password_verify($this->usuario_instanciado->__get('senha'), $usuario->senha)) {
            $_SESSION['id'] = $usuario->id;
            $_SESSION['nome'] = $usuario->nome;
            return true;
        }
        return false;
    }
}
?>
