<?php

class Evenement
{
    private int $idEvent;
    private string $libelleEvent;
    private string $descriptionEvent;
    private int $capaMaxi;

    public function __construct(int $id, string $lib, string $desc, int $max)
    {
        $this->idEvent = $id;
        $this->libelleEvent = $lib;
        $this->descriptionEvent = $desc;
        $this->capaMaxi = $max;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLibEvent(): string
    {
        return $this->libelleEvent;
    }

    public function getDescEvent(): string
    {
        return $this->descriptionEvent;
    }

    public function getCapaMaxi(): int
    {
        return $this->capaMaxi;
    }
}

