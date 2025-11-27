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
            $tarifs = $connexionBD->getLesTarifs();
            include_once 'vues/eventDetail.php';
        } else {
            include_once 'vues/accueil.html';
        }
        break;
    case 'reservation':
        // Gère la réservation envoyée en POST
        $connexionBD = new BaseEvenementDAO();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idEvenement = isset($_POST['idEvenement']) ? filter_var($_POST['idEvenement'], FILTER_VALIDATE_INT) : null;
            $idConcerner = isset($_POST['horaireSelection']) ? filter_var($_POST['horaireSelection'], FILTER_VALIDATE_INT) : 0;
            $panier = isset($_POST['panier']) ? $_POST['panier'] : [];

            $createdIds = [];
            if ($idConcerner && $idEvenement) {
                foreach ($panier as $idTarif => $nbPlace) {
                    $idTarif = filter_var($idTarif, FILTER_VALIDATE_INT);
                    $nbPlace = filter_var($nbPlace, FILTER_VALIDATE_INT);
                    if ($idTarif && $nbPlace && $nbPlace > 0) {
                        // Appel du DAO pour enregistrer la réservation (gère la transaction)
                        $newId = $connexionBD->setReservation($idConcerner, $idTarif, $nbPlace);
                        if ($newId && is_int($newId) && $newId > 0) {
                            $createdIds[] = $newId;
                        }
                    }
                }
            }

            // Si on a un id de réservation créé, rediriger vers la page détail de la réservation
            if (!empty($createdIds)) {
                $lastId = end($createdIds);
                header("Location: index.php?controleur=Event&action=voirReservation&id={$lastId}");
            } else {
                // Sinon, redirection vers la page de détail avec un flag success
                header("Location: index.php?controleur=Event&action=afficherUn&id={$idEvenement}&success=1");
            }
            exit;
        } else {
            // Accès non autorisé en GET: retour à la liste
            header('Location: index.php?controleur=Event&action=afficherTous');
            exit;
        }
        break;


        
}