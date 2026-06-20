<?php
session_start();
require_once(__DIR__ . "/../services/EmpruntService.php");

if (empty($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$service = new EmpruntService();
$actionPage = "Favoris.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["action_livre"]) && !empty($_POST["document_id"])) {
    if ($_POST["action_livre"] === "emprunter") {
        $result = $service->emprunterLivre($_SESSION["user_id"], $_POST["document_id"]);
        $message = $result["message"];
    }
}

$livres = $service->listerFavoris($_SESSION["user_id"]);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes favoris - BU SAMA</title>
    <?php include(__DIR__ . "/../includes/header.php"); ?>
</head>
<body>

    <?php include(__DIR__ . "/../includes/navbar.php"); ?>

    <section class="container my-4">
        
        <a href="DashUser.php" class="back-link">
            <i class="fa-solid fa-arrow-left me-1"></i> Retour au Dashboard
        </a>

        <h2 class="mb-4" style="color: var(--green-dark); font-family: 'Outfit'; font-weight: 700;">
            <i class="fa-solid fa-heart me-2 text-danger"></i> Mes livres favoris
        </h2>

        <?php if ($message): ?>
            <div class="alert alert-success shadow-sm">
                <i class="fa-solid fa-circle-check me-2"></i> <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="alert alert-success bg-light text-dark shadow-sm py-3 mb-4">
            <i class="fa-solid fa-info-circle me-2 text-success-green"></i> 
            <?php echo count($livres) > 0 ? "Vous avez " . count($livres) . " livre(s) dans votre sélection." : "Vous n'avez pas encore de favoris. Parcourez la bibliothèque pour en ajouter."; ?>
        </div>

        <?php if (!empty($livres)): ?>
            <div class="result-grid">
                <?php foreach ($livres as $livre): ?>
                    <?php include(__DIR__ . "/../includes/livre_card.php"); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <?php include(__DIR__ . "/../includes/footer.php"); ?>
</body>
</html>
