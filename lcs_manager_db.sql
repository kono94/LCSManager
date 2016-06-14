-- phpMyAdmin SQL Dump
-- version 4.2.12
-- http://www.phpmyadmin.net
--
-- Host: rdbms
-- Erstellungszeit: 29. Feb 2016 um 15:00
-- Server Version: 5.5.47-log
-- PHP-Version: 5.5.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `DB2436891`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
`id` int(5) NOT NULL,
  `name` varchar(40) COLLATE latin1_german1_ci NOT NULL,
  `name_short` varchar(10) COLLATE latin1_german1_ci NOT NULL,
  `flag_image` varchar(300) COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `countries`
--

INSERT INTO `countries` (`id`, `name`, `name_short`, `flag_image`) VALUES
(1, 'United States', 'us', ''),
(2, 'Germany', 'ger', ''),
(3, 'France', 'fr', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` bigint(20) unsigned NOT NULL,
  `team_a_id` int(5) NOT NULL,
  `team_b_id` int(5) NOT NULL,
  `region_id` int(2) NOT NULL,
  `winning_team_id` int(5) NOT NULL,
  `week_id` int(3) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `games_players`
--

CREATE TABLE IF NOT EXISTS `games_players` (
  `id` bigint(20) unsigned NOT NULL,
  `game_id` bigint(20) unsigned NOT NULL,
  `player_id` int(5) unsigned NOT NULL,
  `kills` int(5) NOT NULL,
  `deaths` int(5) NOT NULL,
  `assists` int(5) NOT NULL,
  `cs` int(5) NOT NULL,
  `match_rating` int(5) NOT NULL,
  `total_points` int(5) NOT NULL,
  `new_price` int(10) NOT NULL,
  `price_change` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `leagues`
--

CREATE TABLE IF NOT EXISTS `leagues` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(30) COLLATE latin1_german1_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(20) COLLATE latin1_german1_ci NOT NULL,
  `admin_user_id` bigint(20) unsigned NOT NULL,
  `note` text COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `leagues`
--

INSERT INTO `leagues` (`id`, `name`, `created`, `password`, `admin_user_id`, `note`) VALUES
(1, 'testleague', '2016-02-15 15:39:34', '123', 3, 'hallo note');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `meta`
--

CREATE TABLE IF NOT EXISTS `meta` (
`id` int(10) unsigned NOT NULL,
  `start_money` int(10) NOT NULL DEFAULT '800000',
  `eu_open` tinyint(4) NOT NULL,
  `na_open` tinyint(4) NOT NULL,
  `current_week` int(2) NOT NULL,
  `default_history_week` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `meta`
--

INSERT INTO `meta` (`id`, `start_money`, `eu_open`, `na_open`, `current_week`, `default_history_week`) VALUES
(1, 800000, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `players`
--

CREATE TABLE IF NOT EXISTS `players` (
`id` int(5) unsigned NOT NULL,
  `nickname` varchar(25) COLLATE latin1_german1_ci NOT NULL,
  `first_name` varchar(25) COLLATE latin1_german1_ci NOT NULL,
  `last_name` varchar(25) COLLATE latin1_german1_ci NOT NULL,
  `image` varchar(300) COLLATE latin1_german1_ci NOT NULL,
  `region` int(2) NOT NULL,
  `role` int(2) NOT NULL,
  `age` int(3) NOT NULL,
  `country` int(5) NOT NULL,
  `team` int(5) NOT NULL,
  `price` int(10) NOT NULL,
  `total_points` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `players`
--

INSERT INTO `players` (`id`, `nickname`, `first_name`, `last_name`, `image`, `region`, `role`, `age`, `country`, `team`, `price`, `total_points`) VALUES
(2, 'test', 'firstname', 'lastname', 'https://i.imgur.com/2mKrsCX.png', 0, 1, 0, 1, 1, 25000, 13),
(3, 'Aphromoo', 'Zaqueri', 'Black', 'http://hydra-media.cursecdn.com/lol.gamepedia.com/thumb/1/13/Aphromoo.jpg/225px-Aphromoo.jpg?version=c9d1d0d0693360b776f68655377a09f1', 0, 4, 23, 1, 1, 85000, 120);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `regions`
--

CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(2) NOT NULL,
  `name` varchar(30) COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `regions`
--

INSERT INTO `regions` (`id`, `name`) VALUES
(0, 'eu'),
(1, 'na');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(2) NOT NULL,
  `short` varchar(10) COLLATE latin1_german1_ci NOT NULL,
  `long` varchar(25) COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `roles`
--

INSERT INTO `roles` (`id`, `short`, `long`) VALUES
(1, 'top', 'Top Lane'),
(2, 'jungle', 'Jungler'),
(3, 'mid', 'Mid Lane'),
(4, 'supp', 'Support'),
(5, 'adc', 'Marksman');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
`id` int(5) NOT NULL,
  `name` varchar(40) COLLATE latin1_german1_ci NOT NULL,
  `name_short` varchar(10) COLLATE latin1_german1_ci NOT NULL,
  `image` varchar(300) COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `teams`
--

INSERT INTO `teams` (`id`, `name`, `name_short`, `image`) VALUES
(1, 'Team Solo Mid', 'TSM', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` bigint(20) unsigned NOT NULL,
  `username` varchar(25) COLLATE latin1_german1_ci NOT NULL,
  `display_name` varchar(25) COLLATE latin1_german1_ci NOT NULL,
  `email` varchar(200) COLLATE latin1_german1_ci NOT NULL,
  `access_token` varchar(40) COLLATE latin1_german1_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `money` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `display_name`, `email`, `access_token`, `created`, `money`) VALUES
