-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : ven. 11 juil. 2025 à 00:24
-- Version du serveur : 10.4.34-MariaDB-1:10.4.34+maria~ubu2004
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecoride`
--

-- --------------------------------------------------------

--
-- Structure de la table `preferences_utilisateur`
--

CREATE TABLE `preferences_utilisateur` (
  `utilisateur_id` int(11) NOT NULL,
  `ambiance` enum('Je suis très bavard','Quand je me sens à l’aise, j’aime discuter et partager','Je suis plutôt quelqu’un de réservé.') DEFAULT NULL,
  `musique` enum('De la musique du début à la fin !','Tout dépend du style musical','Rien ne vaut le silence') DEFAULT NULL,
  `fumeur` enum('Fumer en voiture ne me dérange pas','Ok pour des pauses cigarette à l’extérieur','Merci de ne pas fumer') DEFAULT NULL,
  `animaux` enum('Les animaux sont les bienvenus !','Voyager avec un animal, pourquoi pas selon le cas','Je préfère voyager sans animaux.') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `preferences_utilisateur`
--

INSERT INTO `preferences_utilisateur` (`utilisateur_id`, `ambiance`, `musique`, `fumeur`, `animaux`) VALUES
(1, 'Quand je me sens à l’aise, j’aime discuter et partager', 'Tout dépend du style musical', 'Ok pour des pauses cigarette à l’extérieur', 'Voyager avec un animal, pourquoi pas selon le cas'),
(2, 'Quand je me sens à l’aise, j’aime discuter et partager', 'Tout dépend du style musical', 'Ok pour des pauses cigarette à l’extérieur', 'Voyager avec un animal, pourquoi pas selon le cas'),
(5, NULL, 'Tout dépend du style musical', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trajet_id` int(11) NOT NULL,
  `statut` enum('en attente','confirmé','annulé') DEFAULT 'en attente',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `trajets`
--

CREATE TABLE `trajets` (
  `id` int(11) NOT NULL,
  `conducteur_id` int(11) NOT NULL,
  `vehicule_id` int(11) NOT NULL,
  `ville_depart` varchar(100) NOT NULL,
  `ville_arrivee` varchar(100) NOT NULL,
  `date_depart` datetime NOT NULL,
  `prix` decimal(5,2) NOT NULL,
  `places` int(11) NOT NULL,
  `duree` time DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `trajets`
--

INSERT INTO `trajets` (`id`, `conducteur_id`, `vehicule_id`, `ville_depart`, `ville_arrivee`, `date_depart`, `prix`, `places`, `duree`, `created_at`) VALUES
(4, 1, 1, 'Paris', 'Lyon', '2025-06-10 14:00:00', 55.00, 3, '05:30:00', '2025-04-30 15:49:05'),
(5, 2, 2, 'Paris', 'Lyon', '2025-05-10 12:00:00', 70.00, 2, '05:10:00', '2025-04-30 16:11:55'),
(12, 5, 2, 'Paris', 'Lyon', '2025-05-10 10:00:00', 60.00, 3, '05:20:00', '2025-07-02 18:23:10');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('passager','conducteur','admin') NOT NULL DEFAULT 'passager',
  `credits` int(11) DEFAULT 20,
  `note` decimal(2,1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `photo` varchar(255) DEFAULT 'default-profile.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `password`, `role`, `credits`, `note`, `is_active`, `created_at`, `photo`) VALUES
(1, 'Sophie', 'Sophie@example.com', '$2y$12$iUFj6TRjUSCxGkiit637z.T/zmulPD2WzAZs55dUf/BsybzkcqMee', 'conducteur', 20, 4.0, 1, '2025-04-23 09:01:57', 'sophie.jpg'),
(2, 'David', 'test@ecoride.com', '$2y$12$5G6Qt7zPGsuIj6/iZqS4fOeZwdG3W9fvbhdYfIbeyTyvOcDjjJyn.', 'conducteur', 30, 4.5, 1, '2025-04-30 16:11:55', 'david.jpg'),
(3, 'admin', 'admin@ecoride.fr', '$2y$10$6x3/pH5sGZK2kpUO4U2RmenQHEFDpsBsQaoCODfJnqtnmBUeSEOH.', 'admin', 20, NULL, 1, '2025-05-01 13:42:56', 'default-profile.png'),
(4, 'antoine', 'test34@ecoride.com', '$2y$10$UGk62pznoKqa30/MG53OauzXPVBOV.rtmtKWWuw1goHUsSoey4di2', 'passager', 20, 3.8, 1, '2025-05-12 22:55:23', 'default-profile.png'),
(5, 'Marc', 'marc@test.com', '$2y$10$beo6mlt524q9uDIajFVAPOKPp7UbdCZBhZ8pZJLATbXCEsSRybZEm', 'conducteur', 20, 2.8, 1, '2025-06-26 21:44:41', 'default-profile.png'),
(7, 'henry', 'henry@test.com', '$2y$10$UGk62pznoKqa30/MG53OauzXPVBOV.rtmtKWWuw1goHUsSoey4di2', 'passager', 20, 5.0, 1, '2025-06-26 22:54:00', 'default-profile.png');

-- --------------------------------------------------------

--
-- Structure de la table `vehicules`
--

CREATE TABLE `vehicules` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `modele` varchar(50) DEFAULT NULL,
  `type_energie` enum('essence','diesel','électrique') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vehicules`
--

INSERT INTO `vehicules` (`id`, `user_id`, `marque`, `modele`, `type_energie`, `created_at`) VALUES
(1, 1, 'Renault', 'Clio V', 'essence', '2025-04-30 15:48:51'),
(2, 2, 'Volkswagen', 'Golf 8', 'diesel', '2025-04-30 16:11:55'),
(3, 7, 'Peugeot', '208', 'essence', '2025-07-02 18:33:21');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `preferences_utilisateur`
--
ALTER TABLE `preferences_utilisateur`
  ADD PRIMARY KEY (`utilisateur_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `trajet_id` (`trajet_id`);

--
-- Index pour la table `trajets`
--
ALTER TABLE `trajets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conducteur_id` (`conducteur_id`),
  ADD KEY `vehicule_id` (`vehicule_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `unique_pseudo` (`pseudo`);

--
-- Index pour la table `vehicules`
--
ALTER TABLE `vehicules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `trajets`
--
ALTER TABLE `trajets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `vehicules`
--
ALTER TABLE `vehicules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `preferences_utilisateur`
--
ALTER TABLE `preferences_utilisateur`
  ADD CONSTRAINT `preferences_utilisateur_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`trajet_id`) REFERENCES `trajets` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `trajets`
--
ALTER TABLE `trajets`
  ADD CONSTRAINT `trajets_ibfk_1` FOREIGN KEY (`conducteur_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trajets_ibfk_2` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicules` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `vehicules`
--
ALTER TABLE `vehicules`
  ADD CONSTRAINT `vehicules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
