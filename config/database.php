<?php
$host = 'localhost;port=3308';
$dbname = '';  // nom de la base de  données
$user = 'root'; // Par défaut sur XAMPP/WAMP
$password = '';

try{
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

  die("Erreur de connexion : ". $e->getMessage());
}
 
?>
<?php

