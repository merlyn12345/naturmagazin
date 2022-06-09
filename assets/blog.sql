-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 10. Aug 2020 um 16:51
-- Server-Version: 10.1.38-MariaDB-0+deb9u1
-- PHP-Version: 7.3.5-1+0~20190503093827.38+stretch~1.gbp60a41b

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `blog`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galerien`
--

CREATE TABLE `galerien` (
  `id` int(11) NOT NULL,
  `titel` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  `del` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `galerien`
--

INSERT INTO `galerien` (`id`, `titel`, `text`, `date`, `del`) VALUES
(1, 'die grauen moose', '<p>Zu jeder Galerie kann ein beliebig langer (und <strong>wild</strong> <span style=\"color: #ffff00;\">formatierter</span>) Einleitungstext verfasst werden.</p>', '2012-12-05 22:02:17', 0),
(11, 'Bunt', '<p>Vieleviele bunte Bilder</p>', '2012-12-05 21:07:30', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `url` varchar(50) NOT NULL,
  `typ` varchar(3) NOT NULL,
  `date` datetime NOT NULL,
  `size` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `del` tinyint(4) NOT NULL,
  `breite` smallint(6) NOT NULL DEFAULT '0',
  `hoehe` smallint(6) NOT NULL DEFAULT '0',
  `beschreibung` varchar(255) NOT NULL,
  `galerien_id` int(11) NOT NULL,
  `topdown` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `images`
--

INSERT INTO `images` (`id`, `url`, `typ`, `date`, `size`, `user_id`, `del`, `breite`, `hoehe`, `beschreibung`, `galerien_id`, `topdown`) VALUES
(32, 'tumblr_md7ulmpv8s1rkf8nwo1_1280.jpg', '2', '2012-12-04 19:20:05', 237813, 3, 0, 800, 532, '<p>Unter jedem Bild kann (muss aber nicht), ein kurzer Text stehen. </p>', 1, 0),
(31, 'tumblr_md6qit4z9p1rkf8nwo1_500.jpg', '2', '2012-12-04 19:19:59', 221116, 3, 0, 467, 700, '', 1, 0),
(30, 'tumblr_md6qbdokal1rkf8nwo1_500.jpg', '2', '2012-12-04 19:19:54', 170049, 3, 0, 467, 700, '<p>Jogurt!</p>', 0, 0),
(29, 'tumblr_md6p93ex4x1rkf8nwo1_1280.jpg', '2', '2012-12-04 19:19:48', 270176, 3, 0, 596, 900, '', 1, 0),
(28, 'tumblr_md6o88ezcg1rkf8nwo1_1280.jpg', '2', '2012-12-04 19:19:41', 171019, 3, 0, 531, 800, '', 1, 0),
(33, 'tumblr_mdirrhlsso1rkf8nwo1_500.jpg', '2', '2012-12-04 19:20:17', 76828, 3, 0, 408, 600, '<p>schnee</p>', 1, 0),
(34, 'tumblr_me95zwogek1rkf8nwo1_500.jpg', '2', '2012-12-04 19:20:22', 132020, 3, 0, 469, 700, '<p>schnee</p>', 1, 0),
(35, 'tumblr_meg2jnxky31rkf8nwo1_1280.jpg', '2', '2012-12-04 19:20:26', 259519, 3, 0, 1200, 804, '', 1, 0),
(36, 'mejtofcbeb1rkf8nwo1_1280.jpg', '2', '2012-12-05 21:12:15', 1046373, 3, 0, 1280, 1911, '<p>Ganz neu von mir geklaut...</p>', 12, 0),
(37, 'mejttd8jue1rkf8nwo1_500.jpg', '2', '2012-12-05 21:12:33', 113976, 3, 0, 409, 600, '<p>Und noch eins von den neuen</p>', 11, 0),
(38, 'mejtukkzex1rkf8nwo1_1280.jpg', '2', '2012-12-05 21:12:48', 226484, 3, 0, 1200, 916, '<p>Hmmmmmm</p>', 11, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `intro`
--

CREATE TABLE `intro` (
  `id` int(11) NOT NULL,
  `introtext` text NOT NULL,
  `publish` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `intro`
--

INSERT INTO `intro` (`id`, `introtext`, `publish`, `date`) VALUES
(1, '<p>Hier kann ein superschicker und individueller Seiteneinleitungstext stehen.</p>\r\n<p>Da f&auml;llt Dir schon was ein ;)</p>', 1, '2012-12-05 22:11:17');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lin_menue`
--

