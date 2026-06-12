<?php
require_once(__DIR__ . "/../DAO/UserDao.php");

class UserServices {
    private $dao;

    public function __construct() {
        $this->dao = new UserDao();
    }

    public function inscrire($email, $motDePasse, $confirmation, $nom, $prenom, $typeUser = 'etudiant') {
        $email = trim((string) $email);
        $nom = trim((string) $nom);
        $prenom = trim((string) $prenom);

        if ($email === '' || $motDePasse === '' || $nom === '' || $prenom === '') {
            return ['success' => false, 'message' => 'Veuillez remplir tous les champs obligatoires.'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Adresse email invalide.'];
        }

        if ($motDePasse !== $confirmation) {
            return ['success' => false, 'message' => 'Les mots de passe ne correspondent pas.'];
        }

        if (strlen($motDePasse) < 6) {
            return ['success' => false, 'message' => 'Le mot de passe doit contenir au moins 6 caractères.'];
        }

        if ($this->dao->emailExists($email)) {
            return ['success' => false, 'message' => 'Cet email est déjà utilisé.'];
        }

        $success = $this->dao->insertUser($email, $motDePasse, $nom, $prenom, $typeUser);
        return [
            'success' => $success,
            'message' => $success ? 'Compte créé avec succès. Vous pouvez vous connecter.' : "Erreur lors de l'inscription."
        ];
    }

    public function connecter($email, $motDePasse) {
        $user = $this->dao->getUserByEmail(trim((string) $email));
        if (!$user || !password_verify($motDePasse, $user['mot_de_passe'])) {
            return ['success' => false, 'message' => 'Email ou mot de passe incorrect.'];
        }

        if (!(bool) $user['actif']) {
            return ['success' => false, 'message' => 'Ce compte est désactivé.'];
        }

        $this->dao->updateLastLogin($user['id']);
        return ['success' => true, 'user' => $user, 'message' => 'Connexion réussie.'];
    }

    public function compterUtilisateurs() {
        return $this->dao->countUsers();
    }

    public function compterUtilisateursActifs() {
        return $this->dao->countActiveUsers();
    }
}
?>
