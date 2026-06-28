-- Criar o banco de dados se não existir
CREATE DATABASE IF NOT EXISTS `empresta_si` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `empresta_si`;

-- Tabela Aluno
CREATE TABLE IF NOT EXISTS `Aluno` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(255) NOT NULL,
    `usuario` VARCHAR(50) UNIQUE NOT NULL,
    `senha` VARCHAR(255) DEFAULT NULL, -- Nulo para alunos que não são gestores
    `matricula` CHAR(11) UNIQUE NOT NULL,
    `usuario_discord` VARCHAR(100) DEFAULT NULL,
    `email` VARCHAR(100) UNIQUE NOT NULL,
    `celular` VARCHAR(20) DEFAULT NULL,
    `gestor` TINYINT DEFAULT 0 -- 1 = também é gestor, pode logar no painel
) ENGINE=InnoDB;

-- Tabela Livro
CREATE TABLE IF NOT EXISTS `Livro` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `titulo` VARCHAR(255) NOT NULL,
    `autores` TEXT NOT NULL,
    `editora` VARCHAR(100) NOT NULL,
    `edicao` INT NOT NULL,
    `ano_publicacao` YEAR NOT NULL,
    `exemplar` VARCHAR(255) NOT NULL,
    `alugado` TINYINT DEFAULT 0 -- 0 = disponível, 1 = alugado
) ENGINE=InnoDB;

-- Tabela Locacao
CREATE TABLE IF NOT EXISTS `Locacao` (
    `id_locacao` INT AUTO_INCREMENT PRIMARY KEY,
    `id_aluno` INT NOT NULL,
    `id_livro` INT NOT NULL,
    `data_emprestimo` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `data_devolucao` DATE DEFAULT NULL, -- NULL = ainda alugado
    CONSTRAINT `fk_locacao_aluno` FOREIGN KEY (`id_aluno`) REFERENCES `Aluno` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_locacao_livro` FOREIGN KEY (`id_livro`) REFERENCES `Livro` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- =================================================================
-- SEED DATA (DADOS INICIAIS DE TESTE)
-- =================================================================

-- 1. Inserir Gestor padrão (senha: admin123)
-- Hash de senha bcrypt pré-gerado correspondente a 'admin123'
INSERT INTO `Aluno` (`nome`, `usuario`, `senha`, `matricula`, `usuario_discord`, `email`, `celular`, `gestor`) 
VALUES 
('Gestor Administrador', 'admin', '$2y$10$abcdefghijklmnopqrstuuEZ4tpXm4W5SeJkDbuNdfJ.CF0.Wc2V2', '12345678901', 'admin_discord', 'admin@ufrrj.br', '21999999999', 1);

-- 2. Inserir Alunos comuns (sem acesso ao painel de gestor)
INSERT INTO `Aluno` (`nome`, `usuario`, `senha`, `matricula`, `usuario_discord`, `email`, `celular`, `gestor`)
VALUES
('João da Silva', 'joaosilva', NULL, '20210001234', 'joao_discord', 'joao.silva@ufrrj.br', '21988888888', 0),
('Maria dos Santos', 'mariasantos', NULL, '20220005678', NULL, 'maria.santos@ufrrj.br', '21977777777', 0),
('Pedro Henrique Souza', 'pedrosouza', NULL, '20230009012', 'pedrinho_discord', 'pedro.souza@ufrrj.br', NULL, 0);

-- 3. Inserir Livros (e seus exemplares individuais)
-- Livro com 1 exemplar
INSERT INTO `Livro` (`titulo`, `autores`, `editora`, `edicao`, `ano_publicacao`, `exemplar`, `alugado`)
VALUES
('Introdução ao HTML5 e CSS3', 'Maurício Samy Silva', 'Novatec', 1, 2018, 'Introdução ao HTML5 e CSS3 – Exemplar 1', 0);

-- Livro com 2 exemplares (1 será alugado no seed)
INSERT INTO `Livro` (`titulo`, `autores`, `editora`, `edicao`, `ano_publicacao`, `exemplar`, `alugado`)
VALUES
('Sistemas de Banco de Dados', 'Abraham Silberschatz, Henry F. Korth', 'Pearson', 6, 2012, 'Sistemas de Banco de Dados – Exemplar 1', 1),
('Sistemas de Banco de Dados', 'Abraham Silberschatz, Henry F. Korth', 'Pearson', 6, 2012, 'Sistemas de Banco de Dados – Exemplar 2', 0);

-- Livro com 3 exemplares (1 terá locação finalizada no seed)
INSERT INTO `Livro` (`titulo`, `autores`, `editora`, `edicao`, `ano_publicacao`, `exemplar`, `alugado`)
VALUES
('Código Limpo', 'Robert C. Martin', 'Alta Books', 1, 2009, 'Código Limpo – Exemplar 1', 0),
('Código Limpo', 'Robert C. Martin', 'Alta Books', 1, 2009, 'Código Limpo – Exemplar 2', 0),
('Código Limpo', 'Robert C. Martin', 'Alta Books', 1, 2009, 'Código Limpo – Exemplar 3', 0);

-- 4. Inserir Locações
-- Locação ativa: João da Silva alugou 'Sistemas de Banco de Dados - Exemplar 1' (id do livro = 2, id do aluno = 2)
INSERT INTO `Locacao` (`id_aluno`, `id_livro`, `data_emprestimo`, `data_devolucao`)
VALUES
(2, 2, '2026-06-25 10:00:00', NULL);

-- Locação finalizada (histórico): Maria dos Santos alugou 'Código Limpo - Exemplar 1' (id do livro = 4, id do aluno = 3)
INSERT INTO `Locacao` (`id_aluno`, `id_livro`, `data_emprestimo`, `data_devolucao`)
VALUES
(3, 4, '2026-06-20 14:00:00', '2026-06-24');
