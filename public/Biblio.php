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
        <p id="Nbresult">Aucun résultat pour l’instant.</p>
        <div class="card">
            <div id="details"></div>
        </div>
    </section>

    <!-- Pied de page -->
    <?php include("../includes/footer.php"); ?>
</body>
</html>
