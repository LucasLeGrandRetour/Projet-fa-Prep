<?php
class Horaire 
{
    private int $idConcerner;
    private string $date;
    private string $heureDeb;
    private string $heureFin;


    public function __construct(int $idConcerner, string $date, string $heureDeb, string $heureFin) 
    {
        $this->idConcerner = $idConcerner;
        $this->date = $date;
        $this->heureDeb = $heureDeb;
        $this->heureFin = $heureFin;
    }


    public function getIdConcerner(): int 
    { 
        return $this->idConcerner; 
    }

    public function getDate(): string 
    { 
        return $this->date; 
    }

    public function getHeureDeb(): string 
    { 
        return $this->heureDeb; 
    }

    public function getHeureFin(): string
    { 
        return $this->heureFin; 
    }
}