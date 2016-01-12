-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.6.21 - MySQL Community Server (GPL)
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              8.0.0.4396
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela controlepromissoria.cidade
DROP TABLE IF EXISTS `cidade`;
CREATE TABLE IF NOT EXISTS `cidade` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `estadoId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela controlepromissoria.cidade: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `cidade` DISABLE KEYS */;
INSERT INTO `cidade` (`id`, `descricao`, `estadoId`) VALUES
	(1, 'Goiania2', 1),
	(2, 'Aparecida de Goiania', 1);
/*!40000 ALTER TABLE `cidade` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.crianca
DROP TABLE IF EXISTS `crianca`;
CREATE TABLE IF NOT EXISTS `crianca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_Crianca` varchar(50) DEFAULT NULL,
  `escola_id` int(11) NOT NULL,
  `serie` varchar(50) DEFAULT NULL,
  `observacoes` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nome_Crianca` (`nome_Crianca`),
  KEY `FK_crianca_escola_id` (`escola_id`),
  CONSTRAINT `FK_crianca_escola_id` FOREIGN KEY (`escola_id`) REFERENCES `escola` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela controlepromissoria.crianca: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `crianca` DISABLE KEYS */;
INSERT INTO `crianca` (`id`, `nome_Crianca`, `escola_id`, `serie`, `observacoes`) VALUES
	(1, 'Gabrielly Christinne', 1, 'Jardim 2', 'Muito Linda');
