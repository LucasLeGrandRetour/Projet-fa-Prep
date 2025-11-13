<?php
include_once "BaseDAO.php";
include_once "Evenement.php";

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

            $sql = "SELECT * FROM Evenement;";
            $stmt = $this->prepare($sql);
            $stmt->execute();

            $lesLignes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $lesLignesObjets = [];

            foreach ($lesLignes as $ligne) {
                $lesLignesObjets[] = new Evenement(
                    (int)$ligne['id'],
                    (string)$ligne['nom'],
                    (string)$ligne['prenom']
                );
            }

            return $lesLignesObjets;

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return []; // Retourne un tableau vide en cas d’erreur
        }
    }
}
