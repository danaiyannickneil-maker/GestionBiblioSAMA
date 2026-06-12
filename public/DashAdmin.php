<?php
// Dashboard admin UI
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrateur</title>
    <?php include("../includes/header.php"); ?>
</head>
<body>
    <header>
        <h1>Dashboard Administrateur</h1>
    </header>

    <nav>
        <ul>
            <li><button class="btn-nav" onclick="window.location.href='Biblio.php'">Bibliothèque</button></li>
            <li><button class="btn-nav secondary" onclick="window.location.href='AjouterLivre.php'">Ajouter un livre</button></li>
            <li><button class="btn-nav secondary" onclick="window.location.href='SearchAvancé.php'">Recherche avancée</button></li>
            <li><button class="btn-nav secondary" onclick="window.location.href='DashUser.php'">Dashboard utilisateur</button></li>
        </ul>
    </nav>

    <section class="dashboard-overview">
        <article class="dash-card">
            <h3>Total des livres</h3>
            <p>125</p>
            <small>Nombre d’articles disponibles</small>
        </article>
        <article class="dash-card">
            <h3>Utilisateurs</h3>
            <p>42</p>
            <small>Comptes actifs</small>
        </article>
        <article class="dash-card">
            <h3>Emprunts</h3>
            <p>18</p>
            <small>Livres en circulation</small>
        </article>
    </section>

    <section class="dashboard-actions">
        <div class="dashboard-panel">
            <h2>Ajout rapide de livre</h2>
            <form class="dashboard-form">
                <div class="form-group">
                    <label for="admin-titre">Titre</label>
                    <input id="admin-titre" type="text" placeholder="Titre du livre">
                </div>
                <div class="form-group">
                    <label for="admin-auteur">Auteur</label>
                    <input id="admin-auteur" type="text" placeholder="Nom de l'auteur">
                </div>
                <div class="form-group">
                    <label for="admin-isbn">ISBN</label>
                    <input id="admin-isbn" type="text" placeholder="ISBN">
                </div>
                <button type="submit" class="btn-submit">Ajouter</button>
            </form>
        </div>

        <div class="dashboard-panel">
            <h2>Créer un utilisateur</h2>
            <form class="dashboard-form">
                <div class="form-group">
                    <label for="admin-nom">Nom</label>
                    <input id="admin-nom" type="text" placeholder="Nom">
                </div>
                <div class="form-group">
                    <label for="admin-prenom">Prénom</label>
                    <input id="admin-prenom" type="text" placeholder="Prénom">
                </div>
                <div class="form-group">
                    <label for="admin-email">Email</label>
                    <input id="admin-email" type="email" placeholder="Email">
                </div>
                <button type="submit" class="btn-submit">Créer</button>
            </form>
        </div>
    </section>

    <?php include("../includes/footer.php"); ?>
</body>
</html>
