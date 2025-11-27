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

    /**
     * Récupère l'ID de la dernière entrée insérée.
     * 
     * @return int Identifiant de la dernière insertion.
     */
    protected function lastInsertId(): int
    {
        return $this->db->lastInsertId();
    }

    /**
     * Démarre une transaction.
     *
     * @return bool Retourne vrai si la transaction commence avec succès, sinon faux.
     */
    protected function beginTransaction(): bool
    {
        return $this->db->beginTransaction();
    }

    /**
     * Valide la transaction.
     *
     * @return bool Retourne vrai si la transaction est validée avec succès, sinon faux.
     */
    protected function commit(): bool
    {
        return $this->db->commit();
    }

    /**
     * Annule la transaction en cours.
     *
     * @return bool Retourne vrai si la transaction est annulée avec succès, sinon faux.
     */
    protected function rollBack(): bool
    {
        return $this->db->rollBack();
    }
}