DROP DATABASE IF EXISTS db_projetfa;
CREATE DATABASE IF NOT EXISTS db_projetfa  CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP USER IF EXISTS 'Cli_Read'@'%';
CREATE USER 'Cli_Read'@'%' IDENTIFIED BY 'pwdPourCli_R';

USE db_projetfa;

CREATE TABLE Evenement (
  idEvent INT NOT NULL AUTO_INCREMENT,
  libelleEvent VARCHAR(100) NOT NULL,
  descriptionEvent VARCHAR(500) NOT NULL,
  capaMaxi INT NOT NULL,
  CONSTRAINT Evenement_PK PRIMARY KEY (idEvent)
) ENGINE=InnoDB;

CREATE TABLE Horaires (
  idHoraire INT NOT NULL AUTO_INCREMENT,
  date DATE NOT NULL,
  heureDeb TIME NOT NULL,
  heureFin TIME NOT NULL,
  CONSTRAINT Horaires_PK PRIMARY KEY (idHoraire)
) ENGINE=InnoDB;

CREATE TABLE typeDroit (
  idDroit INT NOT NULL AUTO_INCREMENT,
  libelleDroit VARCHAR(20) NOT NULL,
  CONSTRAINT typeDroit_PK PRIMARY KEY (idDroit)
) ENGINE=InnoDB;

CREATE TABLE Tarif (
  idTarif INT NOT NULL AUTO_INCREMENT,
  libelleTarif VARCHAR(50) NOT NULL,
  prix DOUBLE NOT NULL,
  CONSTRAINT Tarif_PK PRIMARY KEY (idTarif)
) ENGINE=InnoDB;

CREATE TABLE Concerner (
  idHoraire INT NOT NULL,
  idEvent INT NOT NULL,
  CONSTRAINT Concerner_PK PRIMARY KEY (idHoraire, idEvent),
  CONSTRAINT Concerner_idHoraire_FK FOREIGN KEY (idHoraire) REFERENCES Horaires (idHoraire),
  CONSTRAINT Concerner_idEvent_FK FOREIGN KEY (idEvent) REFERENCES Evenement (idEvent)
) ENGINE=InnoDB;

CREATE TABLE User (
  idUser INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(20) NOT NULL,
  prenom VARCHAR(20) NOT NULL,
  mail VARCHAR(20) NOT NULL,
  mdp VARCHAR(20) NOT NULL,
  GDU VARCHAR(50) NOT NULL,
  idDroit INT NOT NULL,
  CONSTRAINT User_PK PRIMARY KEY (idUser),
  CONSTRAINT User_idDroit_FK FOREIGN KEY (idDroit) REFERENCES typeDroit (idDroit)
) ENGINE=InnoDB;

CREATE TABLE Reservation (
  idReserv INT NOT NULL AUTO_INCREMENT,
  dateReserv DATE NOT NULL,
  heureReserv TIME NOT NULL,
  idEvent INT NOT NULL,
  idUser INT NOT NULL,
  CONSTRAINT Reservation_PK PRIMARY KEY (idReserv),
  CONSTRAINT Reservation_idEvent_FK FOREIGN KEY (idEvent) REFERENCES Evenement (idEvent),
  CONSTRAINT Reservation_idUser_FK FOREIGN KEY (idUser) REFERENCES User (idUser)
) ENGINE=InnoDB;

CREATE TABLE Contenir (
  idReserv INT NOT NULL,
  idTarif INT NOT NULL,
  nbPlace INT NOT NULL,
  CONSTRAINT Contenir_PK PRIMARY KEY (idReserv, idTarif),
  CONSTRAINT Contenir_idReserv_FK FOREIGN KEY (idReserv) REFERENCES Reservation (idReserv),
  CONSTRAINT Contenir_idTarif_FK FOREIGN KEY (idTarif) REFERENCES Tarif (idTarif)
) ENGINE=InnoDB;

GRANT SELECT ON `bd_projetfa`.`Evenement` TO 'Cli_Read'@'%';