(3, 'mrmiier', 'MrMiier', 'xchaosninjax55@web.de', '9ab48ygdpoofvuobypedsym38d6xyc', '2016-02-02 12:44:46', 535000);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_leagues`
--

CREATE TABLE IF NOT EXISTS `user_leagues` (
`id` int(10) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `league_id` int(10) unsigned NOT NULL,
  `joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `user_leagues`
--

INSERT INTO `user_leagues` (`id`, `user_id`, `league_id`, `joined`) VALUES
(1, 3, 1, '2016-02-15 15:39:53');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_money`
--

CREATE TABLE IF NOT EXISTS `user_money` (
`id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `region_id` int(2) NOT NULL,
  `amount` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `user_money`
--

INSERT INTO `user_money` (`id`, `user_id`, `region_id`, `amount`, `created`) VALUES
(1, 3, 0, 50000, '2016-02-16 02:00:00'),
(2, 3, 1, 50000, '2016-02-16 03:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_players`
--

CREATE TABLE IF NOT EXISTS `user_players` (
`id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `player_id` int(5) unsigned DEFAULT NULL,
  `position` int(2) NOT NULL,
  `placed_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bought_for` int(10) NOT NULL,
  `region` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `user_players`
--

INSERT INTO `user_players` (`id`, `user_id`, `player_id`, `position`, `placed_time`, `bought_for`, `region`) VALUES
(21, 3, NULL, 1, '2016-02-15 11:51:51', 0, 0),
(22, 3, NULL, 2, '2016-02-12 13:16:41', 0, 0),
(23, 3, NULL, 3, '2016-02-15 11:48:34', 0, 0),
(24, 3, NULL, 4, '2016-02-15 11:51:51', 0, 0),
(25, 3, NULL, 5, '2016-02-15 11:51:34', 0, 0),
(26, 3, 3, 6, '2016-02-16 13:10:11', 85000, 0),
(27, 3, NULL, 7, '2016-02-15 14:46:48', 0, 0),
(28, 3, NULL, 8, '2016-02-15 12:15:32', 0, 0),
(29, 3, NULL, 9, '2016-02-12 13:58:22', 0, 0),
(30, 3, NULL, 10, '2016-02-16 13:10:05', 0, 0),
(31, 3, NULL, 1, '2016-02-11 15:53:15', 0, 1),
(32, 3, NULL, 2, '2016-02-11 15:53:24', 0, 1),
(33, 3, NULL, 3, '2016-02-11 15:53:27', 0, 1),
(34, 3, NULL, 4, '2016-02-11 15:53:36', 0, 1),
(35, 3, NULL, 5, '2016-02-11 15:53:54', 0, 1),
(36, 3, NULL, 6, '2016-02-15 12:25:16', 0, 1),
(37, 3, NULL, 7, '2016-02-15 11:50:33', 0, 1),
(38, 3, NULL, 8, '2016-02-11 15:53:45', 0, 1),
(39, 3, NULL, 9, '2016-02-11 15:53:42', 0, 1),
(40, 3, NULL, 10, '2016-02-11 15:53:39', 0, 1),
(41, 3, NULL, 11, '2016-02-15 12:15:35', 0, 0),
(42, 3, NULL, 12, '2016-02-15 11:51:40', 0, 0),
(43, 3, NULL, 13, '2016-02-14 12:45:12', 0, 0),
(44, 3, NULL, 11, '2016-02-12 13:33:07', 0, 1),
(45, 3, NULL, 12, '2016-02-12 13:33:07', 0, 1),
(46, 3, NULL, 13, '2016-02-12 13:33:07', 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_players_history`
--

CREATE TABLE IF NOT EXISTS `user_players_history` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `games_players_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `weeks`
--

CREATE TABLE IF NOT EXISTS `weeks` (
  `id` int(3) NOT NULL,
  `number` int(3) NOT NULL,
  `region_id` int(2) NOT NULL,
  `start_time` datetime NOT NULL,
  `closing_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `countries`
--
ALTER TABLE `countries`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `games`
--
ALTER TABLE `games`
 ADD PRIMARY KEY (`id`), ADD KEY `team_a_id` (`team_a_id`,`team_b_id`,`region_id`), ADD KEY `winning_team_id` (`winning_team_id`,`week_id`);

--
-- Indizes für die Tabelle `games_players`
--
ALTER TABLE `games_players`
 ADD PRIMARY KEY (`id`), ADD KEY `game_id` (`game_id`,`player_id`), ADD KEY `player_id` (`player_id`);

--
-- Indizes für die Tabelle `leagues`
--
ALTER TABLE `leagues`
 ADD PRIMARY KEY (`id`), ADD KEY `admin_user_id` (`admin_user_id`);

--
-- Indizes für die Tabelle `meta`
--
ALTER TABLE `meta`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `players`
--
ALTER TABLE `players`
 ADD PRIMARY KEY (`id`), ADD KEY `region` (`region`), ADD KEY `role` (`role`), ADD KEY `country` (`country`), ADD KEY `team` (`team`);

--
-- Indizes für die Tabelle `regions`
--
ALTER TABLE `regions`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `teams`
--
ALTER TABLE `teams`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user_leagues`
--
ALTER TABLE `user_leagues`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`,`league_id`), ADD KEY `league_id` (`league_id`);

--
-- Indizes für die Tabelle `user_money`
--
ALTER TABLE `user_money`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`,`region_id`), ADD KEY `region_id` (`region_id`);

--
-- Indizes für die Tabelle `user_players`
--
ALTER TABLE `user_players`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`,`player_id`), ADD KEY `region` (`region`), ADD KEY `player_id` (`player_id`);

