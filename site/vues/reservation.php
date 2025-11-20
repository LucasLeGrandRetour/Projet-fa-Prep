<?php
// Les variables $details et $placesRestantes sont passées par le contrôleur
// Le code PHP pour la vue
?>

<div class="container-fluid reservation-page-wrapper">
</div>
    <div class="card reservation-card shadow-lg border-0 p-4">
        <div class="card-body p-0 bg-transparent">
            <div class="reservation-inner p-4 rounded-4 bg-light">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-7">
                        <div class="rounded-3 overflow-hidden bg-white p-3">
                            <img src="images/musee.jpg" class="img-fluid event-image-top rounded-3" alt="Image Événement" style="width:100%;height:340px;object-fit:cover;">
                        </div>
                        <div class="mt-3 d-flex gap-3 align-items-center">
                            <span class="text-warning small">De <?= htmlspecialchars($details['debut'] ?? '') ?> à <?= htmlspecialchars($details['fin'] ?? '') ?></span>
                            <span class="text-warning small"><?= htmlspecialchars($details['duree'] ?? '45') ?> min</span>
                        </div>
                        <h3 class="mt-4 fw-bold" style="color:#222;">A propos</h3>
                        <p class="text-dark description-text" style="line-height:1.6;">
                            <?= nl2br(htmlspecialchars($details['descriptionEvent'] ?? '')) ?>
                        </p>
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <button class="btn btn-annuler-custom text-white fw-bold">Annuler</button>
                            <button class="btn btn-reserver-custom text-white fw-bold">Réserver</button>
                        </div>
                    </div>

                    <aside class="col-lg-5">
                        <div class="reservation-side p-3 rounded-3 bg-transparent">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="icon-person me-2">&#128100;</span>
                                        <div>
                                            <small class="d-block">Nombre de</small>
                                            <small class="d-block">reservation restante</small>
                                        </div>
                                    </div>
                                    <div class="reservation-count-box"><?= $placesRestantes ?? 0 ?></div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="icon-euro me-2">€</span>
                                    <small class="fw-bold">Tarif</small>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted">Tarif enfant</small>
                                    <div class="tarif-box"><?= number_format($details['prix_enfant'] ?? 0, 0, ',', ' ') ?> €</div>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted">Tarif Adulte</small>
                                    <div class="tarif-box"><?= number_format($details['prix_adulte'] ?? 0, 0, ',', ' ') ?> €</div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>