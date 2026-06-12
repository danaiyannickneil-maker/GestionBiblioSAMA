<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Bibliothèque Universitaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <?php include("../includes/header.php"); ?>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
<div class="container mt-5 mb-5" style="max-width: 480px;">
    <div class="card shadow-lg">
        <div class="card-header">
            <img src="../assets/image/Logo.png" alt="Logo Bibliothèque" class="login-logo">
            <h4>Bibliothèque Universitaire</h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="email">Adresse Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="exemple@univ.fr" required>
                </div>
                <div class="mb-4">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" id="mdp" name="mdp" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>