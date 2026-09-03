CREATE DATABASE IF NOT EXISTS agenda_contatos
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE agenda_contatos;

CREATE TABLE `usuarios` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(150) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`email` VARCHAR(150) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`senha` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`created_at` TIMESTAMP NULL DEFAULT (CURRENT_TIMESTAMP),
	`updated_at` TIMESTAMP NULL DEFAULT (CURRENT_TIMESTAMP) ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `email` (`email`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=8
;

CREATE TABLE `categorias` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=4
;

CREATE TABLE `estados` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`uf` CHAR(2) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=4
;

CREATE TABLE `cidades` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`estado_id` INT NOT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `fk_cidades_estados` (`estado_id`) USING BTREE,
	CONSTRAINT `fk_cidades_estados` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=6
;

CREATE TABLE `contatos` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(150) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`telefone` VARCHAR(20) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`email` VARCHAR(150) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`cpf` VARCHAR(14) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`cidade_id` INT NOT NULL,
	`estado_id` INT NOT NULL,
	`created_at` TIMESTAMP NULL DEFAULT (CURRENT_TIMESTAMP),
	`updated_at` TIMESTAMP NULL DEFAULT (CURRENT_TIMESTAMP) ON UPDATE CURRENT_TIMESTAMP,
	`usuario_id` INT NOT NULL,
	`categoria_id` INT NULL DEFAULT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `fk_contatos_cidades` (`cidade_id`) USING BTREE,
	INDEX `fk_contatos_estados` (`estado_id`) USING BTREE,
	INDEX `fk_contatos_usuarios` (`usuario_id`) USING BTREE,
	INDEX `fk_contatos_categorias` (`categoria_id`) USING BTREE,
	CONSTRAINT `fk_contatos_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT `fk_contatos_cidades` FOREIGN KEY (`cidade_id`) REFERENCES `cidades` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT `fk_contatos_estados` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT `fk_contatos_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=21
;

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `created_at`, `updated_at`) VALUES
	(1, 'Administrador', 'admin@example.com', '12345678', '2026-08-08 01:36:11', '2026-08-08 01:36:11'),
	(2, 'Usuario Teste', 'teste@example.com', '12345678', '2026-08-11 01:57:06', '2026-08-11 01:57:06'),
	(3, 'silene', 'silene.escolar@gmail.com', '$2y$12$TvoGGhGULg6I3yPSfdP2I.qDM9SoTp91pvFQWufxiKC5rwmSZGzWm', '2026-08-11 04:11:21', '2026-08-11 04:11:21'),
	(4, 'davi dos santos', 'davi@email.com', '$2y$12$6sEm55cs9uReIc8SEc7pb.BH44MYDzuBskfFbP5tb3gcvuYbsJlTG', '2026-08-11 04:13:15', '2026-08-11 04:13:15'),
	(5, 'davi dos santos', 'davi@example.com', '$2y$12$cSsRTsbL6zG9IAddNfB6ZeXdg0m0poaUWVA/CbVnmqiU7mf9ktaQe', '2026-08-11 04:15:53', '2026-08-11 04:15:53'),
	(6, 'Teste', 'teste@email.com', '$2y$12$ddLXuGUQLRiGECdPQZrca.NddkkZlyCXMiiK0LAx7g2Jl6hOVubm6', '2026-08-12 05:24:29', '2026-08-12 05:24:29'),
	(7, 'dsafs', 'sadas@email.com', '12345678', '2026-08-13 19:42:02', '2026-08-13 19:42:02');

INSERT INTO `categorias` (`id`, `nome`) VALUES
	(1, 'Família'),
	(2, 'Amigos'),
	(3, 'Cliente');

INSERT INTO `estados` (`id`, `nome`, `uf`) VALUES
	(1, 'Sergipe', 'SE'),
	(2, 'Bahia', 'BA'),
	(3, 'Alagoas', 'AL');

INSERT INTO `cidades` (`id`, `nome`, `estado_id`) VALUES
	(1, 'Aracaju', 1),
	(2, 'Estância', 1),
	(3, 'Lagarto', 1),
	(4, 'Salvador', 2),
	(5, 'Maceió', 3);

INSERT INTO `contatos` (`id`, `nome`, `telefone`, `email`, `cpf`, `cidade_id`, `estado_id`, `created_at`, `updated_at`, `usuario_id`, `categoria_id`) VALUES
	(3, 'Teste maceió', '82222222222', NULL, NULL, 5, 3, '2026-08-05 07:02:36', '2026-08-08 02:09:55', 1, NULL),
	(4, 'Teste Aracaju', '799999999', NULL, NULL, 1, 1, '2026-08-05 07:03:39', '2026-08-08 02:09:55', 1, NULL),
	(5, 'Teste Estância', '7999999999', 'estancia@gmail.com', '11111111111', 2, 1, '2026-08-05 07:03:58', '2026-08-08 02:09:55', 1, NULL),
	(6, 'teste salvador', '111111111111', NULL, NULL, 4, 2, '2026-08-05 07:04:30', '2026-08-08 02:09:55', 1, NULL),
	(7, 'Teste Lagarto', '799999999999', NULL, NULL, 3, 1, '2026-08-05 13:12:55', '2026-08-08 02:09:55', 1, NULL),
	(8, 'jonatas da conceição santos', '79998435996', NULL, NULL, 2, 1, '2026-08-07 04:42:10', '2026-08-08 02:09:55', 1, NULL),
	(10, 'neiff', '79998435996', 'joantasskt18@gmail.com', '08848341586', 5, 3, '2026-08-11 02:00:01', '2026-08-11 02:00:01', 2, NULL),
	(12, 'jonatas da conceição santos', '79998435996', 'email@teste.com', '55555555554', 5, 3, '2026-08-11 05:28:06', '2026-08-13 04:29:36', 5, NULL),
	(13, 'Salabin', '799999999', 'unique@example.com', '88888888888', 4, 2, '2026-08-12 05:26:45', '2026-08-12 05:26:45', 6, NULL),
	(14, 'Teste', '79998435996', 'joantasskt18@gmail.com', '55555555555', 2, 1, '2026-08-13 03:29:04', '2026-08-13 03:29:04', 5, NULL),
	(15, 'jonatas da conceição santos', '79998435996', 'joantasskt18@gmail.com', '88888888888', 2, 1, '2026-08-21 01:18:47', '2026-08-21 01:18:47', 4, NULL),
	(16, 'jonatas da conceição santos', '79998435996', 'joantasskt18@gmail.com', '11111111111', 2, 1, '2026-08-21 01:38:25', '2026-08-21 05:58:23', 4, 1),
	(17, 't3wtaa', '11111111111', 'joantasskt18@gmail.com', '33333333333', 2, 1, '2026-08-21 02:37:18', '2026-08-21 05:29:53', 4, 2),
	(19, 'sadsadsa', '79998435996', 'joantasskt18@gmail.com', '11111111111', 2, 1, '2026-08-27 05:13:48', '2026-08-27 05:13:48', 5, 1),
	(20, 'silene', '79999756835', 'silene123@gmail.com', '11111111111', 5, 3, '2026-09-03 00:20:37', '2026-09-03 00:20:37', 5, 3);
