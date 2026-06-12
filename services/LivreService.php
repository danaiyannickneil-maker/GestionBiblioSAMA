<?php
require_once(__DIR__ . "/../DAO/LivreDao.php");

class LivreService {
    private $dao;

    public function __construct() {
        $this->dao = new LivreDao();
    }

    public function ajouterLivre($titre, $auteur, $isbn, $editeur, $annee = null, $categorie = null, $description = null, $nb_pages = null, $langue = null, $image = null) {
        $titre = trim((string) $titre);
        $auteur = trim((string) $auteur);
        $isbn = trim((string) $isbn);

        if ($titre === '' || $auteur === '' || $isbn === '') {
            return false;
        }

        return $this->dao->insertLivre($titre, $auteur, $isbn, $editeur, $annee, $categorie, $description, $nb_pages, $langue, $image);
    }

    public function rechercherLivres($motCle) {
        return $this->dao->searchLivres($motCle);
    }

    public function rechercherLivresAvance(array $filtres) {
        return $this->dao->searchLivresAvance($filtres);
    }

    public function listerLivres() {
        return $this->dao->getAllLivres();
    }

    public function compterLivres() {
        return $this->dao->countLivres();
    }

    public function compterCategories() {
        return $this->dao->countCategories();
    }
}
?>
