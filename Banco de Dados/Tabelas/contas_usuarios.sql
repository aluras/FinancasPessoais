CREATE TABLE `contas_usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contas_id` int(10) unsigned NOT NULL DEFAULT '0',
  `usuarios_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contas_usuarios_contas_idx` (`contas_id`),
  KEY `fk_contas_usuarios_usuarios_idx` (`usuarios_id`),
  CONSTRAINT `fk_contas_usuarios_usuarios` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_contas_usuarios_contas` FOREIGN KEY (`contas_id`) REFERENCES `contas` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
