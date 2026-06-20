<?php
session_start();

$isLoggedIn = !empty($_SESSION["user_id"]);
$userType = $_SESSION["type_user"] ?? "";
$userObj = $_SESSION["user"] ?? [];
$userName = trim(($userObj["prenom"] ?? "") . " " . ($userObj["nom"] ?? ""));
$userInitial = strtoupper(substr($userObj["prenom"] ?? "U", 0, 1));
$isAdmin = in_array($userType, ["admin", "bibliothecaire"], true);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BU SAMA - Bibliothèque Universitaire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/Biblio.css">
</head>
<body>

<!-- Container principal STYLE WHATSAPP -->
<div class="app-container" id="appContainer">

    <!-- ============================================================
         PANNEAU GAUCHE : BARRE LATÉRALE
         ============================================================ -->
    <div class="sidebar-panel" id="sidebarPanel">

        <!-- En-tête de la sidebar -->
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <img src="../assets/image/Logo.png" alt="BU SAMA" class="navbar-logo">
                <span class="brand-text">BU SAMA</span>
            </div>
            <div class="sidebar-actions">
                <?php if ($isLoggedIn): ?>
                <div class="user-avatar" title="<?php echo htmlspecialchars($userName); ?>">
                    <?php echo htmlspecialchars($userInitial); ?>
                </div>
                <button class="sidebar-icon-btn" title="Déconnexion" onclick="doLogout()">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
                <?php else: ?>
                <button class="sidebar-icon-btn" title="Se connecter" onclick="showTab('login')">
                    <i class="fa-solid fa-sign-in-alt"></i>
                </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Barre de recherche rapide dans la sidebar -->
        <div class="sidebar-search-container">
            <div class="sidebar-search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="sidebarSearchInput" placeholder="Rechercher un livre...">
            </div>
        </div>

        <!-- Liste des onglets (façon liste de chats WhatsApp) -->
        <div class="tab-list" id="tabList">

            <!-- Bibliothèque -->
            <div class="tab-item active" data-tab="library" onclick="showTab('library')">
                <div class="tab-icon-wrap" style="background:#e7f5ed; color:#0a4e2a;">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div class="tab-details">
                    <div class="tab-meta">
                        <h4>Bibliothèque</h4>
                    </div>
                    <p class="tab-desc">Parcourir le catalogue complet</p>
                </div>
            </div>

            <!-- Recherche Avancée -->
            <div class="tab-item" data-tab="search" onclick="showTab('search')">
                <div class="tab-icon-wrap" style="background:#e6f0fa; color:#0f4c81;">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                </div>
                <div class="tab-details">
                    <div class="tab-meta">
                        <h4>Recherche avancée</h4>
                    </div>
                    <p class="tab-desc">Filtres multi-critères précis</p>
                </div>
            </div>

            <?php if ($isLoggedIn): ?>
            <!-- Mes Favoris -->
            <div class="tab-item" data-tab="favorites" onclick="showTab('favorites')">
                <div class="tab-icon-wrap" style="background:#fff0f0; color:#ea0038;">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <div class="tab-details">
                    <div class="tab-meta">
                        <h4>Mes favoris</h4>
                    </div>
                    <p class="tab-desc">Votre sélection personnelle</p>
                </div>
            </div>

            <!-- Ajouter un Livre -->
            <div class="tab-item" data-tab="add_book" onclick="showTab('add_book')">
                <div class="tab-icon-wrap" style="background:#fffbe6; color:#c49200;">
                    <i class="fa-solid fa-square-plus"></i>
                </div>
                <div class="tab-details">
                    <div class="tab-meta">
                        <h4>Ajouter un livre</h4>
                    </div>
                    <p class="tab-desc">Enrichir le catalogue</p>
                </div>
            </div>

            <!-- Dashboard -->
            <div class="tab-item" data-tab="dashboard" onclick="showTab('dashboard')">
                <div class="tab-icon-wrap" style="background:#f3eaff; color:#7c3aed;">
                    <i class="fa-solid fa-chart-pie"></i>
                </div>
                <div class="tab-details">
                    <div class="tab-meta">
                        <h4><?php echo $isAdmin ? "Admin Dashboard" : "Mon Dashboard"; ?></h4>
                    </div>
                    <p class="tab-desc"><?php echo $isAdmin ? "Statistiques globales" : "Mon profil & mes données"; ?></p>
                </div>
            </div>
            <?php else: ?>
            <!-- Connexion (si non connecté) -->
            <div class="tab-item" data-tab="login" onclick="showTab('login')">
                <div class="tab-icon-wrap" style="background:#e7f5ed; color:#0a4e2a;">
                    <i class="fa-solid fa-sign-in-alt"></i>
                </div>
                <div class="tab-details">
                    <div class="tab-meta"><h4>Connexion</h4></div>
                    <p class="tab-desc">Accéder à votre espace</p>
                </div>
            </div>
            <div class="tab-item" data-tab="register" onclick="showTab('register')">
                <div class="tab-icon-wrap" style="background:#fffbe6; color:#c49200;">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div class="tab-details">
                    <div class="tab-meta"><h4>Inscription</h4></div>
                    <p class="tab-desc">Créer un compte étudiant</p>
                </div>
            </div>
            <?php endif; ?>

            <!-- L'Équipe -->
            <div class="tab-item" data-tab="team" onclick="showTab('team')">
                <div class="tab-icon-wrap" style="background:#fef2e8; color:#c05621;">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="tab-details">
                    <div class="tab-meta"><h4>L'Équipe</h4></div>
                    <p class="tab-desc">Les développeurs SAMA</p>
                </div>
            </div>

        </div><!-- /tab-list -->
    </div><!-- /sidebar-panel -->


    <!-- ============================================================
         PANNEAU DROITE : ZONE DE CONTENU
         ============================================================ -->
    <div class="content-panel" id="contentPanel">

        <!-- En-tête du contenu (changeable par JS) -->
        <div class="content-header">
            <button class="mobile-back-btn" id="mobileBackBtn" onclick="hideMobile()">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <h2 id="contentTitle">Bibliothèque Universitaire</h2>
        </div>

        <!-- Corps du contenu -->
        <div class="content-body" id="contentBody">

            <!-- Écran d'accueil par défaut -->
            <div id="view-welcome" class="view-section active">
                <div class="welcome-screen">
                    <img src="../assets/image/Logo.png" alt="BU SAMA" style="height:100px; margin-bottom:1.5rem; filter: drop-shadow(0 5px 15px rgba(10,78,42,0.15));">
                    <h2>Bibliothèque Universitaire SAMA</h2>
                    <p>Sélectionnez un onglet dans le menu de gauche pour commencer à explorer le catalogue, gérer vos favoris ou accéder à votre espace personnel.</p>
                    <div style="display:flex; gap:12px; margin-top:2rem; flex-wrap:wrap; justify-content:center;">
                        <button class="btn-primary-spa" onclick="showTab('library')">
                            <i class="fa-solid fa-book-open me-2"></i> Explorer le catalogue
                        </button>
                        <?php if (!$isLoggedIn): ?>
                        <button class="btn-secondary-spa" onclick="showTab('login')">
                            <i class="fa-solid fa-sign-in-alt me-2"></i> Se connecter
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- VUE : BIBLIOTHÈQUE -->
            <div id="view-library" class="view-section">
                <div class="search-bar-spa">
                    <form id="searchForm" onsubmit="searchBooks(event)">
                        <div class="search-input-wrap">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="searchInput" placeholder="Rechercher par titre, auteur, ISBN, catégorie...">
                        </div>
                        <button type="submit" class="btn-primary-spa"><i class="fa-solid fa-search"></i> Rechercher</button>
                    </form>
                </div>
                <div id="libraryStatus" class="status-bar"></div>
                <div id="bookGrid" class="spa-book-grid">
                    <div class="loading-state">
                        <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
                        <p>Chargement du catalogue...</p>
                    </div>
                </div>
            </div>

            <!-- VUE : RECHERCHE AVANCÉE -->
            <div id="view-search" class="view-section">
                <div class="spa-form-card">
                    <h3 class="form-section-title"><i class="fa-solid fa-sliders me-2"></i> Filtres de recherche</h3>
                    <form id="advancedSearchForm" onsubmit="advancedSearch(event)">
                        <div class="form-grid-2">
                            <div class="spa-form-group">
                                <label>Titre</label>
                                <input type="text" name="titre" placeholder="Titre du livre...">
                            </div>
                            <div class="spa-form-group">
                                <label>Auteur</label>
                                <input type="text" name="auteur" placeholder="Auteur...">
                            </div>
                            <div class="spa-form-group">
                                <label>ISBN</label>
                                <input type="text" name="isbn" placeholder="Code ISBN...">
                            </div>
                            <div class="spa-form-group">
                                <label>Éditeur</label>
                                <input type="text" name="editeur" placeholder="Éditeur...">
                            </div>
                            <div class="spa-form-group">
                                <label>Catégorie</label>
                                <input type="text" name="categorie" placeholder="Ex: Informatique, Sciences...">
                            </div>
                            <div class="spa-form-group">
                                <label>Langue</label>
                                <input type="text" name="langue" placeholder="Ex: Français, Anglais...">
                            </div>
                            <div class="spa-form-group">
                                <label>Année</label>
                                <input type="number" name="annee" min="1000" max="2100" placeholder="YYYY">
                            </div>
                            <div class="spa-form-group">
                                <label>Nb. pages</label>
                                <input type="number" name="nb_pages" min="1" placeholder="Ex: 300">
                            </div>
                        </div>
                        <div class="spa-form-group" style="margin-top:12px;">
                            <label>Mots-clés dans la description</label>
                            <textarea name="description" rows="2" placeholder="Mots-clés du résumé..."></textarea>
                        </div>
                        <button type="submit" class="btn-primary-spa btn-full-width mt-3">
                            <i class="fa-solid fa-search me-2"></i> Lancer la recherche
                        </button>
                    </form>
                    <div id="advSearchStatus" class="status-bar mt-3"></div>
                    <div id="advSearchResults" class="spa-book-grid mt-3"></div>
                </div>
            </div>

            <!-- VUE : FAVORIS -->
            <div id="view-favorites" class="view-section">
                <div id="favoritesStatus" class="status-bar"></div>
                <div id="favoritesGrid" class="spa-book-grid">
                    <div class="loading-state">
                        <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
                        <p>Chargement des favoris...</p>
                    </div>
                </div>
            </div>

            <!-- VUE : AJOUTER UN LIVRE -->
            <div id="view-add_book" class="view-section">
                <div class="spa-form-card">
                    <h3 class="form-section-title"><i class="fa-solid fa-square-plus me-2"></i> Nouveau livre</h3>
                    <form id="addBookForm" onsubmit="addBook(event)" enctype="multipart/form-data">
                        <div class="form-grid-2">
                            <div class="spa-form-group">
                                <label>Titre <span class="req">*</span></label>
                                <input type="text" name="titre" required placeholder="Titre du livre">
                            </div>
                            <div class="spa-form-group">
                                <label>Auteur <span class="req">*</span></label>
                                <input type="text" name="auteur" required placeholder="Prénom Nom">
                            </div>
                            <div class="spa-form-group">
                                <label>ISBN <span class="req">*</span></label>
                                <input type="text" name="isbn" required placeholder="Ex: 978-2-01-234567-8">
                            </div>
                            <div class="spa-form-group">
                                <label>Éditeur</label>
                                <input type="text" name="editeur" placeholder="Nom de l'éditeur">
                            </div>
                            <div class="spa-form-group">
                                <label>Catégorie</label>
                                <input type="text" name="categorie" placeholder="Ex: Informatique">
                            </div>
                            <div class="spa-form-group">
                                <label>Langue</label>
                                <input type="text" name="langue" placeholder="Ex: Français">
                            </div>
                            <div class="spa-form-group">
                                <label>Année</label>
                                <input type="number" name="annee" min="1000" max="2100" placeholder="YYYY">
                            </div>
                            <div class="spa-form-group">
                                <label>Nb. pages</label>
                                <input type="number" name="nb_pages" min="1" placeholder="300">
                            </div>
                        </div>
                        <div class="spa-form-group" style="margin-top:12px;">
                            <label>Description / Résumé</label>
                            <textarea name="description" rows="3" placeholder="Résumé court du livre..."></textarea>
                        </div>
                        <div class="spa-form-group" style="margin-top:12px;">
                            <label>Image de couverture</label>
                            <input type="file" name="image" accept="image/*" class="file-input">
                        </div>
                        <button type="submit" class="btn-primary-spa btn-full-width mt-3">
                            <i class="fa-solid fa-plus me-2"></i> Ajouter au catalogue
                        </button>
                    </form>
                </div>
            </div>

            <!-- VUE : DASHBOARD -->
            <div id="view-dashboard" class="view-section">
                <div id="dashContent">
                    <div class="loading-state">
                        <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
                        <p>Chargement...</p>
                    </div>
                </div>
            </div>

            <!-- VUE : CONNEXION -->
            <div id="view-login" class="view-section">
                <div class="spa-form-card">
                    <div class="auth-header-spa">
                        <img src="../assets/image/Logo.png" alt="BU SAMA" style="height:50px;">
                        <div>
                            <h3>Connexion</h3>
                            <p class="auth-subtitle">Accédez à votre espace bibliothèque</p>
                        </div>
                    </div>
                    <div id="loginMsg"></div>
                    <form id="loginForm" onsubmit="doLogin(event)">
                        <div class="spa-form-group">
                            <label for="loginEmail">Adresse Email</label>
                            <input type="email" id="loginEmail" name="email" required placeholder="exemple@univ.fr">
                        </div>
                        <div class="spa-form-group" style="margin-top:12px;">
                            <label for="loginMdp">Mot de passe</label>
                            <input type="password" id="loginMdp" name="mdp" required placeholder="••••••••">
                        </div>
                        <button type="submit" class="btn-primary-spa btn-full-width mt-3">
                            <i class="fa-solid fa-sign-in-alt me-2"></i> Se connecter
                        </button>
                    </form>
                    <p class="auth-switch">Pas de compte ? <a href="#" onclick="showTab('register')">S'inscrire</a></p>
                </div>
            </div>

            <!-- VUE : INSCRIPTION -->
            <div id="view-register" class="view-section">
                <div class="spa-form-card">
                    <div class="auth-header-spa">
                        <img src="../assets/image/Logo.png" alt="BU SAMA" style="height:50px;">
                        <div>
                            <h3>Créer un compte</h3>
                            <p class="auth-subtitle">Rejoignez la bibliothèque universitaire</p>
                        </div>
                    </div>
                    <div id="registerMsg"></div>
                    <form id="registerForm" onsubmit="doRegister(event)">
                        <div class="form-grid-2">
                            <div class="spa-form-group">
                                <label>Nom</label>
                                <input type="text" name="nom" required placeholder="Votre nom">
                            </div>
                            <div class="spa-form-group">
                                <label>Prénom</label>
                                <input type="text" name="prenom" required placeholder="Votre prénom">
                            </div>
                        </div>
                        <div class="spa-form-group" style="margin-top:12px;">
                            <label>Email</label>
                            <input type="email" name="email" required placeholder="exemple@univ.fr">
                        </div>
                        <div class="spa-form-group" style="margin-top:12px;">
                            <label>Mot de passe</label>
                            <input type="password" name="mdp" required placeholder="Min. 6 caractères">
                        </div>
                        <div class="spa-form-group" style="margin-top:12px;">
                            <label>Confirmer le mot de passe</label>
                            <input type="password" name="mdp2" required placeholder="Confirmez votre mot de passe">
                        </div>
                        <button type="submit" class="btn-primary-spa btn-full-width mt-3">
                            <i class="fa-solid fa-user-plus me-2"></i> S'inscrire
                        </button>
                    </form>
                    <p class="auth-switch">Déjà un compte ? <a href="#" onclick="showTab('login')">Se connecter</a></p>
                </div>
            </div>

            <!-- VUE : ÉQUIPE -->
            <div id="view-team" class="view-section">
                <div class="team-grid">
                    <div class="team-header">
                        <h2><i class="fa-solid fa-code me-2"></i> L'équipe de développement</h2>
                        <p>Trois étudiants passionnés derrière cette plateforme</p>
                        <div class="team-separator"></div>
                    </div>
                    <div class="team-cards">
                        <div class="team-card">
                            <div class="team-avatar" style="background:linear-gradient(135deg,#0a4e2a,#128c51);">
                                <img src="../assets/image/dev1.jpg" alt="Jokias" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                <span class="avatar-fallback" style="display:none;">JK</span>
                            </div>
                            <h4>Jokias Knight</h4>
                            <p class="team-role">Chef de Projet & Back-End</p>
                            <p class="team-bio">Architecture SQL, logique PHP et services métiers robustes.</p>
                            <div class="team-links">
                                <a href="#"><i class="fa-brands fa-github"></i></a>
                                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="team-card">
                            <div class="team-avatar" style="background:linear-gradient(135deg,#0f4c81,#1a7fd4);">
                                <img src="../assets/image/dev2.jpg" alt="Lésita" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                <span class="avatar-fallback" style="display:none;">LW</span>
                            </div>
                            <h4>Lésita -wp</h4>
                            <p class="team-role">Designer UI/UX & Front-End</p>
                            <p class="team-bio">Intégration des maquettes et système de design CSS premium.</p>
                            <div class="team-links">
                                <a href="#"><i class="fa-brands fa-github"></i></a>
                                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="team-card">
                            <div class="team-avatar" style="background:linear-gradient(135deg,#7c3aed,#a855f7);">
                                <img src="../assets/image/dev3.jpg" alt="BlackZheuss" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                <span class="avatar-fallback" style="display:none;">BZ</span>
                            </div>
                            <h4>BlackZheuss ♠</h4>
                            <p class="team-role">Développeur Full-Stack</p>
                            <p class="team-bio">Sessions sécurisées, formulaires PHP et tests applicatifs complets.</p>
                            <div class="team-links">
                                <a href="#"><i class="fa-brands fa-github"></i></a>
                                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /content-body -->
    </div><!-- /content-panel -->


    <!-- ============================================================
         TIROIR DE DÉTAILS LIVRE (DRAWER)
         ============================================================ -->
    <div class="detail-drawer" id="detailDrawer">
        <div class="drawer-header">
            <button class="drawer-close-btn" onclick="closeDrawer()">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <h3>Détails du livre</h3>
        </div>
        <div class="drawer-body" id="drawerBody">
            <!-- Rempli dynamiquement par JS -->
        </div>
    </div>

