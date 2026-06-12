<?php
require_once("../services/LivreService.php");

$service = new LivreService();
$livres = [];
$message = "Aucun résultat pour l’instant.";

if (!empty($_GET["recherche"])) {
    $motCle = trim($_GET["recherche"]);
    if ($motCle !== '') {
        $livres = $service->rechercherLivres($motCle);
        $message = count($livres) > 0
            ? count($livres) . " résultat(s) trouvé(s)."
            : "Aucun livre trouvé pour cette recherche.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque</title>
    <?php include("../includes/header.php"); ?>
</head>
<body>
    <header>
        <h1>📚 Bibliothèque</h1>
    </header>

    <nav>
        <ul>
            <li><button class="btn-nav" onclick="window.location.href='login.php'">Se connecter</button></li>
            <li><button class="btn-nav" onclick="window.location.href='register.php'">S'inscrire</button></li>
            <li><button class="btn-nav" onclick="window.location.href='AjouterLivre.php'">Ajouter un livre</button></li>
            <li><button class="btn-nav" onclick="window.location.href='SearchAvancé.php'">Recherche avancée</button></li>
        </ul>
    </nav>

    <section class="search-panel">
        <h2>Rechercher des livres</h2>
        <form method="get" action="biblio.php" class="search-form">
            <input type="text" name="recherche" placeholder="Rechercher un livre..." value="<?php echo isset($_GET['recherche']) ? htmlspecialchars($_GET['recherche']) : ''; ?>">
            <button type="submit" class="btn-search">Rechercher</button>
        </form>
    </section>

    <section id="resultats">
        <p class="result-message"><?php echo htmlspecialchars($message); ?></p>
        <?php if (!empty($livres)): ?>
            <div class="result-grid">
                <?php foreach ($livres as $livre): ?>
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

    <!-- Pied de page -->
    <?php include("../includes/footer.php"); ?>
</body>
</html>
