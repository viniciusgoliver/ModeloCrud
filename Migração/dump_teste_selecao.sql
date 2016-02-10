/*
SQLyog Enterprise - MySQL GUI v8.2 RC2
MySQL - 5.5.46-0ubuntu0.14.04.2 : Database - teste_selecao
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`teste_selecao` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `teste_selecao`;

/*Table structure for table `cores` */

DROP TABLE IF EXISTS `cores`;

CREATE TABLE `cores` (
  `titulo` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `cores` */

/*Table structure for table `dados_antigos` */

DROP TABLE IF EXISTS `dados_antigos`;

CREATE TABLE `dados_antigos` (
  `codigo` varchar(100) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `tamanho` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `dados_antigos` */

insert  into `dados_antigos`(`codigo`,`titulo`,`cor`,`tamanho`) values ('100','Sapato Verão 2014','Branco','33'),('100','Sapato Verão 2014','Branco','34'),('100','Sapato Verão 2014','Branco','35'),('100','Sapato Verão 2014','Azul','33'),('100','Sapato Verão 2014','Azul','34'),('100','Sapato Verão 2014','Azul','35'),('120','Tênis Nike','Preto','36'),('120','Tênis Nike','Preto','37'),('120','Tênis Nike','Preto','38'),('120','Tênis Nike','Vermelho','36'),('120','Tênis Nike','Vermelho','37'),('120','Tênis Nike','Vermelho','38');

/*Table structure for table `produtos` */

DROP TABLE IF EXISTS `produtos`;

CREATE TABLE `produtos` (
  `titulo` varchar(100) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `produtos` */

/*Table structure for table `produtos_cores` */

DROP TABLE IF EXISTS `produtos_cores`;

CREATE TABLE `produtos_cores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cor` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cor` (`id_cor`),
  KEY `id_produto` (`id_produto`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `produtos_cores` */

/*Table structure for table `produtos_tamanhos` */

DROP TABLE IF EXISTS `produtos_tamanhos`;

CREATE TABLE `produtos_tamanhos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto_cor` int(11) DEFAULT NULL,
  `id_tamanho` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_produto_cor` (`id_produto_cor`),
  KEY `id_tamanho` (`id_tamanho`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `produtos_tamanhos` */

/*Table structure for table `tamanhos` */

DROP TABLE IF EXISTS `tamanhos`;

CREATE TABLE `tamanhos` (
  `titulo` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tamanhos` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
