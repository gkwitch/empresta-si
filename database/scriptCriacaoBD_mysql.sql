-- ============================================================================
-- SCRIPT DE CRIAÇÃO DO BANCO DE DADOS: empresta_si (Atualizado)
-- ============================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- 1. CRIAÇÃO E SELEÇÃO DO BANCO DE DADOS
DROP DATABASE IF EXISTS `empresta_si`;
CREATE DATABASE `empresta_si` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `empresta_si`;

-- ============================================================================
-- 2. CRIAÇÃO DAS TABELAS
-- ============================================================================

-- Estrutura da tabela `Aluno`
CREATE TABLE `Aluno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,                       -- Coluna para Autenticação (Requisito 6.1)
  `matricula` char(11) NOT NULL,
  `usuario_discord` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `gestor` tinyint(1) NOT NULL DEFAULT '0',          -- Coluna Booleana: 1 para Gestor, 0 para Aluno Comum
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `matricula` (`matricula`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Estrutura da tabela `Livro`
CREATE TABLE `Livro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `autores` text NOT NULL,
  `editora` varchar(50) NOT NULL,
  `edicao` int(11) NOT NULL,
  `ano_publicacao` year(4) NOT NULL,
  `exemplar` varchar(50) DEFAULT NULL,
  `alugado` tinyint(1) NOT NULL DEFAULT '0',            -- Controla a disponibilidade do exemplar
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Estrutura da tabela `Locacao`
CREATE TABLE `Locacao` (
  `id_locacao` int(11) NOT NULL AUTO_INCREMENT,
  `id_aluno` int(11) NOT NULL,
  `id_livro` int(11) NOT NULL,
  `data_emprestimo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_devolucao` date DEFAULT NULL,                   -- Se NULL, o livro está emprestado
  PRIMARY KEY (`id_locacao`),
  KEY `fk_locacao_aluno` (`id_aluno`),
  KEY `fk_locacao_livro` (`id_livro`),
  
  -- Restrições de Integridade (Impedem exclusões acidentais com históricos ativos)
  CONSTRAINT `fk_locacao_aluno` FOREIGN KEY (`id_aluno`) REFERENCES `Aluno` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_locacao_livro` FOREIGN KEY (`id_livro`) REFERENCES `Livro` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;