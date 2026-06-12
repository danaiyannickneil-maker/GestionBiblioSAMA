<?php
require_once(__DIR__ . "/../services/LivreService.php");

$service = new LivreService();
$resultats = [];
$message = "Remplissez au moins un champ puis lancez la recherche.";
$criteres = [
    'titre' => '',
    'auteur' => '',
    'isbn' => '',
    'editeur' => '',
    'annee' => '',
    'categorie' => '',
    'description' => '',
    'nb_pages' => '',
    'langue' => ''
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($criteres as $key => $value) {
        $criteres[$key] = trim($_POST[$key] ?? '');
    }

    $filtreActif = array_filter($criteres, function ($value) {
        return $value !== '';
    });

    if (!empty($filtreActif)) {
        $resultats = $service->rechercherLivresAvance($criteres);
        $message = count($resultats) > 0 ? count($resultats) . " resultat(s) trouve(s)." : "Aucun resultat trouve pour ces criteres.";
    } else {
        $message = "Veuillez renseigner au moins un critere de recherche.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche avancee</title>
    <?php include(__DIR__ . "/../includes/header.php"); ?>
</head>
<body>
    <header>
        <h1>Recherche avancee</h1>
    </header>
    <section class="form-container">
        <form method="post" action="SearchAvancé.php" class="form-add-livre">
            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($criteres['titre']); ?>">
            </div>
            <div class="form-group">
                <label for="auteur">Auteur</label>
                <input type="text" id="auteur" name="auteur" value="<?php echo htmlspecialchars($criteres['auteur']); ?>">
            </div>
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($criteres['isbn']); ?>">
            </div>
            <div class="form-group">
                <label for="editeur">Editeur</label>
                <input type="text" id="editeur" name="editeur" value="<?php echo htmlspecialchars($criteres['editeur']); ?>">
            </div>
            <div class="form-group">
                <label for="annee">Annee de publication</label>
                <input type="number" id="annee" name="annee" min="1000" max="2100" value="<?php echo htmlspecialchars($criteres['annee']); ?>">
            </div>
            <div class="form-group">
                <label for="categorie">Categorie</label>
                <input type="text" id="categorie" name="categorie" value="<?php echo htmlspecialchars($criteres['categorie']); ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"><?php echo htmlspecialchars($criteres['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="nb_pages">Nombre de pages</label>
                <input type="number" id="nb_pages" name="nb_pages" min="1" value="<?php echo htmlspecialchars($criteres['nb_pages']); ?>">
            </div>
            <div class="form-group">
                <label for="langue">Langue</label>
                <input type="text" id="langue" name="langue" value="<?php echo htmlspecialchars($criteres['langue']); ?>">
            </div>
            <button type="submit" class="btn-submit">Recherche avancee</button>
        </form>

        <p class="result-message"><?php echo htmlspecialchars($message); ?></p>

        <?php if (!empty($resultats)): ?>
            <div class="result-grid">
                <?php foreach ($resultats as $livre): ?>
                    <article class="result-card">
                        <h3><?php echo htmlspecialchars($livre['titre'] ?? ''); ?></h3>
                        <p><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur'] ?? ''); ?></p>
                        <p><strong>ISBN :</strong> <?php echo htmlspecialchars($livre['isbn'] ?? ''); ?></p>
                        <p><strong>Editeur :</strong> <?php echo htmlspecialchars($livre['editeur'] ?? ''); ?></p>
                        <p><strong>Annee :</strong> <?php echo htmlspecialchars($livre['annee_publication'] ?? ''); ?></p>
                        <p><strong>Categorie :</strong> <?php echo htmlspecialchars($livre['categorie'] ?? ''); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
    <?php include(__DIR__ . "/../includes/footer.php"); ?>
</body>
</html>
