<?php
session_start();
require_once(__DIR__ . "/../services/EmpruntService.php");

// Sécurité : Accès restreint aux utilisateurs connectés
if (empty($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$utilisateurId = $_SESSION["user_id"];
$user = $_SESSION["user"] ?? [];
$empruntService = new EmpruntService();

$livresEmpruntes = $empruntService->compterEmpruntsUtilisateur($utilisateurId);
$favoris = $empruntService->compterFavorisUtilisateur($utilisateurId);
$notifications = $empruntService->compterNotificationsNonLues($utilisateurId);
$nomComplet = trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? ''));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Utilisateur - BU SAMA</title>
    <?php include(__DIR__ . "/../includes/header.php"); ?>
</head>
<body>

    <?php include(__DIR__ . "/../includes/navbar.php"); ?>

    <!-- En-tête Dashboard -->
    <div class="bg-light py-4 border-bottom mb-4">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="mb-0 text-success-green" style="color: var(--green-dark); font-family: 'Outfit'; font-weight: 700;">
                    <i class="fa-solid fa-columns me-2 text-gold"></i> Mon Tableau de Bord
                </h1>
                <p class="text-muted mb-0 small">Gérez vos emprunts, vos lectures favorites et vos informations personnelles.</p>
            </div>
            <?php if ($nomComplet): ?>
                <div class="bg-white px-3 py-2 border rounded shadow-sm">
                    <span class="small text-muted"><i class="fa-solid fa-circle-user me-1 text-gold"></i> Connecté en tant que : </span>
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
                    <h3>Livres empruntés</h3>
                    <i class="fa-solid fa-book-reader fa-2x text-success opacity-25"></i>
                </div>
                <p><?php echo htmlspecialchars($livresEmpruntes); ?></p>
                <small class="text-muted">Documents en cours de lecture</small>
            </div>

            <div class="dash-card dash-card-alt">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Livres favoris</h3>
                    <i class="fa-solid fa-heart fa-2x text-danger opacity-25"></i>
                </div>
                <p><?php echo htmlspecialchars($favoris); ?></p>
                <small class="text-muted">Votre sélection d'ouvrages préférés</small>
            </div>

            <div class="dash-card dash-card-blue">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Notifications</h3>
                    <i class="fa-solid fa-bell fa-2x text-warning opacity-25"></i>
                </div>
                <p><?php echo htmlspecialchars($notifications); ?></p>
                <small class="text-muted">Rappels de retour et alertes</small>
            </div>

        </div>
    </section>

    <!-- Section Actions / Profil -->
    <section class="container">
        <div class="dashboard-actions">
            
            <!-- Panel Profil -->
            <div class="dashboard-panel">
                <h2><i class="fa-solid fa-id-card me-2 text-success-green"></i> Mon profil</h2>
                <form class="dashboard-form">
                    <div class="form-group mb-3">
                        <label for="user-nom">Nom complet</label>
                        <input id="user-nom" type="text" placeholder="Nom" class="form-control" value="<?php echo htmlspecialchars($nomComplet); ?>" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="user-email">Adresse Email</label>
                        <input id="user-email" type="email" placeholder="Email" class="form-control" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="user-role">Type de compte</label>
                        <input id="user-role" type="text" class="form-control" value="<?php echo htmlspecialchars(ucfirst($user['type_user'] ?? 'étudiant')); ?>" readonly>
                    </div>
                    <!-- Bouton factice pour la démonstration -->
                    <button type="button" class="btn-submit" onclick="alert('Fonctionnalité en cours de développement.')"><i class="fa-solid fa-user-edit me-1"></i> Modifier mes informations</button>
                </form>
            </div>

            <!-- Panel Actions rapides -->
            <div class="dashboard-panel">
                <h2><i class="fa-solid fa-bolt me-2 text-gold"></i> Actions rapides</h2>
                <p class="text-muted small mb-4">Accédez rapidement aux fonctionnalités essentielles pour chercher des livres ou voir vos sélections.</p>
                <div class="action-list">
                    <a href="Biblio.php" class="btn-action-primary d-block text-decoration-none mb-2">
                        <i class="fa-solid fa-book-open me-1"></i> Bibliothèque
                    </a>
                    <a href="SearchAvancé.php" class="btn-action-secondary d-block text-decoration-none mb-2">
                        <i class="fa-solid fa-search me-1"></i> Recherche avancée
                    </a>
                    <a href="Favoris.php" class="btn-action-secondary d-block text-decoration-none mb-2" style="background-color: #ffeef0; color: #d9383a !important; border-color: rgba(217, 56, 58, 0.15);">
                        <i class="fa-solid fa-heart me-1"></i> Mes favoris
                    </a>
                    <a href="AjouterLivre.php" class="btn-action-secondary d-block text-decoration-none mb-2">
                        <i class="fa-solid fa-plus me-1"></i> Suggérer un livre
                    </a>
                </div>
            </div>

        </div>
    </section>

    <?php include(__DIR__ . "/../includes/footer.php"); ?>
</body>
</html>
