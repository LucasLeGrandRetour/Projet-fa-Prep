DROP DATABASE IF EXISTS db_projetfa;
CREATE DATABASE IF NOT EXISTS db_projetfa  CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP USER IF EXISTS 'Cli_Read'@'%';
CREATE USER 'Cli_Read'@'%' IDENTIFIED BY 'pwdPourCli_R';

DROP USER IF EXISTS 'Cli_All'@'%';
CREATE USER 'Cli_All'@'%' IDENTIFIED BY 'pwdPourCli_All';

DROP USER IF EXISTS 'Cli_Write'@'%';
CREATE USER 'Cli_Write'@'%' IDENTIFIED BY 'pwdPourCli_W';