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


INSERT INTO Evenement VALUES ('1', 'Evenement de test n°1', "Cet évènement est un test pour l'inesrion et le bon fonctionnement des fonctionnalités en relation avec les évènements.", 50);
INSERT INTO Evenement VALUES ('2', 'Evenement de test n°2', "test encore une fois", 10);

INSERT INTO Horaires(idHoraire, date, heureDeb) VALUES ('1', '2025-11-20', '08:30:00');
INSERT INTO Horaires(idHoraire, date, heureDeb, heureFin) VALUES ('2', '2025-11-20', '08:30:00', '08:40:00');
INSERT INTO Horaires(idHoraire, date, heureDeb) VALUES ('3', '2025-11-22', '16:30:00');
INSERT INTO Horaires(idHoraire, date, heureDeb) VALUES ('4', '2025-11-22', '15:30:00');

INSERT INTO Concerner VALUES ('1', '1');
INSERT INTO Concerner VALUES ('2', '1');
INSERT INTO Concerner VALUES ('3', '1');
INSERT INTO Concerner VALUES ('4', '2');


GRANT SELECT ON `db_projetfa`.`Evenement` TO 'Cli_Read'@'%';