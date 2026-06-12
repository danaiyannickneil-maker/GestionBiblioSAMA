<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>L'Équipe de Développement - Bibliothèque Universitaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <?php include("../includes/header.php"); ?>
    <link rel="stylesheet" href="../assets/css/Biblio.css">
    <link rel="stylesheet" href="../assets/css/developeurs.css">
</head>
<body>

    <header class="dev-header">
        <img src="../assets/image/Logo.png" alt="Logo Bibliothèque" class="logo-site">
        <h1>Bibliothèque Universitaire</h1>
    </header>

    <nav>
        <ul>
            <li><button class="btn-nav" onclick="window.location.href='biblio.php'">Accueil / Recherche</button></li>
            <li><button class="btn-nav" onclick="window.location.href='AjouterLivre.php'">Ajouter un livre</button></li>
            <li><button class="btn-nav active-page" onclick="window.location.href='developpeurs.php'">L'Équipe</button></li>
        </ul>
    </nav>

    <main class="container my-5">
        <div class="text-center mb-5">
            <h2 class="section-title">Les Développeurs de l'Application</h2>
            <p class="section-subtitle">Trois étudiants passionnés derrière la conception de cette plateforme de gestion documentaire.</p>
            <div class="dev-separator"></div>
        </div>

        <div class="row g-4 justify-content-center">
            
            <div class="col-md-4 col-sm-6">
                <div class="card dev-card shadow-sm h-100">
                    <div class="dev-avatar-container">
                        <div class="dev-avatar">
                            <img src="../assets/image/dev1.jpg" alt="Photo de Développeur 1">
                        </div> 
                    </div>
                    <div class="card-body text-center">
                        <h4 class="dev-name">Développeur 1</h4>
                        <p class="dev-role">Chef de Projet & Back-End</p>
                        <p class="dev-bio">Gestion de la base de données SQL, de la logique PHP et de l'architecture des services.</p>
                        <div class="dev-links">
                            <a href="#" target="_blank" class="dev-link">GitHub</a>
                            <a href="#" target="_blank" class="dev-link">LinkedIn</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="card dev-card shadow-sm h-100">
                    <div class="dev-avatar-container">
                        <div class="dev-avatar">
                            <img src="../assets/image/dev2.jpg" alt="Photo de Développeur 2">
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h4 class="dev-name">Développeur 2</h4>
                        <p class="dev-role">Designer UI/UX & Front-End</p>
                        <p class="dev-bio">Intégration des maquettes, création du design système CSS basé sur l'identité du logo.</p>
                        <div class="dev-links">
                            <a href="#" target="_blank" class="dev-link">GitHub</a>
                            <a href="#" target="_blank" class="dev-link">LinkedIn</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="card dev-card shadow-sm h-100">
                    <div class="dev-avatar-container">
                        <div class="dev-avatar">
                            <img src="../assets/image/dev3.jpg" alt="Photo de Développeur 3">
                        </div> 
                    </div>
                    <div class="card-body text-center">
                        <h4 class="dev-name">Développeur 3</h4>
                        <p class="dev-role">Développeur Full-Stack</p>
                        <p class="dev-bio">Connexion des formulaires PHP avec le visuel, sécurité des sessions et tests applicatifs.</p>
                        <div class="dev-links">
                            <a href="#" target="_blank" class="dev-link">GitHub</a>
                            <a href="#" target="_blank" class="dev-link">LinkedIn</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php include("../includes/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>