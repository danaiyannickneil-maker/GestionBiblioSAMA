<?php
require_once("../DAO/LivreDao.php");

class LivreService {
    private $dao;

    public function __construct() {
        $this->dao = new LivreDao();
    }

    public function ajouterLivre($titre, $auteur, $isbn, $editeur, $annee, $categorie, $description, $nb_pages, $langue, $image) {
        // Règles métier : titre, auteur et ISBN obligatoires
        if (empty($titre) || empty($auteur) || empty($isbn)) {
            return false;
        }

        return $this->dao->insertLivre($titre, $auteur, $isbn, $editeur, $annee, $categorie, $description, $nb_pages, $langue, $image);
    }
    public function rechercherLivres($motCle) {
        return $this->dao->searchLivres($motCle);
    }
}
