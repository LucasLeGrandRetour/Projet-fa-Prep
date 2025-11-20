<?php

class Evenement
{
    private int $idEvent;
    private string $libelleEvent;
    private string $descriptionEvent;

    public function __construct(int $id, string $lib, string $desc)
    {
        $this->idEvent = $id;
        $this->libelleEvent = $lib;
        $this->descriptionEvent = $desc;
    }

    public function getId(): int
    {
        return $this->idEvent;
    }

    public function getLibEvent(): string
    {
        return $this->libelleEvent;
    }

    public function getDescEvent(): string
    {
        return $this->descriptionEvent;
    }
}

