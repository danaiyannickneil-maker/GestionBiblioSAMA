<?php
session_start();
require_once(__DIR__ . "/../services/LivreService.php");
require_once(__DIR__ . "/../services/EmpruntService.php");

$livreService = new LivreService();
$empruntService = new EmpruntService();
$resultats = [];
$message = "Remplissez au moins un champ puis lancez la recherche.";
$actionPage = "SearchAvancé.php";
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

    if (!empty($_POST["action_livre"]) && !empty($_POST["document_id"])) {
        if (empty($_SESSION["user_id"])) {
            $message = "Connectez-vous ou inscrivez-vous pour emprunter un livre ou l'ajouter aux favoris.";
        } elseif ($_POST["action_livre"] === "emprunter") {
            $result = $empruntService->emprunterLivre($_SESSION["user_id"], $_POST["document_id"]);
            $message = $result["message"];
        } elseif ($_POST["action_livre"] === "favori") {
            $result = $empruntService->ajouterFavori($_SESSION["user_id"], $_POST["document_id"]);
            $message = $result["message"];
        }
    }

    $filtreActif = array_filter($criteres, function ($value) {
        return $value !== '';
    });

    if (!empty($filtreActif)) {
        $resultats = $livreService->rechercherLivresAvance($criteres);
        if (empty($_POST["action_livre"])) {
            $message = count($resultats) > 0 ? count($resultats) . " résultat(s) trouvé(s)." : "Aucun résultat trouvé pour ces critères.";
        }
    } elseif (empty($_POST["action_livre"])) {
        $message = "Veuillez renseigner au moins un critère de recherche.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche avancée - BU SAMA</title>
    <?php include(__DIR__ . "/../includes/header.php"); ?>
</head>
<body>

    <?php include(__DIR__ . "/../includes/navbar.php"); ?>

    <div class="container my-4">
        
        <div class="form-container">
            <a href="Biblio.php" class="back-link">
                <i class="fa-solid fa-arrow-left me-1"></i> Retour à la bibliothèque
            </a>

            <h2 class="mb-4 text-success-green" style="color: var(--green-dark); font-family: 'Outfit'; font-weight: 700;">
                <i class="fa-solid fa-magnifying-glass me-2 text-gold"></i> Recherche avancée
            </h2>

            <form method="post" action="SearchAvancé.php" class="form-add-livre">
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" placeholder="Titre du livre..." value="<?php echo htmlspecialchars($criteres['titre']); ?>">
                </div>
                <div class="form-group">
                    <label for="auteur">Auteur</label>
                    <input type="text" id="auteur" name="auteur" placeholder="Auteur..." value="<?php echo htmlspecialchars($criteres['auteur']); ?>">
                </div>
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" placeholder="Code ISBN..." value="<?php echo htmlspecialchars($criteres['isbn']); ?>">
                </div>
                <div class="form-group">
                    <label for="editeur">Editeur</label>
                    <input type="text" id="editeur" name="editeur" placeholder="Éditeur..." value="<?php echo htmlspecialchars($criteres['editeur']); ?>">
                </div>
                <div class="form-group">
                    <label for="annee">Année de publication</label>
                    <input type="number" id="annee" name="annee" min="1000" max="2100" placeholder="YYYY" value="<?php echo htmlspecialchars($criteres['annee']); ?>">
                </div>
                <div class="form-group">
                    <label for="categorie">Catégorie</label>
                    <input type="text" id="categorie" name="categorie" placeholder="Ex: Informatique, Sciences..." value="<?php echo htmlspecialchars($criteres['categorie']); ?>">
                </div>
                <div class="form-group">
                    <label for="nb_pages">Nombre de pages</label>
                    <input type="number" id="nb_pages" name="nb_pages" min="1" placeholder="Ex: 300" value="<?php echo htmlspecialchars($criteres['nb_pages']); ?>">
                </div>
                <div class="form-group">
                    <label for="langue">Langue</label>
                    <input type="text" id="langue" name="langue" placeholder="Ex: Français, Anglais..." value="<?php echo htmlspecialchars($criteres['langue']); ?>">
                </div>
                <div class="form-group full-width">
                    <label for="description">Mots-clés de la description</label>
                    <textarea id="description" name="description" placeholder="Mots contenus dans le résumé du livre..."><?php echo htmlspecialchars($criteres['description']); ?></textarea>
                </div>
                <button type="submit" class="btn-submit"><i class="fa-solid fa-search me-1"></i> Lancer la recherche avancée</button>
            </form>
        </div>

        <!-- Section des Résultats -->
        <div class="mt-5">
            <h2 class="mb-3 text-success-green" style="color: var(--green-dark); font-family: 'Outfit'; font-weight: 700;">
                <i class="fa-solid fa-square-poll-horizontal me-2 text-gold"></i> Résultats de la recherche
            </h2>

            <?php if ($message): ?>
                <div class="alert <?php echo (str_contains($message, 'trouvé(s)')) ? 'alert-success' : 'alert-danger'; ?> shadow-sm">
                    <i class="fa-solid <?php echo (str_contains($message, 'trouvé(s)')) ? 'fa-circle-check' : 'fa-circle-info'; ?> me-2"></i>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($message) && empty($_SESSION["user_id"]) && !empty($_POST["action_livre"])): ?>
                <div class="d-flex gap-2 justify-content-center my-3">
                    <a href="login.php" class="btn btn-action-primary"><i class="fa-solid fa-sign-in-alt me-1"></i> Se connecter</a>
                    <a href="register.php" class="btn btn-action-secondary"><i class="fa-solid fa-user-plus me-1"></i> S'inscrire</a>
                </div>
            <?php endif; ?>

            <?php if (!empty($resultats)): ?>
                <div class="result-grid mt-4">
                    <?php foreach ($resultats as $livre): ?>
                        <?php include(__DIR__ . "/../includes/livre_card.php"); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <?php include(__DIR__ . "/../includes/footer.php"); ?>
</body>
</html>
