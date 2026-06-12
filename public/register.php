<?php
session_start();
require_once(__DIR__ . "/../services/UserServices.php");

$message = "";
$messageClass = "danger";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $service = new UserServices();
    $result = $service->inscrire(
        $_POST["email"] ?? "",
        $_POST["mdp"] ?? "",
        $_POST["mdp2"] ?? "",
        $_POST["nom"] ?? "",
        $_POST["prenom"] ?? ""
    );

    $message = $result["message"];
    $messageClass = $result["success"] ? "success" : "danger";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Gestion Bibliotheque</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <?php include(__DIR__ . "/../includes/header.php"); ?>
    <link rel="stylesheet" href="../assets/css/register.css">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 480px;">
    <button type="button" class="btn btn-secondary mb-3" onclick="history.back()">Retour</button>
    <div class="card shadow">
        <div class="card-header text-center">
            <h4>Gestion Bibliotheque</h4>
        </div>
        <div class="card-body">
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageClass; ?>"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label>Nom</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Prenom</label>
                    <input type="text" name="prenom" class="form-control" required>
                </div>
                <div class="mb-3">
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
                <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
            </form>
            <p class="text-center mt-3 mb-0">Deja un compte ? <a href="login.php">Se connecter</a></p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
