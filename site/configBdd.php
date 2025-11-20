<?php
$_ENV['bd'] = 'db_projetfa';
$_ENV['local_dsn'] = 'mysql:host=127.0.0.1;dbname=' . $_ENV['bd'] . ';port=3306';
$_ENV['options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'');
//Comptes

$_ENV['CliRead'] = 'Cli_Read';
$_ENV['pwdCliRead'] = 'pwdPourCli_R';

$_ENV['CliAll'] = 'Cli_All';
$_ENV['pwdCliAll'] = 'pwdPourCli_All';


$_ENV['CliWrite'] = 'Cli_Write';
$_ENV['pwdCliWrite'] = 'pwdPourCli_W';
