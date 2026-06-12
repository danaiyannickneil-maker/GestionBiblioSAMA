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
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>📚 Ajouter un Livre</h1>

    <form method="post" action="AjouterLivre.php" enctype="multipart/form-data">
        <label>Titre :</label>
        <input type="text" name="titre" required><br><br>

        <label>Auteur :</label>
        <input type="text" name="auteur" required><br><br>

        <label>ISBN :</label>
        <input type="text" name="isbn" required><br><br>

        <label>Éditeur :</label>
        <input type="text" name="editeur"><br><br>

        <label>Année de publication :</label>
        <input type="number" name="annee" min="1000" max="2100"><br><br>

        <label>Catégorie :</label>
        <input type="text" name="categorie"><br><br>

        <label>Description :</label>
        <textarea name="description"></textarea><br><br>

        <label>Nombre de pages :</label>
        <input type="number" name="nb_pages" min="1"><br><br>

        <label>Langue :</label>
        <input type="text" name="langue"><br><br>

        <label>Image de couverture :</label>
        <input type="file" name="image" accept="image/*"><br><br>

        <button type="submit">Ajouter</button>
    </form>

    <p style="color:green;"><?php echo $message; ?></p>
</body>
</html>
