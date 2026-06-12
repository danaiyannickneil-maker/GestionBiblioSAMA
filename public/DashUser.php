<?php
session_start();
require_once(__DIR__ . "/../services/EmpruntService.php");

$utilisateurId = $_SESSION["user_id"] ?? null;
$user = $_SESSION["user"] ?? [];
$empruntService = new EmpruntService();

$livresEmpruntes = $utilisateurId ? $empruntService->compterEmpruntsUtilisateur($utilisateurId) : 0;
$favoris = $utilisateurId ? $empruntService->compterFavorisUtilisateur($utilisateurId) : 0;
$notifications = $utilisateurId ? $empruntService->compterNotificationsNonLues($utilisateurId) : 0;
$nomComplet = trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? ''));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utilisateur</title>
    <?php include(__DIR__ . "/../includes/header.php"); ?>
</head>
<body>
    <header>
        <h1>Dashboard Utilisateur</h1>
        <?php if ($nomComplet !== ''): ?>
            <p class="dashboard-user">Connecte : <?php echo htmlspecialchars($nomComplet); ?></p>
        <?php endif; ?>
    </header>

    <nav>
        <ul>
            <li><button class="btn-nav" onclick="window.location.href='Biblio.php'">Bibliotheque</button></li>
            <li><button class="btn-nav secondary" onclick="window.location.href='SearchAvancé.php'">Recherche avancee</button></li>
            <li><button class="btn-nav secondary" onclick="window.location.href='AjouterLivre.php'">Ajouter un livre</button></li>
        </ul>
    </nav>

    <section class="dashboard-overview">
        <article class="dash-card">
            <h3>Livres empruntes</h3>
            <p><?php echo htmlspecialchars($livresEmpruntes); ?></p>
            <small>En cours de lecture</small>
        </article>
        <article class="dash-card">
            <h3>Livres favoris</h3>
            <p><?php echo htmlspecialchars($favoris); ?></p>
            <small>Selection personnelle</small>
        </article>
        <article class="dash-card">
            <h3>Notifications</h3>
            <p><?php echo htmlspecialchars($notifications); ?></p>
            <small>Rappels disponibles</small>
        </article>
    </section>

    <section class="dashboard-actions">
        <div class="dashboard-panel">
            <h2>Mon profil</h2>
            <form class="dashboard-form">
                <div class="form-group">
                    <label for="user-nom">Nom</label>
                    <input id="user-nom" type="text" placeholder="Nom" value="<?php echo htmlspecialchars($user['nom'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="user-email">Email</label>
                    <input id="user-email" type="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                </div>
                <button type="submit" class="btn-submit">Mettre a jour</button>
            </form>
        </div>

        <div class="dashboard-panel">
            <h2>Actions rapides</h2>
            <div class="action-list">
                <button class="btn-nav secondary" onclick="window.location.href='SearchAvancé.php'">Rechercher</button>
                <button class="btn-nav secondary" onclick="window.location.href='AjouterLivre.php'">Ajouter livre</button>
                <button class="btn-nav secondary" onclick="window.location.href='Favoris.php'">Mes favoris</button>
                <button class="btn-nav secondary" onclick="window.location.href='Biblio.php'">Voir la bibliotheque</button>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . "/../includes/footer.php"); ?>
</body>
</html>
