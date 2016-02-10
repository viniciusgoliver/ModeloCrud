<?php
/*
 * Constantes de parтmetros para configuraчуo da conexуo
 */
define('HOST', 'localhost');
define('DBNAME', 'teste_selecao');
define('CHARSET', 'utf8');
define('USER', 'root');
define('PASSWORD', '');

define('DB_DADOS_ANTIGOS', 'dados_antigos');
define('DB_PRODUTOS', 'produtos');
define('DB_TAMANHOS', 'tamanhos');
define('DB_CORES', 'cores');
define('DB_PRODUTOS_CORES', 'produtos_cores');
define('DB_PRODUTOS_TAMANHOS', 'produtos_tamanhos');

// Setando Erros do php.ini
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
ini_set('memory_limit', '256M');