</div><!-- /app-container -->

<!-- Container des toasts de notification -->
<div class="toast-container" id="toastContainer"></div>


<!-- ================================================================
     STYLES SUPPLÉMENTAIRES POUR LA SPA
     ================================================================ -->
<style>
/* États des vues */
.view-section { display: none; }
.view-section.active { display: block; }

/* Avatar utilisateur */
.user-avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--green-medium), var(--green-dark));
    color: white;
    font-weight: 700;
    font-size: 1rem;
    display: flex; align-items: center; justify-content: center;
    cursor: default;
}

/* Boutons SPA */
.btn-primary-spa {
    background: linear-gradient(135deg, var(--green-medium) 0%, var(--green-dark) 100%);
    color: white !important;
    border: none;
    padding: 10px 22px;
    font-size: 0.92rem;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}
.btn-primary-spa:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(18, 140, 81, 0.3);
}
.btn-secondary-spa {
    background: transparent;
    color: var(--green-dark) !important;
    border: 2px solid var(--green-dark);
    padding: 10px 22px;
    font-size: 0.92rem;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}
.btn-secondary-spa:hover {
    background: var(--green-light);
}
.btn-full-width { width: 100%; justify-content: center; }
.mt-3 { margin-top: 16px; }
.me-2 { margin-right: 8px; }

