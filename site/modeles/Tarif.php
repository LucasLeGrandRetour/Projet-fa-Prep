<?php

/**
 * Classe représentant un tarif pour un événement.
 */
class Tarif 
{
    /**
     * @var int Identifiant unique du tarif.
     */
    private int $idTarif;

    /**
     * @var string Libellé du tarif.
     */
    private string $libelleTarif;

    /**
     * @var float Prix du tarif.
     */
    private float $prix;

    /**
     * Constructeur du tarif.
     *
     * @param int    $idTarif      Identifiant du tarif.
     * @param string $libelleTarif Libellé du tarif.
     * @param float  $prix         Prix du tarif.
     */
    public function __construct(int $idTarif, string $libelleTarif, float $prix) 
    {
        $this->idTarif = $idTarif;
        $this->libelleTarif = $libelleTarif;
        $this->prix = $prix;
    }

    /**
     * Récupère l'identifiant du tarif.
     *
     * @return int
     */
    public function getIdTarif(): int 
    { 
        return $this->idTarif; 
    }

    /**
     * Récupère le libellé du tarif.
     *
     * @return string
     */
    public function getLibelleTarif(): string 
    { 
        return $this->libelleTarif; 
    }

    /**
     * Récupère le prix du tarif.
     *
     * @return float
     */
    public function getPrix(): float 
    { 
        return $this->prix; 
    }
}
