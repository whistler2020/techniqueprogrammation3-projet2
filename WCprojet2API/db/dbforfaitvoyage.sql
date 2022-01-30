-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 30 jan. 2022 à 16:51
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dbforfaitvoyage`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `idClient` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sexe` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`idClient`, `nom`, `prenom`, `sexe`) VALUES
(1, 'Clermont', 'Whistler', 'm'),
(2, 'Etienne', 'Me-Alberte', 'f'),
(3, 'Clermont', 'Isaac', 'm'),
(4, 'Fleurisson', 'Marie Santania', 't'),
(5, 'Fleurisson', 'Smith', 'm'),
(6, 'Fleurisson-Dorima', 'Dorima', 'f');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `idReservation` int(11) NOT NULL,
  `destination` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `villeDepart` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `nomHotel` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `coordonneesHotel` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `nombreEtoiles` int(8) NOT NULL,
  `nombreChambres` int(100) NOT NULL,
  `caracteristiques` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dateDepart` date NOT NULL,
  `dateRetour` date NOT NULL,
  `prix` decimal(65,0) NOT NULL,
  `rabais` decimal(65,0) NOT NULL,
  `vedette` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`idReservation`, `destination`, `villeDepart`, `nomHotel`, `coordonneesHotel`, `nombreEtoiles`, `nombreChambres`, `caracteristiques`, `dateDepart`, `dateRetour`, `prix`, `rabais`, `vedette`) VALUES
(1, 'New york', 'Montreal', 'holiday inn de Montreal', '514 2354320', 4, 400, 'Face a la plage;Ascenseur', '2022-02-15', '2022-03-10', '250', '30', 1),
(2, 'London', 'Toronto', 'holiday de London', '68 21 2384539', 5, 500, 'Ascenseur; miniclub', '2022-04-03', '2022-06-06', '350', '39', 1),
(5, 'Berlin', 'Vancouvert', 'Belinois Hotel', '3345797124', 4, 300, 'Miniclud;Ascenseur;Vue sur plage', '2022-04-20', '2022-04-27', '234', '23', 0),
(6, 'Rome', 'Paris', 'holiday de Rome', '384 5469345', 5, 235, 'Miniclub', '2022-06-08', '2022-07-04', '345', '45', 0),
(7, 'Toronto', 'Montreal', 'niagara fall hotel', '5143482345', 5, 326, 'Face a la plage', '2022-08-10', '2022-08-24', '300', '30', 1),
(8, 'Quebec', 'Miami', 'Quebec Hotel', '514 3450867', 4, 250, 'ascenseur', '2022-09-28', '2022-10-18', '259', '45', 0),
(9, 'Winnipeg', 'Montreal', 'Winnipeg Holiday Inn', '5143272440', 5, 250, 'Miniclud;vue sur plage', '2022-10-30', '2022-11-15', '150', '30', 1),
(10, 'Californie', 'Toronto', 'California Hotel', '8192453478', 5, 700, 'Ascenseur;vue sur plage', '2022-11-20', '2022-12-20', '500', '50', 1),
(11, 'Mexico', 'Quebec', 'Labrador Hotel', '52 234 24534', 4, 300, 'Miniclub;vue sur plage', '2022-03-01', '2022-03-15', '130', '25', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`idClient`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`idReservation`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `idReservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
