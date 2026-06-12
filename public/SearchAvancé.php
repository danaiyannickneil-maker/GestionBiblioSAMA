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
            $message = count($resultats) > 0 ? count($resultats) . " resultat(s) trouve(s)." : "Aucun resultat trouve pour ces criteres.";
        }
    } elseif (empty($_POST["action_livre"])) {
        $message = "Veuillez renseigner au moins un critere de recherche.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche avancée</title>
    <?php include(__DIR__ . "/../includes/header.php"); ?>
</head>
<body>
    <header>
        <h1>Recherche avancee</h1>
    </header>
    <section>
        <button type="button" class="btn-nav secondary" onclick="history.back()">Retour</button>
        <button type="button" class="btn-nav" onclick="window.location.href='Biblio.php'">Bibliotheque</button>
    </section>

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
        <?php if (!empty($message) && empty($_SESSION["user_id"]) && !empty($_POST["action_livre"])): ?>
            <div class="auth-actions">
                <button class="btn-nav" onclick="window.location.href='login.php'">Se connecter</button>
                <button class="btn-nav secondary" onclick="window.location.href='register.php'">S'inscrire</button>
            </div>
        <?php endif; ?>

        <?php if (!empty($resultats)): ?>
            <div class="result-grid">
                <?php foreach ($resultats as $livre): ?>
                    <?php include(__DIR__ . "/../includes/livre_card.php"); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
    <?php include(__DIR__ . "/../includes/footer.php"); ?>
</body>
</html>
