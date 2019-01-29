/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE IF NOT EXISTS `smartacademy` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `smartacademy`;

CREATE TABLE IF NOT EXISTS `activities` (
  `id_activity` int(11) NOT NULL AUTO_INCREMENT,
  `headline` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `activity_text` varchar(5000) COLLATE utf8_bin DEFAULT NULL,
  `activity_img` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `activity_date` date DEFAULT NULL,
  PRIMARY KEY (`id_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;

DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `addUser`(
	IN `login` VARCHAR(50),
	IN `password` VARCHAR(50),
	IN `first_name` VARCHAR(50),
	IN `last_name` VARCHAR(50),
	IN `patronomic` VARCHAR(50),
	IN `birthday` DATE,
	IN `phone` INT



)
BEGIN
INSERT INTO users SET user_login=`login`, user_password=`password`, user_first_name=`first_name`, user_last_name=`last_name`, user_patronomic=`patronomic`, user_birthday=`birthday`, user_phone=`phone`;
END//
DELIMITER ;

CREATE TABLE IF NOT EXISTS `department` (
  `id_department` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `id_faculty` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_department`),
  KEY `XIF1department` (`id_faculty`),
  CONSTRAINT `department_ibfk_1` FOREIGN KEY (`id_faculty`) REFERENCES `faculty` (`id_faculty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `department` DISABLE KEYS */;
/*!40000 ALTER TABLE `department` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `documents` (
  `id_document` int(11) NOT NULL AUTO_INCREMENT,
  `document_name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `documentt_link` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id_document`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `faculty` (
  `id_faculty` int(11) NOT NULL AUTO_INCREMENT,
  `faculty_name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id_faculty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `faculty` DISABLE KEYS */;
/*!40000 ALTER TABLE `faculty` ENABLE KEYS */;

DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `getCountUnreadDialogs`(
	IN `user_id` INT
)
BEGIN
SELECT count(sender_id) FROM
(SELECT sender_id FROM messages WHERE adressee_id=user_id AND unread=1 GROUP BY sender_id) t1;
END//
DELIMITER ;

DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `getLastUserMessages`(
	IN `user_id` INT

)
BEGIN
SELECT * FROM messages WHERE messages.id_message IN (SELECT max(id_message) as id_message FROM
(SELECT id_message, adressee_id FROM messages WHERE sender_id=user_id
UNION
SELECT id_message, sender_id as 'adressee_id' FROM messages WHERE adressee_id=user_id) messages_id GROUP BY adressee_id) ORDER BY messages.message_date DESC;
END//
DELIMITER ;

CREATE TABLE IF NOT EXISTS `group` (
  `id_group` int(11) DEFAULT NULL,
  `group_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `group_sname` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `reciept_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `group` DISABLE KEYS */;
/*!40000 ALTER TABLE `group` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `idmessage` (
  `idmessage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `idmessage` DISABLE KEYS */;
INSERT INTO `idmessage` (`idmessage`) VALUES
	(29),
	(24),
	(31);
/*!40000 ALTER TABLE `idmessage` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `manuals` (
  `id_manual` int(11) NOT NULL AUTO_INCREMENT,
  `id_department` int(11) DEFAULT NULL,
  `id_document` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_manual`),
  KEY `XIF1manuals` (`id_department`),
  KEY `XIF2manuals` (`id_document`),
  CONSTRAINT `manuals_ibfk_1` FOREIGN KEY (`id_department`) REFERENCES `department` (`id_department`),
  CONSTRAINT `manuals_ibfk_2` FOREIGN KEY (`id_document`) REFERENCES `documents` (`id_document`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `manuals` DISABLE KEYS */;
/*!40000 ALTER TABLE `manuals` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `messages` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `adressee_id` int(11) NOT NULL,
  `message` varchar(1000) COLLATE utf8_bin NOT NULL,
  `message_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `unread` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_message`),
  KEY `FK_messages_students` (`sender_id`),
  KEY `FK_messages_students_2` (`adressee_id`),
  CONSTRAINT `FK_messages_students` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `FK_messages_students_2` FOREIGN KEY (`adressee_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (`id_message`, `sender_id`, `adressee_id`, `message`, `message_date`, `unread`) VALUES
	(53, 1, 1, '111', '2018-11-29 12:30:53', 0),
	(54, 1, 1, '123', '2018-12-17 18:11:03', 0),
	(55, 1, 1, '1233', '2018-12-17 18:11:03', 0),
	(56, 1, 1, '123', '2018-12-17 18:12:29', 0),
	(57, 1, 1, '111', '2018-12-17 18:12:29', 0),
	(58, 1, 1, '123', '2018-12-17 18:16:05', 0),
	(59, 1, 1, '123', '2018-12-17 18:16:05', 0),
	(60, 1, 1, '123', '2018-12-17 18:16:24', 0),
	(61, 1, 1, '111', '2018-12-17 18:16:24', 0),
	(62, 1, 1, '123', '2018-12-17 18:16:27', 0),
	(63, 1, 1, '123', '2018-12-17 18:16:30', 0),
	(64, 1, 1, 'Вася', '2018-12-17 18:16:37', 0),
	(65, 1, 1, 'Вася', '2018-12-17 18:16:40', 0),
	(66, 1, 1, 'Вася', '2018-12-17 18:16:49', 0),
	(67, 1, 1, 'Гусь', '2018-12-17 18:16:53', 0),
	(68, 1, 1, 'Гусь', '2018-12-17 18:18:28', 0),
	(69, 1, 1, 'Гусь', '2018-12-17 18:18:28', 0),
	(70, 1, 1, 'Гусь', '2018-12-17 18:18:32', 0),
	(71, 1, 1, 'Гусь', '2018-12-17 18:18:32', 0),
	(72, 1, 1, 'Гусь', '2018-12-17 18:18:35', 0),
	(73, 1, 1, 'Гусь', '2018-12-17 18:18:35', 0),
	(74, 1, 1, 'Gblj', '2018-12-17 18:18:45', 0),
	(75, 1, 1, 'Gblj', '2018-12-17 18:18:45', 0),
	(76, 1, 1, 'ddd', '2018-12-17 18:19:00', 0),
	(77, 1, 1, 'ddd', '2018-12-17 18:19:00', 0),
	(78, 1, 1, 'ddd\r\n', '2018-12-17 18:19:14', 0),
	(79, 1, 1, 'ddd\r\n', '2018-12-17 18:19:14', 0),
	(80, 1, 1, 'Смех', '2018-12-17 18:19:22', 0),
	(81, 1, 1, 'Смех', '2018-12-17 18:19:22', 0),
	(82, 1, 1, 'Тю', '2018-12-17 18:20:50', 0),
	(83, 1, 1, 'Пис', '2018-12-17 18:21:01', 0),
	(84, 1, 1, 'Пис', '2018-12-17 18:21:04', 0),
	(85, 1, 1, '123', '2018-12-17 18:21:10', 0),
	(86, 1, 1, '123', '2018-12-17 18:21:14', 0),
	(87, 1, 1, '11', '2018-12-17 18:21:25', 0),
	(88, 1, 1, '123', '2018-12-17 18:23:45', 0),
	(89, 1, 1, '123', '2018-12-17 18:26:05', 0),
	(90, 1, 1, 'ddd', '2018-12-17 18:26:32', 0),
	(91, 1, 1, 'asd', '2018-12-17 18:26:46', 0),
	(92, 1, 1, '123', '2018-12-17 18:30:34', 0),
	(93, 1, 1, 'лл', '2018-12-17 18:31:02', 0);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;

DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `p1`(
	IN `user1` INT




)
BEGIN
 DECLARE a,b int;
 DECLARE cur1 CURSOR FOR SELECT users.user_id FROM users; 
 DECLARE CONTINUE HANDLER FOR NOT FOUND SET b = 1; 
 truncate idmessage;
    OPEN cur1; 
    
    SET b = 0; 

  
   

    WHILE b = 0 DO 

        FETCH cur1 INTO a; 

        IF b = 0 THEN 

        insert into idmessage (idmessage)  ( SELECT messages.id_message FROM messages where messages.message_date=(
             SELECT max(messages.message_date) FROM messages where (messages.sender_id=user1 and messages.adressee_id=a) 
          or (messages.sender_id=a and messages.adressee_id=user1)));
    END IF; 

    END WHILE; 

   

    CLOSE cur1; 

SELECT * FROM messages where messages.id_message IN (SELECT * FROM idmessage);

END//
DELIMITER ;

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_hash` varchar(50) COLLATE utf8_bin NOT NULL,
  `user_ip` int(11) NOT NULL,
  `user_agent` varchar(200) COLLATE utf8_bin NOT NULL,
  `auth_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `destroyed` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`session_id`),
  KEY `FK_sessions_users` (`user_id`),
  CONSTRAINT `FK_sessions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` (`session_id`, `user_id`, `user_hash`, `user_ip`, `user_agent`, `auth_date`, `destroyed`) VALUES
	(33, 1, '45de686b65660a348b595bba7d0c54b7', 1845373467, 'Chrome', '2018-11-19 00:10:36', 0),
	(34, 1, 'ee29a299e7494b357c1fc16d8750f7e4', 1845373467, 'Chrome', '2018-11-19 00:12:29', 0),
	(36, 1, 'f86a96e0c3bb88a397282c510953e1ba', 1845373467, 'Chrome', '2018-11-19 01:16:08', 1),
	(37, 1, '4884f82b2f78b4f01fce4724f8d03ec3', 1845373467, 'Chrome', '2018-11-19 01:16:32', 1),
	(38, 1, 'b2830c26c6ac84af5da00381ded3fb89', 1845373467, 'Chrome', '2018-11-19 01:17:21', 0),
	(39, 1, '56da802632607c8d272fc81b2a0d311c', 1845373467, 'Chrome', '2018-11-19 03:37:16', 0),
	(41, 1, '3585a97daabd8b7825ba1a66e874b114', 1845373467, 'Chrome', '2018-11-20 12:38:55', 0),
	(43, 777, 'ed0a84d392caf5cc0db8580ba8e5c905', 1845373467, 'Chrome', '2018-11-20 22:12:01', 1),
	(44, 777, '62d7d7c700bb308b72896a78f7b0c126', 1845373467, 'Chrome', '2018-11-20 22:29:47', 1),
	(45, 1, '9023e8f04b48e3de705039bc67b470ed', 1845373467, 'Chrome', '2018-11-20 22:45:39', 1),
	(46, 8, 'd8ab36b23cf08602efd353f8539ca28b', 1845373467, 'Chrome', '2018-11-21 10:48:52', 0),
	(48, 1, '7c680081c9920d2e5872e213fcecf60d', 1845373467, 'Chrome', '2018-11-21 17:04:45', 0),
	(49, 1, '06ad84034be741ee99991cb2e0d99eee', 1845373467, 'Chrome', '2018-11-21 17:20:45', 0),
	(50, 1, 'ab522a4c5f519ec0b166b33ee7f3db24', 1845373467, 'Opera', '2018-11-21 17:32:25', 0),
	(51, 1, '69d3aca89ef5ffc9026149cd335b036e', 1845373467, 'Chrome', '2018-11-21 17:59:55', 0),
	(52, 1, 'a4b6b5a610ea92b11be99bb1738b5e79', 1845373467, 'Chrome', '2018-11-21 20:09:16', 1),
	(53, 1, '88b382b6ed6b64f4885002b839770668', 1845373467, 'Chrome', '2018-11-21 20:09:47', 0),
	(54, 1, '3963340a48ac603073d53025819a4730', 1845373467, 'Chrome', '2018-11-21 20:12:31', 0),
	(55, 1, '5d33d3ddaf8fc78157e8d54a03f1e0e0', 1845373467, 'Chrome', '2018-11-24 23:13:41', 1),
	(56, 1, '0397286da2134b3dfa4180ffa4ebd38c', 1845373467, 'Chrome', '2018-11-26 01:32:42', 0),
	(57, 2, 'e85e79a332e27157b6906439fcb9b12d', 1845373467, 'Chrome', '2018-11-26 01:33:15', 1),
	(58, 2, '3911375a9f2a4b9f0715e1106c78162d', 1845373467, 'Opera', '2018-11-26 01:56:33', 1),
	(59, 2, 'a2dd8ecb8b48a6d25156416b94f37d73', 1427183682, 'Chrome', '2018-11-26 01:59:05', 1),
	(60, 2, '93c1015c86eef248e56907b158c6fb4c', 167911567, 'iPhone', '2018-11-26 02:08:02', 1),
	(61, 8, '2f907ec80b28a679983e203f345a7aed', 167911230, 'Chrome', '2018-11-26 02:18:23', 1),
	(62, 8, 'f80b5aa78fb4849aa1a3bbe862ac8608', 1845373467, 'Chrome', '2018-11-26 02:28:19', 1),
	(63, 8, '0b64ae7c78f2052f63bd1b8e4888d6f2', 1845373467, 'Chrome', '2018-11-26 02:57:57', 1),
	(64, 6, '5b0b785421a3d1f98e818a8c386d55ff', 1845373467, 'Chrome', '2018-11-28 11:01:01', 1),
	(65, 2, '7b397ebcadd76b723f384dfa1af7205c', 1845373467, 'Chrome', '2018-11-28 12:58:51', 0),
	(66, 777, '9f8f4e51ae8b76672075d5730c3657e8', 1845373467, 'Chrome', '2018-11-30 22:56:53', 1);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `students` (
  `id_student` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `last_name` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `patronymic` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `id_department` int(11) DEFAULT NULL,
  `phone_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_student`),
  KEY `XIF1students` (`id_department`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`id_department`) REFERENCES `department` (`id_department`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `students` DISABLE KEYS */;
/*!40000 ALTER TABLE `students` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(30) COLLATE utf8_bin NOT NULL,
  `user_password` varchar(50) COLLATE utf8_bin NOT NULL,
  `user_first_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `user_last_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `user_patronomic` varchar(50) COLLATE utf8_bin NOT NULL,
  `user_birthday` date NOT NULL,
  `user_phone` bigint(20) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=778 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `user_login`, `user_password`, `user_first_name`, `user_last_name`, `user_patronomic`, `user_birthday`, `user_phone`) VALUES
	(1, 'dmitry_kostik', 'f0d121f97944958a5affc8755e59129c', 'Дмитрий', 'Костик', 'Константинович', '1998-09-10', 380713254745),
	(2, 'petrov', 'd9b1d7db4cd6e70935368a1efb10e377', 'Петров', 'Петр', 'Петрович', '1998-06-13', 380713426479),
	(3, 'sidorov', 'd9b1d7db4cd6e70935368a1efb10e377', 'Сидоров', 'Сидр', 'Сидорович', '1998-06-13', 380713426479),
	(4, 'rabbit', 'd9b1d7db4cd6e70935368a1efb10e377', 'Заяц', 'Зайцов', 'Зайцович', '1998-06-13', 380713426479),
	(5, 'abba', 'd9b1d7db4cd6e70935368a1efb10e377', 'Abba', 'Ab', 'Зайцович', '1998-06-13', 380713426479),
	(6, 'bear', 'd9b1d7db4cd6e70935368a1efb10e377', 'Bear', 'Bear', 'Зайцович', '1998-06-13', 380713426479),
	(7, 'cat', 'd9b1d7db4cd6e70935368a1efb10e377', 'Cat', 'Catty', 'Зайцович', '1998-06-13', 380713426479),
	(8, 'kolchev', 'd9b1d7db4cd6e70935368a1efb10e377', 'Колчев', 'Ярослав', 'Михайлович', '1998-06-13', 380713426479),
	(9, 'ivanov', 'd9b1d7db4cd6e70935368a1efb10e377', 'Иванов', 'Иван', 'Петрович', '1998-06-13', 380713426479),
	(777, 'lisenok', 'd9b1d7db4cd6e70935368a1efb10e377', 'Алина', 'Лисичка', 'Игоревна', '1998-06-13', 380713426479);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
