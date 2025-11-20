<?php

/**
 * Classe représentant un événement.
 */
class Evenement
{
    /**
     * @var int Identifiant unique de l'événement.
     */
    private int $idEvent;

    /**
     * @var string Libellé de l'événement.
     */
    private string $libelleEvent;

    /**
     * @var string Description de l'événement.
     */
    private string $descriptionEvent;

    /**
     * Constructeur de l'événement.
     *
     * @param int    $id   Identifiant de l'événement.
     * @param string $lib  Libellé de l'événement.
     * @param string $desc Description de l'événement.
     */
    public function __construct(int $id, string $lib, string $desc)
    {
        $this->idEvent = $id;
        $this->libelleEvent = $lib;
        $this->descriptionEvent = $desc;
    }

    /**
     * Récupère l'identifiant de l'événement.
     *
     * @return int ID de l'événement.
     */
    public function getId(): int
    {
        return $this->idEvent;
    }

    /**
     * Récupère le libellé de l'événement.
     *
     * @return string Libellé de l'événement.
     */
    public function getLibEvent(): string
    {
        return $this->libelleEvent;
    }

    /**
     * Récupère la description de l'événement.
     *
     * @return string Description de l'événement.
     */
    public function getDescEvent(): string
    {
        return $this->descriptionEvent;
    }
}
