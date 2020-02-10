SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `dbtest`
--
CREATE DATABASE IF NOT EXISTS `dbtest` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dbtest`;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `numcontract` varchar(500) NOT NULL,
  `date-subscription` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`id_client`, `name`, `numcontract`, `date-subscription`) VALUES
(1, 'LAMBERT', 'XP864', '2019-06-14'),
(2, 'RICHARD', 'BF7571', '2015-12-19'),
(3, 'DUBOIS', 'IU16278', '2012-07-08'),
(4, 'PETIT', 'RZ64543', '1997-10-22');

-- --------------------------------------------------------

--
-- Structure de la table `commands`
--

CREATE TABLE `commands` (
  `id_command` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `date_command` date NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `commands`
--

INSERT INTO `commands` (`id_command`, `id_client`, `date_command`, `price`) VALUES
(1, 1, '2019-03-14', 100),
(2, 1, '2000-01-15', 150),
(3, 2, '2005-01-02', 5),
(4, 3, '2020-01-02', 1000);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `commands`
--
ALTER TABLE `commands`
  ADD PRIMARY KEY (`id_command`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `commands`
--
ALTER TABLE `commands`
  MODIFY `id_command` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
  
  
 
CREATE USER 'userweb'@'%' IDENTIFIED BY 'userweb@123';
GRANT ALL ON dbtest.* TO 'userweb'@'%';
FLUSH PRIVILEGES;
