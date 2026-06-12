<?php
require_once(__DIR__ . "/../DAO/EmpruntDao.php");

class EmpruntService {
    private $dao;

    public function __construct() {
        $this->dao = new EmpruntDao();
    }

    public function compterEmpruntsEnCours() {
        return $this->dao->countEmpruntsEnCours();
    }

    public function compterEmpruntsUtilisateur($utilisateurId) {
        return $this->dao->countEmpruntsByUser($utilisateurId);
    }

    public function compterNotificationsNonLues($utilisateurId) {
        return $this->dao->countNotificationsNonLues($utilisateurId);
    }

    public function compterFavorisUtilisateur($utilisateurId) {
        return $this->dao->countFavorisByUser($utilisateurId);
    }

    public function emprunterLivre($utilisateurId, $documentId) {
        return $this->dao->emprunterDocument((int) $utilisateurId, (int) $documentId);
    }

    public function ajouterFavori($utilisateurId, $documentId) {
        return $this->dao->ajouterFavori((int) $utilisateurId, (int) $documentId);
    }

    public function listerFavoris($utilisateurId) {
        return $this->dao->getFavorisByUser((int) $utilisateurId);
    }
}
?>
