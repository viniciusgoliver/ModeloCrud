<?php

/*
 * Constantes de parтmetros para configuraчуo da conexуo
 */
define('HOST', '192.168.33.10');
define('DBNAME', 'agenda_pdo');
define('CHARSET', 'utf8');
define('USER', 'root');
define('PASSWORD', 'vagrant');

// Setando Erros do php.ini
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
ini_set('memory_limit', '256M');
