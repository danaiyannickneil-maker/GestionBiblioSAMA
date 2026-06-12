<?php
require_once(__DIR__ . "/../config/database.php");

class UserDao {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function insertUser($email, $mot_de_passe, $nom, $prenom, $type_user = 'etudiant') {
        $sql = "INSERT INTO utilisateurs (email, mot_de_passe, nom, prenom, type_user)
                VALUES (:email, :mot_de_passe, :nom, :prenom, :type_user)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':email' => $email,
            ':mot_de_passe' => password_hash($mot_de_passe, PASSWORD_DEFAULT),
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':type_user' => $type_user
        ]);
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM utilisateurs WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getAllUsers() {
        $sql = "SELECT id, email, nom, prenom, type_user, date_inscription, actif FROM utilisateurs";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countUsers() {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn();
    }

    public function countActiveUsers() {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE actif = 1")->fetchColumn();
    }

    public function updateUser($id, $nom, $prenom, $telephone = null, $adresse = null) {
        $sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, telephone = ?, adresse = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom, $prenom, $telephone, $adresse, $id]);
    }

    public function updatePassword($id, $new_password) {
        $sql = "UPDATE utilisateurs SET mot_de_passe = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([password_hash($new_password, PASSWORD_DEFAULT), $id]);
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM utilisateurs WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM utilisateurs WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function updateLastLogin($id) {
        $sql = "UPDATE utilisateurs SET date_derniere_connexion = NOW() WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>
