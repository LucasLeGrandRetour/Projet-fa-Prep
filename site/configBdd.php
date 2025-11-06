<?php
$_ENV['bd'] = 'tp_sio2_bdjourneeintegration';

$_ENV['local_dsn'] = 'mysql:host=127.0.0.1;dbname=' . $_ENV['bd'] . ';port=3306';

$_ENV['remote_dsn_slam'] = 'mysql:host=194.199.35.4;dbname=' . $_ENV['bd'] . ';port=3306';

$_ENV['options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'');