<?php
// Ensure config is loaded using absolute path
require_once(__DIR__ . "/../config/database.php");

// Provide a safe fallback for static analysis or missing config file
if (!class_exists('Database')) {
    class Database {
        public static function getConnection() {
            throw new \Exception('Database class not found. Ensure config/database.php is available.');
        }
    }
}

class LivreDao {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

   public function insertLivre($titre, $auteur, $isbn, $editeur, $annee, $categorie, $description, $nb_pages, $langue, $image) {
    $sql = "INSERT INTO livres (titre, auteur, ISBN, editeur, annee_publication, categorie, description, nb_pages, langue, image_couverture, date_ajout)
            VALUES (:titre, :auteur, :isbn, :editeur, :annee, :categorie, :description, :nb_pages, :langue, :image, NOW())";

    $stmt = $this->pdo->prepare($sql);
    return $stmt->execute([
        ':titre' => $titre,
        ':auteur' => $auteur,
        ':isbn' => $isbn,
        ':editeur' => $editeur,
        ':annee' => $annee,
        ':categorie' => $categorie,
        ':description' => $description,
        ':nb_pages' => $nb_pages,
        ':langue' => $langue,
        ':image' => $image
    ]);
}

    public function searchLivres($motCle) {
        $sql = "SELECT * FROM livres 
                WHERE titre LIKE ? 
                   OR auteur LIKE ? 
                   OR ISBN LIKE ? 
                   OR categorie LIKE ?";
        $stmt = $this->pdo->prepare($sql);
        $like = "%".$motCle."%";
        $stmt->execute([$like, $like, $like, $like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

