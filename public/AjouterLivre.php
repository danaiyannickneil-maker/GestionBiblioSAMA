<?php
require_once("../services/LivreService.php");

$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = $_POST["titre"];
    $auteur = $_POST["auteur"];
    $isbn = $_POST["isbn"];
    $editeur = $_POST["editeur"];
    $annee_publication = $_POST["annee"];
    $categorie_id = $_POST["categorie"];
    $description = $_POST["description"];
    $nb_pages = $_POST["nb_pages"];
    $langue = $_POST["langue"];

    // Gestion de l'image uploadée
    $image = null;
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $targetFile;
        }
    }

    $service = new LivreService();
    $result = $service->ajouterLivre($titre, $auteur, $isbn, $editeur, $annee_publication, $categorie_id, $description, $nb_pages, $langue, $image);

    $message = $result ? "✅ Livre ajouté avec succès !" : "❌ Erreur lors de l'ajout.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Livre</title>
    <?php include("../includes/header.php"); ?>
</head>
<body>
    <header>
        <h1>📚 Ajouter un Livre à la Bibliothèque</h1>
    </header>
    <section class="form-container">
        <?php if ($message): ?>
            <div class="alert <?php echo strpos($message, '✅') !== false ? 'alert-success' : 'alert-error'; ?>"><?php echo $message; ?></div>
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
                <label for="editeur">Éditeur</label>
                <input type="text" id="editeur" name="editeur" placeholder="Entrez le nom de l'éditeur">
            </div>

            <div class="form-group">
                <label for="annee">Année de publication</label>
                <input type="number" id="annee" name="annee" min="1000" max="2100" placeholder="YYYY">
            </div>

            <div class="form-group">
                <label for="categorie">Catégorie</label>
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
                <input type="text" id="langue" name="langue" placeholder="Ex: Français, Anglais...">
            </div>

            <div class="form-group">
                <label for="image">Image de couverture</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            <button type="submit" class="btn-submit">✓ Ajouter le Livre</button>
        </form>
    </section>
</body>
</html>
