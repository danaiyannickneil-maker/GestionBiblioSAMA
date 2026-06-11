<?php
class Database {
    public static function getConnection() {
        $host = "localhost,port=3308";
        $dbname = "bibliotheque";
        $user = "root";
        $pass = "";

        try {
            return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}
?>
