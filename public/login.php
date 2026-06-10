<?php
 session_start();
 require_once '../config/databse.php';

 if ($_SERVER['REQUEST_METHOD'] === 'POST')
    $NOM = $_POST['Nom'];
    $MDP = $_POST['MDP'];

    //$stmt = $db->prepare("SELECT * FROM utilisateurs WHERE identifiant = ?");
    //$stmt->execute([$Nom]);
    //$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Gestion Bibliothèque</title>
</head>
<body>
    <h3>Connexion Bibliothèque</h3>
    <form method="post">
        <label>Nom :</label> <input type="text" name="Nom">
         <label>Mot de passe :</label> <input type="password" name="MDP">
    </form>

</body>
</html>