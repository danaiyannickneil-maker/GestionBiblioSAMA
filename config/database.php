<?php
<<<<<<< HEAD
class Database {
    public static function getConnection() {
        $host = "127.0.0.1";   // adresse du serveur
        $port = "3306";        // port MySQL (confirmé dans phpMyAdmin)
        $dbname = "gestion_bibliotheque";
        $user = "root";
        $pass = "";
=======
$host = 'localhost;port=3308';
$dbname = 'gestion_bibliotheque';  // nom de la base de  données
$user = 'root'; // Par défaut sur XAMPP/WAMP
$password = '';
>>>>>>> ef5a903f8ab640bba57c87a834d072d143b85664

        try {
            return new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}
?>
