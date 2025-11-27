<div class="details-container">
    <div class="details-left">
        <img src="../images/musee.jpg" class="details-img">
        <link rel="stylesheet" href="../styles/styleEventDetail.css">
        <link rel="stylesheet" href="../styles/styles.css">

        <div class="details-info">
            <h2 class="title"><?= $event->getLibEvent() ?></h2>
            <span class="duration">45 min</span>
        </div>

        <h2 class="title">A propos</h2>

        <p class="description">
            <?php
                // Affiche la description de l'événement
                echo $event->getDescEvent();
            ?>
        </p>
    </div>

    <div class="details-right">

        <div class="bloc">
            <div class="bloc-title">Nombre de places restante</div>
            <div class="bloc-value" style="text-align: left;"><?= "A modif selon l'horaire" ?></div>
        </div>

        <form method="POST" action="index.php?action=reservation">
            
            <input type="hidden" name="idEvenement" value="<?= $event->getId() ?>">

            <div class="bloc">
                <div class="bloc-title">Tarif(s)</div>
                
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                    <?php
                        // Boucle sur les tarifs disponibles
                        foreach ($tarifs as $tarif) {
                            ?>
                            <tr>
                                <td class="sub" style="padding: 8px 0;">
                                    <?= $tarif->getLibelleTarif() ?>
                                </td>
                                
                                <td class="bloc-value" style="padding: 8px 0;">
                                    <?= $tarif->getPrix() ?> €
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
                            <?php
                        }
                    ?>
                </table>
            </div>
            
            <div class="bloc">
                <div class="bloc-title">Date et Heure de réservation</div>
                
                <label for="dateVisite" class="sub" style="margin-top: 10px; display: block; font-weight: 700; color: #4a3334;">Date de la visite</label>
                <input type="date" 
                       name="dateVisite" 
                       id="dateVisite"
                       class="input-date" 
                       min="<?= date('Y-m-d') ?>" 
                       required>
                
                <label for="horaireSelection" class="sub" style="margin-top: 15px; display: block; font-weight: 700; color: #4a3334;">Heure de début</label>
                <select name="horaireSelection" id="horaireSelection" class="input-date" required>
                    <option value="">-- Choisir une heure --</option>
                    <?php 
                    /*
                    * NOTE: Pour que les horaires soient dynamiques, la variable $lesHoraires 
                    * doit être passée par le contrôleur (gestionEvent.php).
                    */
                    if (isset($horaires) && is_array($horaires)):
                        foreach ($lesHoraires as $horaire): ?>
                            <option value="<?= $horaire->getIdHoraire() ?>">
                                <?= $horaire->getHeureDebut() ?> - <?= $horaire->getHeureFin() ?>
                            </option>
                        <?php endforeach;
                    else: ?>
                        <option value="9h00">9:00 - 9:45 (Exemple)</option>
                        <option value="10h00">10:00 - 10:45 (Exemple)</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="btn-zone">
                <button type="button" class="cancel-btn" onclick="history.back()">Annuler</button>
                <button type="submit" class="reserve-btn">Réserver</button>
            </div>
            
        </form>
        
    </div>
</div>