<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>L'Équipe de Développement - BU SAMA</title>
    <?php include("../includes/header.php"); ?>
    <link rel="stylesheet" href="../assets/css/developeurs.css">
</head>
<body>

    <?php include("../includes/navbar.php"); ?>

    <main class="container my-5">
        <div class="text-center mb-5">
            <h2 class="section-title" style="color: var(--green-dark); font-family: 'Outfit'; font-weight: 700;">Les Développeurs de l'Application</h2>
            <p class="section-subtitle text-muted">Trois étudiants passionnés derrière la conception de cette plateforme moderne de gestion documentaire.</p>
            <div class="dev-separator" style="background: linear-gradient(90deg, var(--gold) 0%, var(--green-medium) 100%);"></div>
        </div>

        <div class="row g-4 justify-content-center">
            
            <!-- Développeur 1 -->
            <div class="col-md-4 col-sm-6">
                <div class="card dev-card shadow-sm h-100 border-0">
                    <div class="dev-avatar-container" style="background: linear-gradient(135deg, var(--green-light) 0%, #d8eae1 100%);">
                        <div class="dev-avatar" style="border: 3px solid var(--gold);">
                            <img src="../assets/image/dev1.jpg" alt="Photo de Jokias Knight" onerror="this.src='https://cdn-icons-png.flaticon.com/512/3135/3135715.png'">
                        </div> 
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <div>
                            <h4 class="dev-name" style="color: var(--green-dark); font-weight: 700;">Jokias Knight</h4>
                            <p class="dev-role" style="color: var(--green-medium); font-weight: 600;">Chef de Projet & Back-End</p>
                            <p class="dev-bio text-muted small">Gestion de la base de données SQL, de la logique PHP et de l'architecture robuste des services de l'application.</p>
                        </div>
                        <div class="dev-links mt-3">
                            <a href="#" target="_blank" class="dev-link"><i class="fa-brands fa-github me-1"></i> GitHub</a>
                            <a href="#" target="_blank" class="dev-link"><i class="fa-brands fa-linkedin me-1 text-primary"></i> LinkedIn</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Développeur 2 -->
            <div class="col-md-4 col-sm-6">
                <div class="card dev-card shadow-sm h-100 border-0">
                    <div class="dev-avatar-container" style="background: linear-gradient(135deg, var(--green-light) 0%, #d8eae1 100%);">
                        <div class="dev-avatar" style="border: 3px solid var(--gold);">
                            <img src="../assets/image/dev2.jpg" alt="Photo de Lésita -wp" onerror="this.src='https://cdn-icons-png.flaticon.com/512/3135/3135768.png'">
                        </div>
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <div>
                            <h4 class="dev-name" style="color: var(--green-dark); font-weight: 700;">Lésita -wp</h4>
                            <p class="dev-role" style="color: var(--green-medium); font-weight: 600;">Designer UI/UX & Front-End</p>
                            <p class="dev-bio text-muted small">Intégration minutieuse des maquettes, création du design système CSS basé sur la charte graphique du logo.</p>
                        </div>
                        <div class="dev-links mt-3">
                            <a href="#" target="_blank" class="dev-link"><i class="fa-brands fa-github me-1"></i> GitHub</a>
                            <a href="#" target="_blank" class="dev-link"><i class="fa-brands fa-linkedin me-1 text-primary"></i> LinkedIn</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Développeur 3 -->
            <div class="col-md-4 col-sm-6">
                <div class="card dev-card shadow-sm h-100 border-0">
                    <div class="dev-avatar-container" style="background: linear-gradient(135deg, var(--green-light) 0%, #d8eae1 100%);">
                        <div class="dev-avatar" style="border: 3px solid var(--gold);">
                            <img src="../assets/image/dev3.jpg" alt="Photo de BlackZheuss" onerror="this.src='https://cdn-icons-png.flaticon.com/512/4086/4086679.png'">
                        </div> 
                    </div>
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <div>
                            <h4 class="dev-name" style="color: var(--green-dark); font-weight: 700;">BlackZheuss ♠</h4>
                            <p class="dev-role" style="color: var(--green-medium); font-weight: 600;">Développeur Full-Stack</p>
                            <p class="dev-bio text-muted small">Connexion des formulaires PHP avec le visuel interactif, sécurité renforcée des sessions et phases de tests applicatifs.</p>
                        </div>
                        <div class="dev-links mt-3">
                            <a href="#" target="_blank" class="dev-link"><i class="fa-brands fa-github me-1"></i> GitHub</a>
                            <a href="#" target="_blank" class="dev-link"><i class="fa-brands fa-linkedin me-1 text-primary"></i> LinkedIn</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php include("../includes/footer.php"); ?>
</body>
</html>