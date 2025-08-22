CREATE DATABASE futebol_db;
USE futebol_db;

CREATE TABLE times (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL
);

CREATE TABLE jogadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    posicao VARCHAR(30) NOT NULL,
    numero_camisa INT NOT NULL,
    time_id INT,
    FOREIGN KEY (time_id) REFERENCES times(id)
);

CREATE TABLE partidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    time_casa_id INT NOT NULL,
    time_fora_id INT NOT NULL,
    data_jogo DATE NOT NULL,
    gols_casa INT DEFAULT 0,
    gols_fora INT DEFAULT 0,
    FOREIGN KEY (time_casa_id) REFERENCES times(id),
    FOREIGN KEY (time_fora_id) REFERENCES times(id)
);

INSERT INTO times (nome, cidade) VALUES
    ('Atlético Mineiro', 'Belo Horizonte'), 
    ('Atlético Paranaense', 'Curitiba '),
    ('Bahia', 'Salvador'),
    ('Botafogo', 'Rio de Janeiro'), 
    ('Corinthians', 'São Paulo'),
    ('Coritiba', 'Curitiba'),
    ('Cruzeiro', 'Belo Horizonte'),
    ('Cuiabá', 'Cuiabá'),
    ('Flamengo', 'Rio de Janeiro'),
    ('Fluminense', 'Rio de Janeiro'),
    ('Fortaleza', 'Fortaleza'),
    ('Goiás', 'Goiânia'),
    ('Grêmio', 'Porto Alegre'),
    ('Internacional', 'Porto Alegre'),
    ('Palmeiras', 'São Paulo'),
    ('Santos', 'Santos'),
    ('São Paulo', 'São Paulo'),
    ('Vasco da Gama', 'Rio de Janeiro'),
    ('Atlético Goianiense', 'Goiânia'),
    ('América Mineiro', 'Belo Horizonte');