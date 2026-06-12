<?php
require_once(__DIR__ . "/../config/database.php");

class EmpruntDao {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function countEmpruntsEnCours() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM emprunts WHERE statut = ?");
        $stmt->execute(['en cours']);
        return (int) $stmt->fetchColumn();
    }

    public function countEmpruntsByUser($utilisateurId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM emprunts WHERE utilisateur_id = ? AND statut = ?");
        $stmt->execute([$utilisateurId, 'en cours']);
        return (int) $stmt->fetchColumn();
    }

    public function countNotificationsNonLues($utilisateurId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM notifications WHERE utilisateur_id = ? AND lue = 0");
        $stmt->execute([$utilisateurId]);
        return (int) $stmt->fetchColumn();
    }

    public function countFavorisByUser($utilisateurId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM favoris WHERE utilisateur_id = ?");
        $stmt->execute([$utilisateurId]);
        return (int) $stmt->fetchColumn();
    }

    public function emprunterDocument($utilisateurId, $documentId) {
        if ($this->hasEmpruntEnCours($utilisateurId, $documentId)) {
            return ['success' => false, 'message' => 'Vous avez deja emprunte ce livre.'];
        }

        $exemplaire = $this->findOrCreateExemplaireDisponible($documentId);
        if (!$exemplaire) {
            return ['success' => false, 'message' => 'Aucun exemplaire disponible pour ce livre.'];
        }

        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare("INSERT INTO emprunts (utilisateur_id, exemplaire_id, document_id, date_retour_prevue, statut)
                                         VALUES (?, ?, ?, DATE_ADD(CURDATE(), INTERVAL 14 DAY), 'en cours')");
            $stmt->execute([$utilisateurId, $exemplaire['id'], $documentId]);

            $stmt = $this->pdo->prepare("UPDATE exemplaires SET statut = 'emprunté' WHERE id = ?");
            $stmt->execute([$exemplaire['id']]);

            $this->pdo->commit();
            return ['success' => true, 'message' => 'Livre emprunte avec succes.'];
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'message' => "Erreur lors de l'emprunt."];
        }
    }

    public function ajouterFavori($utilisateurId, $documentId) {
        $stmt = $this->pdo->prepare("INSERT IGNORE INTO favoris (utilisateur_id, document_id) VALUES (?, ?)");
        $success = $stmt->execute([$utilisateurId, $documentId]);
        return [
            'success' => $success,
            'message' => $stmt->rowCount() > 0 ? 'Livre ajoute aux favoris.' : 'Ce livre est deja dans vos favoris.'
        ];
    }

    public function getFavorisByUser($utilisateurId) {
        $sql = "SELECT d.*, c.nom AS categorie
                FROM favoris f
                INNER JOIN documents d ON d.id = f.document_id
                LEFT JOIN categories c ON c.id = d.categorie_id
                WHERE f.utilisateur_id = ?
                ORDER BY f.date_ajout DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$utilisateurId]);
        return $stmt->fetchAll();
    }

    private function hasEmpruntEnCours($utilisateurId, $documentId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM emprunts WHERE utilisateur_id = ? AND document_id = ? AND statut = 'en cours'");
        $stmt->execute([$utilisateurId, $documentId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    private function findOrCreateExemplaireDisponible($documentId) {
        $stmt = $this->pdo->prepare("SELECT id FROM exemplaires WHERE document_id = ? AND statut = 'disponible' LIMIT 1");
        $stmt->execute([$documentId]);
        $exemplaire = $stmt->fetch();
        if ($exemplaire) {
            return $exemplaire;
        }

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM exemplaires WHERE document_id = ?");
        $stmt->execute([$documentId]);
        if ((int) $stmt->fetchColumn() > 0) {
            return null;
        }

        $codeBarre = 'EX-' . $documentId . '-' . strtoupper(substr(uniqid(), -6));
        $stmt = $this->pdo->prepare("INSERT INTO exemplaires (document_id, code_barre, statut, date_acquisition) VALUES (?, ?, 'disponible', CURDATE())");
        $stmt->execute([$documentId, $codeBarre]);

        return ['id' => (int) $this->pdo->lastInsertId()];
    }
}
?>