/* Barre de recherche de la vue Bibliothèque */
.search-bar-spa {
    background: white;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid var(--border-color);
}
.search-bar-spa form {
    display: flex;
    gap: 10px;
    align-items: center;
}
.search-input-wrap {
    flex: 1;
    display: flex;
    align-items: center;
    background: #f0f2f5;
    border-radius: 8px;
    padding: 8px 14px;
    gap: 10px;
}
.search-input-wrap i { color: var(--text-light); }
.search-input-wrap input {
    background: transparent;
    border: none;
    flex: 1;
    font-size: 0.95rem;
    color: var(--text-dark);
}
.search-input-wrap input:focus { outline: none; }

/* Statut bar */
.status-bar {
    font-size: 0.88rem;
    color: var(--text-light);
    padding: 6px 2px;
    min-height: 24px;
}

/* État de chargement */
.loading-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 4rem;
    color: var(--text-light);
    gap: 16px;
}

/* Formulaires SPA */
.spa-form-card {
    background: white;
    border-radius: 14px;
    padding: 28px;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    max-width: 720px;
}
.form-section-title {
    font-size: 1.15rem;
    color: var(--green-dark);
    margin-bottom: 20px;
    font-family: 'Outfit';
    font-weight: 700;
    border-bottom: 2px solid var(--border-color);
    padding-bottom: 12px;
}
.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.spa-form-group { display: flex; flex-direction: column; }
.spa-form-group label {
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--text-light);
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.spa-form-group input,
.spa-form-group textarea,
.spa-form-group select {
    border: 1.5px solid var(--border-color);
    border-radius: 8px;
    padding: 9px 12px;
    font-size: 0.92rem;
    font-family: 'Inter', sans-serif;
    color: var(--text-dark);
    background: #fafbfc;
    transition: all 0.2s;
}
.spa-form-group input:focus,
.spa-form-group textarea:focus {
    outline: none;
    border-color: var(--green-medium);
    box-shadow: 0 0 0 3px rgba(18, 140, 81, 0.12);
    background: white;
}
.spa-form-group textarea { resize: vertical; min-height: 80px; }
.file-input { cursor: pointer; }
.req { color: var(--danger-red); }

