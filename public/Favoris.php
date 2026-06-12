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
    <title>Mes favoris</title>
    <?php include(__DIR__ . "/../includes/header.php"); ?>
</head>
<body>
    <header>
        <h1>Mes favoris</h1>
    </header>

    <section>
        <button type="button" class="btn-nav secondary" onclick="history.back()">Retour</button>
        <button type="button" class="btn-nav" onclick="window.location.href='Biblio.php'">Bibliotheque</button>
    </section>

    <section id="resultats">
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <p class="result-message"><?php echo count($livres) > 0 ? count($livres) . " favori(s)." : "Vous n'avez pas encore de favoris."; ?></p>
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
