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
}
?>