/* Auth forms */
.auth-header-spa {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--border-color);
}
.auth-header-spa h3 { margin: 0; font-size: 1.4rem; color: var(--green-dark); }
.auth-subtitle { color: var(--text-light); font-size: 0.85rem; margin: 0; }
.auth-switch { text-align: center; margin-top: 16px; font-size: 0.88rem; color: var(--text-light); }
.auth-switch a { color: var(--green-medium); font-weight: 600; text-decoration: none; }
.auth-switch a:hover { text-decoration: underline; }

/* Alert inline */
.inline-alert {
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 0.88rem;
    font-weight: 500;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.inline-alert.success { background: #e6f6ee; color: #0e7a3a; border-left: 4px solid var(--success-green); }
.inline-alert.error { background: #fef0f0; color: #c0392b; border-left: 4px solid var(--danger-red); }

/* Dashboard */
.dash-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 28px;
}
.dash-stat-card {
    background: white;
    border-radius: 14px;
    padding: 22px;
    border: 1px solid var(--border-color);
    box-shadow: 0 3px 12px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    transition: transform 0.25s ease;
}
.dash-stat-card:hover { transform: translateY(-3px); }
.dash-stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 5px; height: 100%;
    border-radius: 2px 0 0 2px;
}
.dash-stat-card.green::before { background: var(--green-medium); }
.dash-stat-card.gold::before { background: var(--gold); }
.dash-stat-card.blue::before { background: var(--blue-star); }
.dash-stat-card.purple::before { background: #7c3aed; }
.dash-stat-icon { font-size: 1.5rem; margin-bottom: 12px; opacity: 0.7; }
.dash-stat-num { font-size: 2.8rem; font-weight: 800; font-family: 'Outfit'; line-height: 1; margin-bottom: 6px; }
.dash-stat-label { font-size: 0.82rem; color: var(--text-light); font-weight: 500; }
.dash-stat-card.green .dash-stat-icon { color: var(--green-medium); }
.dash-stat-card.green .dash-stat-num { color: var(--green-dark); }
.dash-stat-card.gold .dash-stat-icon { color: var(--gold-hover); }
.dash-stat-card.gold .dash-stat-num { color: #9a6c00; }
.dash-stat-card.blue .dash-stat-icon { color: var(--blue-star); }
.dash-stat-card.blue .dash-stat-num { color: var(--blue-star); }
.dash-stat-card.purple .dash-stat-icon { color: #7c3aed; }
.dash-stat-card.purple .dash-stat-num { color: #6d28d9; }

.dash-user-card {
    background: white;
    border-radius: 14px;
    padding: 24px;
    border: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
}
.dash-user-avatar {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--green-medium), var(--green-dark));
    color: white; font-size: 1.8rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.dash-user-info h3 { margin: 0; font-size: 1.2rem; color: var(--text-dark); }
.dash-user-info p { margin: 4px 0 0; color: var(--text-light); font-size: 0.88rem; }
.dash-role-badge {
    display: inline-block;
    background: var(--green-light);
    color: var(--green-dark);
    padding: 3px 10px;
    border-radius: 50px;
    font-size: 0.78rem;
    font-weight: 700;
    margin-top: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.dash-actions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.dash-action-btn {
    background: white;
    border: 1.5px solid var(--border-color);
    border-radius: 12px;
    padding: 18px;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
    transition: all 0.25s ease;
    text-align: left;
    font-family: 'Inter', sans-serif;
}
.dash-action-btn i { font-size: 1.5rem; }
.dash-action-btn span { font-size: 0.9rem; font-weight: 600; color: var(--text-dark); }
.dash-action-btn small { font-size: 0.78rem; color: var(--text-light); }
.dash-action-btn:hover { border-color: var(--green-medium); background: var(--green-light); transform: translateY(-2px); }

/* Équipe */
.team-grid { max-width: 900px; }
.team-header { text-align: center; margin-bottom: 40px; }
.team-header h2 { font-size: 1.8rem; color: var(--green-dark); margin-bottom: 8px; }
.team-header p { color: var(--text-light); }
.team-separator {
    height: 4px; width: 60px;
    background: linear-gradient(90deg, var(--gold), var(--green-medium));
    border-radius: 2px; margin: 16px auto 0;
}
.team-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; }
.team-card {
    background: white;
    border-radius: 16px;
    padding: 28px 20px;
    text-align: center;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.team-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(10,78,42,0.1); }
.team-avatar {
    width: 90px; height: 90px;
    border-radius: 50%;
    margin: 0 auto 16px;
    overflow: hidden;
    border: 3px solid var(--gold);
    position: relative;
    display: flex; align-items: center; justify-content: center;
}
.team-avatar img { width: 100%; height: 100%; object-fit: cover; }
.avatar-fallback {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 1.5rem; font-weight: 800;
    font-family: 'Outfit';
}
.team-card h4 { font-size: 1.05rem; color: var(--text-dark); margin: 0 0 4px; }
.team-role { font-size: 0.82rem; color: var(--green-medium); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px; }
.team-bio { font-size: 0.85rem; color: var(--text-light); line-height: 1.5; margin-bottom: 16px; }
.team-links { display: flex; justify-content: center; gap: 12px; }
.team-links a {
    width: 34px; height: 34px; border-radius: 50%;
    background: var(--bg-panel-header);
    color: var(--text-light);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; text-decoration: none;
    transition: all 0.2s;
}
.team-links a:hover { background: var(--green-dark); color: white; }

/* Drawer - boutons d'action */
.drawer-btn-emprunt {
    background: linear-gradient(135deg, var(--green-medium), var(--green-dark));
    color: white;
    border-radius: 8px; font-weight: 600;
}
.drawer-btn-emprunt:hover { opacity: 0.9; transform: translateY(-1px); }
.drawer-btn-favori {
    background: #fff0f0; color: #c0392b;
    border: 1.5px solid rgba(220,53,69,0.2);
    border-radius: 8px; font-weight: 600;
}
.drawer-btn-favori:hover { background: #fddde0; }

/* Toasts */
.app-toast {
    background: white;
    padding: 14px 18px;
    border-radius: 10px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
    animation: toastIn 0.35s ease forwards;
    max-width: 320px;
    border-left: 4px solid;
}
.app-toast.success { border-color: var(--success-green); }
.app-toast.error { border-color: var(--danger-red); }
.app-toast .toast-icon { font-size: 1.1rem; flex-shrink: 0; }
.app-toast.success .toast-icon { color: var(--success-green); }
.app-toast.error .toast-icon { color: var(--danger-red); }
.app-toast .toast-text { font-size: 0.88rem; font-weight: 500; color: var(--text-dark); }
@keyframes toastIn {
    from { transform: translateX(110%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

/* Responsive mobile */
@media (max-width: 768px) {
    .form-grid-2 { grid-template-columns: 1fr; }
    .dash-actions-grid { grid-template-columns: 1fr; }
    .search-bar-spa form { flex-direction: column; }
    .spa-form-card { padding: 16px; }
}
</style>


<!-- ================================================================
     JAVASCRIPT SPA — ROUTEUR + AJAX
     ================================================================ -->
<script>
// ── Données utilisateur injectées depuis PHP ──────────────────────────
const APP_STATE = {
    isLoggedIn: <?php echo $isLoggedIn ? 'true' : 'false'; ?>,
    userType: "<?php echo htmlspecialchars($userType); ?>",
    userName: "<?php echo htmlspecialchars($userName); ?>",
    userPrenom: "<?php echo htmlspecialchars($userObj['prenom'] ?? ''); ?>",
    isAdmin: <?php echo $isAdmin ? 'true' : 'false'; ?>
};
const API_URL = "api.php";

// ── Onglet actif ──────────────────────────────────────────────────────
let currentTab = "library";
let currentBook = null;

// ── NAVIGUER ENTRE LES ONGLETS ────────────────────────────────────────
function showTab(tabName) {
    // Masquer toutes les vues
    document.querySelectorAll(".view-section").forEach(v => v.classList.remove("active"));
    document.querySelectorAll(".tab-item").forEach(t => t.classList.remove("active"));

    // Mettre à jour le titre
    const titles = {
        library: "Bibliothèque",
        search: "Recherche avancée",
        favorites: "Mes Favoris",
        add_book: "Ajouter un livre",
        dashboard: APP_STATE.isAdmin ? "Admin Dashboard" : "Mon Dashboard",
        login: "Connexion",
        register: "Inscription",
        team: "L'Équipe"
    };
    document.getElementById("contentTitle").textContent = titles[tabName] || "BU SAMA";

    // Activer la bonne vue
    const viewEl = document.getElementById("view-" + tabName);
    if (viewEl) viewEl.classList.add("active");

    // Activer le bon onglet dans la liste
    const tabEl = document.querySelector(`.tab-item[data-tab="${tabName}"]`);
    if (tabEl) tabEl.classList.add("active");

    currentTab = tabName;

    // Charger les données si nécessaire
    if (tabName === "library") loadLibrary();
    if (tabName === "favorites") loadFavorites();
    if (tabName === "dashboard") loadDashboard();

    // Mobile : afficher le panneau de droite
    document.getElementById("appContainer").classList.add("show-content");
}

// ── RETOUR MOBILE ─────────────────────────────────────────────────────
function hideMobile() {
    document.getElementById("appContainer").classList.remove("show-content");
    closeDrawer();
}

// ── RECHERCHE RAPIDE SIDEBAR ──────────────────────────────────────────
document.getElementById("sidebarSearchInput").addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
        showTab("library");
        document.getElementById("searchInput").value = this.value;
        loadLibrary(this.value);
    }
});

// ── CHARGEMENT DE LA BIBLIOTHÈQUE ────────────────────────────────────
function loadLibrary(query = "") {
    const grid = document.getElementById("bookGrid");
    const status = document.getElementById("libraryStatus");
    grid.innerHTML = '<div class="loading-state"><i class="fa-solid fa-spinner fa-spin fa-2x"></i><p>Chargement...</p></div>';
    status.textContent = "";

    const url = query.trim()
        ? `${API_URL}?action=get_books&recherche=${encodeURIComponent(query.trim())}`
        : `${API_URL}?action=get_books`;

    fetch(url)
        .then(r => r.json())
        .then(data => {
            if (data.success && data.books.length > 0) {
                status.textContent = `${data.books.length} livre(s) trouvé(s)`;
                grid.innerHTML = data.books.map(b => renderBookCard(b)).join("");
            } else {
                status.textContent = "Aucun livre trouvé.";
                grid.innerHTML = `<div class="loading-state"><i class="fa-solid fa-book-open fa-2x" style="opacity:.3"></i><p>Aucun résultat.</p></div>`;
            }
        })
        .catch(() => {
            status.textContent = "Erreur de chargement.";
            grid.innerHTML = "";
        });
}

// ── RECHERCHE DEPUIS LA VUE BIBLIOTHÈQUE ─────────────────────────────
function searchBooks(e) {
    e.preventDefault();
    const q = document.getElementById("searchInput").value;
    loadLibrary(q);
}

// ── RENDU CARD LIVRE ──────────────────────────────────────────────────
function renderBookCard(book) {
    const imgSrc = book.image_couverture && book.image_couverture !== "default_cover.jpg"
        ? (book.image_couverture.startsWith("http") ? book.image_couverture : book.image_couverture)
        : null;
    const coverHTML = imgSrc
        ? `<img class="cover" src="${escHtml(imgSrc)}" alt="${escHtml(book.titre || '')}" onerror="this.parentElement.innerHTML='<div class=\\'placeholder\\'><i class=\\'fa-solid fa-book fa-2x\\'></i></div>'">`
        : `<div class="placeholder"><i class="fa-solid fa-book fa-2x"></i></div>`;
    return `
        <div class="spa-book-card" onclick="openDrawer(${JSON.stringify(book).replace(/'/g,"\\'")})" >
            ${coverHTML}
            <h4>${escHtml(book.titre || "")}</h4>
            <p>${escHtml(book.auteur || "")}</p>
            ${book.categorie ? `<p style="color:var(--green-medium);font-size:0.78rem;font-weight:600;margin-top:4px;"><i class="fa-solid fa-tag me-1"></i>${escHtml(book.categorie)}</p>` : ""}
        </div>`;
}

// ── TIROIR : OUVRIR ───────────────────────────────────────────────────
function openDrawer(book) {
    currentBook = book;
    const drawer = document.getElementById("detailDrawer");
    const body = document.getElementById("drawerBody");

    const imgSrc = book.image_couverture && book.image_couverture !== "default_cover.jpg"
        ? (book.image_couverture.startsWith("http") ? book.image_couverture : book.image_couverture)
        : null;

    const coverHTML = imgSrc
        ? `<img class="drawer-cover" src="${escHtml(imgSrc)}" alt="${escHtml(book.titre || "")}" onerror="this.outerHTML='<div class=\\'drawer-cover-placeholder\\'><i class=\\'fa-solid fa-book fa-4x\\'></i></div>'">`
        : `<div class="drawer-cover-placeholder"><i class="fa-solid fa-book fa-4x"></i><p style="margin-top:12px;font-weight:600;font-family:Outfit;">SAMA BIBLIO</p></div>`;

    const actionBtns = APP_STATE.isLoggedIn
        ? `<button class="drawer-actions" onclick="doEmprunter(${book.id})" style="flex:1;padding:12px;font-size:.9rem;font-weight:700;background:linear-gradient(135deg,var(--green-medium),var(--green-dark));color:white;border:none;border-radius:8px;cursor:pointer;">
               <i class="fa-solid fa-book-reader me-2"></i> Emprunter
           </button>
           <button onclick="doFavori(${book.id})" style="flex:1;padding:12px;font-size:.9rem;font-weight:700;background:#fff0f0;color:#c0392b;border:1.5px solid rgba(220,53,69,.2);border-radius:8px;cursor:pointer;">
               <i class="fa-solid fa-heart me-2"></i> Favori
           </button>`
        : `<button onclick="showTab('login')" style="flex:1;padding:12px;font-size:.9rem;font-weight:700;background:var(--green-light);color:var(--green-dark);border:none;border-radius:8px;cursor:pointer;">
               <i class="fa-solid fa-sign-in-alt me-2"></i> Connexion requise
           </button>`;

    body.innerHTML = `
        ${coverHTML}
        <h2>${escHtml(book.titre || "")}</h2>
        ${book.categorie ? `<span class="drawer-category-badge"><i class="fa-solid fa-tag me-1"></i>${escHtml(book.categorie)}</span>` : ""}
        <div class="drawer-info-grid">
            <div class="drawer-info-item"><strong>Auteur :</strong> ${escHtml(book.auteur || "—")}</div>
            <div class="drawer-info-item"><strong>ISBN :</strong> ${escHtml(book.isbn || "—")}</div>
            <div class="drawer-info-item"><strong>Éditeur :</strong> ${escHtml(book.editeur || "—")}</div>
            <div class="drawer-info-item"><strong>Année :</strong> ${escHtml(String(book.annee_publication || "—"))}</div>
            <div class="drawer-info-item"><strong>Langue :</strong> ${escHtml(book.langue || "—")}</div>
            <div class="drawer-info-item"><strong>Pages :</strong> ${escHtml(String(book.nombre_pages || "—"))}</div>
        </div>
        ${book.description ? `<div class="drawer-description">${escHtml(book.description)}</div>` : ""}
        <div style="display:flex;gap:10px;margin-top:1rem;">${actionBtns}</div>
    `;

    drawer.classList.add("open");
}

// ── TIROIR : FERMER ───────────────────────────────────────────────────
function closeDrawer() {
    document.getElementById("detailDrawer").classList.remove("open");
    currentBook = null;
}

// ── FAVORIS : CHARGER ─────────────────────────────────────────────────
function loadFavorites() {
    if (!APP_STATE.isLoggedIn) {
        document.getElementById("favoritesGrid").innerHTML = `
            <div class="loading-state">
                <i class="fa-solid fa-lock fa-2x" style="color:var(--text-light)"></i>
                <p>Connectez-vous pour voir vos favoris</p>
                <button class="btn-primary-spa mt-3" onclick="showTab('login')">Se connecter</button>
            </div>`;
        return;
    }
    document.getElementById("favoritesGrid").innerHTML = '<div class="loading-state"><i class="fa-solid fa-spinner fa-spin fa-2x"></i></div>';

    fetch(`${API_URL}?action=get_favorites`)
        .then(r => r.json())
        .then(data => {
            if (data.success && data.books.length > 0) {
                document.getElementById("favoritesStatus").textContent = `${data.books.length} favori(s)`;
                document.getElementById("favoritesGrid").innerHTML = data.books.map(b => renderBookCard(b)).join("");
            } else {
                document.getElementById("favoritesGrid").innerHTML = `
                    <div class="loading-state">
                        <i class="fa-regular fa-heart fa-2x" style="color:var(--text-light)"></i>
                        <p>Aucun favori pour l'instant</p>
                    </div>`;
            }
        });
}

// ── DASHBOARD : CHARGER ───────────────────────────────────────────────
function loadDashboard() {
    if (!APP_STATE.isLoggedIn) {
        document.getElementById("dashContent").innerHTML = `
            <div class="loading-state">
                <i class="fa-solid fa-lock fa-2x"></i>
                <p>Connexion requise</p>
                <button class="btn-primary-spa mt-3" onclick="showTab('login')">Se connecter</button>
            </div>`;
        return;
    }
    document.getElementById("dashContent").innerHTML = '<div class="loading-state"><i class="fa-solid fa-spinner fa-spin fa-2x"></i></div>';

    fetch(`${API_URL}?action=get_stats`)
        .then(r => r.json())
        .then(data => {
            if (!data.success) return;
            const u = data.user;
            const s = data.stats;
            const initial = (u.prenom || "U")[0].toUpperCase();

            let statsHTML = "";
            if (APP_STATE.isAdmin) {
                statsHTML = `
                    <div class="dash-stats-grid">
                        <div class="dash-stat-card green"><div class="dash-stat-icon"><i class="fa-solid fa-book"></i></div><div class="dash-stat-num">${s.total_livres}</div><div class="dash-stat-label">Livres au catalogue</div></div>
                        <div class="dash-stat-card gold"><div class="dash-stat-icon"><i class="fa-solid fa-users"></i></div><div class="dash-stat-num">${s.utilisateurs}</div><div class="dash-stat-label">Utilisateurs actifs</div></div>
                        <div class="dash-stat-card blue"><div class="dash-stat-icon"><i class="fa-solid fa-handshake-angle"></i></div><div class="dash-stat-num">${s.emprunts}</div><div class="dash-stat-label">Emprunts en cours</div></div>
                    </div>`;
            } else {
                statsHTML = `
                    <div class="dash-stats-grid">
                        <div class="dash-stat-card green"><div class="dash-stat-icon"><i class="fa-solid fa-book-reader"></i></div><div class="dash-stat-num">${s.emprunts}</div><div class="dash-stat-label">Livres empruntés</div></div>
                        <div class="dash-stat-card gold"><div class="dash-stat-icon"><i class="fa-solid fa-heart"></i></div><div class="dash-stat-num">${s.favoris}</div><div class="dash-stat-label">Livres favoris</div></div>
                        <div class="dash-stat-card purple"><div class="dash-stat-icon"><i class="fa-solid fa-bell"></i></div><div class="dash-stat-num">${s.notifications}</div><div class="dash-stat-label">Notifications</div></div>
                    </div>`;
            }

            document.getElementById("dashContent").innerHTML = `
                <div class="dash-user-card">
                    <div class="dash-user-avatar">${initial}</div>
                    <div class="dash-user-info">
                        <h3>${escHtml(u.prenom + " " + u.nom)}</h3>
                        <p><i class="fa-solid fa-envelope me-1"></i> ${escHtml(u.email)}</p>
                        <span class="dash-role-badge"><i class="fa-solid fa-shield-halved me-1"></i> ${escHtml(u.type_user)}</span>
                    </div>
                </div>
                ${statsHTML}
                <h3 style="font-family:Outfit;font-weight:700;color:var(--green-dark);margin-bottom:14px;font-size:1.05rem;">Actions rapides</h3>
                <div class="dash-actions-grid">
                    <button class="dash-action-btn" onclick="showTab('library')">
                        <i class="fa-solid fa-book-open" style="color:var(--green-medium)"></i>
                        <span>Bibliothèque</span>
                        <small>Parcourir le catalogue</small>
                    </button>
                    <button class="dash-action-btn" onclick="showTab('favorites')">
                        <i class="fa-solid fa-heart" style="color:#c0392b"></i>
                        <span>Mes favoris</span>
                        <small>Voir mes sélections</small>
                    </button>
                    <button class="dash-action-btn" onclick="showTab('add_book')">
                        <i class="fa-solid fa-plus-circle" style="color:var(--gold-hover)"></i>
                        <span>Ajouter un livre</span>
                        <small>Enrichir le catalogue</small>
                    </button>
                    <button class="dash-action-btn" onclick="showTab('search')">
                        <i class="fa-solid fa-magnifying-glass" style="color:var(--blue-star)"></i>
                        <span>Recherche avancée</span>
                        <small>Filtres précis</small>
                    </button>
                </div>`;
        });
}

// ── EMPRUNTER ─────────────────────────────────────────────────────────
function doEmprunter(docId) {
    postAction(`${API_URL}?action=emprunter`, { document_id: docId })
        .then(data => showToast(data.success, data.message));
}

// ── AJOUTER AUX FAVORIS ───────────────────────────────────────────────
function doFavori(docId) {
    postAction(`${API_URL}?action=favori`, { document_id: docId })
        .then(data => showToast(data.success, data.message));
}

// ── CONNEXION ─────────────────────────────────────────────────────────
function doLogin(e) {
    e.preventDefault();
    const fd = new FormData(e.target);
    postFormData(`${API_URL}?action=login`, fd)
        .then(data => {
            if (data.success) {
                showToast(true, "Connexion réussie ! Rechargement...");
                setTimeout(() => location.reload(), 1200);
            } else {
                document.getElementById("loginMsg").innerHTML =
                    `<div class="inline-alert error"><i class="fa-solid fa-circle-xmark"></i> ${escHtml(data.message)}</div>`;
            }
        });
}

// ── INSCRIPTION ───────────────────────────────────────────────────────
function doRegister(e) {
    e.preventDefault();
    const fd = new FormData(e.target);
    postFormData(`${API_URL}?action=register`, fd)
        .then(data => {
            const cls = data.success ? "success" : "error";
            const icon = data.success ? "fa-circle-check" : "fa-circle-xmark";
            document.getElementById("registerMsg").innerHTML =
                `<div class="inline-alert ${cls}"><i class="fa-solid ${icon}"></i> ${escHtml(data.message)}</div>`;
            if (data.success) {
                e.target.reset();
                setTimeout(() => showTab("login"), 2000);
            }
        });
}

// ── DÉCONNEXION ───────────────────────────────────────────────────────
function doLogout() {
    fetch(`${API_URL}?action=logout`)
        .then(() => {
            showToast(true, "Déconnexion réussie...");
            setTimeout(() => location.reload(), 1000);
        });
}

// ── RECHERCHE AVANCÉE ─────────────────────────────────────────────────
function advancedSearch(e) {
    e.preventDefault();
    const fd = new FormData(e.target);
    const status = document.getElementById("advSearchStatus");
    const results = document.getElementById("advSearchResults");
    status.textContent = "Recherche en cours...";
    results.innerHTML = '<div class="loading-state"><i class="fa-solid fa-spinner fa-spin"></i></div>';

    postFormData(`${API_URL}?action=advanced_search`, fd)
        .then(data => {
            if (data.success && data.books.length > 0) {
                status.textContent = `${data.books.length} résultat(s)`;
                results.innerHTML = data.books.map(b => renderBookCard(b)).join("");
            } else {
                status.textContent = "Aucun résultat.";
                results.innerHTML = "";
            }
        });
}

// ── AJOUTER UN LIVRE ─────────────────────────────────────────────────
function addBook(e) {
    e.preventDefault();
    if (!APP_STATE.isLoggedIn) {
        showTab("login");
        return;
    }
    const fd = new FormData(e.target);
    postFormData(`${API_URL}?action=add_book`, fd)
        .then(data => {
            showToast(data.success, data.message);
            if (data.success) {
                e.target.reset();
                setTimeout(() => { showTab("library"); loadLibrary(); }, 1500);
            }
        });
}

// ── TOASTS ────────────────────────────────────────────────────────────
function showToast(isSuccess, msg) {
    const container = document.getElementById("toastContainer");
    const toast = document.createElement("div");
    toast.className = `app-toast ${isSuccess ? "success" : "error"}`;
    toast.innerHTML = `
        <i class="fa-solid ${isSuccess ? "fa-circle-check" : "fa-circle-xmark"} toast-icon"></i>
        <span class="toast-text">${escHtml(msg)}</span>`;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = "none";
        toast.style.opacity = "0";
        toast.style.transition = "opacity 0.4s";
        setTimeout(() => toast.remove(), 450);
    }, 3500);
}

// ── HELPERS ───────────────────────────────────────────────────────────
function escHtml(str) {
    return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function postAction(url, data) {
    const fd = new FormData();
    Object.entries(data).forEach(([k, v]) => fd.append(k, v));
    return fetch(url, { method: "POST", body: fd }).then(r => r.json());
}

function postFormData(url, fd) {
    return fetch(url, { method: "POST", body: fd }).then(r => r.json());
}

// ── INIT ──────────────────────────────────────────────────────────────
window.addEventListener("DOMContentLoaded", () => {
    showTab("library");
});
</script>
</body>
</html>