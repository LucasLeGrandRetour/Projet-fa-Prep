<?php
/**
 * Classe de base pour l'accès aux données.
 * Fournit la connexion à la base de données et la préparation de requêtes SQL.
 */
class BaseDAO
{
    /**
     * Instance PDO utilisée pour les requêtes SQL.
     * 
     * @var PDO
     */
    protected PDO $db;

    /**
     * Constructeur protégé pour empêcher l'instanciation directe.
     */
    protected function __construct() {}

    /**
     * Initialise la connexion à la base de données.
     *
     * @param string $dsn     Data Source Name (DSN) pour PDO.
     * @param string $user    Nom d'utilisateur de la base.
     * @param string $mdp     Mot de passe pour la connexion.
     * @param array  $options Options PDO (ex : [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]).
     * 
     * @return void
     */
    protected function setConnexionBase(string $dsn, string $user, string $mdp, array $options): void
    {
        try {
            $this->db = new PDO($dsn, $user, $mdp, $options);
        } catch (PDOException $erreur) {
            die('Erreur de connexion à la base de données : ' . $erreur->getMessage());
        }
    }

    /**
     * Prépare une requête SQL pour exécution.
     *
     * @param string $sql Requête SQL à préparer.
     * 
     * @return PDOStatement Objet PDOStatement prêt à être exécuté.
     */
    protected function prepare(string $sql): PDOStatement
    {
        return $this->db->prepare($sql);
    }
}
