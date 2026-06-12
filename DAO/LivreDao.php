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

    public function searchLivresAvance(array $filtres) {
        $conditions = [];
        $params = [];

        if (!empty($filtres['titre'])) {
            $conditions[] = 'titre LIKE ?';
            $params[] = '%'.$filtres['titre'].'%';
        }
        if (!empty($filtres['auteur'])) {
            $conditions[] = 'auteur LIKE ?';
            $params[] = '%'.$filtres['auteur'].'%';
        }
        if (!empty($filtres['isbn'])) {
            $conditions[] = 'ISBN LIKE ?';
            $params[] = '%'.$filtres['isbn'].'%';
        }
        if (!empty($filtres['editeur'])) {
            $conditions[] = 'editeur LIKE ?';
            $params[] = '%'.$filtres['editeur'].'%';
        }
        if (!empty($filtres['annee'])) {
            $conditions[] = 'annee_publication = ?';
            $params[] = $filtres['annee'];
        }
        if (!empty($filtres['categorie'])) {
            $conditions[] = 'categorie LIKE ?';
            $params[] = '%'.$filtres['categorie'].'%';
        }
        if (!empty($filtres['description'])) {
            $conditions[] = 'description LIKE ?';
            $params[] = '%'.$filtres['description'].'%';
        }
        if (!empty($filtres['nb_pages'])) {
            $conditions[] = 'nb_pages = ?';
            $params[] = $filtres['nb_pages'];
        }
        if (!empty($filtres['langue'])) {
            $conditions[] = 'langue LIKE ?';
            $params[] = '%'.$filtres['langue'].'%';
        }

        $sql = 'SELECT * FROM livres';
        if (!empty($conditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

