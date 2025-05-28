SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE IF NOT EXISTS `bodies_lists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `bodies` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `calendars` (
  `user_id` int NOT NULL,
  `bodies_list_id` int NOT NULL,
  `moon_phase_id` int NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `bodies_list_id` (`bodies_list_id`),
  KEY `moon_phase_id` (`moon_phase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `moon_phases` (
  `id` int NOT NULL AUTO_INCREMENT,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `date` date NOT NULL,
  `image_url` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `salt` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `longitude` int DEFAULT NULL,
  `latitude` int DEFAULT NULL,
  `last_selected_date` date DEFAULT NULL,
  `last_selected_time` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (
    `first_name`,
    `last_name`,
    `email`,
    `password`,
    `salt`,
    `token`,
    `is_verified`,
    `longitude`,
    `latitude`,
    `last_selected_date`,
    `last_selected_time`
) VALUES (
             'vlada',
             'kolbeko',
             'vlada@example.com',
             'a66d94a5e7279096b1a87e47e6b0f1a5b0c2f1b5e86e2c5f5e5f5a5e5f5a5e5',
             'abc123',
             'dummy_token_1234567890',
             0,
             NULL,
             NULL,
             NULL,
             NULL
         );

ALTER TABLE `calendars`
  ADD CONSTRAINT `calendars_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `calendars_ibfk_2` FOREIGN KEY (`bodies_list_id`) REFERENCES `bodies_lists` (`id`),
  ADD CONSTRAINT `calendars_ibfk_3` FOREIGN KEY (`moon_phase_id`) REFERENCES `moon_phases` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
