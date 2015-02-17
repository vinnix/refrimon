-- MySQL dump 10.13  Distrib 5.5.40, for Linux (x86_64)
--
-- Host: localhost    Database: bd_refrimon
-- ------------------------------------------------------
-- Server version	5.5.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `chamada`
--

DROP TABLE IF EXISTS `chamada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chamada` (
  `id_chamada` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` smallint(5) unsigned NOT NULL DEFAULT '0',
  `produto` varchar(40) DEFAULT NULL,
  `defeito` varchar(60) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `observacao` text,
  PRIMARY KEY (`id_chamada`),
  UNIQUE KEY `id_chamada` (`id_chamada`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=MyISAM AUTO_INCREMENT=11509 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id_cliente` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nm_cliente` varchar(40) DEFAULT NULL,
  `telefone` varchar(40) DEFAULT NULL,
  `endereco` varchar(75) DEFAULT NULL,
  `observacao` text,
  `data_cadastro` date DEFAULT NULL,
  UNIQUE KEY `id_cliente` (`id_cliente`),
  KEY `nm_cliente` (`nm_cliente`),
  KEY `telefone` (`telefone`),
  KEY `endereco` (`endereco`)
) ENGINE=MyISAM AUTO_INCREMENT=9350 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conta_receber`
--

DROP TABLE IF EXISTS `conta_receber`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conta_receber` (
  `id_conta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_servico` int(10) unsigned NOT NULL DEFAULT '0',
  `data` date DEFAULT NULL,
  `valor` decimal(7,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_conta`),
  UNIQUE KEY `id_conta` (`id_conta`),
  KEY `id_servico` (`id_servico`)
) ENGINE=MyISAM AUTO_INCREMENT=7302 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conta_recebida`
--

DROP TABLE IF EXISTS `conta_recebida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conta_recebida` (
  `id_conta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_servico` int(10) unsigned NOT NULL DEFAULT '0',
  `data` date DEFAULT NULL,
  `valor` decimal(7,2) unsigned DEFAULT NULL,
  `verificada` enum('n','v') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id_conta`),
  UNIQUE KEY `id_conta` (`id_conta`),
  KEY `id_servico` (`id_servico`)
) ENGINE=MyISAM AUTO_INCREMENT=8661 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fornecedor` (
  `id_fornecedor` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nm_fornecedor` varchar(60) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `nm_contato` varchar(40) DEFAULT NULL,
  `telefone` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id_fornecedor`),
  UNIQUE KEY `id_fornecedor` (`id_fornecedor`)
) ENGINE=MyISAM AUTO_INCREMENT=216 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `peca`
--

DROP TABLE IF EXISTS `peca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peca` (
  `id_peca` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `prefixo` varchar(8) DEFAULT NULL,
  `nm_peca` varchar(70) DEFAULT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `quantidade` float unsigned DEFAULT '0',
  `quantidade_minima` float unsigned DEFAULT '0',
  `unidade` varchar(8) NOT NULL DEFAULT '',
  `valor_compra` decimal(7,2) unsigned DEFAULT NULL,
  `valor_venda` decimal(7,2) unsigned DEFAULT NULL,
  `endereco` varchar(10) DEFAULT NULL,
  UNIQUE KEY `id_peca` (`id_peca`),
  KEY `prefixo` (`prefixo`),
  KEY `nm_peca` (`nm_peca`)
) ENGINE=MyISAM AUTO_INCREMENT=2379 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `peca_usada_oficina`
--

DROP TABLE IF EXISTS `peca_usada_oficina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peca_usada_oficina` (
  `id_peca` smallint(5) unsigned NOT NULL DEFAULT '0',
  `quantidade` float DEFAULT '0',
  `data` date DEFAULT NULL,
  KEY `data` (`data`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `peca_usada_servico`
--

DROP TABLE IF EXISTS `peca_usada_servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peca_usada_servico` (
  `id_servico` int(10) unsigned NOT NULL DEFAULT '0',
  `id_peca` smallint(5) unsigned NOT NULL DEFAULT '0',
  `quantidade` float unsigned DEFAULT NULL,
  KEY `id_servico` (`id_servico`,`id_peca`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `peca_usada_usuario`
--

DROP TABLE IF EXISTS `peca_usada_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peca_usada_usuario` (
  `id_usuario` smallint(5) unsigned NOT NULL DEFAULT '0',
  `id_peca` smallint(5) unsigned NOT NULL DEFAULT '0',
  `quantidade` float unsigned DEFAULT NULL,
  `data` date DEFAULT NULL,
  KEY `id_usuario` (`id_usuario`,`id_peca`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `peca_usada_veiculo`
--

DROP TABLE IF EXISTS `peca_usada_veiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peca_usada_veiculo` (
  `id_uso` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `id_veiculo` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id_peca` smallint(5) unsigned NOT NULL DEFAULT '0',
  `quantidade` float unsigned DEFAULT NULL,
  `data` date DEFAULT NULL,
  PRIMARY KEY (`id_uso`),
  UNIQUE KEY `id_uso` (`id_uso`),
  KEY `id_veiculo` (`id_veiculo`,`id_peca`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `servico`
--

DROP TABLE IF EXISTS `servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servico` (
  `id_servico` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_chamada` smallint(5) unsigned NOT NULL DEFAULT '0',
  `id_cliente` smallint(5) unsigned NOT NULL DEFAULT '0',
  `produto` varchar(100) DEFAULT NULL,
  `defeito` varchar(200) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `valor` decimal(7,2) unsigned DEFAULT NULL,
  `data` date DEFAULT NULL,
  `observacao` text,
  `garantia` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_servico`),
  UNIQUE KEY `id_servico` (`id_servico`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_chamada` (`id_chamada`)
) ENGINE=MyISAM AUTO_INCREMENT=10931 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `nm_usuario` char(255) NOT NULL DEFAULT '',
  `senha` char(255) DEFAULT NULL,
  PRIMARY KEY (`nm_usuario`),
  UNIQUE KEY `nm_usuario` (`nm_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuario_peca`
--

DROP TABLE IF EXISTS `usuario_peca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_peca` (
  `id_usuario` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nm_usuario` varchar(15) NOT NULL DEFAULT '',
  `ativo` enum('S','N') DEFAULT 'S',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `veiculo`
--

DROP TABLE IF EXISTS `veiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `veiculo` (
  `id_veiculo` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` char(20) DEFAULT NULL,
  PRIMARY KEY (`id_veiculo`),
  UNIQUE KEY `id_veiculo` (`id_veiculo`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-02-17 16:06:08
