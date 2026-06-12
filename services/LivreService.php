<?php
require_once("../DAO/LivreDao.php");

class LivreService {
    private $dao;

    public function __construct() {
        $this->dao = new LivreDao();
    }

    public function ajouterLivre($titre, $auteur, $isbn, $editeur, $annee = null, $categorie = null, $description = null, $nb_pages = null, $langue = null, $image = null) {
        // Règles métier : titre, auteur et ISBN obligatoires
        if (empty($titre) || empty($auteur) || empty($isbn)) {
            return false;
        }

        // DAO insertLivre expects 4 arguments: titre, auteur, isbn, editeur
        return $this->dao->insertLivre($titre, $auteur, $isbn, $editeur);
    }
    public function rechercherLivres($motCle) {
        return $this->dao->searchLivres($motCle);
    }
}
