-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 03 oct. 2020 à 16:37
-- Version du serveur :  5.7.24
-- Version de PHP :  7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `prise_de_note`
--

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE IF NOT EXISTS `etudiant` (
  `num_etudiant` int(11) NOT NULL AUTO_INCREMENT,
  `nom_etudiant` varchar(255) NOT NULL,
  `prenom_etudiant` varchar(255) NOT NULL,
  `classe_etudiant` varchar(255) NOT NULL,
  PRIMARY KEY (`num_etudiant`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`num_etudiant`, `nom_etudiant`, `prenom_etudiant`, `classe_etudiant`) VALUES
(1, 'bernard', 'jean', '3eme'),
(2, 'trouillard', 'ronan', '3eme'),
(3, 'richard', 'hug', '3eme'),
(4, 'trouillard', 'jean', '4eme');

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

DROP TABLE IF EXISTS `matiere`;
CREATE TABLE IF NOT EXISTS `matiere` (
  `num_matiere` int(11) NOT NULL AUTO_INCREMENT,
  `matiere_matiere` varchar(25) NOT NULL,
  PRIMARY KEY (`num_matiere`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `matiere`
--

INSERT INTO `matiere` (`num_matiere`, `matiere_matiere`) VALUES
(1, 'mathematique'),
(2, 'SVT'),
(3, 'math');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `num_note` int(11) NOT NULL AUTO_INCREMENT,
  `note_note` int(11) NOT NULL,
  `coef_note` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `id_martiere` int(11) NOT NULL,
  PRIMARY KEY (`num_note`),
  UNIQUE KEY `id_etudiant` (`id_etudiant`,`id_martiere`),
  KEY `id_matiere` (`id_martiere`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `note`
--

INSERT INTO `note` (`num_note`, `note_note`, `coef_note`, `id_etudiant`, `id_martiere`) VALUES
(1, 15, 2, 1, 1),
(2, 12, 2, 2, 1),
(3, 9, 2, 3, 1),
(4, 9, 1, 3, 2),
(5, 5, 1, 1, 2),
(6, 13, 1, 4, 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
