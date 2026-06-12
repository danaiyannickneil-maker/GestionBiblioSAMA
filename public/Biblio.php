<?php
require_once("../services/LivreService.php");

$service = new LivreService();
$livres = [];

if (isset($_GET["recherche"]) && !empty($_GET["recherche"])) {
    $motCle = $_GET["recherche"];
    $rechercheMethod = null;
    $candidates = [
        'rechercherLivres',
        'rechercherLivre',
        'rechercher',
        'searchLivres',
        'search',
        'getAllLivres'
    ];

    foreach ($candidates as $methodName) {
        if (method_exists($service, $methodName)) {
            $rechercheMethod = $methodName;
            break;
        }
    }

    if ($rechercheMethod === 'getAllLivres') {
        $allLivres = $service->{$rechercheMethod}();
        $livres = array_filter($allLivres, function ($livre) use ($motCle) {
            return stripos($livre['titre'], $motCle) !== false
                || stripos($livre['auteur'], $motCle) !== false
                || stripos($livre['description'], $motCle) !== false
                || stripos($livre['editeur'], $motCle) !== false;
        });
    } elseif ($rechercheMethod !== null) {
        $livres = $service->{$rechercheMethod}($motCle);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque</title>
    <link rel="stylesheet" href="../assets/css/Biblio.css">
</head>
<body>
    <header>
        <h1>📚 Bibliothèque</h1>
    </header>

    <nav>
        <ul>
            <li><button onclick="window.location.href='login.php'">Se connecter</button></li>
            <li><button onclick="window.location.href='register.php'">S'inscrire</button></li>
            <li><button onclick="window.location.href='AjouterLivre.php'">Ajouter un livre</button></li>
        </ul>
    </nav>

    <section>
        <h2> Rechercher des livres</h2>
        <form method="get" action="biblio.php">
            <input type="text" name="recherche" placeholder="Rechercher un livre...">
            <button type="submit">Rechercher</button>
        </form>
    </section>

    <section id="resultats">
        <?php if (!empty($livres)): ?>
            <p id="Nbresult"><?php echo count($livres); ?> résultat(s) trouvé(s)</p>
            <?php foreach ($livres as $livre): ?>
                <div class="card">
                    <img src="<?php echo $livre['image_couverture']; ?>" alt="Couverture" width="120">
                    <h3><?php echo htmlspecialchars($livre['titre']); ?></h3>
                    <p><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur']); ?></p>
                    <p><strong>ISBN :</strong> <?php echo htmlspecialchars($livre['ISBN']); ?></p>
                    <p><strong>Éditeur :</strong> <?php echo htmlspecialchars($livre['editeur']); ?></p>
                    <p><strong>Année :</strong> <?php echo htmlspecialchars($livre['annee_publication']); ?></p>
                    <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($livre['categorie']); ?></p>
                    <p><strong>Pages :</strong> <?php echo htmlspecialchars($livre['nb_pages']); ?></p>
                    <p><strong>Langue :</strong> <?php echo htmlspecialchars($livre['langue']); ?></p>
                    <p><strong>Description :</strong> <?php echo nl2br(htmlspecialchars($livre['description'])); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p id="Nbresult">Aucun résultat pour l’instant.</p>
        <?php endif; ?>
    </section>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
