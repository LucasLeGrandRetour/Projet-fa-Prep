-- script d'initialisation de la base de données pour l'application web avec les droits de l'utilisateur
DROP DATABASE IF EXISTS `tp_sio2_bdjourneeintegration`;

CREATE DATABASE IF NOT EXISTS `tp_sio2_bdjourneeintegration` CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE DATABASE IF NOT EXISTS `tp_sio2_bdjourneeintegration` CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP USER IF EXISTS 'JI_Dev_Read'@'%';

CREATE USER 'JI_Dev_Read'@'%' IDENTIFIED BY 'pwdJIPourDev_R';

DROP USER IF EXISTS 'JI_Dev_Write'@'%';

CREATE USER 'JI_Dev_Write'@'%' IDENTIFIED BY 'pwdJIPourDev_W';

DROP USER IF EXISTS 'JI_Dev_Supp'@'%';

CREATE USER 'JI_Dev_Supp'@'%' IDENTIFIED BY 'pwdJIPourDev_S';

DROP USER IF EXISTS 'JI_Dev_Update'@'%';

CREATE USER 'JI_Dev_Update'@'%' IDENTIFIED BY 'pwdJIPourDev_U';


DROP USER IF EXISTS 'JI_Comp_Read'@'%';

CREATE USER 'JI_Comp_Read'@'%' IDENTIFIED BY 'pwdJIPourComp_R';

DROP USER IF EXISTS 'JI_Comp_Write'@'%';

CREATE USER 'JI_Comp_Write'@'%' IDENTIFIED BY 'pwdJIPourComp_W';


USE `tp_sio2_bdjourneeintegration`;