/*!40000 ALTER TABLE `crianca` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.endereco
DROP TABLE IF EXISTS `endereco`;
CREATE TABLE IF NOT EXISTS `endereco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logradouro` varchar(50) NOT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) NOT NULL,
  `cidade_id` int(11) NOT NULL,
  `cep` int(11) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longetude` varchar(50) DEFAULT NULL,
  `ponto_referencia` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ponto_referencia` (`ponto_referencia`),
  KEY `FK_endereco_cidade_id` (`cidade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela controlepromissoria.endereco: ~13 rows (aproximadamente)
/*!40000 ALTER TABLE `endereco` DISABLE KEYS */;
INSERT INTO `endereco` (`id`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade_id`, `cep`, `latitude`, `longetude`, `ponto_referencia`) VALUES
	(1, '18-D', '0', 'Qd. 167 Lt. 17', 'Garavelo', 2, 74930360, '-16.768948', '-49.327192', 'Escola Estadual Maria Rosilda Rodrigues'),
	(2, '18-D', '0', 'Qd. 185 Lt. 25 Editado', 'Garavelo', 1, 74930360, '-16.768948', '-49.327192', 'Supermercado Garavelo'),
	(3, 'Outra Escola', '1', '111', 'Oriente Vile', 1, 74930360, '-16.7511237', '-49.3558132', 'Supermercado Garavelo'),
	(4, 'rua nova', '0', 'qd 8 lt 9', 'bairro', 2, 74930360, '0', '0', 'ponto ref'),
	(5, '1', '1', '1', '1', 2, 1, '1', '1', '1'),
	(6, '1', '1', '1', '1', 1, 1, '1', '1', '1'),
	(7, '1', '1', '1', '1', 1, 1, '1', '1', '1'),
	(8, '2', '2', '2', '2', 2, 2, '2', '2', '2'),
	(9, 'a', '1', 'a', 'a', 2, 1, '1', '1', 'a'),
	(10, '1', '1', '1', '1', 2, 1, '1', '1', '1'),
	(11, 'a', '1', 'a', '1', 2, 1, '1', '1', '1'),
	(12, 'a', '2', 'a', 'a', 2, 32, '4', '4', '3'),
	(13, 'rua a', '3', 'compl 4', 'bair', 2, 887, '1', '1', 'ponto');
/*!40000 ALTER TABLE `endereco` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.escola
DROP TABLE IF EXISTS `escola`;
CREATE TABLE IF NOT EXISTS `escola` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) DEFAULT NULL,
  `dddtelefone` int(11) DEFAULT NULL,
  `numtelefone` int(11) DEFAULT NULL,
  `enderecoId` int(11) NOT NULL,
  `observacoes` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `descricao` (`descricao`),
  KEY `FK_escola_endereco_id` (`enderecoId`),
  CONSTRAINT `FK_escola_endereco_id` FOREIGN KEY (`enderecoId`) REFERENCES `endereco` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela controlepromissoria.escola: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `escola` DISABLE KEYS */;
INSERT INTO `escola` (`id`, `descricao`, `dddtelefone`, `numtelefone`, `enderecoId`, `observacoes`) VALUES
	(1, 'Escola Castelo dos Genios', 62, 30303030, 2, 'Diretora Chata muito doido'),
	(2, 'Escola Castelo dos Genios', 62, 30303030, 2, 'Diretora Chata'),
	(4, 'nome escola', 11, 222, 13, 'observa');
/*!40000 ALTER TABLE `escola` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.estado
DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL DEFAULT '0',
  `paisId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela controlepromissoria.estado: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` (`id`, `descricao`, `paisId`) VALUES
	(1, 'Goias', 1),
	(2, 'Florida', 2);
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.historico
DROP TABLE IF EXISTS `historico`;
CREATE TABLE IF NOT EXISTS `historico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promissoria_id` int(11) NOT NULL,
  `data_evento` date NOT NULL,
  `datavencimento_original` date NOT NULL,
  `datavencimento_novo` date NOT NULL,
  `situacaopromissoria_original_id` int(11) NOT NULL,
  `situacaopromissoria_novo_id` int(11) NOT NULL,
  `saldo_original` int(11) NOT NULL,
  `saldo_novo` int(11) NOT NULL,
  `observacoes` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_historico_promissoria_id` (`promissoria_id`),
  KEY `FK_historico_situacaopromissoria_original_id` (`situacaopromissoria_original_id`),
  KEY `FK_historico_situacaopromissoria_novo_id` (`situacaopromissoria_novo_id`),
  CONSTRAINT `FK_historico_promissoria_id` FOREIGN KEY (`promissoria_id`) REFERENCES `promissoria` (`id`),
  CONSTRAINT `FK_historico_situacaopromissoria_novo_id` FOREIGN KEY (`situacaopromissoria_novo_id`) REFERENCES `situacaopromissoria` (`id`),
  CONSTRAINT `FK_historico_situacaopromissoria_original_id` FOREIGN KEY (`situacaopromissoria_original_id`) REFERENCES `situacaopromissoria` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela controlepromissoria.historico: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `historico` DISABLE KEYS */;
INSERT INTO `historico` (`id`, `promissoria_id`, `data_evento`, `datavencimento_original`, `datavencimento_novo`, `situacaopromissoria_original_id`, `situacaopromissoria_novo_id`, `saldo_original`, `saldo_novo`, `observacoes`) VALUES
	(2, 3, '2016-01-07', '2016-01-07', '2016-01-07', 1, 5, -200, -150, 'pagou em dinheiro');
/*!40000 ALTER TABLE `historico` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.pais
DROP TABLE IF EXISTS `pais`;
CREATE TABLE IF NOT EXISTS `pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela controlepromissoria.pais: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` (`id`, `descricao`) VALUES
	(1, 'Brasil'),
	(2, 'EUA');
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.perfilusuario
DROP TABLE IF EXISTS `perfilusuario`;
CREATE TABLE IF NOT EXISTS `perfilusuario` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela controlepromissoria.perfilusuario: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `perfilusuario` DISABLE KEYS */;
INSERT INTO `perfilusuario` (`id`, `descricao`) VALUES
	(1, 'Acesso Completo');
/*!40000 ALTER TABLE `perfilusuario` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.pessoa
DROP TABLE IF EXISTS `pessoa`;
CREATE TABLE IF NOT EXISTS `pessoa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cpf_cnpj` int(11) NOT NULL,
  `razao_social` varchar(50) NOT NULL,
  `nome_fantasia` varchar(50) NOT NULL,
  `endereco_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf_cnpj` (`cpf_cnpj`),
  UNIQUE KEY `razao_social` (`razao_social`),
  KEY `nome_fantasia` (`nome_fantasia`),
  KEY `FK_empresa_endereco_id` (`endereco_id`),
  CONSTRAINT `FK_empresa_endereco_id` FOREIGN KEY (`endereco_id`) REFERENCES `endereco` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela controlepromissoria.pessoa: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `pessoa` DISABLE KEYS */;
INSERT INTO `pessoa` (`id`, `cpf_cnpj`, `razao_social`, `nome_fantasia`, `endereco_id`) VALUES
	(1, 983170169, 'Thiago Augusto', 'Aguia Robo', 1),
	(2, 2147483647, 'Jackeline', 'Jackeline', 1);
/*!40000 ALTER TABLE `pessoa` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.promissoria
DROP TABLE IF EXISTS `promissoria`;
CREATE TABLE IF NOT EXISTS `promissoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dataemissao` date NOT NULL,
  `datavencimento` date NOT NULL,
  `trabalho_id` int(11) NOT NULL,
  `situacaopromissoria_id` int(11) NOT NULL,
  `valorNominal` int(11) NOT NULL,
  `observacoes` varchar(200),
  PRIMARY KEY (`id`),
  KEY `FK_promissoria_trabalho_id` (`trabalho_id`),
  KEY `FK_promissoria_situacao_promissoria_id` (`situacaopromissoria_id`),
  CONSTRAINT `FK_promissoria_situacao_promissoria_id` FOREIGN KEY (`situacaopromissoria_id`) REFERENCES `situacaopromissoria` (`id`),
  CONSTRAINT `FK_promissoria_trabalho_id` FOREIGN KEY (`trabalho_id`) REFERENCES `trabalho` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela controlepromissoria.promissoria: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `promissoria` DISABLE KEYS */;
INSERT INTO `promissoria` (`id`, `dataemissao`, `datavencimento`, `trabalho_id`, `situacaopromissoria_id`, `valorNominal`, `observacoes`) VALUES
	(3, '2016-01-07', '2016-02-07', 1, 1, 50, NULL),
	(4, '2016-01-07', '2016-03-07', 1, 1, 50, NULL),
	(5, '2016-01-07', '2016-04-08', 1, 1, 50, NULL),
	(6, '2016-01-07', '2016-05-08', 1, 1, 50, NULL);
/*!40000 ALTER TABLE `promissoria` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.responsavel
DROP TABLE IF EXISTS `responsavel`;
CREATE TABLE IF NOT EXISTS `responsavel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pessoa_id` int(11) NOT NULL,
  `crianca_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_responsavel_pessoa_id` (`pessoa_id`),
  KEY `FK_responsavel_crianca_id` (`crianca_id`),
  CONSTRAINT `FK_responsavel_crianca_id` FOREIGN KEY (`crianca_id`) REFERENCES `crianca` (`id`),
  CONSTRAINT `FK_responsavel_pessoa_id` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela controlepromissoria.responsavel: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `responsavel` DISABLE KEYS */;
INSERT INTO `responsavel` (`id`, `pessoa_id`, `crianca_id`) VALUES
	(1, 1, 1),
	(2, 2, 1);
/*!40000 ALTER TABLE `responsavel` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.situacaopromissoria
DROP TABLE IF EXISTS `situacaopromissoria`;
CREATE TABLE IF NOT EXISTS `situacaopromissoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `descricao` (`descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela controlepromissoria.situacaopromissoria: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `situacaopromissoria` DISABLE KEYS */;
INSERT INTO `situacaopromissoria` (`id`, `descricao`) VALUES
	(1, 'A Vencer'),
	(4, 'Perdida'),
	(3, 'Protestada'),
	(5, 'Quitada'),
	(2, 'Vencida');
/*!40000 ALTER TABLE `situacaopromissoria` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.telefone
DROP TABLE IF EXISTS `telefone`;
CREATE TABLE IF NOT EXISTS `telefone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ddd` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `ramail` varchar(50) NOT NULL,
  `observacao` varchar(50) NOT NULL,
  `pessoa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_telefone_pessoa_id` (`pessoa_id`),
  CONSTRAINT `FK_telefone_pessoa_id` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela controlepromissoria.telefone: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `telefone` DISABLE KEYS */;
INSERT INTO `telefone` (`id`, `ddd`, `numero`, `ramail`, `observacao`, `pessoa_id`) VALUES
	(1, 62, 82114349, '0', 'Ligar fora de Expediente', 1);
/*!40000 ALTER TABLE `telefone` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.trabalho
DROP TABLE IF EXISTS `trabalho`;
CREATE TABLE IF NOT EXISTS `trabalho` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `crianca_id` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `parcelas` int(11) DEFAULT NULL,
  `saldo` int(11) DEFAULT NULL,
  `observacoes` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_trabalho_crianca_id` (`crianca_id`),
  CONSTRAINT `FK_trabalho_crianca_id` FOREIGN KEY (`crianca_id`) REFERENCES `crianca` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela controlepromissoria.trabalho: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `trabalho` DISABLE KEYS */;
INSERT INTO `trabalho` (`id`, `crianca_id`, `valor`, `parcelas`, `saldo`, `observacoes`) VALUES
	(1, 1, 200, 4, -200, 'incluir foto painel');
/*!40000 ALTER TABLE `trabalho` ENABLE KEYS */;


-- Copiando estrutura para tabela controlepromissoria.usuario
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `idPerfilUsuario` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `FK_Usuario_PerfilUsuario` (`idPerfilUsuario`),
  CONSTRAINT `FK_Usuario_PerfilUsuario` FOREIGN KEY (`idPerfilUsuario`) REFERENCES `perfilusuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela controlepromissoria.usuario: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`id`, `usuario`, `senha`, `idPerfilUsuario`, `status`) VALUES
	(110, '1', 'c4ca4238a0b923820dcc509a6f75849b', 1, 1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
