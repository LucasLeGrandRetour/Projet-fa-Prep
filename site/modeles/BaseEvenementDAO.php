<?php
include_once 'configBdd.php';
include_once 'BaseDAO.php';
include_once 'Evenement.php';
include_once 'Horaire.php';
include_once 'Tarif.php';

/**
 * DAO pour gérer les événements.
 * Permet de récupérer les événements, leurs horaires, tarifs et réservations.
 */
class BaseEvenementDAO extends BaseDAO
{
    /**
     * Constructeur.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Initialise la connexion selon le rôle.
     *
     * @param string $role Rôle pour la connexion (CliRead, CliAll, CliWrite).
     */
    private function setConnexionSelonRole(string $role): void
    {
        $this->setConnexionBase(
            $_ENV['local_dsn'],
            $_ENV[$role],
            $_ENV['pwd' . $role],
            $_ENV['options']
        );
    }

    /**
     * Récupère tous les événements.
     *
     * @return Evenement[] Tableau d'objets Evenement.
     */
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

    /**
     * Récupère un événement par son ID.
     *
     * @param int $idEvent ID de l'événement.
     * @return Evenement|null L'événement ou null si non trouvé.
     */
    public function getUnEvenement(int $idEvent): ?Evenement
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

    /**
     * Récupère les horaires d'un événement.
     *
     * @param int $idEvent ID de l'événement.
     * @return Horaire[] Tableau d'objets Horaire.
     */
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

    /**
     * Récupère tous les tarifs.
     *
     * @return Tarif[] Tableau d'objets Tarif.
     */
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

    /**
     * Calcule le nombre de places restantes pour un horaire donné.
     *
     * @param int $idConcerner ID de la ligne Concerner.
     * @return int Nombre de places restantes.
     */
    public function getPlacesRestantes(int $idConcerner): int
    {
        try {
            $this->setConnexionSelonRole("CliAll");

            $sql = "SELECT capaMaxi FROM Concerner WHERE idConcerner = ?";
            $stmt = $this->prepare($sql);
            $stmt->execute([$idConcerner]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) return 0;

            $capaMax = (int)$data['capaMaxi'];

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

    /**
     * Calcule le nombre total de places réservées pour un événement.
     *
     * @param int $id ID de l'événement.
     * @return int Nombre de places réservées.
     */
    public function setReservation(int $idConcern, int $idTarif, int $nbPlace): string 
    {
        try {
            $this->setConnexionSelonRole("CliWrite");
            $this->beginTransaction();

            if ($idConcern <= 0 || $idTarif <= 0 || $nbPlace <= 0) {
                return "Erreur : Données invalides pour la réservation.";
            }

            $sql = "INSERT INTO Reservation (dateReserv, idConcerner) VALUES (NOW(), ?)";
            $stmt = $this->prepare($sql);
            $stmt->execute([$idConcern]);
            $id = $this->lastInsertId();

            if (!$id) {
                $this->rollBack();
                return "Erreur : Impossible de créer la réservation.";
            }

            $sql = "UPDATE Concerner SET capaMaxi = capaMaxi - ? WHERE idConcerner = ?";
            $stmt = $this->prepare($sql);
            $stmt->execute([$nbPlace, $idConcern]);

            if ($stmt->rowCount() === 0) {
                $this->rollBack();
                return "Erreur : L'événement n'existe pas ou la capacité est insuffisante.";
            }

            $sql = "INSERT INTO Contenir(idReserv, idTarif, nbPlace) VALUES (?, ?, ?)";
            $stmt = $this->prepare($sql);
            $stmt->execute([$id, $idTarif, $nbPlace]);

            if ($stmt->rowCount() === 0) {
                $this->rollBack();
                return "Erreur : Impossible d'ajouter les informations de tarif et places.";
            }

            $this->commit();

            return "Réservation effectuée avec succès.";
        } catch (Exception $e) {
            $this->rollBack();
            return "Erreur : " . $e->getMessage();
        }
    }
}
