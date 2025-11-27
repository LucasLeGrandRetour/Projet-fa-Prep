<!-- events.html (sans header/footer, version PHP ready) -->
<div class="events-container">
    <div class="sidebar">
        <div class="filter-title">Votre budget</div>
        <link rel="stylesheet" href="../styles/styleEvent.css">
        <link rel="stylesheet" href="../styles/styles.css">
        <div class="budget-zone">
            <input type="number" placeholder="min" class="budget-input">
            <input type="number" placeholder="max" class="budget-input">
        </div>

        <div class="filter-title" style="margin-top:20px;">Catégorie</div>
        <select>
            <option value="">-- Choisir --</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
    </div>

    <div class="content">
        <div class="search-bar">
            <span>Mot-Clés</span>
            <input type="text" class="search-input">
            <span class="search-icon">🔍</span>
        </div>

        <div class="event-grid">
            <?php
            foreach($lesEvents as $event) {
                echo '<div class="event-card">
                        <img src="../images/musee.jpg" alt="event">
                        <div class="event-title">' . htmlspecialchars($event->getLibEvent()) . '</div>
                        <a href="index.php?controleur=Event&action=afficherUn&id=' . htmlspecialchars($event->getId()) .'" class="details-link"> Détails </a>
                      </div>';
            }
            ?>
        </div>
    </div>
</div>
