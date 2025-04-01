CREATE DATABASE loginpaginas;
USE loginpaginas;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(50) NOT NULL,
    sobrenome VARCHAR(50) NOT NULL,
    nascimento DATE NOT NULL,
    genero ENUM('male', 'female', 'other') NOT NULL
);

INSERT INTO usuarios (email, senha) VALUES ('teste@email.com', '12345');
SELECT * FROM usuarios;


SELECT * FROM usuarios WHERE email = 'teste@email.com';

DROP TABLE usuarios;

DELETE FROM usuarios where id = 3;
