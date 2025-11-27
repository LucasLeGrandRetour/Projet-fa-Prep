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
                        H.idHoraire,
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
                    (int)$ligne['idHoraire'],
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
     * Récupère les horaires d'un événement pour une date donnée.
     * Cette version est utilisée par AJAX et le chargement initial.
     *
     * @param int $idEvent ID de l'événement.
     * @param string $date Date au format YYYY-MM-DD.
     * @return Horaire[] Tableau d'objets Horaire.
     */
    public function getHorairesEvenementParDate(int $idEvent, string $date): array
    {
        try {
            $this->setConnexionSelonRole("CliAll");

            // Requête SQL pour récupérer les horaires correspondant à l'événement et à la date
            $sql = "SELECT 
                        H.idHoraire,
                        C.idConcerner,
                        H.date,
                        H.heureDeb,
                        H.heureFin
                    FROM Concerner C
                    JOIN Horaires H ON H.idHoraire = C.idHoraire
                    WHERE C.idEvent = ? AND H.date = ?";  // Ajout du filtre pour la date

            $stmt = $this->prepare($sql);
            $stmt->execute([$idEvent, $date]);  // On passe l'ID de l'événement et la date

            // Récupérer les résultats sous forme de tableau associatif
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Transformation des résultats en objets Horaire
            $horaires = [];
            foreach ($rows as $ligne) {
                $horaires[] = new Horaire(
                    (int)$ligne['idHoraire'],
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

            // 1. Récupérer la capacité maximale fixe
            $sql = "SELECT capaMaxi FROM Concerner WHERE idConcerner = ?";
            $stmt = $this->prepare($sql);
            $stmt->execute([$idConcerner]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) return 0;

            $capaMax = (int)$data['capaMaxi'];

            // 2. Calculer les places déjà réservées
            $sql = "SELECT IFNULL(SUM(nbPlace),0)
                    FROM Contenir CO
                    JOIN Reservation R ON R.idReserv = CO.idReserv
                    WHERE R.idConcerner = ?";

            $stmt = $this->prepare($sql);
            $stmt->execute([$idConcerner]);
            $nb = (int)$stmt->fetchColumn();

            // 3. Retourner la différence
            return $capaMax - $nb;

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return 0;
        }
    }

    /**
     * Enregistre une nouvelle réservation.
     *
     * @param int $idConcern ID de la ligne Concerner (créneau horaire).
     * @param array $panier Tableau des tarifs [idTarif => nbPlace].
     * @param float $total Montant total de la réservation (pour vérification).
     * @return int ID de la réservation insérée ou 0 en cas d'échec.
     */
    public function setReservation(int $idConcern, array $panier, float $total): int 
    {
        try {
            $this->setConnexionSelonRole("CliWrite");
            $this->beginTransaction();

            if ($idConcern <= 0 || $total <= 0 || empty($panier)) {
                return 0; // FIX: Retourne 0 au lieu d'une chaîne
            }
            
            // NOTE: Le code DOIT vérifier ici si getPlacesRestantes(idConcern) est > 0 pour toutes les places demandées
            
            // 1. Insertion de la réservation principale
            $sql = "INSERT INTO Reservation (dateReserv, idConcerner) VALUES (NOW(), ?)";
            $stmt = $this->prepare($sql);
            $stmt->execute([$idConcern]);
            $id = $this->lastInsertId();

            if (!$id) {
                $this->rollBack();
                return 0;
            }

            // FIX: Suppression de la ligne d'UPDATE INCORRECTE qui modifie capaMaxi.
            /* $sql = "UPDATE Concerner SET capaMaxi = capaMaxi - ? WHERE idConcerner = ?";
            $stmt = $this->prepare($sql);
            $stmt->execute([$nbPlace, $idConcern]); 
            */

            // 2. Insertion des lignes de détail (Contenir)
            foreach ($panier as $idTarif => $nbPlace) {
                if ($nbPlace > 0) {
                    $sql = "INSERT INTO Contenir(idReserv, idTarif, nbPlace) VALUES (?, ?, ?)";
                    $stmt = $this->prepare($sql);
                    $stmt->execute([$id, $idTarif, $nbPlace]);

                    if ($stmt->rowCount() === 0) {
                        $this->rollBack();
                        return 0;
                    }
                }
            }

            $this->commit();

            return (int)$id;
        } catch (Exception $e) {
            $this->rollBack();
            // Vous pouvez loguer l'erreur ici : error_log("Erreur de réservation: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Récupère les détails d'une réservation (informations + ligne tarif/quantité).
     *
     * @param int $idReserv
     * @return array ['reservation' => array, 'contenu' => array]
     */
    public function getReservationDetail(int $idReserv): array
    {
        try {
            $this->setConnexionSelonRole("CliAll");

                $sql = "SELECT R.idReserv, R.dateReserv, C.idConcerner, E.idEvent, E.libelleEvent, H.date as dateHoraire, H.heureDeb, H.heureFin
                    FROM Reservation R
                    JOIN Concerner C ON C.idConcerner = R.idConcerner
                    JOIN Evenement E ON E.idEvent = C.idEvent
                    JOIN Horaires H ON H.idHoraire = C.idHoraire
                    WHERE R.idReserv = ?";

            $stmt = $this->prepare($sql);
            $stmt->execute([$idReserv]);
            $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

            // Récupère les lignes de tarif
            $sql2 = "SELECT CO.idTarif, CO.nbPlace, T.libelleTarif, T.prix
                    FROM Contenir CO
                    JOIN Tarif T ON T.idTarif = CO.idTarif
                    WHERE CO.idReserv = ?";
            $stmt2 = $this->prepare($sql2);
            $stmt2->execute([$idReserv]);
            $contenu = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            return ['reservation' => $reservation ?: [], 'contenu' => $contenu ?: []];
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return ['reservation' => [], 'contenu' => []];
        }
    }
}