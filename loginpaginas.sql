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
    arquivo_url VARCHAR(255), -- link para download ou leitura (nao teremos)
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
