<?php

class Database {
    public static function getConnection() {
        $host = 'localhost';   // adresse du serveur
        $port = '3308';        // port MySQL (confirmé dans phpMyAdmin)
        $dbname = 'gestion_bibliotheque';
        $user = 'root';
        $pass = '';

        try {
            return new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }
}
