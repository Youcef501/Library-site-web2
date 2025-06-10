-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 08 juin 2025 à 23:02
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `library`
--

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `author`
--

INSERT INTO `author` (`id`, `nom`, `prenom`) VALUES
(1, 'Orwell', 'Georges'),
(2, 'Zola', 'Emile'),
(3, 'Coulcher', 'Patrick');

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `id_category` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `title`, `price`, `stock`, `date`, `id_category`, `author_id`) VALUES
(1, 'MIST & MOUNTAINS', 16.50, 10, '2025-06-08', NULL, 1),
(2, 'Forest Journey', 15.50, 8, '2025-06-08', NULL, 3);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `nom` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','completed','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_email`, `total_amount`, `order_date`, `status`) VALUES
(1, 'Client Test', 'client@test.com', 32.00, '2025-06-01 18:20:36', 'pending'),
(2, 'benhassen', 'benhaasen@', 48.50, '2025-06-01 18:29:26', 'pending'),
(3, 'youssef ben hassen', 'ben hassen youcef 457@gmail.com', 63.00, '2025-06-01 18:31:14', 'pending'),
(4, 'aloo', 'aloo@gmail.com', 65.00, '2025-06-01 18:38:38', 'pending'),
(6, 'joujou', 'jougou@gmail.com', 48.50, '2025-06-01 19:31:00', 'pending'),
(7, 'youssef', 'ben@gmail.com', 78.50, '2025-06-02 07:17:30', 'pending'),
(8, 'youcef ', 'benhssan@gmail.com', 96.00, '2025-06-02 11:23:54', 'pending'),
(9, 'youssef', 'benhassrn@gmail.cim', 112.50, '2025-06-02 12:04:33', 'pending'),
(10, 'youssef', 'benhass@gmail.com', 78.50, '2025-06-02 12:27:23', 'pending'),
(11, 'youssef', 'brfdgfg@', 80.50, '2025-06-02 13:20:46', 'pending'),
(12, 'rtththr', 'vvfsvsfsf', 32.00, '2025-06-02 14:03:07', 'pending');

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `book_id`, `quantity`, `unit_price`) VALUES
(1, 1, 1, 1, 16.50),
(2, 1, 2, 1, 15.50),
(3, 2, 1, 2, 16.50),
(4, 2, 1, 1, 15.50),
(5, 3, 1, 1, 16.50),
(6, 3, 1, 3, 15.50),
(7, 4, 1, 3, 16.50),
(8, 4, 1, 1, 15.50),
(11, 6, 1, 2, 16.50),
(12, 6, 1, 1, 15.50),
(13, 7, 1, 1, 16.50),
(14, 7, 1, 4, 15.50),
(15, 8, 1, 3, 16.50),
(16, 8, 1, 3, 15.50),
(17, 9, 1, 4, 16.50),
(18, 9, 1, 3, 15.50),
(19, 10, 1, 1, 16.50),
(20, 10, 1, 4, 15.50),
(21, 11, 1, 3, 16.50),
(22, 11, 1, 2, 15.50),
(23, 12, 1, 1, 16.50),
(24, 12, 1, 1, 15.50);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `fk_author` (`author_id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `fk_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`);

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
