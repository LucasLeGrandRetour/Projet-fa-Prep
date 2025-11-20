<?php
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
        $this->setConnexionBase($_ENV['bd'], $_ENV[$role], $_ENV['pwd' . $role]);
    }

    public function getLesEvenements(): array
    {
        try {
            $this->setConnexionSelonRole("CliRead");

            $sql = "SELECT * FROM Evenement;";
            $stmt = $this->prepare($sql);
            $stmt->execute();

            $lesLignes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $lesLignesObjets = [];

            foreach ($lesLignes as $ligne) {
                $lesLignesObjets[] = new Evenement(
                    (int)$ligne['idEvent'],
                    (string)$ligne['libelleEvent'],
                    (string)$ligne['descriptionEvent'],
                    (int)$ligne['capaMaxi']
                );
            }

            return $lesLignesObjets;

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return []; // Retourne un tableau vide en cas d’erreur
        }
    }

    public function getUnEvenement($id): array
    {
        try {
            $this->setConnexionSelonRole("CliRead");

            $sql = "SELECT * FROM Evenement WHERE idEvent = ?"; 
            $stmt = $this->prepare($sql);
            $stmt->execute([$id]);


            $ligne = $stmt->fetch(PDO::FETCH_ASSOC);

            $event =  new Evenement((int)$ligne['idEvent'],
                    (string)$ligne['libelleEvent'],
                    (string)$ligne['descriptionEvent'],
                    (int)$ligne['capaMaxi']);

            return $event;

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return []; // Retourne un tableau vide en cas d’erreur
        }
    }
}
