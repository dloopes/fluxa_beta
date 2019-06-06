# fluxa_beta
Versão Beta da Plataforma Fluxa - V1.2018

Autores
Lala Dehenzelin
Rodrigo Benedito
Diogo Lopes

Requisitos
PHP
MYSQL
SLIM FRAMEWORK

Criando uma BASE DE DADOS
Para criar a base de dados copie e cole o DUMP da estrutura de dados no seu gerenciador e execute.
Em alguns casos será necessário substituir o campo current_timestamp(), por  '0000-00-00 00:00:00' para que funcione.

-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 06/06/2019 às 19:34
-- Versão do servidor: 10.2.23-MariaDB
-- Versão do PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u238694432_fluxa`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `areas_interesse`
--

CREATE TABLE `areas_interesse` (
  `id` int(50) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
--

CREATE TABLE `endereco` (
  `id` int(50) NOT NULL,
  `cep` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `logradouro` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `complemento` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bairro` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pais` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fluxo`
--

CREATE TABLE `fluxo` (
  `id` int(50) NOT NULL,
  `id_usuario_oferece` int(50) DEFAULT NULL,
  `id_usuario_necessita` int(50) DEFAULT NULL,
  `id_recurso` int(50) DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `date_insert` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fluxo_mensagem`
--

CREATE TABLE `fluxo_mensagem` (
  `id` int(50) NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `id_fluxo` int(50) DEFAULT NULL,
  `date_insert` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_remetente` int(50) DEFAULT NULL,
  `id_destinatario` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `moeda`
--

CREATE TABLE `moeda` (
  `id` int(50) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacao`
--

CREATE TABLE `notificacao` (
  `id` int(50) NOT NULL,
  `texto` text COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_usuario` int(50) DEFAULT NULL,
  `visualizado` tinyint(1) DEFAULT 0,
  `date_insert` timestamp NOT NULL DEFAULT current_timestamp(),
  `url` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `recurso`
--

CREATE TABLE `recurso` (
  `id` int(50) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `detalhe` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_recurso` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_categoria` int(50) DEFAULT NULL,
  `id_usuario` int(50) DEFAULT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_fluxo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_endereco` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `recurso_categoria`
--

CREATE TABLE `recurso_categoria` (
  `id` int(50) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sinergia_tipos`
--

CREATE TABLE `sinergia_tipos` (
  `id` int(50) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(50) NOT NULL,
  `id_rede_social` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url_imagem` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `senha` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `perfil` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_ultimo_acesso` timestamp NOT NULL DEFAULT current_timestamp(),
  `d_e_l_e_t_` tinyint(1) DEFAULT 0,
  `chave_cadastro` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_confirmado` tinyint(1) DEFAULT 0,
  `chave_recuperar_senha` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `recuperar_senha` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `areas_interesse`
--
ALTER TABLE `areas_interesse`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `fluxo`
--
ALTER TABLE `fluxo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario_oferece` (`id_usuario_oferece`),
  ADD KEY `id_usuario_necessita` (`id_usuario_necessita`),
  ADD KEY `id_recurso` (`id_recurso`);

--
-- Índices de tabela `fluxo_mensagem`
--
ALTER TABLE `fluxo_mensagem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_fluxo` (`id_fluxo`),
  ADD KEY `id_remetente` (`id_remetente`),
  ADD KEY `id_destinatario` (`id_destinatario`);

--
-- Índices de tabela `moeda`
--
ALTER TABLE `moeda`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `notificacao`
--
ALTER TABLE `notificacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_endereco` (`id_endereco`);

--
-- Índices de tabela `recurso_categoria`
--
ALTER TABLE `recurso_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sinergia_tipos`
--
ALTER TABLE `sinergia_tipos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `areas_interesse`
--
ALTER TABLE `areas_interesse`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fluxo`
--
ALTER TABLE `fluxo`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fluxo_mensagem`
--
ALTER TABLE `fluxo_mensagem`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `moeda`
--
ALTER TABLE `moeda`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notificacao`
--
ALTER TABLE `notificacao`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `recurso`
--
ALTER TABLE `recurso`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `recurso_categoria`
--
ALTER TABLE `recurso_categoria`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `sinergia_tipos`
--
ALTER TABLE `sinergia_tipos`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `fluxo`
--
ALTER TABLE `fluxo`
  ADD CONSTRAINT `fluxo_ibfk_1` FOREIGN KEY (`id_usuario_oferece`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fluxo_ibfk_2` FOREIGN KEY (`id_usuario_necessita`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fluxo_ibfk_3` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id`);

--
-- Restrições para tabelas `fluxo_mensagem`
--
ALTER TABLE `fluxo_mensagem`
  ADD CONSTRAINT `fluxo_mensagem_ibfk_1` FOREIGN KEY (`id_fluxo`) REFERENCES `fluxo` (`id`),
  ADD CONSTRAINT `fluxo_mensagem_ibfk_2` FOREIGN KEY (`id_remetente`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `fluxo_mensagem_ibfk_3` FOREIGN KEY (`id_destinatario`) REFERENCES `usuario` (`id`);

--
-- Restrições para tabelas `notificacao`
--
ALTER TABLE `notificacao`
  ADD CONSTRAINT `notificacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Restrições para tabelas `recurso`
--
ALTER TABLE `recurso`
  ADD CONSTRAINT `recurso_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `recurso_categoria` (`id`),
  ADD CONSTRAINT `recurso_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `recurso_ibfk_3` FOREIGN KEY (`id_endereco`) REFERENCES `endereco` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
