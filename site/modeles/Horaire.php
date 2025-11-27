<?php

/**
 * Classe représentant un horaire associé à un événement.
 */
class Horaire 
{
    /**
     * @var int Identifiant de la ligne Concerner.
     */
    private int $idHoraire;

    /**
     * @var int Identifiant de la ligne Concerner.
     */
    private int $idConcerner;

    /**
     * @var string Date de l'horaire (format YYYY-MM-DD).
     */
    private string $date;

    /**
     * @var string Heure de début (format HH:MM:SS).
     */
    private string $heureDeb;

    /**
     * @var string Heure de fin (format HH:MM:SS).
     */
    private string $heureFin;

    /**
     * Constructeur de l'horaire.
     *
     * @param int    $idConcerner Identifiant de la ligne Concerner.
     * @param int    $idConcerner Identifiant de la ligne Concerner.
     * @param string $date        Date de l'horaire.
     * @param string $heureDeb    Heure de début.
     * @param string $heureFin    Heure de fin.
     */
    public function __construct(int $idHoraire, int $idConcerner, string $date, string $heureDeb, string $heureFin) 
    {
        $this->idHoraire = $idHoraire;
        $this->idConcerner = $idConcerner;
        $this->date = $date;
        $this->heureDeb = $heureDeb;
        $this->heureFin = $heureFin;
    }

    /**
     * Récupère l'identifiant de la ligne Concerner.
     *
     * @return int
     */
    public function getIdHoraire(): int 
    { 
        return $this->idHoraire; 

    }
    /**
     * Récupère l'identifiant de la ligne Concerner.
     *
     * @return int
     */
    public function getIdConcerner(): int 
    { 
        return $this->idConcerner; 
    }

    /**
     * Récupère la date de l'horaire.
     *
     * @return string
     */
    public function getDate(): string 
    { 
        return $this->date; 
    }

    /**
     * Récupère l'heure de début.
     *
     * @return string
     */
    public function getHeureDeb(): string 
    { 
        return $this->heureDeb; 
    }

    /**
     * Récupère l'heure de fin.
     *
     * @return string
     */
    public function getHeureFin(): string
    { 
        return $this->heureFin; 
    }
}
