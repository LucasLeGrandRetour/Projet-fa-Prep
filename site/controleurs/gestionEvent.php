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
            $id = $_GET['id'];
            $event = $connexionBD->getUnEvenement($id);
            include_once 'vues/reservation.php';
        } else {
            include_once 'vues/accueil.html';
        }
        break;
}