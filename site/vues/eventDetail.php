<div class="details-container">
    <!-- Section gauche : image et description -->
    <div class="details-left">
        <img src="../images/musee.jpg" class="details-img" alt="Image de l'événement">
        <link rel="stylesheet" href="../styles/styleEventDetail.css">

        <div class="details-info">
            <h2 class="title"><?= htmlspecialchars($event->getLibEvent()) ?></h2>
            <span class="duration">45 min</span>
        </div>

        <h2 class="title">A propos</h2>
        <p class="description">
            <?= nl2br(htmlspecialchars($event->getDescEvent())) ?>
        </p>
    </div>

    <!-- Section droite : réservation -->
    <div class="details-right">
        <div class="bloc">
            <div class="bloc-title">Nombre de places restantes</div>
            <div class="bloc-value" style="text-align: left;">
                <?= "À modifier selon l'horaire" ?>
            </div>
        </div>

        <!-- Formulaire de réservation -->
        <form method="POST" action="index.php?action=reservation">
            <input type="hidden" name="idEvenement" value="<?= $event->getId() ?>">

            <!-- Section des tarifs -->
            <div class="bloc">
                <div class="bloc-title">Tarif(s)</div>
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                    <?php foreach ($tarifs as $tarif): ?>
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
                                       style="width: 60px; padding: 5px; border: 1px solid #ccc; border-radius: 4px; outline: none;">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <!-- Section de la date et heure de réservation -->
            <div class="bloc">
                <div class="bloc-title">Date et Heure de réservation</div>

                <label for="dateVisite" class="sub" style="margin-top: 10px; display: block; font-weight: 700; color: #4a3334;">Date de la visite</label>
                <input type="date" 
                       name="dateVisite" 
                       id="dateVisite"
                       class="input-date" 
                       value=""
                       required>

                <label for="horaireSelection" class="sub" style="margin-top: 15px; display: block; font-weight: 700; color: #4a3334;">Heure de début</label>
                <select name="horaireSelection" 
                        id="horaireSelection" 
                        class="input-date" 
                        required>
                    <option value="">-- Choisir une heure --</option>
                    <!-- Les options seront mises à jour avec JavaScript -->
                </select>
            </div>

            <!-- Boutons d'annulation et de soumission -->
            <div class="btn-zone">
                <button type="button" class="cancel-btn" onclick="history.back()">Annuler</button>
                <button type="submit" class="reserve-btn">Réserver</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Lorsque la date est changée, on récupère les horaires correspondants
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
    });
</script>
