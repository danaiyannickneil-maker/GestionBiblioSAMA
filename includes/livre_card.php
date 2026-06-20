<?php
$image = trim((string) ($livre['image_couverture'] ?? ''));
$imageSrc = '';
if ($image !== '' && $image !== 'default_cover.jpg') {
    $imageSrc = preg_match('/^https?:\/\//', $image) ? $image : (str_starts_with($image, '../') ? $image : '../uploads/' . basename($image));
}
$actionPage = $actionPage ?? basename($_SERVER['PHP_SELF']);
$category = trim((string) ($livre['categorie'] ?? ''));
?>
<article class="book-card">
    <?php if ($imageSrc): ?>
        <img class="book-cover" src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Couverture de <?php echo htmlspecialchars($livre['titre'] ?? 'livre'); ?>">
    <?php else: ?>
        <div class="book-cover book-cover-placeholder d-flex flex-column gap-2 text-center p-3">
            <i class="fa-solid fa-book fa-3x mb-1 text-gold"></i>
            <span class="small font-weight-bold opacity-75">SAMA BIBLIO</span>
        </div>
    <?php endif; ?>

    <div class="book-card-body">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h3 class="mb-0"><?php echo htmlspecialchars($livre['titre'] ?? ''); ?></h3>
        </div>
        
        <?php if ($category !== ''): ?>
            <div class="mb-3">
                <span class="badge text-success-green bg-light-mint px-2.5 py-1 rounded" style="background-color: var(--green-light); color: var(--green-dark); font-weight: 600; font-size: 0.78rem;">
                    <i class="fa-solid fa-tags me-1"></i> <?php echo htmlspecialchars($category); ?>
                </span>
            </div>
        <?php endif; ?>

        <p class="mb-1"><strong><i class="fa-solid fa-user me-1.5 opacity-75"></i> Auteur :</strong> <?php echo htmlspecialchars($livre['auteur'] ?? ''); ?></p>
        <p class="mb-1"><strong><i class="fa-solid fa-barcode me-1.5 opacity-75"></i> ISBN :</strong> <?php echo htmlspecialchars($livre['isbn'] ?? ''); ?></p>
        
        <div class="row g-0 my-2 pt-2 border-top border-light-subtle">
            <div class="col-6">
                <p class="mb-0 small"><strong>Editeur :</strong> <?php echo htmlspecialchars($livre['editeur'] ?? 'N/A'); ?></p>
            </div>
            <div class="col-6 text-end">
                <p class="mb-0 small"><strong>Année :</strong> <?php echo htmlspecialchars($livre['annee_publication'] ?? 'N/A'); ?></p>
            </div>
            <div class="col-6 mt-1">
                <p class="mb-0 small"><strong>Langue :</strong> <?php echo htmlspecialchars($livre['langue'] ?? 'fr'); ?></p>
            </div>
            <div class="col-6 text-end mt-1">
                <p class="mb-0 small"><strong>Pages :</strong> <?php echo htmlspecialchars($livre['nombre_pages'] ?? 'N/A'); ?></p>
            </div>
        </div>

        <?php if (!empty($livre['description'])): ?>
            <p class="book-description"><?php echo htmlspecialchars($livre['description']); ?></p>
        <?php endif; ?>
    </div>

    <form method="post" action="<?php echo htmlspecialchars($actionPage); ?>" class="book-actions">
        <input type="hidden" name="document_id" value="<?php echo htmlspecialchars($livre['id'] ?? ''); ?>">
        <button type="submit" name="action_livre" value="emprunter" class="btn-submit">
            <i class="fa-solid fa-book-reader me-1"></i> Emprunter
        </button>
        <button type="submit" name="action_livre" value="favori" class="btn-action-secondary">
            <i class="fa-solid fa-heart me-1 text-danger"></i> Favori
        </button>
    </form>
</article>
