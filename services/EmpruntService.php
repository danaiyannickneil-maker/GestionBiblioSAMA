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
}
?>
