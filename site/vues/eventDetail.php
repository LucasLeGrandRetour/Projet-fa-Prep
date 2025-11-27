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

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // Variables nécessaires
    const eventId = <?= (int)$event->getId() ?>;
    const dateInput = document.getElementById('dateVisite');
    const horaireSelect = document.getElementById('horaireSelection');
    const placesLeftEl = document.getElementById('placesLeft');
    const form = document.querySelector('form[action^="index.php?controleur=Event&action=reservation"]');
    
    // --- UTILITIES ---
    function formatPlaces(n) {
        if (n === null || n === undefined || isNaN(n)) return '-';
        if (n <= 0) return 'Complet';
        return n + ' place' + (n > 1 ? 's' : '');
    }

    function formatMoney(v) {
        // Formatte l'argent en français (ex: 1 200,50 €)
        return Number(v).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
    }

    // --- PLACES RESTANTES LOGIC ---
    function updatePlacesLeftFromSelected() {
        if (!horaireSelect) return;
        const opt = horaireSelect.selectedOptions[0];
        
        if (!opt || !placesLeftEl) {
             if(placesLeftEl) placesLeftEl.textContent = '-';
             return;
        }
        
        const places = opt.dataset.places !== undefined ? parseInt(opt.dataset.places, 10) : null;
        placesLeftEl.textContent = formatPlaces(places);
    }

    // --- HORAIRES DYNAMIQUES (AJAX) ---
    async function loadHorairesForDate(dateStr) {
        horaireSelect.innerHTML = '<option value="">-- Chargement... --</option>';
        placesLeftEl.textContent = '...';

        if (!dateStr || !eventId) return;

        try {
            // NOTE: Ceci nécessite que l'action 'getHorairesAjax' soit implémentée dans gestionEvent.php
            const resp = await fetch(`index.php?controleur=Event&action=getHorairesAjax&id=${eventId}&date=${encodeURIComponent(dateStr)}`);
            if (!resp.ok) throw new Error('Erreur réseau');
            const horaires = await resp.json();
            
            horaireSelect.innerHTML = '';
            
            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = '-- Choisir une heure --';
            horaireSelect.appendChild(placeholder);

            if (!horaires || horaires.length === 0) {
                placeholder.textContent = 'Aucun horaire disponible';
                placeholder.disabled = true;
                placesLeftEl.textContent = '-';
                return;
            }
            
            horaires.forEach(h => {
                const opt = document.createElement('option');
                // h.idConcerner et h.placesDisponibles sont envoyés par le contrôleur
                opt.value = h.idConcerner;
                opt.dataset.places = h.placesDisponibles;
                opt.textContent = `${h.heureDeb} - ${h.heureFin}`;
                if (h.placesDisponibles <= 0) {
                    opt.disabled = true;
                    opt.textContent += ' (complet)';
                }
                horaireSelect.appendChild(opt);
            });

            if (horaireSelect.options.length === 2 && !horaireSelect.options[1].disabled) {
                horaireSelect.selectedIndex = 1;
            }
            
            updatePlacesLeftFromSelected(); 
            
        } catch (err) {
            console.error('Erreur chargement horaires:', err);
            horaireSelect.innerHTML = '<option value="" disabled>-- Erreur de chargement --</option>';
            placesLeftEl.textContent = 'Erreur';
        }
    }

    // --- TOTAL CALCULATION LOGIC ---
    const totalPriceEl = document.getElementById('totalPrice');
    const totalInput = document.getElementById('totalTarif');
    const panierInputs = document.querySelectorAll('input.panier-input');

    function updateTotal() {
        let total = 0.0;
        panierInputs.forEach(function (inp) {
            const q = parseInt(inp.value, 10) || 0;
            // Récupère le prix stocké dans l'attribut data-price
            const price = parseFloat(inp.dataset.price || '0') || 0;
            total += q * price;
        });
        totalInput.value = total.toFixed(2);
        if (totalPriceEl) totalPriceEl.textContent = formatMoney(total);
    }

    // --- INITIALISATION ET ÉCOUTEURS D'ÉVÉNEMENTS ---
    
    // 1. Gestion des horaires dynamiques au changement de date
    if (dateInput) {
        const initialDate = dateInput.value || dateInput.min || new Date().toISOString().slice(0, 10);
        dateInput.value = initialDate;
        
        // Si la liste est vide (pas d'horaires chargés par PHP), on charge via JS
        if (horaireSelect.options.length <= 1 || horaireSelect.options[1].disabled) {
            loadHorairesForDate(initialDate);
        } else {
            updatePlacesLeftFromSelected();
        }
        
        dateInput.addEventListener('change', function (e) {
            const d = e.target.value;
            loadHorairesForDate(d);
        });
    }

    // 2. Mise à jour des places restantes au changement d'horaire
    if (horaireSelect) {
        horaireSelect.addEventListener('change', updatePlacesLeftFromSelected);
    }

    // 3. Gestion du total du panier
    panierInputs.forEach(function (inp) {
        inp.addEventListener('change', updateTotal);
        inp.addEventListener('input', updateTotal);
    });
    updateTotal(); // Calcul initial au chargement de la page

    // 4. Form Submission (s'assurer du total)
    if (form) {
        form.addEventListener('submit', function () {
            updateTotal();
        }, true);
    }
});
</script>