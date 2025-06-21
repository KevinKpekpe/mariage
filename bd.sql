-- Création de la base de données
CREATE DATABASE IF NOT EXISTS `registre_mariages_civils` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `registre_mariages_civils`;

-- Table pour les Communes / Villes / Districts / Provinces
CREATE TABLE `communes` (
    `id_commune` INT(11) NOT NULL AUTO_INCREMENT,
    `nom_commune` VARCHAR(255) NOT NULL,
    `district` VARCHAR(255) DEFAULT NULL,
    `province` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id_commune`),
    UNIQUE KEY `idx_unique_commune_district_province` (`nom_commune`, `district`, `province`) -- Assure l'unicité des lieux
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour les Officiers d'État Civil
CREATE TABLE `officiers` (
    `id_officier` INT(11) NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(255) NOT NULL,
    `prenom` VARCHAR(255) NOT NULL,
    `matricule` VARCHAR(100) UNIQUE DEFAULT NULL, -- Peut être NULL si non disponible
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `mot_de_passe` VARCHAR(255) NOT NULL, -- Haché
    `id_commune` INT(11) NOT NULL, -- L'officier est rattaché à une commune
    `role` ENUM('admin', 'officier_communal') NOT NULL DEFAULT 'officier_communal',
    `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_mise_a_jour` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_officier`),
    FOREIGN KEY (`id_commune`) REFERENCES `communes`(`id_commune`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour les Personnes (époux et épouses)
CREATE TABLE `personnes` (
    `id_personne` INT(11) NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(255) NOT NULL,
    `prenom` VARCHAR(255) NOT NULL,
    `date_naissance` DATE DEFAULT NULL,
    `lieu_naissance` VARCHAR(255) DEFAULT NULL,
    `nationalite` VARCHAR(100) NOT NULL DEFAULT 'Congolaise',
    `profession` VARCHAR(255) DEFAULT NULL,
    `adresse_actuelle` VARCHAR(500) DEFAULT NULL,
    `type_personne` ENUM('homme', 'femme') NOT NULL,
    `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_mise_a_jour` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour les Mariages Civils
CREATE TABLE `mariages` (
    `id_mariage` INT(11) NOT NULL AUTO_INCREMENT,
    `numero_acte_mariage` VARCHAR(100) UNIQUE NOT NULL,
    `date_celebration` DATE NOT NULL,
    `heure_celebration` TIME NOT NULL,
    `id_officier_celebration` INT(11) NOT NULL,
    `id_commune_celebration` INT(11) NOT NULL,
    `nom_complet_temoin_1` VARCHAR(255) DEFAULT NULL,
    `nom_complet_temoin_2` VARCHAR(255) DEFAULT NULL,
    `etat_acte` ENUM('actif', 'dissous', 'annule') NOT NULL DEFAULT 'actif',
    `date_dissolution_annulation` DATE DEFAULT NULL,
    `motif_dissolution_annulation` TEXT DEFAULT NULL, 
    `regime_matrimonial` VARCHAR(255) DEFAULT NULL, 
    `date_publication_annonce` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_mise_a_jour` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_mariage`),
    FOREIGN KEY (`id_officier_celebration`) REFERENCES `officiers`(`id_officier`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`id_commune_celebration`) REFERENCES `communes`(`id_commune`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table de liaison entre les mariages et les personnes (époux et épouses)
CREATE TABLE `epoux_mariage` (
    `id_epoux_mariage` INT(11) NOT NULL AUTO_INCREMENT,
    `id_mariage` INT(11) NOT NULL,
    `id_personne` INT(11) NOT NULL,
    `type_role` ENUM('époux', 'épouse') DEFAULT NULL,
    PRIMARY KEY (`id_epoux_mariage`),
    FOREIGN KEY (`id_mariage`) REFERENCES `mariages`(`id_mariage`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`id_personne`) REFERENCES `personnes`(`id_personne`) ON DELETE RESTRICT ON UPDATE CASCADE,
    UNIQUE KEY `idx_unique_mariage_personne_role` (`id_mariage`, `id_personne`, `type_role`) -- Un mariage ne peut avoir qu'un seul époux et une seule épouse
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Index pour améliorer les performances de recherche
CREATE INDEX `idx_date_celebration` ON `mariages` (`date_celebration`);
CREATE INDEX `idx_nom_prenom_personnes` ON `personnes` (`nom`, `prenom`);
CREATE INDEX `idx_nom_prenom_officiers` ON `officiers` (`nom`, `prenom`);
CREATE INDEX `idx_nom_commune` ON `communes` (`nom_commune`);