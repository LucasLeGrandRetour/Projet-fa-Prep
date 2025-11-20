<?php
// Attendu : $lesEvents (tableau d'objets Evenement) fourni par le contrôleur
$eventsToShow = [];
if (isset($lesEvents) && is_array($lesEvents)) {
    // Ne montrer que les 6 premiers événements
    $eventsToShow = array_slice($lesEvents, 0, 6);
}
?>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Colonne gauche : filtres -->
        <aside class="col-md-3 sidebar-filters p-4">
            <h5 class="mb-3">Votre budget</h5>
            <div class="d-flex gap-2 mb-3">
                <input type="number" class="form-control" placeholder="min">
                <input type="number" class="form-control" placeholder="max">
            </div>

            <h5 class="mb-3 mt-4">Catégorie</h5>
            <select class="form-select mb-3">
                <option value="">Toutes</option>
                <?php for ($i = 1; $i <= 8; $i++): ?>
                    <option value="<?= $i ?>">Catégorie <?= $i ?></option>
                <?php endfor; ?>
            </select>

            <small class="text-muted">Choisissez une catégorie</small>
        </aside>

        <!-- Zone principale : recherche + liste d'événements -->
        <main class="col-md-9 events-main-area p-4">
            <div class="top-search-strip rounded-3 mb-4 p-3 d-flex align-items-center justify-content-between">
                <div class="ps-2"><strong class="text-white">Mot-Clés</strong></div>
                <div class="input-group search-bar-top-custom" style="max-width:520px;">
                    <input type="text" class="form-control rounded-pill" placeholder="Rechercher...">
                    <button class="btn btn-search-icon rounded-pill" type="button">🔍</button>
                </div>
            </div>

            <div class="row g-4">
                <?php if (empty($eventsToShow)): ?>
                    <div class="col-12">
                        <div class="alert alert-secondary">Aucun événement trouvé.</div>
                    </div>
                <?php else: ?>
                    <?php foreach ($eventsToShow as $event): ?>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="event-card-custom h-100 shadow-sm p-0">
                                <div class="card-image-wrapper" style="overflow:hidden;">
                                    <img src="images/musee.jpg" alt="<?= htmlspecialchars($event->getLibEvent()) ?>" style="width:100%;height:210px;object-fit:cover;display:block;">
                                </div>
                                <div class="event-card-body">
                                    <div class="event-title"><?= htmlspecialchars($event->getLibEvent()) ?></div>
                                    <a href="index.php?controleur=Event&action=afficherUn&id=<?= $event->getId() ?>" class="btn btn-detail-custom">Détails</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </main>
    </div>
</div>
