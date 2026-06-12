
<?php
session_start();
require_once(__DIR__ . "/../services/UserServices.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $service = new UserServices();
    $result = $service->connecter($_POST["email"] ?? "", $_POST["mdp"] ?? "");

    if ($result["success"]) {
        $_SESSION["user"] = $result["user"];
        $_SESSION["user_id"] = $result["user"]["id"];
        $_SESSION["type_user"] = $result["user"]["type_user"];

        $destination = in_array($result["user"]["type_user"], ["admin", "bibliothecaire"], true)
            ? "DashAdmin.php"
            : "DashUser.php";
        header("Location: " . $destination);
        exit;
    }

    $message = $result["message"];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Bibliothèque Universitaire</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <?php include(__DIR__ . "/../includes/header.php"); ?>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>
<div class="container mt-5 mb-5" style="max-width: 480px;">
    <div class="card shadow-lg">
        <div class="card-header">
            <img src="../assets/image/Logo.png" alt="Logo Bibliothèque" class="login-logo">
            <h4>Bibliothèque Universitaire</h4>

<body class="bg-light">
<div class="container mt-5" style="max-width: 480px;">
    <button type="button" class="btn btn-secondary mb-3" onclick="history.back()">Retour</button>
    <div class="card shadow">
        <div class="card-header text-center">
            <h4>Gestion Bibliotheque</h4>

        </div>
        <div class="card-body">
            <?php if ($message): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
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
            <p class="text-center mt-3 mb-0">Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
