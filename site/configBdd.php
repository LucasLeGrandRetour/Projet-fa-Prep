<?php

/**
 * Fichier de configuration de la base de données
 * Il est suggéré d'enlever ce fichier des push ultérieurs
 */
$_ENV['bd'] = 'tp_sio2_bdjourneeintegration'; // nom de la base de données distante

$_ENV['local_dsn'] = 'mysql:host=127.0.0.1;dbname=' . $_ENV['bd'] . ';port=3306'; // local data source name

$_ENV['remote_dsn_slam'] = 'mysql:host=194.199.35.4;dbname=' . $_ENV['bd'] . ';port=3306'; // remote data source name

$_ENV['options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''); // option pour le driver PDO : UTF8 pour gérer les accents


/**
 * Compte ayant les habilitations pour la fonctionnalité "aPropos" :liste des développeurs
 */
$_ENV['DevRead'] = 'JI_Dev_Read'; // utilisateur de la base de données
$_ENV['pwdDevRead'] = 'pwdJIPourDev_R'; // mot de passe de l'utilisateur de la base de données
/**
 * Compte ayant les habilitations pour la fonctionnalité "aPropos" :liste des développeurs
 */
$_ENV['DevWrite'] = 'JI_Dev_Write'; // utilisateur de la base de données
$_ENV['pwdDevWrite'] = 'pwdJIPourDev_W'; // mot de passe de l'utilisateur de la base de données

$_ENV['DevSupp'] = 'JI_Dev_Supp'; // utilisateur de la base de données
$_ENV['pwdDevSupp'] = 'pwdJIPourDev_S'; // mot de passe de l'utilisateur de la base de données

$_ENV['DevUpdate'] = 'JI_Dev_Update'; // utilisateur de la base de données
$_ENV['pwdDevUpdate'] = 'pwdJIPourDev_U'; // mot de passe de l'utilisateur de la base de données


$_ENV['CompRead'] = 'JI_Comp_Read'; // utilisateur de la base de données
$_ENV['pwdCompRead'] = 'pwdJIPourComp_R'; // mot de passe de l'utilisateur de la base de données

$_ENV['CompWrite'] = 'JI_Comp_Write'; // utilisateur de la base de données
$_ENV['pwdCompWrite'] = 'pwdJIPourComp_W'; // mot de passe de l'utilisateur de la base de données
