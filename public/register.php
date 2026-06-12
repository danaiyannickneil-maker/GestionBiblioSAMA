<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Gestion Bibliothèque</title>
  
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/css/image/register.css">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 480px;">
    <div class="card shadow">
        <div class="card-header text-center">
               <h4>📚 Gestion Bibliothèque</h4>
        </div>
 <div class="card-body">
 <form method="POST">
 <div class="mb-3">
    <label>Nom</label>
    <input type="text" name="nom" class="form-control" required>
     </div>
    <div class="mb-3">
     <label>Prénom</label>
      <input type="text" name="prenom" class="form-control" required>
     </div>
    
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Mot de passe</label>
                    <input type="password" name="mdp" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="mdp2" class="form-control" required>
                </div>
                <button type="submit" class="btn w-100">S'inscrire</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>