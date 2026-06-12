<?php
require_once(__DIR__ . "/../config/database.php");

class LivreDao {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function insertLivre($titre, $auteur, $isbn, $editeur, $annee, $categorie, $description, $nb_pages, $langue, $image) {
        $categorieId = $this->resolveCategorieId($categorie);
        $numeroUnique = $this->generateNumeroUnique($isbn);

        $sql = "INSERT INTO documents (numero_unique, titre, auteur, isbn, editeur, annee_publication, categorie_id, description, nombre_pages, langue, image_couverture)
                VALUES (:numero_unique, :titre, :auteur, :isbn, :editeur, :annee, :categorie_id, :description, :nb_pages, :langue, :image)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':numero_unique' => $numeroUnique,
            ':titre' => $titre,
            ':auteur' => $auteur,
            ':isbn' => $isbn ?: null,
            ':editeur' => $editeur ?: null,
            ':annee' => $annee ?: null,
            ':categorie_id' => $categorieId,
            ':description' => $description ?: null,
            ':nb_pages' => $nb_pages ?: null,
            ':langue' => $langue ?: 'français',
            ':image' => $image ?: 'default_cover.jpg'
        ]);
    }

    public function searchLivres($motCle) {
        $sql = "SELECT d.*, c.nom AS categorie
                FROM documents d
                LEFT JOIN categories c ON c.id = d.categorie_id
                WHERE d.titre LIKE ?
                   OR d.auteur LIKE ?
                   OR d.isbn LIKE ?
                   OR d.langue LIKE ?
                   OR c.nom LIKE ?
                ORDER BY d.date_ajout DESC";
        $stmt = $this->pdo->prepare($sql);
        $like = "%".$motCle."%";
        $stmt->execute([$like, $like, $like, $like, $like]);
        return $stmt->fetchAll();
    }

    public function searchLivresAvance(array $filtres) {
        $conditions = [];
        $params = [];

        if (!empty($filtres['titre'])) {
            $conditions[] = 'd.titre LIKE ?';
            $params[] = '%'.$filtres['titre'].'%';
        }
        if (!empty($filtres['auteur'])) {
            $conditions[] = 'd.auteur LIKE ?';
            $params[] = '%'.$filtres['auteur'].'%';
        }
        if (!empty($filtres['isbn'])) {
            $conditions[] = 'd.isbn LIKE ?';
            $params[] = '%'.$filtres['isbn'].'%';
        }
        if (!empty($filtres['editeur'])) {
            $conditions[] = 'd.editeur LIKE ?';
            $params[] = '%'.$filtres['editeur'].'%';
        }
        if (!empty($filtres['annee'])) {
            $conditions[] = 'd.annee_publication = ?';
            $params[] = $filtres['annee'];
        }
        if (!empty($filtres['categorie'])) {
            $conditions[] = 'c.nom LIKE ?';
            $params[] = '%'.$filtres['categorie'].'%';
        } elseif (!empty($filtres['categorie_id'])) {
            $conditions[] = 'd.categorie_id = ?';
            $params[] = $filtres['categorie_id'];
        }
        if (!empty($filtres['description'])) {
            $conditions[] = 'd.description LIKE ?';
            $params[] = '%'.$filtres['description'].'%';
        }
        if (!empty($filtres['nb_pages'])) {
            $conditions[] = 'd.nombre_pages = ?';
            $params[] = $filtres['nb_pages'];
        }
        if (!empty($filtres['langue'])) {
            $conditions[] = 'd.langue LIKE ?';
            $params[] = '%'.$filtres['langue'].'%';
        }

        $sql = "SELECT d.*, c.nom AS categorie
                FROM documents d
                LEFT JOIN categories c ON c.id = d.categorie_id";
        if (!empty($conditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }
        $sql .= ' ORDER BY d.date_ajout DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getAllLivres() {
        $sql = "SELECT d.*, c.nom AS categorie
                FROM documents d
                LEFT JOIN categories c ON c.id = d.categorie_id
                ORDER BY d.date_ajout DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function countLivres() {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM documents")->fetchColumn();
    }

    public function countCategories() {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    }

    private function resolveCategorieId($categorie) {
        $categorie = trim((string) $categorie);
        if ($categorie === '') {
            return null;
        }

        if (ctype_digit($categorie)) {
            $stmt = $this->pdo->prepare("SELECT id FROM categories WHERE id = ?");
            $stmt->execute([(int) $categorie]);
            if ($stmt->fetchColumn()) {
                return (int) $categorie;
            }
        }

        $stmt = $this->pdo->prepare("SELECT id FROM categories WHERE LOWER(nom) = LOWER(?)");
        $stmt->execute([$categorie]);
        $id = $stmt->fetchColumn();
        if ($id) {
            return (int) $id;
        }

        $asciiName = iconv('UTF-8', 'ASCII//TRANSLIT', $categorie);
        $baseCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]+/', '', $asciiName ?: $categorie), 0, 12));
        $baseCode = $baseCode ?: 'CAT';
        $code = $baseCode;
        $suffix = 1;

        while ($this->categoryCodeExists($code)) {
            $code = $baseCode . $suffix;
            $suffix++;
        }

        $stmt = $this->pdo->prepare("INSERT INTO categories (nom, code) VALUES (?, ?)");
        $stmt->execute([$categorie, $code]);
        return (int) $this->pdo->lastInsertId();
    }

    private function categoryCodeExists($code) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM categories WHERE code = ?");
        $stmt->execute([$code]);
        return (int) $stmt->fetchColumn() > 0;
    }

    private function generateNumeroUnique($isbn) {
        $suffix = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', (string) $isbn), -6));
        $suffix = $suffix ?: strtoupper(substr(uniqid(), -6));
        $numero = 'LIV-' . $suffix;
        $base = $numero;
        $index = 1;

        while ($this->numeroUniqueExists($numero)) {
            $numero = $base . '-' . $index;
            $index++;
        }

        return $numero;
    }

    private function numeroUniqueExists($numero) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM documents WHERE numero_unique = ?");
        $stmt->execute([$numero]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
