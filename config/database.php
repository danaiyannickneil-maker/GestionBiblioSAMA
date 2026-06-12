<?php
class Database {
    public static function getConnection() {
        $host = "127.0.0.1";   // adresse du serveur
        $port = "3306";        // port MySQL (confirmé dans phpMyAdmin)
        $dbname = "gestion_bibliotheque";
        $user = "root";
        $pass = "";

        try {
            return new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}
?>
