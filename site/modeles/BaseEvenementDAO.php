<?php
include_once 'configBdd.php';
include_once 'BaseDAO.php';
include_once 'Evenement.php';

class BaseEvenementDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct();
    }

    private function setConnexionSelonRole(string $role): void
    {
        $this->setConnexionBase($_ENV['local_dsn'], $_ENV[$role], $_ENV['pwd' . $role], $_ENV['options']);
    }

    public function getLesEvenements(): array
    {
        try {
            $this->setConnexionSelonRole("CliRead");

            $sql = "SELECT idEvent, libelleEvent, descriptionEvent FROM Evenement;";
            $stmt = $this->prepare($sql);
            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $liste = [];

            foreach ($rows as $ligne) {
                $liste[] = new Evenement(
                    (int)$ligne['idEvent'],
                    (string)$ligne['libelleEvent'],
                    (string)$ligne['descriptionEvent']
                );
            }

            return $liste;

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }

    public function getUnEvenement(int $idEvent)
    {
        try {
            $this->setConnexionSelonRole("CliAll");

            $sql = "SELECT idEvent, libelleEvent, descriptionEvent
                    FROM Evenement
                    WHERE idEvent = ?";

            $stmt = $this->prepare($sql);
            $stmt->execute([$idEvent]);

            $ligne = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$ligne) return null;

            return new Evenement(
                (int)$ligne['idEvent'],
                (string)$ligne['libelleEvent'],
                (string)$ligne['descriptionEvent']
            );

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return null;
        }
    }

    public function getHorairesEvenement(int $idEvent): array
    {
        try {
            $this->setConnexionSelonRole("CliAll");

            $sql = "SELECT 
                        C.idConcerner,
                        H.date,
                        H.heureDeb,
                        H.heureFin
                    FROM Concerner C
                    JOIN Horaires H ON H.idHoraire = C.idHoraire
                    WHERE C.idEvent = ?";

            $stmt = $this->prepare($sql);
            $stmt->execute([$idEvent]);

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $horaires = [];

            foreach ($rows as $ligne) {
                $horaires[] = new Horaire(
                    (int)$ligne['idConcerner'],
                    (string)$ligne['date'],
                    (string)$ligne['heureDeb'],
                    (string)$ligne['heureFin']
                );
            }

            return $horaires;

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }

    public function getLesTarifs(): array
    {
        try {
            $this->setConnexionSelonRole("CliAll");

            $sql = "SELECT idTarif, libelleTarif, prix FROM Tarif";
            $stmt = $this->prepare($sql);
            $stmt->execute();

            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $tarifs = [];

            foreach ($rows as $ligne) {
                $tarifs[] = new Tarif(
                    (int)$ligne['idTarif'],
                    (string)$ligne['libelleTarif'],
                    (float)$ligne['prix']
                );
            }

            return $tarifs;

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }

    public function getPlacesRestantes(int $idConcerner): int
    {
        try {
            $this->setConnexionSelonRole("CliAll");

            // Capacité max
            $sql = "SELECT capaMaxi FROM Concerner WHERE idConcerner = ?";
            $stmt = $this->prepare($sql);
            $stmt->execute([$idConcerner]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) return 0;

            $capaMax = (int)$data['capaMaxi'];

            // Réservations
            $sql = "SELECT IFNULL(SUM(nbPlace),0)
                    FROM Contenir CO
                    JOIN Reservation R ON R.idReserv = CO.idReserv
                    WHERE R.idConcerner = ?";

            $stmt = $this->prepare($sql);
            $stmt->execute([$idConcerner]);
            $nb = (int)$stmt->fetchColumn();

            return $capaMax - $nb;

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return 0;
        }
    }

    public function setReservation(int $id): int 
    {
    try {
        $this->setConnexionSelonRole("CliWrite");

        $sql = "SELECT COALESCE(SUM(c.nbPlace), 0) AS nbPlaces
                FROM Reservation r
                INNER JOIN Contenir c ON c.idReserv = r.idReserv
                WHERE r.idEvent = ?";

        $stmt = $this->prepare($sql);
        $stmt->execute([$id]);

        $ligne = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)$ligne['nbPlaces'];

    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
        return 0;
        }
    }

}