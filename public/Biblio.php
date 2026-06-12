<?php
require_once(__DIR__ . "/../services/LivreService.php");

$service = new LivreService();
$livres = [];
$message = "Aucun resultat pour l'instant.";

if (!empty($_GET["recherche"])) {
    $motCle = trim($_GET["recherche"]);
    if ($motCle !== '') {
        $livres = $service->rechercherLivres($motCle);
        $message = count($livres) > 0
            ? count($livres) . " resultat(s) trouve(s)."
            : "Aucun livre trouve pour cette recherche.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliotheque</title>
    <?php include(__DIR__ . "/../includes/header.php"); ?>
</head>
<body>
    <header>
        <h1>Bibliotheque</h1>
    </header>

    <nav>
        <ul>
            <li><button class="btn-nav" onclick="window.location.href='login.php'">Se connecter</button></li>
            <li><button class="btn-nav" onclick="window.location.href='register.php'">S'inscrire</button></li>
            <li><button class="btn-nav" onclick="window.location.href='AjouterLivre.php'">Ajouter un livre</button></li>
            <li><button class="btn-nav" onclick="window.location.href='SearchAvancé.php'">Recherche avancee</button></li>
        </ul>
    </nav>

    <section class="search-panel">
        <h2>Rechercher des livres</h2>
        <form method="get" action="Biblio.php" class="search-form">
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
