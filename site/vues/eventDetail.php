<div class="details-container">
    <div class="details-left">
        <img src="../images/musee.jpg" class="details-img" alt="Image de l'événement">
        <link rel="stylesheet" href="../styles/styleEventDetail.css">
        <link rel="stylesheet" href="../styles/styles.css"> 

        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; margin-bottom: 20px; border-radius: 8px; font-weight: 700; text-align: center;">
                ✅ Votre événement est bien réservé !
            </div>
        <?php endif; ?>
        
        <div class="details-info">
            <h2 class="title"><?= htmlspecialchars($event->getLibEvent()) ?></h2>
            <span class="duration">45 min</span>
        </div>

        <h2 class="title">A propos</h2>
        <p class="description">
            <?= nl2br(htmlspecialchars($event->getDescEvent())) ?>
        </p>
    </div>

    <div class="details-right">
        
        <div class="bloc">
            <div class="bloc-title">Nombre de places restante</div>
            <?php
                // Logique du commit distant (0f990d7) pour calculer les places restantes initiales
                $initialPlaces = null;
                // Instanciez le DAO pour calculer le nombre de places pour le premier horaire
                if (!isset($connexionBD) && class_exists('BaseEvenementDAO')) {
                    $connexionBD = new BaseEvenementDAO();
                } else {
                    $connexionBD = null;
                }
                
                if ($connexionBD && isset($horaires) && is_array($horaires) && count($horaires) > 0 && method_exists($connexionBD, 'getPlacesRestantes')) {
                    // On prend le premier horaire chargé par le contrôleur
                    $initialPlaces = $connexionBD->getPlacesRestantes($horaires[0]->getIdConcerner());
                } else {
                    $initialPlaces = "N/A";
                }
            ?>
            <div id="placesLeft" class="bloc-value" style="text-align: left;"><?= $initialPlaces !== "N/A" ? ($initialPlaces <= 0 ? 'Complet' : ($initialPlaces . ' place' . ($initialPlaces > 1 ? 's' : ''))) : '-' ?></div>
        </div>

        <form method="POST" action="index.php?controleur=Event&action=reservation">
            
            <input type="hidden" name="idEvenement" value="<?= $event->getId() ?>">

            <div class="bloc">
                <div class="bloc-title">Tarif(s)</div>
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                    <?php foreach ($tarifs as $tarif) { ?>
                        <tr>
                            <td class="sub" style="padding: 8px 0;">
                                <?= htmlspecialchars($tarif->getLibelleTarif()) ?>
                            </td>
                            <td class="bloc-value" style="padding: 8px 0;">
                                <?= number_format($tarif->getPrix(), 2, ',', ' ') ?> €
                            </td>
                            <td style="padding: 8px 0 8px 15px; text-align: right;">
                                <input type="number" 
                                       name="panier[<?= $tarif->getIdTarif() ?>]" 
                                       min="0" 
                                       value="0" 
                                       placeholder="0"
                                       data-price="<?= number_format($tarif->getPrix(), 2, '.', '') ?>"
                                       class="panier-input"
                                       style="width: 60px; padding: 5px; border: 1px solid #ccc; border-radius: 4px; outline: none;">
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <div class="bloc">
                <div class="bloc-title">Date et Heure de réservation</div>

                <label for="dateVisite" class="sub" style="margin-top: 10px; display: block; font-weight: 700; color: #4a3334;">Date de la visite</label>
                <input type="date" 
                        name="dateVisite" 
                        id="dateVisite"
                        class="input-date" 
                        value="<?= date('Y-m-d') ?>"
                        min="<?= date('Y-m-d') ?>"
                        required>

                <label for="horaireSelection" class="sub" style="margin-top: 15px; display: block; font-weight: 700; color: #4a3334;">Heure de début</label>
                <select name="horaireSelection" 
                        id="horaireSelection" 
                        class="input-date" 
                        required>
                    <option value="">-- Choisir une heure --</option>
                    <?php 
                    /* Affichage initial des horaires au chargement (avec vérif places) */
                    if (isset($horaires) && is_array($horaires)):
                        foreach ($horaires as $horaire): 
                            // Nécessite $connexionBD pour le calcul des places
                            if ($connexionBD && method_exists($connexionBD, 'getPlacesRestantes')) {
                                $hPlaces = $connexionBD->getPlacesRestantes($horaire->getIdConcerner());
                            } else {
                                $hPlaces = 99; // Default si le DAO n'est pas prêt
                            }
                            ?>
                            <option value="<?= $horaire->getIdConcerner() ?>" data-places="<?= $hPlaces ?>" <?= $hPlaces <= 0 ? 'disabled' : '' ?>>
                                <?= $horaire->getHeureDeb() ?> - <?= $horaire->getHeureFin() ?><?= $hPlaces <= 0 ? ' (complet)' : '' ?>
                            </option>
                        <?php endforeach;
                    else: ?>
                        <option value="" disabled>Veuillez choisir une date</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="btn-zone">
                <button type="button" class="cancel-btn" onclick="history.back()">Annuler</button>
                <button type="submit" class="reserve-btn">Réserver</button>
            </div>
            
            <div class="bloc" style="margin-top: 10px;">
                <div class="bloc-title">Total</div>
                <div id="totalPrice" class="bloc-value" style="text-align: left;">0,00 €</div>
                <input type="hidden" name="totalTarif" id="totalTarif" value="0">
            </div>
            
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Lors de la sélection de la date, on charge les horaires correspondants
    $('#dateVisite').on('change', function() {
        var dateChoisie = $(this).val();  // Récupère la date choisie
        var idEvenement = $('input[name="idEvenement"]').val();  // Récupère l'ID de l'événement

        // Envoie la requête AJAX pour récupérer les horaires correspondant à la date
        $.ajax({
            url: '../controleurs/get_horaires.php',  // Fichier PHP pour récupérer les horaires
            type: 'POST',
            data: { date: dateChoisie, idEvenement: idEvenement },  // Envoie la date et l'ID de l'événement
            success: function(response) {
                console.log("Réponse du serveur : " + response);  // Affiche la réponse dans la console
                $('#horaireSelection').html(response);  // Met à jour la liste des horaires avec la réponse
            }
        });
    });

    // Lorsque l'utilisateur change d'horaire, mettre à jour les places restantes
    $('#horaireSelection').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var placesRestantes = selectedOption.data('places');  // Récupère les places restantes

        // Affiche les places restantes
        if (placesRestantes !== undefined) {
            $('#placesLeft').text(placesRestantes <= 0 ? 'Complet' : placesRestantes + ' place' + (placesRestantes > 1 ? 's' : ''));
        }
    });

    // Calcul du total du panier
    $('input.panier-input').on('input change', function() {
        var total = 0;
        $('input.panier-input').each(function() {
            var quantity = $(this).val() || 0;
            var price = $(this).data('price');
            total += (quantity * price);
        });

        $('#totalPrice').text(total.toFixed(2) + ' €');
        $('#totalTarif').val(total.toFixed(2));
    });

});
</script>
