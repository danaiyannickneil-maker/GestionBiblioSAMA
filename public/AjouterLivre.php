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

    $message = $result ? "Livre ajoute avec succes." : "Erreur lors de l'ajout.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Livre</title>
    <?php include(__DIR__ . "/../includes/header.php"); ?>
</head>
<body>
    <header>
        <h1>Ajouter un livre</h1>
    </header>

    <section>
        <button type="button" class="btn-nav secondary" onclick="history.back()">Retour</button>
        <button type="button" class="btn-nav" onclick="window.location.href='Biblio.php'">Bibliotheque</button>
    </section>

    <section class="form-container">
        <?php if (!$isLoggedIn): ?>
            <div class="auth-required">
                <h2>Connexion requise</h2>
                <p>Vous devez vous connecter ou creer un compte pour ajouter un livre.</p>
                <div class="auth-actions">
                    <button class="btn-nav" onclick="window.location.href='login.php'">Se connecter</button>
                    <button class="btn-nav secondary" onclick="window.location.href='register.php'">S'inscrire</button>
                </div>
            </div>
        <?php else: ?>
            <?php if ($message): ?>
                <div class="alert <?php echo str_contains($message, 'succes') ? 'alert-success' : 'alert-error'; ?>"><?php echo htmlspecialchars($message); ?></div>
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
                    <input type="text" id="editeur" name="editeur" placeholder="Entrez le nom de l'editeur">
                </div>

                <div class="form-group">
                    <label for="annee">Annee de publication</label>
                    <input type="number" id="annee" name="annee" min="1000" max="2100" placeholder="YYYY">
                </div>

                <div class="form-group">
                    <label for="categorie">Categorie</label>
                    <input type="text" id="categorie" name="categorie" placeholder="Ex: Fiction, Science, Histoire...">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Entrez une description du livre"></textarea>
                </div>

                <div class="form-group">
                    <label for="nb_pages">Nombre de pages</label>
                    <input type="number" id="nb_pages" name="nb_pages" min="1" placeholder="300">
                </div>

                <div class="form-group">
                    <label for="langue">Langue</label>
                    <input type="text" id="langue" name="langue" placeholder="Ex: Francais, Anglais...">
                </div>

                <div class="form-group">
                    <label for="image">Image de couverture</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>

                <button type="submit" class="btn-submit">Ajouter le livre</button>
            </form>
        <?php endif; ?>
    </section>
    <?php include(__DIR__ . "/../includes/footer.php"); ?>
</body>
</html>
