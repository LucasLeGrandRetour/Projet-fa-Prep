<?php
class Tarif 
{
    private int $idTarif;
    private string $libelleTarif;
    private float $prix;


    public function __construct(int $idTarif, string $libelleTarif, float $prix) 
    {
        $this->idTarif = $idTarif;
        $this->libelleTarif = $libelleTarif;
        $this->prix = $prix;
    }


    public function getIdTarif(): int 
    { 
        return $this->idTarif; 
    }

    public function getLibelleTarif(): string 
    { 
        return $this->libelleTarif; 
    }

    public function getPrix(): float 
    { 
        return $this->prix; 
    }
}