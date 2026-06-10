<?php
 session_start();
 require_once '../config/databse.php';

 if ($_SERVER[''])
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
         <label>Prénom :</label> <input type="text" name="Prénom">
         <label>Mot de passe :</label> <input type="password" name="MDP">
    </form>

</body>
</html>