CREATE TABLE `lin_menue` (
  `id` int(11) NOT NULL,
  `text` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `rollen_id` varchar(5) NOT NULL,
  `topdown` tinyint(4) NOT NULL,
  `view` tinyint(4) NOT NULL,
  `seiten_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `lin_menue`
--

INSERT INTO `lin_menue` (`id`, `text`, `url`, `rollen_id`, `topdown`, `view`, `seiten_id`) VALUES
(1, 'Home', 'index', '1', 0, 1, 1),
(16, 'Bunt', 'index', '1', 13, 1, 27),
(4, 'Bilderadmin', 'index', '2', 6, 1, 25),
(5, 'Galerien bearbeiten', 'index', '2', 4, 1, 14),
(7, 'Bilderupload', 'index', '2', 1, 1, 7),
(8, 'Startseite bearbeiten', 'index', '2', 10, 1, 24),
(9, 'die grauen moose', 'index', '1', 7, 1, 15);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `posts`
--

CREATE TABLE `posts` (
  `id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `headline` varchar(40) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `headline`, `text`, `date`) VALUES
(1, 1, 'Der erste Beitrag', 'Hallo uns Herzlich willkommen - dies ist der erste Eintrag! Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. ', '2009-06-05'),
(2, 2, 'Link zu php tutorial', 'hallo, Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et. hier der Link zu selfphp [link]www.selfphp.de[/link]', '2009-06-08'),
(3, 3, 'Link zu Seite', 'hallo , hier ist ein Link zu Wikipedia [link]www.wikipedia.de[/link]', '2009-06-12'),
(4, 2, 'Tipp von mir', 'Ein Computer, (von lat.: computare, zsche Begriff computer, abgeleitet vom Verb to compute (rechnen), bezeichnete ursprünglich Menschen, die zumeist langwierige Berechnungen vornahmen, zum Beispiel für Astronomen im Mittelalter. In der Namensgebung des 1946 der Öffentlichkeit vorgestellten Electronic Numerical Integrator and Computer (kurz ENIAC) taucht erstmals das Wort als Namensbestandteil auf. In der Folge etablierte sich Computer als Gattungsbegriff für diese neuartigen Maschinen.  Zunächst war die Informationsverarbeitung mit Computern auf die Verarbeitung von Zahlen beschränkt. Mit zunehmender Leistungsfähigkeit eröffneten sich neue Einsatzbereiche. Computer sind heute in allen Bereichen des täglichen Lebens vorzufinden: Sie dienen der Verarbeitung und Ausgabe von Informationen in Wirtschaft und Behörden, der Berechnung der Statik von Bauw', '2009-06-12'),
(28, 2, 'Internet ist so', 'Das Internet (w&Atilde;&para;rtlich etwa &iuml;&iquest;&frac12;Zwischennetz&iuml;&iquest;&frac12; oder &iuml;&iquest;&frac12;Verbundnetz&iuml;&iquest;&frac12;, von engl.: interconnected Networks: &iuml;&iquest;&frac12;untereinander verbundene Netzwerke&iuml;&iquest;&frac12;) ist ein weltweites Netzwerk bestehend aus vielen Rechnernetzwerken, durch das Daten ausgetauscht werden. Es erm&Atilde;&para;glicht die Nutzung von Internetdiensten wie E-Mail, Telnet, Usenet, Datei&Atilde;&frac14;bertragung, WWW und in letzter Zeit zunehmend auch Telefonie, Radio und Fernsehen. Im Prinzip kann dabei jeder Rechner weltweit mit jedem anderen Rechner verbunden werden. Der Datenaustausch zwischen den einzelnen Internet-Rechnern erfolgt &Atilde;&frac14;ber die technisch normierten Internetprotokolle.', '2009-06-12'),
(12, 3, 'Tips', 'TIPS (auch: TIPSS) ist die Abk&uuml;rzung f&uuml;r einen transjugul&auml;ren intrahepatischen portosystemischen (Stent-)Shunt und bezeichnet eine minimal-invasiv geschaffene Verbindung zwischen der Pfortader und der Lebervene durch die Leber hindurch (Portosystemischer Shunt). Mit dem TIPS soll erreicht werden, dass ein gewisser Teil des Blutflusses von der Pfortader nicht in die Leber, sondern direkt in den gro&szlig;en Blutkreislauf flie&szlig;t. Eingesetzt wird ein TIPS in der Behandlung eines Pfortaderhochdrucks.', '2009-06-11'),
(24, 31, 'Tippser', 'Tippser.de ist die neue Community rund um Tipps und Tricks aus allen Lebensbereichen. In den Kategorien finden Sie Tipps zum Thema Abnehmen, Auto, Beruf, Beauty, Computer, Familie, Geld, Gesundheit, Garten, Haushalt, Haustiere und Reisen. Zudem pr&auml;sentieren wir Ihnen garantiert gute Spartipps, die sich in einer eigenen Kategorie Sparen von A-Z wieder finden.', '2009-06-11'),
(14, 16, 'Links', 'Links und rechts sind einander entgegengesetzte Richtungsangaben.\r\n\r\nWikipedia [link]de.wikipedia.org/wiki/Links_und_rechts[/wikipedia]\r\n\r\nRechts bedeutet eine Abweichung von der gedachten Geradeauslinie vom Betrachter aus im Uhrzeigersinn, links bedeutet eine Abweichung gegen den Uhrzeigersinn. In einer aufrechten Position mit Blickrichtung Norden befindet sich links im Westen und rechts im Osten.', '2009-06-11'),
(16, 16, 'hallo', '[link]www.de.wikipedia.org/wiki/Links_und_rechts[/link] wikipedia', '2009-06-11'),
(23, 4, '&uuml;ber mich...', 'Ein Autor (lat. auctor „Urheber“, „Sch&ouml;pfer“, „F&ouml;rderer“, „Veranlasser“) ist der Verfasser oder geistige Urheber eines Werkes. Dabei handelt es sich meist um Werke der Literatur im weitesten Sinn (Schriftsteller, Fachbuch-, Lehrbuch-, Sachbuch-, Drehbuch-, Fernseh-, Opern- oder B&uuml;hnenautor). Seltener wird, mit einem deutlich juristischen Beiklang, als Autor der Urheber eines Werkes der nichtliterarischen Kunst (etwa Musik, Fotografie, Filmkunst) und der Wissenschaft verstanden (vgl. auch Softwareautoren, Gesetzesautoren). Un&uuml;blich scheint es auch zu sein, konkrete Poesie, visuelle Poesie oder Wortbilder als von Autoren geschaffen zu bezeichnen.', '2009-06-11'),
(33, 37, 'mein toller Artikel', 'das ist schon klasse, dieses da!\r\neine Webseite [link]www.webseite.de[/link]\r\n\r\n\r\njajaja', '2009-08-23'),
(34, 3, 'aslkdhkdsa', 'lsakjdlsa[img]http://127.0.0.1/blog_tmpl_parse/images/2jahrehorstt.jpg[/img]\r\n\r\njajaj', '2011-05-03'),
(36, 3, 'Dreiundzwanzig', 'Bilder im [img]http://127.0.0.1/blog_neu/images/dreiundzwanzig.jpg[/img]\r\nVerzichnis.', '2011-05-04'),
(37, 3, 'oiuzpoiuz', 'o&ouml;iu&uuml;oiuo [img]http://127.0.0.1/blog_neu/images/dreiundzwanzig16.jpg[/img]', '2011-05-04'),
(39, 3, 'jztuz tiuz', 'kjzt.kizuv [img]http://127.0.0.1/blog_neu/images/tag.jpg[/img]\r\n\r\ntext', '2011-09-26'),
(40, 3, 'rujdhrs', 'hdh[img]http://127.0.0.1/blog_neu/images/labyrinth.jpg[/img]', '2011-09-26'),
(41, 3, 'abcd', 'abcd e [img]http://127.0.0.1/blog_neu/images/dreiundzwanzig16.jpg[/img]\r\njaja', '2012-11-23');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rollen`
--

CREATE TABLE `rollen` (
  `id` int(11) NOT NULL,
  `rolle` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `rollen`
--

INSERT INTO `rollen` (`id`, `rolle`) VALUES
(1, 'gast'),
(2, 'user'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `seiten`
--

CREATE TABLE `seiten` (
  `id` int(11) NOT NULL,
  `rollen_id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `loadphp` varchar(100) NOT NULL,
  `loadhtml` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `meta` varchar(250) NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '0',
  `editlock` tinyint(1) NOT NULL DEFAULT '0',
  `galerie_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `seiten`
--

INSERT INTO `seiten` (`id`, `rollen_id`, `title`, `loadphp`, `loadhtml`, `created`, `user_id`, `meta`, `publish`, `editlock`, `galerie_id`) VALUES
(1, 0, 'Startseite', 'indexcontent', 'indexcontent', '0000-00-00 00:00:00', 1, '', 0, 0, 0),
(7, 0, 'Bilderupload', 'uploadcontent', 'uploadcontent', '2009-09-07 06:28:45', 1, '', 0, 0, 0),
(8, 0, 'Neuer Beitrag', 'new_post', '', '2009-09-07 06:29:55', 1, '', 0, 0, 0),
(10, 0, 'Meine Beitr&auml;ge', 'index', '', '2009-09-07 06:31:28', 1, '', 0, 0, 0),
(14, 0, 'Galeriemanager', 'galeriemanagercontent', 'galeriemanagercontent', '2012-11-29 00:00:00', 0, '', 0, 0, 0),
(15, 1, 'die grauen moose', 'galeriecontent', 'galeriecontent', '2012-11-29 21:03:17', 1, '', 1, 0, 1),
(18, 2, 'Galerie neu anlegen', 'galerie_neu_content', 'galerie_neu_content', '2012-12-05 21:05:27', 2, '', 1, 0, 0),
(17, 1, 'galerie aendern', 'galerie_aendern_content', 'galerie_aendern_content', '2012-11-30 00:04:47', 1, '', 1, 0, 0),
(26, 2, 'Bild aendern', 'bild_aendern', 'bild_aendern', '2012-12-05 19:11:24', 2, '', 1, 0, 0),
(25, 2, 'Bilderadmin', 'b_inventory', 'b_inventory.tpl', '2012-12-05 14:03:08', 1, '', 1, 0, 0),
(24, 1, 'Startseitentext bearbeiten', 'hometext', 'hometext', '2012-12-04 19:43:29', 1, '', 1, 0, 0),
(27, 1, 'Bunt', 'galeriecontent', 'galeriecontent', '2012-12-05 21:07:30', 1, '', 1, 0, 11);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(12) NOT NULL,
  `passwd` char(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `confirm` char(32) NOT NULL,
  `website` varchar(200) NOT NULL,
  `avatar` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `username`, `passwd`, `email`, `confirm`, `website`, `avatar`) VALUES
(1, 'hah', '637d1f5c6e6d1be22ed907eb3d223d858ca396d8', 'haha', '1771d7176d97f91c85af0a7ffffda60a', '', ''),
(2, 'walla', 'c05779def602c0f8bdce11370e812966f5424e61', 'postmaster@localhost', '', '', ''),
(3, 'uwe', '4c29b7920d701a3ce02ffa2c79046ead1af87b11', 'postmaster@localhost', '', '', ''),
(4, 'georg', '839351b191e365c955875d46f4916e894e69f6d4', 'georg@home.com', 'ba7d10a5a151467cb3fd05c37d38d491', '', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_rollen`
--

CREATE TABLE `user_rollen` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rollen_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user_rollen`
--

INSERT INTO `user_rollen` (`id`, `user_id`, `rollen_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 1),
(4, 4, 1),
(5, 3, 2);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `galerien`
--
ALTER TABLE `galerien`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `intro`
--
ALTER TABLE `intro`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `lin_menue`
--
ALTER TABLE `lin_menue`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `rollen`
--
ALTER TABLE `rollen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `seiten`
--
ALTER TABLE `seiten`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user_rollen`
--
ALTER TABLE `user_rollen`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `galerien`
--
ALTER TABLE `galerien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT für Tabelle `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT für Tabelle `intro`
--
ALTER TABLE `intro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `lin_menue`
--
ALTER TABLE `lin_menue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT für Tabelle `posts`
--
ALTER TABLE `posts`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT für Tabelle `rollen`
--
ALTER TABLE `rollen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `seiten`
--
ALTER TABLE `seiten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `user_rollen`
--
ALTER TABLE `user_rollen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
