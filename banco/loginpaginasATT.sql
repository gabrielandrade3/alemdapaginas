CREATE DATABASE loginpaginas;
USE loginpaginas;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nome_usuario VARCHAR(50) UNIQUE NOT NULL,
    nome_exibicao VARCHAR(50) NOT NULL,
    nascimento DATE NOT NULL,
    genero ENUM('male', 'female', 'other') NOT NULL,
    foto_perfil LONGBLOB DEFAULT NULL,
    bio VARCHAR(255) DEFAULT NULL
);

CREATE TABLE generos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100)
);
CREATE TABLE livros (
    id_livro INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200),
    autor VARCHAR(150),
    descricao TEXT,
    capa_url VARCHAR(255),
    arquivo_url VARCHAR(255),
    data_publicacao DATE,
    genero_id INT,
    FOREIGN KEY (genero_id) REFERENCES generos(id)
);

CREATE TABLE resenhas (
    id_resenha INT AUTO_INCREMENT PRIMARY KEY,
    livro_id INT NOT NULL,
    usuario_id INT NOT NULL,
    comentario TEXT,
    nota INT CHECK (nota >= 1 AND nota <= 5),
    data_resenha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (livro_id) REFERENCES livros(id_livro),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

INSERT INTO generos (nome) VALUES 
('Romance'),
('Suspense'),
('Poesia'),
('Fantasia'),
('Ficção Científica'),
('Biografia'),
('Autoajuda'),
('Aventura');
//executar daqui pra cima

// já adicionado na propria tabela
ALTER TABLE usuarios ADD UNIQUE (email);
ALTER TABLE usuarios ADD UNIQUE (nome_usuario);

//testes

DESCRIBE livros;
SELECT id_livro, LENGTH(capa_url), LENGTH(arquivo_url) FROM livros;
SELECT id_livro, LENGTH(capa_url) FROM livros ORDER BY id_livro DESC LIMIT 1;
SELECT id_livro, LENGTH(capa_url) AS capa, LENGTH(arquivo_url) AS arquivo 
FROM livros ORDER BY id_livro DESC LIMIT 1;

SELECT id_livro, LENGTH(capa_url) AS capa_bytes, LENGTH(arquivo_url) AS arquivo_bytes
FROM livros ORDER BY id_livro DESC LIMIT 1;

ALTER TABLE usuarios
ADD COLUMN foto_perfil LONGBLOB DEFAULT NULL;
ALTER TABLE usuarios
MODIFY COLUMN foto_perfil LONGBLOB;


ALTER TABLE usuarios ADD COLUMN bio TEXT DEFAULT NULL;



