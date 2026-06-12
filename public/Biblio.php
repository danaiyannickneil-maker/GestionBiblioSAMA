<?php
session_start();
require_once(__DIR__ . "/../services/LivreService.php");
require_once(__DIR__ . "/../services/EmpruntService.php");

$livreService = new LivreService();
$empruntService = new EmpruntService();
$livres = [];
$message = "Recherchez un livre par titre, auteur, ISBN, langue ou categorie.";
$actionPage = "Biblio.php" . (!empty($_GET["recherche"]) ? "?recherche=" . urlencode($_GET["recherche"]) : "");

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["action_livre"]) && !empty($_POST["document_id"])) {
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

if (!empty($_GET["recherche"])) {
    $motCle = trim($_GET["recherche"]);
    if ($motCle !== '') {
        $livres = $livreService->rechercherLivres($motCle);
        if (empty($_POST["action_livre"])) {
            $message = count($livres) > 0
                ? count($livres) . " resultat(s) trouve(s)."
                : "Aucun livre trouve pour cette recherche.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Bibliothèque Universitaire</title>
    <?php include("../includes/header.php"); ?>
    <link rel="stylesheet" href="../assets/css/Biblio.css">

    <style>
        header {
            display: flex;
            justify-content: flex-start; /* Aligne les éléments à gauche */
            align-items: center;        /* Centre verticalement le logo et le texte */
            gap: 20px;                  /* Espace agréable entre le logo et le titre */
            padding: 15px 30px;
        }
        .logo-site {
            height: 70px;               /* Taille optimisée pour la lisibilité du logo */
            width: auto;  
            filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.1)); /* Léger relief */
        }
        header h1 {
            font-size: 2.2rem;
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <img src="../assets/image/Logo.png" alt="Logo Bibliothèque Universitaire" class="logo-site">
        <h1>Bibliothèque Universitaire</h1>

    </header>

    <nav>
        <ul>
            <li><button class="btn-nav" onclick="window.location.href='login.php'">Se connecter</button></li>
            <li><button class="btn-nav" onclick="window.location.href='register.php'">S'inscrire</button></li>
            <li><button class="btn-nav" onclick="window.location.href='AjouterLivre.php'">Ajouter un livre</button></li>
            <li><button class="btn-nav secondary" onclick="window.location.href='Favoris.php'">Mes favoris</button></li>
            <li><button class="btn-nav secondary" onclick="window.location.href='SearchAvancé.php'">Recherche avancee</button></li>
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
        <?php if (!empty($message) && empty($_SESSION["user_id"]) && $_SERVER["REQUEST_METHOD"] === "POST"): ?>
            <div class="auth-actions">
                <button class="btn-nav" onclick="window.location.href='login.php'">Se connecter</button>
                <button class="btn-nav secondary" onclick="window.location.href='register.php'">S'inscrire</button>
            </div>
        <?php endif; ?>

        <?php if (!empty($livres)): ?>
            <div class="result-grid">
                <?php foreach ($livres as $livre): ?>
                    <?php include(__DIR__ . "/../includes/livre_card.php"); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>


    <?php include(__DIR__ . "/../includes/footer.php"); ?>
</body>
</html>