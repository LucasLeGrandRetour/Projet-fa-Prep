<div class="details-container">
    <div class="details-left">
        <img src="../images/musee.jpg" class="details-img">
        <link rel="stylesheet" href="../styles/styleEventDetail.css">
        <link rel="stylesheet" href="../styles/styles.css">

        <div class="details-info">
            <span class="time">De {Debut} à {Fin}</span>
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
            <div class="bloc-value"><?= "A modif selon l'horaire" ?></div>
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
                                
                                <td class="bloc-value" style="padding: 8px 0; text-align: center;">
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

            <div class="btn-zone">
                <button type="button" class="cancel-btn" onclick="history.back()">Annuler</button>
                <button type="submit" class="reserve-btn">Réserver</button>
            </div>
            
        </form>
        </div>
</div>