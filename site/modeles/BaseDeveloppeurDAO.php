<?php
// lien vers la classe mère
include_once "BaseDAO.php";
include_once "Developpeur.php";

/**
 * Modifications :
 * - création d'une classe spécifique pour chaque table de la base de données
 * - modification du constructeur : instruction de connexion enlevée
 * - réalisation de la connexion en décalé afin de pouvoir
 *   définir un accès spécifique selon le type d'opération à réaliser
 */

class BaseDeveloppeurDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct(); // par défaut la connexion n'est pas établie.
    }


    /**
     * Méthode permettant de définir la connexion
     * à la base de données
     * avec les habilitations les plus adéquates (droits restreints)
     * selon l'action à réaliser
     */
    private function setConnexionSelonRole(string $role)
    {
        $this->setConnexionBase($_ENV['local_dsn'], $_ENV[$role], $_ENV['pwd' . $role], $_ENV['options']);
    }

    // Nouvelle méthode créée à l'intérieur du modèle
    // pour rendre l'application plus modulaire

    /**
     * Fonction qui permet de récupérer les informations relatives aux développeurs
     * @return array $lesLignes
     */
    public function getLesDeveloppeurs(): array
    {
        /*  pour la BD
        
        // connexion à la base de données avec des droits adéquats
        $this->setConnexionSelonRole("DevRead");
        // demande d'exécution de la requête fournie
        $requeteAExecuter = "SELECT * FROM Developpeur;";
        $resultatDeLaRequete = $this->query($requeteAExecuter);
        
        
        $lesLignes = $resultatDeLaRequete->fetch();*/

        try {
        // Lire le contenu brut du fichier
        $contenuFichier = file_get_contents('modeles/developpeur.json');

        // Vérifier si la lecture a échoué
        if ($contenuFichier === false || json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Erreur lors de la récupération du fichier JSON ");
        }

        // Convertir le JSON en tableau PHP
        $lesLignes = json_decode($contenuFichier, true);
        
        $lesLignesObjets = [];

        foreach ($lesLignes as $ligne) {
            $lesLignesObjets[] = new Developpeur(
                (int)$ligne['id'],
                (string)$ligne['nom'],
                (string)$ligne['prenom']
            );
        }

        // fermeture de la connexion à la base de données
        $resultatDeLaRequete = null;

        return $lesLignesObjets; // renvoi du tableau d'objets

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return []; // Retourner un tableau vide en cas d'erreur
        }
    }

        /**
     * Procédur qui permet de supprimer un développeur
     */
    public function supprimerDeveloppeur(int $id): string
    {
        // connexion à la base de données avec des droits adéquats
        $this->setConnexionSelonRole("DevSupp");
        // demande d'exécution de la requête fournie
        $requeteAExecuter = "DELETE FROM Developpeur WHERE id = :id;";
        $stmt = $this->prepare($requeteAExecuter);
        $lesLignes = $stmt->execute([':id' => $id]);

        // Vérifier si l'insertion a réussi
        if ($lesLignes) {
           $msg = "Le développeur a été supprimé avec succès.";
        } else {
            $msg =  "Erreur lors de la suppression du développeur.";
        }

        // Fermeture de la connexion à la base de données
        $lesLignes = null;

        return $msg;
    }

    public function ajouterDeveloppeur(Developpeur $dev): string
    {
        // connexion à la base de données avec des droits adéquats
        $this->setConnexionSelonRole("DevWrite");
        // demande d'exécution de la requête fournie
        $requeteAExecuter = "INSERT INTO Developpeur(nom, prenom) VALUES('".$dev->getNom()."', '".$dev->getPrenom()."');";
        $lesLignes = $this->query($requeteAExecuter);

        // Vérifier si l'insertion a réussi
        if ($lesLignes->rowCount() > 0) {
           $msg = "Le développeur a été ajouté avec succès.";
        } else {
            $msg =  "Erreur lors de l'ajout du développeur.";
        }

        // Fermeture de la connexion à la base de données
        $lesLignes = null;

        return $msg;
    }

    public function modifierDeveloppeur(Developpeur $dev): string
    {
        // connexion à la base de données avec des droits adéquats
        $this->setConnexionSelonRole("DevUpdate");
        // demande d'exécution de la requête fournie
        $requeteAExecuter = "UPDATE Developpeur SET nom = '".$dev->getNom()."', prenom = '".$dev->getPrenom()."' WHERE id = ".$dev->getId().";";
        $lesLignes = $this->query($requeteAExecuter);

        // Vérifier si l'insertion a réussi
        if ($lesLignes->rowCount() > 0) {
           $msg = "Le développeur a été modifié avec succès.";
        } else {
            $msg =  "Erreur lors de la modification du développeur.";
        }

        // Fermeture de la connexion à la base de données
        $lesLignes = null;

        return $msg;
    }

    public function getLeDeveloppeur(int $id): Developpeur
    {
        
        // connexion à la base de données avec des droits adéquats
        $this->setConnexionSelonRole("DevRead");
        // demande d'exécution de la requête fournie
        $requeteAExecuter = "SELECT * FROM Developpeur WHERE id = ".$id.";";
        $resultatDeLaRequete = $this->query($requeteAExecuter);
        $resultat = $resultatDeLaRequete->fetch();
        $dev = new Developpeur($resultat['id'],$resultat['nom'],$resultat['prenom']);

        // fermeture de la connexion à la base de données
        $resultat = null;

        return $dev; 
    }
}
