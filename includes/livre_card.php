<?php
$image = trim((string) ($livre['image_couverture'] ?? ''));
$imageSrc = '';
if ($image !== '' && $image !== 'default_cover.jpg') {
    $imageSrc = preg_match('/^https?:\/\//', $image) ? $image : (str_starts_with($image, '../') ? $image : '../uploads/' . basename($image));
}
$actionPage = $actionPage ?? basename($_SERVER['PHP_SELF']);
?>
<article class="result-card book-card">
    <?php if ($imageSrc): ?>
        <img class="book-cover" src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Couverture de <?php echo htmlspecialchars($livre['titre'] ?? 'livre'); ?>">
    <?php else: ?>
        <div class="book-cover book-cover-placeholder">Livre</div>
    <?php endif; ?>

    <div class="book-card-body">
        <h3><?php echo htmlspecialchars($livre['titre'] ?? ''); ?></h3>
        <p><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur'] ?? ''); ?></p>
        <p><strong>ISBN :</strong> <?php echo htmlspecialchars($livre['isbn'] ?? ''); ?></p>
        <p><strong>Editeur :</strong> <?php echo htmlspecialchars($livre['editeur'] ?? ''); ?></p>
        <p><strong>Annee :</strong> <?php echo htmlspecialchars($livre['annee_publication'] ?? ''); ?></p>
        <p><strong>Categorie :</strong> <?php echo htmlspecialchars($livre['categorie'] ?? ''); ?></p>
        <p><strong>Pages :</strong> <?php echo htmlspecialchars($livre['nombre_pages'] ?? ''); ?></p>
        <p><strong>Langue :</strong> <?php echo htmlspecialchars($livre['langue'] ?? ''); ?></p>
        <?php if (!empty($livre['description'])): ?>
            <p class="book-description"><?php echo htmlspecialchars($livre['description']); ?></p>
        <?php endif; ?>
    </div>

    <form method="post" action="<?php echo htmlspecialchars($actionPage); ?>" class="book-actions">
        <input type="hidden" name="document_id" value="<?php echo htmlspecialchars($livre['id'] ?? ''); ?>">
        <button type="submit" name="action_livre" value="emprunter" class="btn-submit">Emprunter</button>
        <button type="submit" name="action_livre" value="favori" class="btn-nav secondary">Favori</button>
    </form>
</article>
