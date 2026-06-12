<?php
require_once("../services/LivreService.php");

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
        $message = count($resultats) > 0 ? count($resultats) . " résultat(s) trouvé(s)." : "Aucun résultat trouvé pour ces critères.";
    } else {
        $message = "Veuillez renseigner au moins un critère de recherche.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche avancée</title>
    <?php include("../includes/header.php"); ?>
</head>
<body>
    <header>
        <h1>Recherche avancée</h1>
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
                <label for="editeur">Éditeur</label>
                <input type="text" id="editeur" name="editeur" value="<?php echo htmlspecialchars($criteres['editeur']); ?>">
            </div>
            <div class="form-group">
                <label for="annee">Année de publication</label>
                <input type="number" id="annee" name="annee" min="1000" max="2100" value="<?php echo htmlspecialchars($criteres['annee']); ?>">
            </div>
            <div class="form-group">
                <label for="categorie">Catégorie</label>
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
            <button type="submit" class="btn-submit">Recherche avancée</button>
        </form>

        <p class="result-message"><?php echo htmlspecialchars($message); ?></p>

        <?php if (!empty($resultats)): ?>
            <div class="result-grid">
                <?php foreach ($resultats as $livre): ?>
                    <article class="result-card">
                        <h3><?php echo htmlspecialchars($livre['titre']); ?></h3>
                        <p><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur']); ?></p>
                        <p><strong>ISBN :</strong> <?php echo htmlspecialchars($livre['ISBN']); ?></p>
                        <p><strong>Éditeur :</strong> <?php echo htmlspecialchars($livre['editeur']); ?></p>
                        <p><strong>Année :</strong> <?php echo htmlspecialchars($livre['annee_publication']); ?></p>
                        <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($livre['categorie']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
    <?php include("../includes/footer.php"); ?>
</body>
</html>