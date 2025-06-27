-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql-container:3306
-- Généré le : ven. 27 juin 2025 à 11:54
-- Version du serveur : 9.2.0
-- Version de PHP : 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `registre_mariages_civils`
--

-- --------------------------------------------------------

--
-- Structure de la table `communes`
--

CREATE TABLE `communes` (
  `id_commune` int NOT NULL,
  `nom_commune` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `communes`
--

INSERT INTO `communes` (`id_commune`, `nom_commune`, `district`, `province`) VALUES
(1, 'Bandalungwa', 'Funa', 'Kinshasa'),
(2, 'Barumbu', 'Funa', 'Kinshasa'),
(3, 'Bumbu', 'Lukunga', 'Kinshasa'),
(4, 'Gombe', 'Lukunga', 'Kinshasa'),
(5, 'Kalamu', 'Funa', 'Kinshasa'),
(6, 'Kasa-Vubu', 'Funa', 'Kinshasa'),
(7, 'Kimbanseke', 'Tshangu', 'Kinshasa'),
(8, 'Kinshasa', 'Lukunga', 'Kinshasa'),
(9, 'Kintambo', 'Lukunga', 'Kinshasa'),
(10, 'Kisenso', 'Mont Amba', 'Kinshasa'),
(11, 'Lemba', 'Mont Amba', 'Kinshasa'),
(12, 'Limete', 'Mont Amba', 'Kinshasa'),
(13, 'Lingwala', 'Lukunga', 'Kinshasa'),
(14, 'Makala', 'Funa', 'Kinshasa'),
(15, 'Maluku', 'Tshangu', 'Kinshasa'),
(16, 'Masina', 'Tshangu', 'Kinshasa'),
(17, 'Matete', 'Funa', 'Kinshasa'),
(18, 'Mont-Ngafula', 'Mont Amba', 'Kinshasa'),
(19, 'Ndjili', 'Tshangu', 'Kinshasa'),
(20, 'Ngaba', 'Mont Amba', 'Kinshasa'),
(21, 'Ngaliema', 'Lukunga', 'Kinshasa'),
(22, 'Ngiri-Ngiri', 'Funa', 'Kinshasa'),
(23, 'Nsele', 'Tshangu', 'Kinshasa'),
(24, 'Selembao', 'Mont Amba', 'Kinshasa');

-- --------------------------------------------------------

--
-- Structure de la table `epoux_mariage`
--

CREATE TABLE `epoux_mariage` (
  `id_epoux_mariage` int NOT NULL,
  `id_mariage` int NOT NULL,
  `id_personne` int NOT NULL,
  `type_role` enum('époux','épouse') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `epoux_mariage`
--

INSERT INTO `epoux_mariage` (`id_epoux_mariage`, `id_mariage`, `id_personne`, `type_role`) VALUES
(1, 1, 1, 'époux'),
(2, 1, 2, 'épouse'),
(5, 2, 3, 'époux'),
(6, 2, 4, 'épouse');

-- --------------------------------------------------------

--
-- Structure de la table `mariages`
--

CREATE TABLE `mariages` (
  `id_mariage` int NOT NULL,
  `numero_acte_mariage` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_celebration` date NOT NULL,
  `heure_celebration` time NOT NULL,
  `id_officier_celebration` int NOT NULL,
  `id_commune_celebration` int NOT NULL,
  `nom_complet_temoin_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom_complet_temoin_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat_acte` enum('actif','dissous','annule') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'actif',
  `date_dissolution_annulation` date DEFAULT NULL,
  `motif_dissolution_annulation` text COLLATE utf8mb4_unicode_ci,
  `regime_matrimonial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_publication_annonce` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_mise_a_jour` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mariages`
--

INSERT INTO `mariages` (`id_mariage`, `numero_acte_mariage`, `date_celebration`, `heure_celebration`, `id_officier_celebration`, `id_commune_celebration`, `nom_complet_temoin_1`, `nom_complet_temoin_2`, `etat_acte`, `date_dissolution_annulation`, `motif_dissolution_annulation`, `regime_matrimonial`, `date_publication_annonce`, `date_creation`, `date_mise_a_jour`) VALUES
(1, 'ACTE2024-001', '2025-06-25', '10:00:00', 1, 1, 'Tshibangu Marcel', 'Mutombo Claire', 'actif', NULL, NULL, 'Communauté des biens', '2025-08-23 22:29:39', '2025-06-21 22:29:39', '2025-06-22 00:10:41'),
(2, 'ACTE2024-002', '2025-06-30', '11:30:00', 1, 1, 'Kalonji Pascal', 'Ilunga Alice', 'actif', NULL, NULL, 'communauté de biens', '2025-06-21 22:29:39', '2025-06-21 22:29:39', '2025-06-22 00:11:03');

-- --------------------------------------------------------

--
-- Structure de la table `officiers`
--

CREATE TABLE `officiers` (
  `id_officier` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricule` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_commune` int NOT NULL,
  `role` enum('admin','officier_communal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'officier_communal',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_mise_a_jour` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `officiers`
--

INSERT INTO `officiers` (`id_officier`, `nom`, `prenom`, `matricule`, `email`, `mot_de_passe`, `id_commune`, `role`, `date_creation`, `date_mise_a_jour`) VALUES
(1, 'Dupont', 'Jean', NULL, 'jean.dupont@example.com', '$2y$10$XtHYEF3mFt83tfUkhnnncuyPUi.aQiKLdEU.f.9k1nWcpFI6Daeli', 1, 'admin', '2025-06-21 22:24:42', '2025-06-21 22:24:42'),
(2, 'Kabongo', 'Kabongo', NULL, 'kabongo@example.com', '$2y$10$Zas1UHb9JiwCYLaTCIamWeh2.ljC3EGHjWSM05g8qwG86lN9jx16O', 1, 'officier_communal', '2025-06-21 22:26:24', '2025-06-21 22:26:24');

-- --------------------------------------------------------

--
-- Structure de la table `personnes`
--

CREATE TABLE `personnes` (
  `id_personne` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `lieu_naissance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationalite` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Congolaise',
  `profession` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse_actuelle` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_personne` enum('homme','femme') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_mise_a_jour` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personnes`
--

INSERT INTO `personnes` (`id_personne`, `nom`, `prenom`, `date_naissance`, `lieu_naissance`, `nationalite`, `profession`, `adresse_actuelle`, `photo`, `type_personne`, `date_creation`, `date_mise_a_jour`) VALUES
(1, 'Kabasele', 'Jean-Pierre', '1990-05-12', 'Kinshasa', 'Congolaise', 'Médecin', 'Avenue Kasa-Vubu n°45, Kinshasa', 'uploads/personnes/68573f8bcdb32_profil.png', 'homme', '2025-06-21 22:29:24', '2025-06-21 23:26:03'),
(2, 'Ngoy', 'Thérèse', '1992-08-25', 'Lubumbashi', 'Congolaise', 'Comptable', 'Avenue Lumumba n°12, Lubumbashi', 'uploads/personnes/68573fadbcdd7_profil.png', 'femme', '2025-06-21 22:29:24', '2025-06-21 23:26:37'),
(3, 'Mbala', 'Dieudonné', '1985-11-02', 'Mbuji-Mayi', 'Congolaise', 'Enseignant', 'Quartier Diulu, Mbuji-Mayi', 'uploads/personnes/68573f9736c03_profil.png', 'homme', '2025-06-21 22:29:24', '2025-06-21 23:26:15'),
(4, 'Mbuyi', 'Chantal', '1987-03-15', 'Kananga', 'Congolaise', 'Infirmière', 'Avenue Kasai, Kananga', 'uploads/personnes/68573fa32d079_profil.png', 'femme', '2025-06-21 22:29:24', '2025-06-21 23:26:27');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `communes`
--
ALTER TABLE `communes`
  ADD PRIMARY KEY (`id_commune`),
  ADD UNIQUE KEY `idx_unique_commune_district_province` (`nom_commune`,`district`,`province`),
  ADD KEY `idx_nom_commune` (`nom_commune`);

--
-- Index pour la table `epoux_mariage`
--
ALTER TABLE `epoux_mariage`
  ADD PRIMARY KEY (`id_epoux_mariage`),
  ADD UNIQUE KEY `idx_unique_mariage_personne_role` (`id_mariage`,`id_personne`,`type_role`),
  ADD KEY `id_personne` (`id_personne`);

--
-- Index pour la table `mariages`
--
ALTER TABLE `mariages`
  ADD PRIMARY KEY (`id_mariage`),
  ADD UNIQUE KEY `numero_acte_mariage` (`numero_acte_mariage`),
  ADD KEY `id_officier_celebration` (`id_officier_celebration`),
  ADD KEY `id_commune_celebration` (`id_commune_celebration`),
  ADD KEY `idx_date_celebration` (`date_celebration`);

--
-- Index pour la table `officiers`
--
ALTER TABLE `officiers`
  ADD PRIMARY KEY (`id_officier`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `matricule` (`matricule`),
  ADD KEY `id_commune` (`id_commune`),
  ADD KEY `idx_nom_prenom_officiers` (`nom`,`prenom`);

--
-- Index pour la table `personnes`
--
ALTER TABLE `personnes`
  ADD PRIMARY KEY (`id_personne`),
  ADD KEY `idx_nom_prenom_personnes` (`nom`,`prenom`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `communes`
--
ALTER TABLE `communes`
  MODIFY `id_commune` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `epoux_mariage`
--
ALTER TABLE `epoux_mariage`
  MODIFY `id_epoux_mariage` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `mariages`
--
ALTER TABLE `mariages`
  MODIFY `id_mariage` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `officiers`
--
ALTER TABLE `officiers`
  MODIFY `id_officier` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `personnes`
--
ALTER TABLE `personnes`
  MODIFY `id_personne` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `epoux_mariage`
--
ALTER TABLE `epoux_mariage`
  ADD CONSTRAINT `epoux_mariage_ibfk_1` FOREIGN KEY (`id_mariage`) REFERENCES `mariages` (`id_mariage`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `epoux_mariage_ibfk_2` FOREIGN KEY (`id_personne`) REFERENCES `personnes` (`id_personne`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `mariages`
--
ALTER TABLE `mariages`
  ADD CONSTRAINT `mariages_ibfk_1` FOREIGN KEY (`id_officier_celebration`) REFERENCES `officiers` (`id_officier`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `mariages_ibfk_2` FOREIGN KEY (`id_commune_celebration`) REFERENCES `communes` (`id_commune`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `officiers`
--
ALTER TABLE `officiers`
  ADD CONSTRAINT `officiers_ibfk_1` FOREIGN KEY (`id_commune`) REFERENCES `communes` (`id_commune`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
