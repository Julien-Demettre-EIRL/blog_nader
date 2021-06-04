-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  lun. 25 jan. 2021 à 16:37
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
-- Base de données :  `blog2`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `publicationDate` varchar(250) NOT NULL,
  `postId` int(11) NOT NULL,
  `valider` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `publicationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `imageFileName` varchar(250) NOT NULL,
  `writerId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `publicationDate`, `imageFileName`, `writerId`) VALUES
(7, 'thoma', 'nader.al.aghbari1@gmail.com', '2020-10-26 23:35:06', '5f983e80894fd.jpg', 1),
(8, 'thoma', 'nader.al.aghbari1@gmail.com', '2020-10-27 14:18:01', '5f983e80894fd.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `writers`
--

DROP TABLE IF EXISTS `writers`;
CREATE TABLE IF NOT EXISTS `writers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `hashedPassword` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `writers`
--

INSERT INTO `writers` (`id`, `username`, `hashedPassword`) VALUES
(1, 'nader.al.aghbari1@gmail.com', '$2y$10$XM6o/B3SdJA795n7D9uyUec3jj6KynJYSiE7pdRAq6mW75hhFRX4C');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
