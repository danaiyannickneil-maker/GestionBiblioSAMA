<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = !empty($_SESSION["user_id"]);
$userType = $_SESSION["type_user"] ?? '';
$userObj = $_SESSION["user"] ?? [];
$userName = trim(($userObj['prenom'] ?? '') . ' ' . ($userObj['nom'] ?? ''));
if ($userName === '' && $isLoggedIn) {
    $userName = "Utilisateur";
}

$dashLink = "DashUser.php";
if (in_array($userType, ["admin", "bibliothecaire"], true)) {
    $dashLink = "DashAdmin.php";
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg app-navbar shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="Biblio.php">
            <img src="../assets/image/Logo.png" alt="Logo" class="navbar-logo me-2">
            <span class="brand-text">BU SAMA</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#appNavbarContent" aria-controls="appNavbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="appNavbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page === 'Biblio.php') ? 'active' : ''; ?>" href="Biblio.php">
                        <i class="fa-solid fa-book-open me-1"></i> Bibliothèque
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page === 'SearchAvancé.php') ? 'active' : ''; ?>" href="SearchAvancé.php">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Recherche avancée
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page === 'Dévelopeurs.php') ? 'active' : ''; ?>" href="Dévelopeurs.php">
                        <i class="fa-solid fa-users me-1"></i> L'Équipe
                    </a>
                </li>
            </ul>
            <div class="d-flex align-items-center flex-wrap gap-2 mt-2 mt-lg-0">
                <?php if ($isLoggedIn): ?>
                    <span class="navbar-user-greet me-2 text-white">
                        <i class="fa-solid fa-circle-user me-1 text-gold"></i> <?php echo htmlspecialchars($userName); ?> (<?php echo htmlspecialchars(ucfirst($userType)); ?>)
                    </span>
                    <a href="<?php echo htmlspecialchars($dashLink); ?>" class="btn btn-navbar-dash btn-sm">
                        <i class="fa-solid fa-chart-line me-1"></i> Dashboard
                    </a>
                    <a href="logout.php" class="btn btn-navbar-logout btn-sm">
                        <i class="fa-solid fa-right-from-bracket me-1"></i> Déconnexion
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-navbar-login btn-sm">
                        <i class="fa-solid fa-sign-in-alt me-1"></i> Connexion
                    </a>
                    <a href="register.php" class="btn btn-navbar-register btn-sm">
                        <i class="fa-solid fa-user-plus me-1"></i> Inscription
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
