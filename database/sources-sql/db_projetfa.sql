USE db_projetfa;

CREATE TABLE Evenement (
  idEvent INT NOT NULL AUTO_INCREMENT,
  libelleEvent VARCHAR(100) NOT NULL,
  descriptionEvent VARCHAR(500) NOT NULL,
  CONSTRAINT Evenement_PK PRIMARY KEY (idEvent)
) ENGINE=InnoDB;

CREATE TABLE Horaires (
  idHoraire INT NOT NULL AUTO_INCREMENT,
  date DATE NOT NULL,
  heureDeb TIME NOT NULL,
  heureFin TIME NULL,
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
  idConcerner INT NOT NULL AUTO_INCREMENT,
  idHoraire INT NOT NULL,
  idEvent INT NOT NULL,
  capaMaxi INT NOT NULL,
  PRIMARY KEY (idConcerner),
  FOREIGN KEY (idHoraire) REFERENCES Horaires(idHoraire),
  FOREIGN KEY (idEvent) REFERENCES Evenement(idEvent)
) ENGINE=InnoDB;

CREATE TABLE User (
  idUser INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(30) NOT NULL,
  prenom VARCHAR(30) NOT NULL,
  mail VARCHAR(50) NOT NULL,
  mdp VARCHAR(50) NOT NULL,
  GDU VARCHAR(50) NOT NULL,
  idDroit INT NOT NULL,
  CONSTRAINT User_PK PRIMARY KEY (idUser),
  CONSTRAINT User_idDroit_FK FOREIGN KEY (idDroit) REFERENCES typeDroit (idDroit)
) ENGINE=InnoDB;

CREATE TABLE Reservation (
  idReserv INT NOT NULL AUTO_INCREMENT,
  dateReserv DATE NOT NULL,
  heureReserv TIME NOT NULL,
  idUser INT NOT NULL,
  idConcerner INT NOT NULL,
  PRIMARY KEY (idReserv),
  FOREIGN KEY (idUser) REFERENCES User(idUser),
  FOREIGN KEY (idConcerner) REFERENCES Concerner(idConcerner)
) ENGINE=InnoDB;

CREATE TABLE Contenir (
  idReserv INT NOT NULL,
  idTarif INT NOT NULL,
  nbPlace INT NOT NULL,
  CONSTRAINT Contenir_PK PRIMARY KEY (idReserv, idTarif),
  CONSTRAINT Contenir_idReserv_FK FOREIGN KEY (idReserv) REFERENCES Reservation (idReserv),
  CONSTRAINT Contenir_idTarif_FK FOREIGN KEY (idTarif) REFERENCES Tarif (idTarif)
) ENGINE=InnoDB;


INSERT INTO Evenement (idEvent, libelleEvent, descriptionEvent) VALUES
(1, 'Evenement de test n°1', "Cet évènement est un test pour l'insertion et le bon fonctionnement des fonctionnalités en relation avec les évènements."),
(2, 'Evenement de test n°2', "Test encore une fois.");

INSERT INTO Horaires (idHoraire, date, heureDeb, heureFin) VALUES
(1, '2025-11-20', '08:30:00', NULL),
(2, '2025-11-20', '08:30:00', '08:40:00'),
(3, '2025-11-22', '16:30:00', NULL),
(4, '2025-11-22', '15:30:00', NULL);

INSERT INTO typeDroit (idDroit, libelleDroit) VALUES
(1, 'Admin'),
(2, 'client'),
(3, 'employe');

INSERT INTO Tarif (idTarif, libelleTarif, prix) VALUES
(1, 'Enfant', 10.0),
(2, 'Adulte', 20.0),
(3, 'Senior', 15.0);

INSERT INTO Concerner (idConcerner, idHoraire, idEvent, capaMaxi) VALUES
(1, 1, 1, 50),
(2, 2, 1, 50),
(3, 3, 1, 50),
(4, 4, 2, 10);

INSERT INTO User (idUser, nom, prenom, mail, mdp, GDU, idDroit) VALUES
(1, 'Dupont', 'Jean', 'jean.dupont@test.com', 'mdp123', 'GDU1', 2),
(2, 'Martin', 'Claire', 'claire.martin@test.com', 'mdp456', 'GDU2', 3);

INSERT INTO Reservation (idReserv, dateReserv, heureReserv, idUser, idConcerner) VALUES
(1, '2025-11-20', '08:30:00', 2, 1),
(2, '2025-11-20', '08:30:00', 2, 2);

INSERT INTO Contenir (idReserv, idTarif, nbPlace) VALUES
(1, 1, 2), 
(1, 2, 1),
(2, 2, 2);



GRANT SELECT ON `db_projetfa`.`Evenement` TO 'Cli_Read'@'%';

GRANT SELECT ON `db_projetfa`.* TO 'Cli_All'@'%';

GRANT SELECT, INSERT, UPDATE ON `db_projetfa`.`Concerner` TO 'Cli_Write'@'%';
GRANT SELECT, INSERT, UPDATE ON `db_projetfa`.`Reservation` TO 'Cli_Write'@'%';
GRANT SELECT, INSERT, UPDATE ON `db_projetfa`.`Contenir` TO 'Cli_Write'@'%';