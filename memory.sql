-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 07 Paź 2017, 10:09
-- Wersja serwera: 5.7.14
-- Wersja PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `memory`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `boards`
--

CREATE TABLE `boards` (
  `id` int(10) NOT NULL,
  `game_id` int(10) NOT NULL,
  `element_col` int(2) NOT NULL,
  `element_row` int(2) NOT NULL,
  `value` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `state` tinyint(4) DEFAULT NULL,
  `user` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `devices`
--

CREATE TABLE `devices` (
  `id` int(10) UNSIGNED NOT NULL,
  `imei` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `games`
--

CREATE TABLE `games` (
  `id` int(10) NOT NULL,
  `name` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `tiles` int(11) NOT NULL,
  `turn` int(11) NOT NULL,
  `theme` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `level` int(11) NOT NULL,
  `background` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `geolocs`
--

CREATE TABLE `geolocs` (
  `id` int(10) UNSIGNED NOT NULL,
  `imei` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `deviceid` int(10) DEFAULT NULL,
  `clientdata` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `serverdata` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `altitude` double DEFAULT NULL,
  `accuracy` float NOT NULL,
  `speed` float NOT NULL,
  `bearing` float NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `devicetime` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `memories`
--

CREATE TABLE `memories` (
  `id` int(10) NOT NULL,
  `game_id` int(10) NOT NULL,
  `element_col` int(2) NOT NULL,
  `element_row` int(2) NOT NULL,
  `value` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pictures`
--

CREATE TABLE `pictures` (
  `id` int(10) NOT NULL,
  `theme` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `number` int(2) NOT NULL,
  `img_src` varchar(1024) COLLATE utf8_polish_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pictures`
--

INSERT INTO `pictures` (`id`, `theme`, `number`, `img_src`, `created_at`, `modified`) VALUES
(1, 'numbers', 0, '0.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(2, 'numbers', 1, '1.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(3, 'numbers', 2, '2.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(4, 'numbers', 3, '3.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(5, 'numbers', 4, '4.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(6, 'numbers', 5, '5.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(7, 'numbers', 6, '6.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(8, 'numbers', 7, '7.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(9, 'numbers', 8, '8.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(10, 'numbers', 9, '9.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(11, 'numbers', 10, '10.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(12, 'numbers', 11, '11.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(13, 'numbers', 12, '12.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(14, 'numbers', 13, '13.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(15, 'numbers', 14, '14.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(16, 'numbers', 15, '15.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(17, 'numbers', 16, '16.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(18, 'numbers', 17, '17.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(19, 'numbers', 18, '18.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(20, 'numbers', 19, '19.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(21, 'numbers', 20, '20.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(22, 'numbers', 21, '21.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(23, 'numbers', 22, '22.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(24, 'numbers', 23, '23.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(25, 'numbers', 24, '24.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(26, 'numbers', 25, '25.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(27, 'numbers', 26, '26.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(28, 'numbers', 27, '27.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(29, 'numbers', 28, '28.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(30, 'numbers', 29, '29.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(31, 'numbers', 30, '30.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(32, 'numbers', 31, '31.png', '2015-10-26 19:33:54', '0000-00-00 00:00:00'),
(33, 'cities-old', 0, 'newyork.jpg', '2015-10-31 02:27:36', '0000-00-00 00:00:00'),
(34, 'cities-old', 1, 'paris.png', '2015-10-31 02:18:56', '0000-00-00 00:00:00'),
(35, 'cities-old', 2, 'rome.jpg', '2015-10-31 02:20:45', '0000-00-00 00:00:00'),
(36, 'cities-old', 3, 'amsterdam.jpg', '2015-10-31 02:22:26', '0000-00-00 00:00:00'),
(37, 'cities-old', 4, 'madrid.jpg', '2015-10-31 02:23:43', '0000-00-00 00:00:00'),
(38, 'cities-old', 5, 'Barcelona.jpg', '2015-10-31 02:24:30', '0000-00-00 00:00:00'),
(39, 'cities-old', 6, 'washington.png', '2015-10-31 02:25:11', '0000-00-00 00:00:00'),
(40, 'cities-old', 7, 'sydney.jpg', '2015-10-31 02:25:52', '0000-00-00 00:00:00'),
(41, 'cities-old', 8, 'london.jpg', '2015-10-31 02:26:35', '0000-00-00 00:00:00'),
(42, 'cities-old', 9, 'kualalumpur.jpg', '2015-10-31 02:27:08', '0000-00-00 00:00:00'),
(43, 'cities-old', 10, 'moscow.jpg', '2015-10-31 02:29:01', '0000-00-00 00:00:00'),
(44, 'cities-old', 11, 'warsaw.jpg', '2015-10-31 02:29:31', '0000-00-00 00:00:00'),
(45, 'cities-old', 12, 'breslau.jpg', '2015-10-31 02:30:21', '0000-00-00 00:00:00'),
(46, 'cities-old', 13, 'dubai.jpg', '2015-10-31 02:31:02', '0000-00-00 00:00:00'),
(47, 'cities-old', 14, 'prague.JPG', '2015-10-31 02:31:40', '0000-00-00 00:00:00'),
(48, 'cities-old', 15, 'San_Francisco.jpg', '2015-10-31 02:32:55', '0000-00-00 00:00:00'),
(49, 'cities-old', 16, 'MexictoCity.jpg', '2015-10-31 02:33:34', '0000-00-00 00:00:00'),
(50, 'cities-old', 17, 'rio.jpg', '2015-10-31 02:34:19', '0000-00-00 00:00:00'),
(51, 'cities-old', 18, 'beijing.jpg', '2015-10-31 02:34:56', '0000-00-00 00:00:00'),
(52, 'cities-old', 19, 'cairo.jpg', '2015-10-31 02:35:46', '0000-00-00 00:00:00'),
(53, 'cities-old', 20, 'athens.jpg', '2015-10-31 02:36:24', '0000-00-00 00:00:00'),
(54, 'cities-old', 21, 'berlin.jpg', '2015-10-31 02:36:55', '0000-00-00 00:00:00'),
(55, 'cities-old', 22, 'delhi.jpg', '2015-10-31 02:37:54', '0000-00-00 00:00:00'),
(56, 'cities-old', 23, 'HongKong.jpg', '2015-10-31 02:38:57', '0000-00-00 00:00:00'),
(57, 'cities-old', 24, 'Casablanca.jpg', '2015-10-31 02:39:36', '0000-00-00 00:00:00'),
(58, 'cities-old', 25, 'grozny.jpg', '2015-10-31 02:41:36', '0000-00-00 00:00:00'),
(59, 'cities-old', 26, 'Teheran.png', '2015-10-31 02:42:14', '0000-00-00 00:00:00'),
(60, 'cities-old', 27, 'budapest.jpg', '2015-10-31 02:42:39', '0000-00-00 00:00:00'),
(61, 'cities-old', 28, 'baghdad.jpg', '2015-10-31 02:44:41', '0000-00-00 00:00:00'),
(62, 'cities-old', 29, 'lisbon.jpg', '2015-10-31 02:45:52', '0000-00-00 00:00:00'),
(63, 'cities-old', 30, 'istanbul.jpg', '2015-10-31 02:46:32', '0000-00-00 00:00:00'),
(64, 'cities-old', 31, 'nairobi.jpg', '2015-10-31 02:48:16', '0000-00-00 00:00:00'),
(65, 'cities', 0, 'algier.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(66, 'cities', 1, 'amsterdam.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(67, 'cities', 2, 'athens.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(68, 'cities', 3, 'bangkok.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(69, 'cities', 4, 'barcelona.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(70, 'cities', 5, 'berlin.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(71, 'cities', 6, 'cairo.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(72, 'cities', 7, 'calcutta.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(73, 'cities', 8, 'casablanca.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(74, 'cities', 9, 'delhi.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(75, 'cities', 10, 'dubai.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(76, 'cities', 11, 'edinburgh.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(77, 'cities', 12, 'hongkong.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(78, 'cities', 13, 'istanbul.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(79, 'cities', 14, 'jerusalem.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(80, 'cities', 15, 'krakow.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(81, 'cities', 16, 'kualalumpur.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(82, 'cities', 17, 'london.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(83, 'cities', 18, 'losangeles.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(84, 'cities', 19, 'mecca.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(85, 'cities', 20, 'moscow.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(86, 'cities', 21, 'newyork.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(87, 'cities', 22, 'paris.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(88, 'cities', 23, 'prague.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(89, 'cities', 24, 'rio.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(90, 'cities', 25, 'rome.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(91, 'cities', 26, 'seoul.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(92, 'cities', 27, 'shanghai.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(93, 'cities', 28, 'sydney.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(94, 'cities', 29, 'tokyo.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(95, 'cities', 30, 'washington.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(96, 'cities', 31, 'wroclaw.jpg', '2016-10-02 18:39:30', '0000-00-00 00:00:00'),
(97, 'birds', 0, '0e8585f9d21ef28ead641855bfa39b54.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(98, 'birds', 1, '112ec2c17d02a46060c577e560251555.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(99, 'birds', 2, '12c74b69e27265b80536cc47d374270e.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(100, 'birds', 3, '178749-beautiful-birds-pretty-bird.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(101, 'birds', 4, '272ts.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(102, 'birds', 5, '2e9cd69d6fd5c301914b4085e0e996ef.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(103, 'birds', 6, '936b143f02cf44bdd38559b57c06e42d.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(104, 'birds', 7, 'beautiful-bird-macro-wallpaper-hd-1587-wallpaper-high.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(105, 'birds', 8, 'Beautiful-cute-bird-wide-images.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(106, 'birds', 9, 'bird-of-paradise.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(107, 'birds', 10, 'bird-owl.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(108, 'birds', 11, 'birds-of-prey-wallpapers-11.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(109, 'birds', 12, 'canary.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(110, 'birds', 13, 'Chrysolampis_mosquitus.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(111, 'birds', 14, 'city-birds-orange-crowned-warbler.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(112, 'birds', 15, 'Egret3.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(113, 'birds', 16, 'eliska_08.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(114, 'birds', 17, 'emu.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(115, 'birds', 18, 'flaming.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(116, 'birds', 19, 'Goldfinch.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(117, 'birds', 20, 'hawk-on-the-sea-flying_85941-1600x1200.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(118, 'birds', 21, 'hooded-warbler-e1446499255827.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(119, 'birds', 22, 'INDIAN-ROLLER-Subramanniyan-Mani.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(120, 'birds', 23, 'keel_billed_toucan.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(121, 'birds', 24, 'Male_adult_Gouldian_Finch.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(122, 'birds', 25, 'Male_greater_frigate_bird_displaying.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(123, 'birds', 26, 'maxresdefault.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(124, 'birds', 27, 'red-nose-stork-bird-white.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(125, 'birds', 28, 'resplendent_quetzal.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(126, 'birds', 29, 'Rose-breasted_Grosbeak-2752.jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(127, 'birds', 30, 'shutterstock_124926872-(1).jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00'),
(128, 'birds', 31, 'shutterstock_57393118-(1).jpg', '2016-10-14 16:27:35', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `places`
--

CREATE TABLE `places` (
  `id` int(10) UNSIGNED NOT NULL,
  `imei` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL,
  `altitude` float NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `players`
--

CREATE TABLE `players` (
  `id` int(10) NOT NULL,
  `game_id` int(10) NOT NULL,
  `name` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `score` int(3) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `missed` int(11) NOT NULL,
  `num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `savedroutes`
--

CREATE TABLE `savedroutes` (
  `id` int(10) UNSIGNED NOT NULL,
  `imei` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datefrom` timestamp NOT NULL,
  `dateto` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pausetime` float DEFAULT NULL,
  `distance` double DEFAULT NULL,
  `distance2` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `themes`
--

CREATE TABLE `themes` (
  `id` int(1) NOT NULL,
  `themename` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `comment` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `themes`
--

INSERT INTO `themes` (`id`, `themename`, `comment`) VALUES
(1, 'numbers', 'Numbers'),
(2, 'cities', 'Cities'),
(3, 'birds', 'Birds');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `userdevices`
--

CREATE TABLE `userdevices` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL,
  `imei` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT '0',
  `defaultdevice` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation_token` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activation_token_expire` datetime DEFAULT NULL,
  `status` int(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `game_id_2` (`game_id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `devices` (`imei`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `geolocs`
--
ALTER TABLE `geolocs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devicetime` (`devicetime`);

--
-- Indexes for table `memories`
--
ALTER TABLE `memories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `game_id_2` (`game_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`theme`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `savedroutes`
--
ALTER TABLE `savedroutes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userdevices`
--
ALTER TABLE `userdevices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `boards`
--
ALTER TABLE `boards`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=385;
--
-- AUTO_INCREMENT dla tabeli `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT dla tabeli `games`
--
ALTER TABLE `games`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT dla tabeli `geolocs`
--
ALTER TABLE `geolocs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3665;
--
-- AUTO_INCREMENT dla tabeli `memories`
--
ALTER TABLE `memories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=385;
--
-- AUTO_INCREMENT dla tabeli `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT dla tabeli `places`
--
ALTER TABLE `places`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT dla tabeli `players`
--
ALTER TABLE `players`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT dla tabeli `savedroutes`
--
ALTER TABLE `savedroutes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT dla tabeli `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT dla tabeli `userdevices`
--
ALTER TABLE `userdevices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
