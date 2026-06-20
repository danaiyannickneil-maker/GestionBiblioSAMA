<?php
session_start();
require_once(__DIR__ . "/../services/LivreService.php");

$message = "";
$isLoggedIn = !empty($_SESSION["user_id"]);

if ($isLoggedIn && $_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = $_POST["titre"] ?? "";
    $auteur = $_POST["auteur"] ?? "";
    $isbn = $_POST["isbn"] ?? "";
    $editeur = $_POST["editeur"] ?? "";
    $annee_publication = $_POST["annee"] ?? "";
    $categorie = $_POST["categorie"] ?? "";
    $description = $_POST["description"] ?? "";
    $nb_pages = $_POST["nb_pages"] ?? "";
    $langue = $_POST["langue"] ?? "";

    $image = null;
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = __DIR__ . "/../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $safeName = uniqid("cover_", true) . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $safeName;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = "../uploads/" . $safeName;
        }
    }

    $service = new LivreService();
    $result = $service->ajouterLivre($titre, $auteur, $isbn, $editeur, $annee_publication, $categorie, $description, $nb_pages, $langue, $image);

    $message = $result ? "Livre ajouté avec succès." : "Erreur lors de l'ajout.";
}

// Déterminer dynamiquement le lien de retour
$backLink = "Biblio.php";
if ($isLoggedIn && !empty($_SESSION["type_user"])) {
    $backLink = in_array($_SESSION["type_user"], ["admin", "bibliothecaire"], true) ? "DashAdmin.php" : "DashUser.php";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Livre - BU SAMA</title>
    <?php include(__DIR__ . "/../includes/header.php"); ?>
</head>
<body>

    <?php include(__DIR__ . "/../includes/navbar.php"); ?>

    <section class="container my-4">
        
        <div class="form-container">
            <a href="<?php echo htmlspecialchars($backLink); ?>" class="back-link">
                <i class="fa-solid fa-arrow-left me-1"></i> Retour au Dashboard
            </a>

            <?php if (!$isLoggedIn): ?>
                <div class="auth-required text-center py-4">
                    <i class="fa-solid fa-lock fa-3x text-gold mb-3"></i>
                    <h2 class="mb-2">Connexion requise</h2>
                    <p class="text-muted">Vous devez vous connecter ou créer un compte pour ajouter un livre au catalogue.</p>
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <a href="login.php" class="btn btn-action-primary"><i class="fa-solid fa-sign-in-alt me-1"></i> Se connecter</a>
                        <a href="register.php" class="btn btn-action-secondary"><i class="fa-solid fa-user-plus me-1"></i> S'inscrire</a>
                    </div>
                </div>
            <?php else: ?>
                
                <h2 class="mb-4" style="color: var(--green-dark); font-family: 'Outfit'; font-weight: 700;">
                    <i class="fa-solid fa-square-plus me-2 text-gold"></i> Ajouter un livre au catalogue
                </h2>

                <?php if ($message): ?>
                    <div class="alert <?php echo str_contains($message, 'succès') ? 'alert-success' : 'alert-danger'; ?> shadow-sm">
                        <i class="fa-solid <?php echo str_contains($message, 'succès') ? 'fa-circle-check' : 'fa-triangle-exclamation'; ?> me-2"></i>
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="AjouterLivre.php" enctype="multipart/form-data" class="form-add-livre">
                    <div class="form-group">
                        <label for="titre">Titre *</label>
                        <input type="text" id="titre" name="titre" required placeholder="Entrez le titre du livre">
                    </div>

                    <div class="form-group">
                        <label for="auteur">Auteur *</label>
                        <input type="text" id="auteur" name="auteur" required placeholder="Entrez le nom de l'auteur">
                    </div>

                    <div class="form-group">
                        <label for="isbn">ISBN *</label>
                        <input type="text" id="isbn" name="isbn" required placeholder="Entrez le code ISBN">
                    </div>

                    <div class="form-group">
                        <label for="editeur">Editeur</label>
                        <input type="text" id="editeur" name="editeur" placeholder="Entrez le nom de l'éditeur">
                    </div>

                    <div class="form-group">
                        <label for="annee">Année de publication</label>
                        <input type="number" id="annee" name="annee" min="1000" max="2100" placeholder="YYYY">
                    </div>

                    <div class="form-group">
                        <label for="categorie">Catégorie</label>
                        <input type="text" id="categorie" name="categorie" placeholder="Ex: Informatique, Sciences, Roman...">
                    </div>

                    <div class="form-group">
                        <label for="nb_pages">Nombre de pages</label>
                        <input type="number" id="nb_pages" name="nb_pages" min="1" placeholder="Ex: 300">
                    </div>

                    <div class="form-group">
                        <label for="langue">Langue</label>
                        <input type="text" id="langue" name="langue" placeholder="Ex: Français, Anglais...">
                    </div>

                    <div class="form-group full-width">
                        <label for="image">Image de couverture</label>
                        <input type="file" id="image" name="image" accept="image/*" class="form-control">
                    </div>

                    <div class="form-group full-width">
                        <label for="description">Description / Résumé</label>
                        <textarea id="description" name="description" rows="4" placeholder="Entrez une brève description du livre..."></textarea>
                    </div>

                    <button type="submit" class="btn-submit"><i class="fa-solid fa-plus me-1"></i> Ajouter le livre</button>
                </form>
            <?php endif; ?>
        </div>
    </section>

    <?php include(__DIR__ . "/../includes/footer.php"); ?>
</body>
</html>
