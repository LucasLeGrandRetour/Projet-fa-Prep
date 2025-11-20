<!-- event_details.html (vue identique à ton screen, sans header/footer) -->
<div class="details-container">
    <div class="details-left">
        <img src="img/event.jpg" class="details-img">
        <link rel="stylesheet" href="../styles/styleEventDetail.css">
        <link rel="stylesheet" href="../styles/styles.css">

        <div class="details-info">
            <span class="time">De {Debut} à {Fin}</span>
            <span class="duration">45 min</span>
        </div>

        <h2 class="title">A propos</h2>

        <p class="description">
            {DESCRIPTION_DE_LA_BD}
        </p>
    </div>

    <div class="details-right">

        <div class="bloc">
            <div class="icon">👤</div>
            <div class="bloc-title">Nombre de reservation restante</div>
            <div class="bloc-value">{NB_PLACE}</div>
        </div>

        <div class="bloc">
            <div class="icon">💶</div>
            <div class="bloc-title">Tarif</div>
            <div class="sub">Tarif enfant</div>
            <div class="bloc-value">{PRIX_ENFANT} €</div>
            <div class="sub">Tarif adulte</div>
            <div class="bloc-value">{PRIX_ADULTE} €</div>
        </div>

        <div class="btn-zone">
            <button class="cancel-btn">Annuler</button>
            <button class="reserve-btn">Réserver</button>
        </div>
    </div>
</div>
