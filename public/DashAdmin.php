<?php
session_start();
require_once(__DIR__ . "/../services/LivreService.php");
require_once(__DIR__ . "/../services/UserServices.php");
require_once(__DIR__ . "/../services/EmpruntService.php");

// Sécurité : Accès restreint aux administrateurs et bibliothécaires
if (empty($_SESSION["user_id"]) || !in_array($_SESSION["type_user"], ["admin", "bibliothecaire"], true)) {
    header("Location: login.php");
    exit;
}

$livreService = new LivreService();
$userService = new UserServices();
$empruntService = new EmpruntService();

$totalLivres = $livreService->compterLivres();
$utilisateursActifs = $userService->compterUtilisateursActifs();
$empruntsEnCours = $empruntService->compterEmpruntsEnCours();
$userObj = $_SESSION["user"] ?? [];
$nomComplet = trim(($userObj['prenom'] ?? '') . ' ' . ($userObj['nom'] ?? ''));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrateur - BU SAMA</title>
    <?php include("../includes/header.php"); ?>
</head>
<body>

    <?php include("../includes/navbar.php"); ?>

    <!-- En-tête Dashboard -->
    <div class="bg-light py-4 border-bottom mb-4">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="mb-0 text-success-green" style="color: var(--green-dark); font-family: 'Outfit'; font-weight: 700;">
                    <i class="fa-solid fa-chart-pie me-2 text-gold"></i> Dashboard Administrateur
                </h1>
                <p class="text-muted mb-0 small">Portail de gestion et d'administration de la bibliothèque.</p>
            </div>
            <?php if ($nomComplet): ?>
                <div class="bg-white px-3 py-2 border rounded shadow-sm">
                    <span class="small text-muted"><i class="fa-solid fa-user-shield me-1 text-gold"></i> Connecté en tant que : </span>
                    <strong class="text-success-green"><?php echo htmlspecialchars($nomComplet); ?></strong>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Section statistiques -->
    <section class="container mt-2">
        <div class="dashboard-overview">
            
            <div class="dash-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Total des livres</h3>
                    <i class="fa-solid fa-book fa-2x text-success opacity-25"></i>
                </div>
                <p><?php echo htmlspecialchars($totalLivres); ?></p>
                <small class="text-muted">Nombre d'articles disponibles au catalogue</small>
            </div>

            <div class="dash-card dash-card-alt">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Utilisateurs Actifs</h3>
                    <i class="fa-solid fa-users fa-2x text-warning opacity-25"></i>
                </div>
                <p><?php echo htmlspecialchars($utilisateursActifs); ?></p>
                <small class="text-muted">Comptes étudiants enregistrés et actifs</small>
            </div>

            <div class="dash-card dash-card-blue">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Emprunts en cours</h3>
                    <i class="fa-solid fa-handshake-angle fa-2x text-primary opacity-25"></i>
                </div>
                <p><?php echo htmlspecialchars($empruntsEnCours); ?></p>
                <small class="text-muted">Livres actuellement empruntés</small>
            </div>

        </div>
    </section>

    <!-- Section Actions Administrateur -->
    <section class="container">
        <div class="dashboard-actions">
            
            <div class="dashboard-panel">
                <h2><i class="fa-solid fa-plus-circle me-2 text-success-green"></i> Catalogue</h2>
                <p class="text-muted small">Ajoutez de nouvelles références de livres, enregistrez les codes ISBN et associez des images de couverture pour les étudiants.</p>
                <div class="mt-4">
                    <a href="AjouterLivre.php" class="btn-submit d-inline-block px-4 py-2 text-decoration-none">
                        <i class="fa-solid fa-book-medical me-1"></i> Ajouter un livre
                    </a>
                </div>
            </div>

            <div class="dashboard-panel">
                <h2><i class="fa-solid fa-user-gear me-2 text-gold"></i> Utilisateurs</h2>
                <p class="text-muted small">Ajoutez de nouveaux profils utilisateurs, créez des comptes étudiants ou administrateurs et suivez leurs statistiques d'emprunt.</p>
                <div class="mt-4">
                    <a href="register.php" class="btn-action-secondary d-inline-block px-4 py-2 text-decoration-none">
                        <i class="fa-solid fa-user-plus me-1"></i> Créer un utilisateur
                    </a>
                </div>
            </div>

        </div>
    </section>

    <?php include(__DIR__ . "/../includes/footer.php"); ?>
</body>
</html>
