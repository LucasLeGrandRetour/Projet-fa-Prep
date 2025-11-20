<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "modeles/BaseEvenementDAO.php";

if (isset($_GET['action']))
    $action = filter_var($_GET['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
else
    $action = "afficherTous";


switch ($action) {
    case 'afficherTous' :
        $connexionBD = new BaseEvenementDAO();
        $lesEvents = $connexionBD->getLesEvenements();
        include_once 'vues/listeEvents.php';
        break;

    case 'afficherUn' : 
        $connexionBD = new BaseEvenementDAO();
        if (isset($_GET['id'])){
            $id = intval($_GET['id']);
            $event = $connexionBD->getUnEvenement($id);
            if ($event !== null) {
                // Préparer le tableau $details attendu par la vue reservation.php
                $placesReservees = $connexionBD->setReservation($id);
                $placesRestantes = max(0, $event->getCapaMaxi() - $placesReservees);

                $details = [
                    'idEvent' => $event->getId(),
                    'libelleEvent' => $event->getLibEvent(),
                    'descriptionEvent' => $event->getDescEvent(),
                    // Valeurs par défaut si non présentes en base (modifiables)
                    'prix_enfant' => 5,
                    'prix_adulte' => 3421,
                    'duree' => 45,
                    'debut' => '09:00',
                    'fin' => '09:45'
                ];

                include_once 'vues/reservation.php';
            } else {
                include_once 'vues/accueil.html';
            }
        } else {
            include_once 'vues/accueil.html';
        }
        break;
}