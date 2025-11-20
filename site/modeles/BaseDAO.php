<?php
class BaseDAO
{
    protected PDO $db;

    protected function __construct() {}

    protected function setConnexionBase(string $dsn, string $user, string $mdp, array $options)
    {
        try {
            $this->db = new PDO($dsn, $user, $mdp, $options);
        } catch (PDOException $erreur) {
            die('Erreur de connexion à la base de données : ' . $erreur->getMessage());
        }
    }

    protected function prepare(string $sql): PDOStatement
    {
        return $this->db->prepare($sql);
    }
}