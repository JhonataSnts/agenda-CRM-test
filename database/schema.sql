CREATE DATABASE IF NOT EXISTS agenda_contatos
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE agenda_contatos;

CREATE TABLE estados (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  uf CHAR(2) NOT NULL
);

CREATE TABLE cidades (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  estado_id INT NOT NULL,
  CONSTRAINT fk_cidades_estados
    FOREIGN KEY (estado_id) REFERENCES estados(id)
);

CREATE TABLE contatos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  telefone VARCHAR(20) NOT NULL,
  cidade_id INT NOT NULL,
  estado_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_contatos_cidades
    FOREIGN KEY (cidade_id) REFERENCES cidades(id),
  CONSTRAINT fk_contatos_estados
    FOREIGN KEY (estado_id) REFERENCES estados(id)
);

INSERT INTO estados (nome, uf) VALUES
('Sergipe', 'SE'),
('Bahia', 'BA'),
('Alagoas', 'AL');

INSERT INTO cidades (nome, estado_id) VALUES
('Aracaju', 1),
('Estância', 1),
('Lagarto', 1),
('Salvador', 2),
('Maceió', 3);