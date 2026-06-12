<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SearchAvancé</title>
</head>
<body>
   <form method="post" action="SearchAvancé.php" enctype="multipart/form-data">
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

        <button type="submit">Cherche</button>
    </form>
     <?php include("../includes/footer.php"); ?>
</body>
</html>