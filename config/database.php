<?php

class Database {
    public static function getConnection() {
        $host = 'localhost';   // adresse du serveur
        $port = '3308';        // port MySQL (confirmé dans phpMyAdmin)
        $dbname = 'gestion_bibliotheque';
        $user = 'root';
        $pass = '';

        try {
            $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }
}
