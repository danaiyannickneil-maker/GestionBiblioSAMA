<?php
require_once("../config/database.php");

class LivreDao {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function insertLivre($titre, $auteur, $annee, $categorie) {
        $sql = "INSERT INTO livres (titre, auteur, annee, categorie) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$titre, $auteur, $annee, $categorie]);
    }
}
