<?php
include_once "../modeles/BaseEvenementDAO.php";
include_once '../configBdd.php';

// Vérification si la date et l'ID de l'événement sont envoyés via POST
if (isset($_POST['date']) && isset($_POST['idEvenement'])) {
    $dateChoisie = $_POST['date'];  // Récupère la date choisie
    $idEvenement = $_POST['idEvenement'];  // Récupère l'ID de l'événement

    // Crée une instance de la classe BaseEvenementDAO pour interagir avec la base de données
    $connexionBD = new BaseEvenementDAO();

    // Récupérer les horaires qui correspondent à la date et à l'événement
    $horaires = $connexionBD->getHorairesEvenementParDate($idEvenement, $dateChoisie);

    // Si des horaires sont trouvés, on les renvoie sous forme de <option>
    if (!empty($horaires)) {
        foreach ($horaires as $horaire) {
            // Récupération du nombre de places restantes
            $placesRestantes = $connexionBD->getPlacesRestantes($horaire->getIdConcerner());

            // Génération de l'option HTML avec les places restantes
            echo '<option value="' . $horaire->getIdConcerner() . '" data-places="' . $placesRestantes . '"';
            if ($placesRestantes <= 0) {
                echo ' disabled';
            }
            echo '>';
            echo htmlspecialchars($horaire->getHeureDeb()) . ' - ' . htmlspecialchars($horaire->getHeureFin());
            if ($placesRestantes <= 0) {
                echo ' (complet)';
            }
            echo '</option>';
        }
    } else {
        echo '<option value="">Aucun horaire disponible pour cette date</option>';
    }
}
?>
