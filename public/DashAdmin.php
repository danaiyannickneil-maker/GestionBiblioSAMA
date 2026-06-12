<?php
require_once(__DIR__ . "/../services/LivreService.php");
require_once(__DIR__ . "/../services/UserServices.php");
require_once(__DIR__ . "/../services/EmpruntService.php");

$livreService = new LivreService();
$userService = new UserServices();
$empruntService = new EmpruntService();

$totalLivres = $livreService->compterLivres();
$utilisateursActifs = $userService->compterUtilisateursActifs();
$empruntsEnCours = $empruntService->compterEmpruntsEnCours();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrateur</title>
    <?php include(__DIR__ . "/../includes/header.php"); ?>
</head>
<body>
    <header>
        <h1>Dashboard Administrateur</h1>
    </header>

    <nav>
        <ul>
            <li><button class="btn-nav" onclick="window.location.href='Biblio.php'">Bibliotheque</button></li>
            <li><button class="btn-nav secondary" onclick="window.location.href='AjouterLivre.php'">Ajouter un livre</button></li>
            <li><button class="btn-nav secondary" onclick="window.location.href='SearchAvancé.php'">Recherche avancee</button></li>
            <li><button class="btn-nav secondary" onclick="window.location.href='DashUser.php'">Dashboard utilisateur</button></li>
        </ul>
    </nav>

    <section class="dashboard-overview">
        <article class="dash-card">
            <h3>Total des livres</h3>
            <p><?php echo htmlspecialchars($totalLivres); ?></p>
            <small>Nombre d'articles disponibles</small>
        </article>
        <article class="dash-card">
            <h3>Utilisateurs</h3>
            <p><?php echo htmlspecialchars($utilisateursActifs); ?></p>
            <small>Comptes actifs</small>
        </article>
        <article class="dash-card">
            <h3>Emprunts</h3>
            <p><?php echo htmlspecialchars($empruntsEnCours); ?></p>
            <small>Livres en circulation</small>
        </article>
    </section>

    <section class="dashboard-actions">
        <div class="dashboard-panel">
            <h2>Ajout rapide de livre</h2>
            <form class="dashboard-form" method="get" action="AjouterLivre.php">
                <button type="submit" class="btn-submit">Ajouter un livre</button>
            </form>
        </div>

        <div class="dashboard-panel">
            <h2>Gestion utilisateurs</h2>
            <form class="dashboard-form" method="get" action="register.php">
                <button type="submit" class="btn-submit">Creer un utilisateur</button>
            </form>
        </div>
    </section>

    <?php include(__DIR__ . "/../includes/footer.php"); ?>
</body>
</html>
