CREATE DATABASE bd_tarefas_php_pdo;
USE bd_tarefas_php_pdo;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE tb_status (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    status VARCHAR(25) NOT NULL
);

INSERT INTO tb_status (id, status) VALUES
(1, 'Pendente'),
(2, 'Realizado');

CREATE TABLE tb_tarefas (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_status INT(11) NOT NULL DEFAULT 1,
    id_usuario INT(11) NOT NULL,
    tarefa TEXT NOT NULL,
    data_cadastrado DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_status) REFERENCES tb_status(id)
);