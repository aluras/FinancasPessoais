CREATE DATABASE  IF NOT EXISTS `financas_pessoais` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `financas_pessoais`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: financas_pessoais
-- ------------------------------------------------------
-- Server version	5.5.42

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
-- Dumping data for table `conta_usuarios`
--

LOCK TABLES `conta_usuarios` WRITE;
/*!40000 ALTER TABLE `conta_usuarios` DISABLE KEYS */;
INSERT INTO `conta_usuarios` VALUES (1,1,1,NULL,NULL),(2,2,1,NULL,'2015-04-23 03:40:31'),(3,3,1,NULL,NULL),(4,4,1,NULL,NULL),(5,5,1,NULL,NULL),(6,6,1,NULL,NULL);
/*!40000 ALTER TABLE `conta_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `contas`
--

LOCK TABLES `contas` WRITE;
/*!40000 ALTER TABLE `contas` DISABLE KEYS */;
INSERT INTO `contas` VALUES (1,'Geral',0.00,-150.00,1,'',NULL,'2015-04-23 16:12:40'),(2,'Banco do Brasil',0.00,12042.30,1,'',NULL,'2015-04-23 03:42:14'),(3,'Cartão Caixa',0.00,7400.00,3,'',NULL,'2015-05-25 04:28:53'),(4,'BB RF LP Parc',50000.00,52068.00,2,'',NULL,'2015-05-18 03:48:13'),(5,'Carteira André',70.00,1029.00,4,'',NULL,'2015-05-26 03:05:44'),(6,'VR André',360.00,-791.00,5,'',NULL,'2015-05-26 03:25:25');
/*!40000 ALTER TABLE `contas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `grupos`
--

LOCK TABLES `grupos` WRITE;
/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;
INSERT INTO `grupos` VALUES (32,'Dívidas',1,NULL,NULL),(33,'Moradia',1,NULL,NULL),(34,'Alimentação',1,NULL,NULL),(35,'Saúde',1,NULL,NULL),(36,'Educação',1,NULL,NULL),(37,'Vestuário',1,NULL,NULL),(38,'Transporte',1,NULL,NULL),(39,'Lazer',1,NULL,NULL),(40,'Despesas Pessoais',1,NULL,NULL),(41,'Despesas Financeiras',1,NULL,NULL),(42,'Outras',1,NULL,NULL),(43,'Receitas',2,NULL,NULL),(44,'Transferências',3,NULL,NULL);
/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `subgrupos`
--

LOCK TABLES `subgrupos` WRITE;
/*!40000 ALTER TABLE `subgrupos` DISABLE KEYS */;
INSERT INTO `subgrupos` VALUES (60,32,'Crediário',1,NULL,NULL,NULL,NULL),(61,32,'Cartão de crédito',2,NULL,NULL,NULL,NULL),(62,32,'Cheque especial',2,NULL,NULL,NULL,NULL),(63,32,'Outro',2,NULL,NULL,NULL,NULL),(64,33,'Aluguel',1,NULL,NULL,NULL,NULL),(65,33,'Condomínio',1,NULL,NULL,NULL,NULL),(66,33,'IPTU',1,NULL,NULL,NULL,NULL),(67,33,'Empregado(a)',1,NULL,NULL,NULL,NULL),(68,33,'Água',2,NULL,NULL,NULL,NULL),(69,33,'Luz',2,NULL,NULL,NULL,NULL),(70,33,'Gás',2,NULL,NULL,NULL,NULL),(71,33,'Telefone fixo',2,NULL,NULL,NULL,NULL),(72,33,'Telefone celular',2,NULL,NULL,NULL,NULL),(73,33,'TV a cabo',1,NULL,NULL,NULL,NULL),(74,33,'Internet',2,NULL,NULL,NULL,NULL),(75,33,'Móveis/Utensílios',3,NULL,NULL,NULL,NULL),(76,33,'Consertos',3,NULL,NULL,NULL,NULL),(77,34,'Supermercado',2,NULL,NULL,NULL,NULL),(78,34,'Açougue',2,NULL,NULL,NULL,NULL),(79,34,'Feira',2,NULL,NULL,NULL,NULL),(80,34,'Padaria',2,NULL,NULL,NULL,NULL),(81,34,'Restaurante',2,NULL,NULL,NULL,NULL),(82,35,'Convênio',1,NULL,NULL,NULL,NULL),(83,35,'Médico',3,NULL,NULL,NULL,NULL),(84,35,'Dentista',3,NULL,NULL,NULL,NULL),(85,35,'Farmácia',3,NULL,NULL,NULL,NULL),(86,36,'Escola',1,NULL,NULL,NULL,NULL),(87,36,'Material',3,NULL,NULL,NULL,NULL),(88,36,'Uniforme',3,NULL,NULL,NULL,NULL),(89,36,'Cursos extras',1,NULL,NULL,NULL,NULL),(90,37,'Roupas',2,NULL,NULL,NULL,NULL),(91,37,'Calçados',2,NULL,NULL,NULL,NULL),(92,37,'Acessórios',2,NULL,NULL,NULL,NULL),(93,38,'Ônibus',1,NULL,NULL,NULL,NULL),(94,38,'Metro',1,NULL,NULL,NULL,NULL),(95,38,'Táxi',3,NULL,NULL,NULL,NULL),(96,38,'IPVA',1,NULL,NULL,NULL,NULL),(97,38,'Prestação carro/moto',1,NULL,NULL,NULL,NULL),(98,38,'Seguro',1,NULL,NULL,NULL,NULL),(99,38,'Licenciamento',1,NULL,NULL,NULL,NULL),(100,38,'Combustível',2,NULL,NULL,NULL,NULL),(101,38,'Manutenção',3,NULL,NULL,NULL,NULL),(102,38,'Multas de trânsito',3,NULL,NULL,NULL,NULL),(103,38,'Estacionamento',3,NULL,NULL,NULL,NULL),(104,39,'Livros/revistas',2,NULL,NULL,NULL,NULL),(105,39,'Cinema/teatro',2,NULL,NULL,NULL,NULL),(106,39,'Bares',3,NULL,NULL,NULL,NULL),(107,39,'Viagem/Passeio',2,NULL,NULL,NULL,NULL),(108,39,'Presentes',2,NULL,NULL,NULL,NULL),(109,40,'Academia',1,NULL,NULL,NULL,NULL),(110,40,'Seguro de vida',1,NULL,NULL,NULL,NULL),(111,40,'Cabeleireiro',2,NULL,NULL,NULL,NULL),(112,40,'Manicure',2,NULL,NULL,NULL,NULL),(113,40,'Produto de beleza',2,NULL,NULL,NULL,NULL),(114,41,'Juros',2,NULL,NULL,NULL,NULL),(115,41,'Multas',3,NULL,NULL,NULL,NULL),(116,41,'Tarifas bancárias',2,NULL,NULL,NULL,NULL),(117,41,'Anuidades',2,NULL,NULL,NULL,NULL),(118,42,'Outra despesa',2,NULL,NULL,NULL,NULL),(119,43,'Salário',1,NULL,NULL,NULL,NULL),(120,43,'13º salário',1,NULL,NULL,NULL,NULL),(121,43,'Rendimento de investimento',2,NULL,NULL,NULL,NULL),(122,43,'Premios e bonificações',3,NULL,NULL,NULL,NULL),(123,43,'Receita de aluguéis',1,NULL,NULL,NULL,NULL),(124,43,'Indenizações',3,NULL,NULL,NULL,NULL),(125,44,'Pagto. Cartão de Crédito',2,NULL,3,NULL,NULL),(126,44,'Aplicação em investimento',3,NULL,2,NULL,NULL),(127,44,'Resgate de investimento',3,2,NULL,NULL,NULL),(128,44,'Saque',3,NULL,4,NULL,NULL),(129,44,'Transferência',3,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `subgrupos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tipo_contas`
--

LOCK TABLES `tipo_contas` WRITE;
/*!40000 ALTER TABLE `tipo_contas` DISABLE KEYS */;
INSERT INTO `tipo_contas` VALUES (1,'Conta corrente',NULL,NULL),(2,'Investimento',NULL,NULL),(3,'Cartão de Crédito',NULL,NULL),(4,'Espécie',NULL,NULL),(5,'Outras',NULL,NULL);
/*!40000 ALTER TABLE `tipo_contas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tipo_grupo`
--

LOCK TABLES `tipo_grupo` WRITE;
/*!40000 ALTER TABLE `tipo_grupo` DISABLE KEYS */;
INSERT INTO `tipo_grupo` VALUES (1,'Despesa',NULL,NULL),(2,'Receita',NULL,NULL),(3,'Transferência',NULL,NULL);
/*!40000 ALTER TABLE `tipo_grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tipo_subgrupo`
--

LOCK TABLES `tipo_subgrupo` WRITE;
/*!40000 ALTER TABLE `tipo_subgrupo` DISABLE KEYS */;
INSERT INTO `tipo_subgrupo` VALUES (1,'fixo',NULL,NULL),(2,'variável',NULL,NULL),(3,'eventual',NULL,NULL);
/*!40000 ALTER TABLE `tipo_subgrupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'andrelrs80@gmail.com','$2a$10$7tIPP96Lo6L0cCOmq6fd5u.055e3bg9VkJHCocrANIx5.l20yDYhy',NULL,'admin','2015-02-01 02:36:02','2015-02-01 02:36:02'),(3,'drimrfisio@gmail.com','$2a$10$uFmFwnHx3GkZqAY2OtFrC.4fTCNsce08eGyIlWcl/yir03splRZrq','ff8bcb7c14bf14fb566d95c4176dfda4','admin','2015-06-01 12:24:06','2015-06-01 12:24:06');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-03 14:30:43
