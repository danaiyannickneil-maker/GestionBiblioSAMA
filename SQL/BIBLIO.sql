-- =====================================================================
-- 1. CRÉATION ET SÉLECTION DE LA BASE DE DONNÉES
-- =====================================================================
CREATE DATABASE IF NOT EXISTS gestion_bibliotheque CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gestion_bibliotheque;

-- =====================================================================
-- 2. CRÉATION DE LA TABLE : categories
-- =====================================================================
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    code VARCHAR(20) UNIQUE,
    description TEXT NULL,
    parent_id INT NULL,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =====================================================================
-- 3. CRÉATION DE LA TABLE : utilisateurs
-- =====================================================================
CREATE TABLE utilisateurs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    type_user ENUM('etudiant', 'enseignant', 'bibliothecaire', 'admin') NOT NULL,
    numero_etudiant VARCHAR(50) NULL,
    telephone VARCHAR(20) NULL,
    adresse TEXT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_derniere_connexion DATETIME NULL,
    actif BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB;

-- =====================================================================
-- 4. CRÉATION DE LA TABLE : documents (Avec image et numéro unique)
-- =====================================================================
CREATE TABLE documents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_unique VARCHAR(50) NOT NULL UNIQUE,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) NULL UNIQUE,
    editeur VARCHAR(100) NULL,
    annee_publication INT NULL,
    categorie_id INT NULL,
    description TEXT NULL,
    nombre_pages INT NULL,
    langue VARCHAR(50) DEFAULT 'français',
    image_couverture VARCHAR(255) NULL DEFAULT 'default_cover.jpg',
    date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =====================================================================
-- 5. CRÉATION DE LA TABLE : exemplaires
-- =====================================================================
CREATE TABLE exemplaires (
    id INT PRIMARY KEY AUTO_INCREMENT,
    document_id INT NOT NULL,
    code_barre VARCHAR(100) NOT NULL UNIQUE,
    statut ENUM('disponible', 'emprunté', 'perdu', 'endommagé', 'maintenance') DEFAULT 'disponible',
    localisation VARCHAR(100) NULL,
    date_acquisition DATE NULL,
    `condition` ENUM('très bon', 'bon', 'acceptable', 'détérioré') DEFAULT 'très bon',
    date_dernier_entretien DATE NULL,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 6. CRÉATION DE LA TABLE : emprunts
-- =====================================================================
CREATE TABLE emprunts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    exemplaire_id INT NOT NULL,
    document_id INT NOT NULL,
    date_emprunt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_retour_prevue DATE NOT NULL,
    date_retour_reel DATE NULL,
    statut ENUM('en cours', 'retourné', 'retard', 'perdu') DEFAULT 'en cours',
    nombre_prolongations INT DEFAULT 0,
    date_derniere_prolongation DATE NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE RESTRICT,
    FOREIGN KEY (exemplaire_id) REFERENCES exemplaires(id) ON DELETE RESTRICT,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- =====================================================================
-- 7. CRÉATION DE LA TABLE : reservations
-- =====================================================================
CREATE TABLE reservations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    document_id INT NOT NULL,
    date_reservation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    position_file INT NOT NULL,
    statut ENUM('en attente', 'prêt_à_retirer', 'récupéré', 'annulée') DEFAULT 'en attente',
    date_limite_retrait DATE NULL,
    date_notification DATETIME NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 8. CRÉATION DE LA TABLE : amendes
-- =====================================================================
CREATE TABLE amendes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    emprunt_id INT NULL,
    montant DECIMAL(10,2) NOT NULL,
    raison VARCHAR(255) NOT NULL,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_limite_paiement DATE NOT NULL,
    statut ENUM('impayée', 'payée', 'remise') DEFAULT 'impayée',
    date_paiement DATE NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE RESTRICT,
    FOREIGN KEY (emprunt_id) REFERENCES emprunts(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =====================================================================
-- 9. CRÉATION DE LA TABLE : notifications
-- =====================================================================
CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    type ENUM('retard', 'reservation_prete', 'amende', 'rappel_retour', 'info') NOT NULL,
    message TEXT NOT NULL,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_lecture DATETIME NULL,
    lue BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 10. CRÉATION DE LA TABLE : favoris
-- =====================================================================
CREATE TABLE favoris (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT NOT NULL,
    document_id INT NOT NULL,
    date_ajout DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    note TEXT NULL,
    priorite ENUM('normale', 'haute') DEFAULT 'normale',
    CONSTRAINT uq_user_document UNIQUE (utilisateur_id, document_id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 11. RÉACTIVATION DES VÉRIFICATIONS
-- =====================================================================
SET FOREIGN_KEY_CHECKS = 1;