--
-- Indizes für die Tabelle `user_players_history`
--
ALTER TABLE `user_players_history`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`,`games_players_id`), ADD KEY `games_players_id` (`games_players_id`);

--
-- Indizes für die Tabelle `weeks`
--
ALTER TABLE `weeks`
 ADD PRIMARY KEY (`id`), ADD KEY `region_id` (`region_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `countries`
--
ALTER TABLE `countries`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `leagues`
--
ALTER TABLE `leagues`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `meta`
--
ALTER TABLE `meta`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `players`
--
ALTER TABLE `players`
MODIFY `id` int(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `teams`
--
ALTER TABLE `teams`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `user_leagues`
--
ALTER TABLE `user_leagues`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `user_money`
--
ALTER TABLE `user_money`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `user_players`
--
ALTER TABLE `user_players`
MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `games_players`
--
ALTER TABLE `games_players`
ADD CONSTRAINT `games_players_constraint` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`),
ADD CONSTRAINT `games_players_game_id_constraint` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `leagues`
--
ALTER TABLE `leagues`
ADD CONSTRAINT `admin_user_id_constraint` FOREIGN KEY (`admin_user_id`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `players`
--
ALTER TABLE `players`
ADD CONSTRAINT `country_player_constraint` FOREIGN KEY (`country`) REFERENCES `countries` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `player_region_contraint` FOREIGN KEY (`region`) REFERENCES `regions` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `player_team_constraint` FOREIGN KEY (`team`) REFERENCES `teams` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `role_constraint` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `user_leagues`
--
ALTER TABLE `user_leagues`
ADD CONSTRAINT `user_league_constraint` FOREIGN KEY (`league_id`) REFERENCES `leagues` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `user__league_id_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `user_money`
--
ALTER TABLE `user_money`
ADD CONSTRAINT `money_region_constraint` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`),
ADD CONSTRAINT `money_user_constaint` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `user_players`
--
ALTER TABLE `user_players`
ADD CONSTRAINT `user_player_constraint` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD CONSTRAINT `region_constraint` FOREIGN KEY (`region`) REFERENCES `regions` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `user_players_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `user_players_history`
--
ALTER TABLE `user_players_history`
ADD CONSTRAINT `game_players_history_constraint` FOREIGN KEY (`games_players_id`) REFERENCES `games_players` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `history_user_constraint` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
