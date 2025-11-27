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

CREATE TABLE Reservation (
  idReserv INT NOT NULL AUTO_INCREMENT,
  dateReserv DATE NOT NULL,
  idConcerner INT NOT NULL,
  PRIMARY KEY (idReserv),
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
(2, 'Evenement de test n°2', "Test encore une fois."),(3, 'Evenement de test n°3', "Test encore une fois.")
,(4, 'Evenement de test n°2', "Test encore une fois."),(5, 'Evenement de test n°2', "Test encore une fois."),
(6, 'Evenement de test n°2', "Test encore une fois."),(13, 'Evenement de test n°2', "Test encore une fois."),
(7, 'Evenement de test n°2', "Test encore une fois."),(14, 'Evenement de test n°2', "Test encore une fois."),
(8, 'Evenement de test n°2', "Test encore une fois."),(15, 'Evenement de test n°2', "Test encore une fois."),
(9, 'Evenement de test n°2', "Test encore une fois."),(16, 'Evenement de test n°2', "Test encore une fois."),
(10, 'Evenement de test n°2', "Test encore une fois."),(17, 'Evenement de test n°2', "Test encore une fois."),
(11, 'Evenement de test n°2', "Test encore une fois."),(18, 'Evenement de test n°2', "Test encore une fois."),
(12, 'Evenement de test n°2', "Test encore une fois."),(19, 'Evenement de test n°2', "Test encore une fois.");

INSERT INTO Horaires (idHoraire, date, heureDeb, heureFin) VALUES
(1, '2025-11-20', '08:30:00', NULL),
(2, '2025-11-28', '08:30:00', '08:40:00'),
(3, '2025-11-27', '16:30:00', NULL),
(4, '2025-11-29', '15:30:00', NULL);

INSERT INTO Tarif (idTarif, libelleTarif, prix) VALUES
(1, 'Enfant', 10.0),
(2, 'Adulte', 20.0),
(3, 'Senior', 15.0);

INSERT INTO Concerner (idConcerner, idHoraire, idEvent, capaMaxi) VALUES
(1, 1, 1, 50),
(2, 2, 1, 50),
(3, 3, 1, 50),
(4, 4, 2, 10);

INSERT INTO Reservation (idReserv, dateReserv, idConcerner) VALUES
(1, '2025-11-20', 1),
(2, '2025-11-20', 2);

INSERT INTO Contenir (idReserv, idTarif, nbPlace) VALUES
(1, 1, 2), 
(1, 2, 1),
(2, 2, 2);



GRANT SELECT ON `db_projetfa`.`Evenement` TO 'Cli_Read'@'%';

GRANT SELECT ON `db_projetfa`.* TO 'Cli_All'@'%';

GRANT SELECT, INSERT ON `db_projetfa`.`Concerner` TO 'Cli_Write'@'%';
GRANT SELECT, INSERT ON `db_projetfa`.`Reservation` TO 'Cli_Write'@'%';
GRANT SELECT, INSERT ON `db_projetfa`.`Contenir` TO 'Cli_Write'@'%';