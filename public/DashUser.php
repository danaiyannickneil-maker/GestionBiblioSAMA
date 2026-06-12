<?php
// Dashboard utilisateur UI
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Utilisateur</title>
    <?php include("../includes/header.php"); ?>
    
</head>
<body>
    <header>
        <h1>Dashboard Utilisateur</h1>
    </header>

    <nav>
        <ul>
            <li><button class="btn-nav" onclick="window.location.href='Biblio.php'">Bibliothèque</button></li>
            <li><button class="btn-nav secondary" onclick="window.location.href='SearchAvancé.php'">Recherche avancée</button></li>
            <li><button class="btn-nav secondary" onclick="window.location.href='AjouterLivre.php'">Ajouter un livre</button></li>
        </ul>
    </nav>

    <section class="dashboard-overview">
        <article class="dash-card">
            <h3>Livres empruntés</h3>
            <p>5</p>
            <small>En cours de lecture</small>
        </article>
        <article class="dash-card">
            <h3>Livres favoris</h3>
            <p>12</p>
            <small>Sélection personnelle</small>
        </article>
        <article class="dash-card">
            <h3>Notifications</h3>
            <p>3</p>
            <small>Rappels disponibles</small>
        </article>
    </section>

    <section class="dashboard-actions">
        <div class="dashboard-panel">
            <h2>Mon profil</h2>
            <form class="dashboard-form">
                <div class="form-group">
                    <label for="user-nom">Nom</label>
                    <input id="user-nom" type="text" placeholder="Nom" value="Exemple">
                </div>
                <div class="form-group">
                    <label for="user-email">Email</label>
                    <input id="user-email" type="email" placeholder="Email" value="user@example.com">
                </div>
                <button type="submit" class="btn-submit">Mettre à jour</button>
            </form>
        </div>

        <div class="dashboard-panel">
            <h2>Actions rapides</h2>
            <div class="action-list">
                <button class="btn-nav secondary" onclick="window.location.href='SearchAvancé.php'">Rechercher</button>
                <button class="btn-nav secondary" onclick="window.location.href='AjouterLivre.php'">Ajouter livre</button>
                <button class="btn-nav secondary" onclick="window.location.href='Biblio.php'">Voir la bibliothèque</button>
            </div>
        </div>
    </section>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
