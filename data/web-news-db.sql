-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2022 at 11:18 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web-news`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Fudbal', '2021-11-23 00:38:33', NULL),
(2, 'Kosarka', '2021-11-23 00:38:55', '2021-11-23 00:39:01'),
(3, 'Tenis', '2021-11-23 00:40:07', NULL),
(4, 'Automoto', '2021-11-23 00:40:23', NULL),
(5, 'Esport', '2021-11-23 00:40:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `parent_id` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `text`, `parent_id`, `id_post`, `id_user`, `created_at`) VALUES
(1, 'Prvi', 0, 1, 8, '2022-02-18 21:21:55'),
(2, 'Drugi', 0, 1, 8, '2022-02-18 21:21:59'),
(3, 'Prvi prvi', 1, 1, 8, '2022-02-18 21:22:07'),
(4, 'Reply to drugi', 2, 1, 8, '2022-02-20 13:34:46'),
(6, 'Reakcija na prvi komentar', 3, 1, 1, '2022-02-20 17:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `headings`
--

CREATE TABLE `headings` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `headings`
--

INSERT INTO `headings` (`id`, `name`, `created_at`, `updated_at`, `category_id`) VALUES
(1, 'Premier League', '2022-02-06 00:16:10', NULL, 1),
(2, 'Primera', '2022-02-06 00:16:22', NULL, 1),
(3, 'Champions League', '2022-02-06 00:16:34', NULL, 1),
(4, 'Europa League', '2022-02-06 00:16:46', NULL, 1),
(5, 'Bundnesliga', '2022-02-06 00:16:57', NULL, 1),
(6, 'NBA', '2022-02-06 00:17:10', NULL, 2),
(7, 'ABA League', '2022-02-06 00:17:19', NULL, 2),
(8, 'Euroleague', '2022-02-06 00:17:32', NULL, 2),
(9, 'ATP', '2022-02-06 00:17:56', NULL, 3),
(10, 'WTA', '2022-02-06 00:18:04', NULL, 3),
(11, 'Formula 1', '2022-02-06 00:18:15', NULL, 4),
(12, 'WRC', '2022-02-06 00:18:21', NULL, 4),
(13, 'CS GO', '2022-02-06 00:18:29', NULL, 5),
(14, 'Lol', '2022-02-06 00:18:36', NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `heading_tag`
--

CREATE TABLE `heading_tag` (
  `heading_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `heading_tag`
--

INSERT INTO `heading_tag` (`heading_id`, `tag_id`) VALUES
(1, 166),
(1, 167),
(1, 168),
(1, 169),
(1, 170),
(1, 171),
(1, 172),
(1, 173),
(1, 174),
(1, 175),
(1, 176),
(1, 177),
(1, 178),
(1, 179),
(1, 180),
(1, 182),
(2, 134),
(2, 158),
(2, 159),
(2, 160),
(2, 161),
(2, 162),
(2, 163),
(2, 164),
(2, 165),
(3, 140),
(3, 141),
(3, 142),
(3, 143),
(3, 144),
(3, 145),
(3, 146),
(3, 147),
(3, 148),
(3, 149),
(3, 150),
(3, 151),
(3, 152),
(3, 153),
(3, 181),
(4, 133),
(4, 134),
(4, 135),
(4, 136),
(4, 137),
(4, 138),
(4, 139),
(5, 150),
(5, 151),
(5, 154),
(5, 155),
(5, 156),
(5, 157),
(6, 75),
(6, 76),
(6, 77),
(6, 78),
(6, 79),
(6, 80),
(6, 81),
(6, 82),
(6, 83),
(6, 84),
(6, 85),
(6, 86),
(6, 87),
(6, 88),
(6, 89),
(6, 90),
(6, 91),
(6, 92),
(6, 93),
(6, 94),
(6, 95),
(6, 96),
(6, 97),
(6, 98),
(6, 99),
(6, 100),
(6, 101),
(6, 102),
(6, 103),
(6, 104),
(6, 105),
(6, 106),
(6, 123),
(6, 124),
(7, 73),
(7, 74),
(7, 109),
(7, 111),
(7, 127),
(7, 128),
(7, 129),
(7, 130),
(7, 131),
(7, 132),
(8, 107),
(8, 108),
(8, 109),
(8, 110),
(8, 111),
(8, 112),
(8, 113),
(8, 114),
(8, 115),
(8, 116),
(8, 117),
(8, 118),
(8, 119),
(8, 120),
(8, 121),
(8, 122),
(8, 125),
(8, 126),
(9, 46),
(9, 47),
(9, 48),
(9, 49),
(9, 50),
(9, 51),
(9, 52),
(9, 53),
(9, 54),
(9, 55),
(9, 56),
(9, 57),
(9, 58),
(9, 59),
(9, 60),
(9, 61),
(9, 62),
(10, 63),
(10, 64),
(10, 65),
(10, 66),
(10, 67),
(10, 68),
(10, 69),
(10, 70),
(10, 71),
(10, 72),
(11, 37),
(11, 38),
(11, 39),
(11, 40),
(11, 41),
(11, 42),
(11, 43),
(11, 44),
(11, 45),
(12, 32),
(12, 33),
(12, 34),
(12, 35),
(12, 36),
(13, 11),
(13, 12),
(13, 13),
(13, 14),
(13, 15),
(13, 16),
(13, 17),
(13, 18),
(13, 19),
(13, 20),
(13, 21),
(13, 22),
(13, 23),
(13, 24),
(13, 25),
(13, 26),
(13, 27),
(13, 28),
(13, 29),
(13, 30),
(14, 1),
(14, 2),
(14, 3),
(14, 4),
(14, 5),
(14, 6),
(14, 7),
(14, 8),
(14, 9),
(14, 10),
(14, 11),
(14, 31);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `heading_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `name`, `description`, `image_path`, `category_id`, `heading_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'LEC: Gledamo veliki derbi nepora??enih timova', '<p><strong>Danas i sutra gledamo tre??u nedelju LEC lige, a u centru pa??nje ??e se na??i ve??era&scaron;nji duel dva jedina nepora??ena sastava u ligi - Fnatica i Rogue.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Nakon pet odigranih kola LEC-a Rogue i Fnatic su se izdvojili na vrhu tabele sa maksimalnim u??inkom i ??ak dve pobede vi&scaron;e od najbli??ih rivala. Ova dva tima su ujedno i pokazala najvi&scaron;e na startu takmi??enja, i dok se od Fnatica o??ekivalo da zgaze sve pred sobom, Rogue koji je promenio dva igra??a je izuzetno prijatno osve??enje i mo??emo re??i da je nadma&scaron;io o??ekivanja.</p>\r\n\r\n<p>Prema na&scaron;im o??ekivanjima Fnatic ulazi u ovaj me?? kao veliki favorit iako mo??da po stanju na tabeli tako ne izgleda. Rogue je pru??io odli??ne partije, ali je sem MAD Lionsa koji tako??e uigravaju novu ekipu izbegao ja??e timove tako da mo??emo re??i da im je ovo prvi zaista veliki tekst.</p>\r\n\r\n<p>Fnatic ??e biti ja??i na top i bot lejnu, duel Humaonida i Larssena ??e kao i u prethodnim sezonama biti izuzetno zanimljiv za gledanje, a dosta toga ??e zavisiti i od novih junglera u oba tima, Razorka i Malranga.</p>\r\n\r\n<p>Fnatic ispred sebe ima izuzetno te&scaron;ku nedelju, po&scaron;to ih sutra ??eka njihov najve??i rival G2 Esports, a ako bi uspeli da nastave sa nizanjem pobeda stavili bi svima jasno do znanja da su glavni kandidati za titulu i da ne??e dozvoliti da ih bilo ko ozbiljnije ugrozi. Naravno znamo da smo mnogo puta do sada videli velike promene u samom plejofu u odnosu na grupnu fazu, postoji uvek &scaron;ansa da vam se samopouzdanje obije o glavu ako se vremenom opustite, ali uz iskusnog trenera to ne bi trebalo da predstavlja toliku opasnost za Fnatic.</p>\r\n\r\n<p>Ako govorimo o te&scaron;kom rasporedu ne smemo zaboraviti i da Rogue sutra ??eka jo&scaron; jedan te??ak me?? protiv probu??ene ekipe Vitality koja je nakon katastrofalne 0-3 prve nedelje uspela da ve??e dve pobede u nastavku lige i to uz sjajnu igru koju su pru??ili Perkz i Selfmade.</p>\r\n\r\n<p>Vitality danas o??ekuje relativno lagan me?? protiv SK Gaminga koji kao &scaron;to se i o??ekivalo nije pokazao previ&scaron;e i za njih bi mnogo zna??ilo da od 0-3 do??u do 4-3 i potpuno preokrenu tok sezone.</p>\r\n', '1644362358_1643377852-Hylissang-2.jpg', 5, 14, 6, '2022-02-09 00:19:18', NULL),
(2, 'Novi support sti??e u LoL esport', '<p><strong>Renata Glasc je ime 159. League of Legends heroja, gleda??emo je na bot lejnu kao supporta, a njen izlazak je najavljen za patch 12.4.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Kada su tokom ju&scaron;era&scaron;njeg dana procurele Renatine ve&scaron;tine mnogi su smatrali da je u pitanju fejk info i da nema &scaron;anse da ??e Riot izbaciti na prvi pogled toliko mo??nog heroja. Ispostavilo se da Renata zaista dolazi sa novom unikatnom ve&scaron;tinom u LoL-u koja ??e uvoditi heroje u do sada nevi??eno stanje &ndash; Berserk.</p>\r\n\r\n<p>Heroji koji su u Berserk stanju ??e prvo napadati svoje saigra??e, potom neutralna bi??a na mapi, a tek onda renatine saigra??e i na kraju samu Renatu. Ovako mo??na magija je naravno njen ulti i zva??e se Hostile Takeover.</p>\r\n\r\n<p>Njena Q magija se zove Handshake koji ??e root-ovati prvog protivnika na kog naleti, a kada se ponovo aktivira ova magija baca protivni??kog heroja u ??eljenom pravcu.</p>\r\n\r\n<p>W magija Bailout je ve?? pokrenula lavinu kritika, jer ??e omogu??iti o??ivljavanje saigra??a ukoliko ubiju nekog u periodu od tri sekunde nakon svoje smrti, dok je Bailout na njima. Ina??e pored o??ivljavanja, Bailout daje bonus na brzinu napadanja i kretanja.</p>\r\n\r\n<p>E &ndash; Loyalty Program baca &scaron;tit na saigra??e i usporava i ranjava protivnike, a pasivna ve&scaron;tina Leverage stavlja znak na protivni??ke heroje koji im pravi dodatnu &scaron;tetu.</p>\r\n\r\n<p>Ta??an izgled njenih magija i ve&scaron;tina mo??ete pogledati na&nbsp;<a href=\"https://www.leagueoflegends.com/en-us/event/renata-glasc-abilities-rundown/\" target=\"_blank\">zvani??nom sajtu</a></p>\r\n\r\n<p>Mi&scaron;ljenja profesionalnih igra??a su za sada podeljena i mnogi su zabrinuti &scaron;to se toliko ??esto dodaju novi heroji sa kompleksnim ve&scaron;tinama koje znatno mogu da uti??u na balans same igre.</p>\r\n', '1644362520_1643716561-FKdx6IDUcAAHGnC-750x422 (1).jpg', 5, 14, 6, '2022-02-09 00:22:00', '2022-02-11 10:08:40'),
(3, 'T1 nezaustavljiv u LCK ligi i nakon sedmog kola', '<p><strong>Najtrofejniji LoL tim svih vremena je sa??uvao maksimalni u??inak u LCK-u nakon pobede u izuzetno uzbudljivom me??u protiv Hanwha Life Esportsa.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>HLE nije najbolje otvorio sezonu i nakon &scaron;est kola ostvarili su ispod proseka u??inak sa ukupnim skorom 2-4, dok je sa druge strane T1 trijumfovao u svakom od me??eve koje su do sada odigrali. I pored toga HLE je taj koji je prvi pripretio i to uz novog heroja Zeri odnev&scaron;i pobedu u prvoj partiji nakon pola sata igre.</p>\r\n\r\n<p>??inilo se da smo na pragu velikog iznena??enja nakon &scaron;to su u drugoj partiji igra??i HLE krenuli da skupljaju killove na topu. DuDu je vrlo brzo do&scaron;ao do tri killa kao Tryndamere, ali je T1 uspeo da zaustavi krvarenje i potpuno preokrene partiju da bi ve?? u 25. minutu izjedna??io na 1-1.</p>\r\n\r\n<p>Tre??a partija se odu??ila nakon &scaron;to je HLE zastao posle tre??eg zmaja. T1 je uspeo da spre??i protivnika da kontroli&scaron;e mapu, a iako je HLE imao bolji sastav heroja za du??e partije, iskustvo igra??a T1 je prevagnulo. Faker i ostatak tima su se odli??no kretali po mapi, a heroj za T1 je bio Keria koji je sa Tahm Kenhcom redovno spasavao saigra??e u klju??nim momentima &scaron;to je pravilo razliku izme??u pobede i poraza u borbama.</p>\r\n\r\n<p>Na kraju T1 zaslu??eno odnosi sedmu pobedu u isto toliko kola LCK-a, a ve?? u narednom kolu ih o??ekuje veliki derbi protiv najbli??ih pratilaca na tabeli &ndash; ekipe Gen.G koja trenutno sa utakmicom manje ima skor 5-1.</p>\r\n', '1644570597_1644419093-Keria-750x422.jpeg', 5, 14, 6, '2022-02-11 10:09:57', NULL),
(4, 'Perkz i Vitality startovali 0-3 u LEC-u', '<p><strong>Iako je pre po??etka takmi??enja progla&scaron;en za jednog od glavnih favorita, Vitality se i pored dovo??enja velikih zvezda nije sna&scaron;ao u prvoj nedelji LEC lige koju su zavr&scaron;ili bez pobede, sa tri pretpljena poraza iz isto toliko me??eva.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>EU navija??i su dugo ??ekali da kona??no vide na delu super tim formiran oko Luke &bdquo;Perkz&ldquo; Perkovi??a i Barney &bdquo;Alphari&ldquo; Morrisa, ali za sada makar, ova ekipa nije ispunila ni deo o??ekivanja publike. Istina mora se priznati da je Vitality imao poprili??no te??ak raspored, u prvom kolu ih je do??ekao &scaron;ampion MAD Lions, u drugom su igrali veliki derbi protiv Fnatica, ali to ne bi trebalo da budu opravdanja za izuzetno blede partije koje je tim pru??io.</p>\r\n\r\n<p>Ne mo??emo izdvojiti jednog krivca za neuspeh ekipe na startu lige. Perkz je igrao ispod nivoa u svakom od me??eva, Alphari i kada je pravio prednost na po??etku partija nije ni&scaron;ta umeo sa tim da uradi, Oskar &bdquo;Selfmade&ldquo; Boderek je bio katastrofalan, a ni bot lejn ekipe nije ni&scaron;ta pokazao.</p>\r\n\r\n<p>U prvom kolu i dominaciji MAD Lionsa protiv Vitality posebno se istakao Javier &bdquo;Elyoya&ldquo; Prades Batalla koji je odigrao 8-1-10 sa Dianom. Razlika u d??ungli je jednostavno bila prevelika i MAD Lions je podsetio publiku da ma koliko hajpovali njihove protivnike, ipak su oni ti koji su prvaci LEC lige.</p>\r\n\r\n<p>??inilo se da ima nade za Vitality koji je poveo protiv Fnatica ostvariv&scaron;i prednost od preko 5.000 golda nakon 20 minuta igre, ali kako je partija odmicala tako se videlo da tim jo&scaron; uvek nije uigran, &scaron;to je Fnatic znao da iskoristi. Martin &bdquo;Wunder &bdquo;Hansen je imao odli??an debi u dresu Fnatica, igrao je sjajno tokom cele partije a na kraju je igrao klju??nu ulogu u odlu??uju??oj borbi koja je donela pobedu njegovom timu.</p>\r\n\r\n<p>Kap koja je prelila ??a&scaron;u strpljenja navija??a je poraz protiv ekipe Excel koja do tre??eg kola tako??e nije znala za pobedu u ligi. U sudaru timova sa dna tabele o??ekivalo se da ??e Vitality brzo trijumfovati, ali jo&scaron; jednom nisu uspeli da bilo &scaron;ta poka??u.</p>\r\n\r\n<p>Alphari jo&scaron; jednom nije umeo da iskoristi prednost koju je napravio na startu me??a, dok je njegov rival Finn &bdquo;Finn&ldquo; Wiestal pravio velike probleme sa Jayce-om tokom cele partije.</p>\r\n\r\n<p>Iako je ovakav rezultat na startu LEC-a krajnje alarmantan, ne treba zaboraviti da je ovo ipak skupina igra??a koja je tek od nedavno na okupu. Iskustvo je na njihovoj strani, ali mora??e na mnogo toga da porade ako ??ele da se do kraja sezone dokopaju plejof i u njemu mo??da na??ine rezultat koji bi bio zadovoljavaju?? za sastav sa ovakvim renomeom.</p>\r\n', '1644570674_1642414758-51820338048_1c03ba8d0f_k-750x500.jpg', 5, 14, 6, '2022-02-11 10:11:14', NULL),
(5, 'Mikyx potpisao za Excel, Advienne izba??en iz tima', '<p><strong>??etvorostruki prvak LEC lige Mihael &quot;Mikyx&quot; Mehle ??e nastaviti karijeru u ekipi Excel gde ??e zameniti Henka &quot;Advienne&quot; Reijenga.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Popularni support je ostao bez mesta u nekom od LEC timova tokom prelaznog perioda, nakon &scaron;to je G2 zatra??io ve??u svotu novca nego &scaron;to je iko ??eleo da izdvoji. Zbog toga je Mikyx po??eo sezonu na klupi G2 Esportsa, a nakon samo dve nedelje takmi??enja dobija priliku da ponovo zaigra.</p>\r\n\r\n<p>Advienne je naveo na svom Tviter profilu da je do promene do&scaron;lo bez bilo kakvog konsultovanja sa timom i da je on u nedelju obave&scaron;tene da vi&scaron;e ne??e igrati za Excel. Advienne je zaigrao za Excel tokom pro&scaron;le godine kada su on i Mark &bdquo;Markoon&ldquo; van Woensel dobili priliku kao igra??i Excel akademije.</p>\r\n\r\n<p>Excel je pro&scaron;le sezone &scaron;esti put za redom ostao bez plejofa, a trenutno se nakon pet kola nalaze na deobi &scaron;estog mesta tabele sa 2-3 skorom.</p>\r\n', '1644570852_1638812792-G2-Mikyx-750x494.jpg', 5, 14, 6, '2022-02-11 10:14:12', NULL),
(6, 'HuNter- progla??en za 12. CS:GO igra??a sveta', '<p><strong>Nemanja &quot;huNter-&quot; Kova?? je napredovao za jedno mesto u odnosu na pro&scaron;lu godinu i sada je 12. najbolji CS:GO esportista na cenjenoj godi&scaron;njoj HLTV top 20 rang listi.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Najpopularniji CS:GO portal HLTV je u toku predstavljanja svoje top 20 liste za 2021. godinu, a na njoj se kao i pro&scaron;le godine na&scaron;ao prvotimac G2 Esportsa huNter-.</p>\r\n\r\n<p>Ovo je bila velika godina za G2 i huNter-a, prva cela godinu koju je proveo rame uz rame sa svojim bratom Nikolom &bdquo;NiKo&ldquo; Kova??em. Slavni duo bosanskih igra??a poreklom iz Srbije je doveo G2 do ogromnog uspeha koji smo krajem pro&scaron;le godine pratili na Sport Klubu, titule vice&scaron;ampiona PGL Stockholm Majora gde su bra??a Kova?? i G2 zaustavljeni u spektakularnom finalu od ma&scaron;inerije zvane Natus Vincere &ndash; trenutno najboljeg tima sveta.</p>\r\n\r\n<p>HuNter- je i ove godine nastavio da re&scaron;eta protivnike na serveru, samo sada uz pomo?? Nikole, i uz njih ekipa je uspela da u kontinuitetu dr??i mesto u samom vrhu CS:GO-a. Uglavnom su u zavr&scaron;nicama najve??ih turnira zaustavljani od strane Na&rsquo;Vi i Gambita, ali su uspeli da se uspostave kao vode??i tim Evrope ostavljaju??i iza sebe timove kao &scaron;to su Heroic, Astralis, Vitality, Ninjas in Pyjamas i FaZe Clan.</p>\r\n\r\n<p>Odli??na godina kako za HuNter-a tako i za ceo G2 je pro&scaron;la u znaku sitnih problema. G2 nije uspeo da prona??e stabilnu petorku i AWP-era koji im odgovara, imali su nagli pad forme nakon letnje pauze, a krajem godine i HuNter- je na kratko zbog izazova u privatnom ??ivotu kako je naveo u HLTV intervjuu imao blagi pad forme, ali i pored svega toga G2 je pokazao koliki je njihov sirovi potencijal, ponajvi&scaron;e zahvalju??i bra??i Kova??.</p>\r\n\r\n<p>Kada se sve sabere, mo??emo re??i da su blagi pad forme u drugom delu godine i turbulencije unutar samog tima glavni razlog za&scaron;to se huNter- nije probio u top 10, a ako ove godine ekipa uspe da se brzo uigra u novom sastavu i jako zapo??ne sezonu, mo??emo o??ekivati da se huNter- jo&scaron; vi&scaron;e popne na lestvici i nastavi da dokazuje celom svetu svoj neosporivi kvalitet.</p>\r\n', '1644571329_1641931474-HuNter-750x500.jpg', 5, 13, 6, '2022-02-11 10:22:09', NULL),
(7, 'NiKo progla??en za tre??eg CS:GO igra??a planete', '<p><strong>Nikola &quot;NiKo&quot; Kova?? je napredovao jednu poziciju u odnosu na pro&scaron;logodi&scaron;nju top 20 listu najboljih CS:GO igra??a sveta portala HLTV.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Presti??na rang lista HLTV-a koja je na neki na??in i najrealniji pokazatelj stanja u CS:GO esportu je potvrdila ono &scaron;to je svima jasno, a to je da je NiKo jedan od najboljih na planeti. NiKo iza sebe ima vrhunsku 2021. godinu u kojoj je pomagao ekipi G2 Esports da postane Major vice&scaron;ampion, a kada pogledamo statistiku NiKo je dokazao da je bez konkurencije kada je re?? o ulozi riflera u CS:GO esportu.</p>\r\n\r\n<p>Ispred njega su se samo na&scaron;li Mathieu &bdquo;ZywOo&ldquo; Herbaut i Aleksandr &bdquo;s1mple&ldquo; Kostyliev koji dr??e prvu poziciju tre??u godinu za redom. NiKo stoji rame uz rame sa dva najbolja igra??a sveta, koja dodu&scaron;e ne mo??emo direktno porediti sa njim jer su u pitanju igra??i koji primarno igraju AWP (snajper) dok NiKo na neki na??in ima jo&scaron; te??i zadatak da poka??e svoju genijalnost i vanserijski talenat.</p>\r\n\r\n<p>Po mnogima jedan od najboljih ako ne i najbolji rifler svih vremena u CS:GO-u, NiKo je blistao tokom ove godine ??ak i u momentima kada je G2 imao padove u naletu forme. Pro&scaron;la godina je bila turbulentna za G2, nisu uspevali da prona??u idealnu petorku, ali su i pored toga maltene u kontinuitetu uspevali da opstanu na vrhu.</p>\r\n\r\n<p>G2 je tokom godine vezao nekoliko top 4 fini&scaron;a na velikim turnirima, a uglavnom su Gambit i Na&rsquo;Vi bili ti koji su na kraju dana ostali nepremostiva prepreka za G2. Pored Majora, posebno ??e ostati upam??eno finale IEM Kelna u kom je G2 i pored sjajne igre do??iveo te??ak 0-3 poraz u finalu protiv Na&rsquo;Vi, zbog ??ega ne ??udi da je na kraju kada su zavr&scaron;ili godinu bez trofeja promena unutar tima bila neminovna.</p>\r\n\r\n<p>Dolazak jednog od najtalentovanijih mladih igra??a dana&scaron;njice Ilye &bdquo;m0NESY&ldquo; Osipova je osve??io motivaciju ekipe, a kako je i sam NiKo naveo u razgovoru za G2, iako biti u top 4 najbolja timova sveta nije mala stvar, on i G2 imaju velike &scaron;ampionske ambicije i uradi??e sve &scaron;to je potrebno kako bi skinuli Na&rsquo;Vi sa trona.</p>\r\n\r\n<p>Glavni pitanje kada je re?? o Nikoli je da li ??e uspeti da zadr??i neverovatnu formu iz 2021. godine i nastavi da predvodi G2 do uspeha. On je sam postavio neverovatno visoke kriterijume i bi??e potrebno da nastavi sa majstorskim igrama kako bi se G2 &scaron;to br??e uhodao u novom sastavu i nastavio da bude pretedent na trofeje koji su im pro&scaron;le godine u vi&scaron;e navrata zamalo izmakli iz ruku.</p>\r\n', '1644571471_1636282539-g2-niko-750x501.jpg', 5, 13, 6, '2022-02-11 10:24:32', NULL),
(8, 'BLAST: NaVi na dnu tabele, OG prvi u grupi B', '<p><strong>Najbolji CS:GO tima je neo??ekivano zapo??eo godinu sa dva vezana poraza na BLAST-u, dok je Nemanja &quot;nexa&quot; Isakovi?? debitovao za OG na najbolji mogu??i na??in donev&scaron;i im prvo mesto u grupi i povla&scaron;??en polo??aj u bara??u za prolaz na zavr&scaron;nicu turnira.</strong></p>\r\n\r\n<p>Borba u grupi B na BLAST Premier Spring 2022 turniru je zapo??ela me??om izme??u Na&rsquo;Vi i brazilske ekipe MiBR. Iako se prema prognozama nije dovodilo u pitanje ko ??e biti pobednik MiBR je neverovatno dobro odigrao dok je najbolji igra?? sveta Aleksandr &bdquo;s1mple&ldquo; Kostyliev imao jako slabu partiju koju je zavr&scaron;io sa 51.4 &scaron;tete po rundi i 0.83 rejtingom.</p>\r\n\r\n<p>MiBR je slavio 16-12 na Dust2, a nakon toga OG odnosi komfornu 16-8 pobedu protiv Astralisa uz 27 fragova i 1.88 rejting nexe.</p>\r\n\r\n<p>OG je u nastavku turnira savladao i preostala dva rivala u grupi, MiBR rezultatom 16-9, a potom i Astralis u me??u za prvo mesto (16-8 Inferno) najaviv&scaron;i sjajnu godinu za ekipu koja nije imala previ&scaron;e zapa??enih rezultata u godini koja je iza nas.</p>\r\n\r\n<p>Na&rsquo;Vi je do??iveo drugi uzastopni poraz protiv Astralisa i to nakon produ??etaka na mapi Mirage. U pobedni??kim redovima je zasijao Benjamin &bdquo;blameF&ldquo; Bremer sa 33 fraga.</p>\r\n\r\n<p>Na&rsquo;Vi ??e sada morati da dobije tri uzastopna me??a ako ??ele do Spring Finalsa direktno, ina??e im ne gine da se bore kroz Showdown i time znatno ote??aju sebi posao.</p>\r\n', '1644571532_s1mple-blast-199830-750x499.jpeg', 5, 13, 6, '2022-02-11 10:25:32', NULL),
(9, 'Katowice: Ropz pozitivan na koronu, propu??ta start turnira', '<p><strong>FaZe Clan je do??iveo velikih peh pred po??etak IEM Katowice 2022 CS:GO takmi??enja. Zvezda tima Robin &quot;ropz&quot; Kool ??e biti u karantinu do 19. februara nakon &scaron;to se ispostavilo da je pozitivan na testu za koronu.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Ropz je imao odli??an debi za FaZe na prole??nom BLAST-u gde su zavr&scaron;ili kao prvoplasirani tim u grupi C ispred Vitality, da bi u me??u za plasman na Spring Finals pobedili BIG i dokazali da su u odli??noj formi.</p>\r\n\r\n<p>Zbog toga i ne ??udi da je FaZe bio jedan od favorita za titulu na IEM Katowice 2022, ali je njihov uspeh sada pod znakom pitanja jer ??e Ropz morati da propusti plejin fazu, a potom i deo grupne faze turnira ukoliko FaZe obezbedi prolaz dalje.</p>\r\n\r\n<p>Iako se o??ekivalo da ??e rupu u timu popuniti Olof &bdquo;olofemister&ldquo; Kajbjer, igra?? koga je Ropz i zamenio, olof je objavio da putuje u Njujork i da ne??e mo??i da se pridru??i timu u Poljskoj, tako da u ovom trenutku nema nikakvih naznaka ko bi mogao da bude peti igra?? ekipe.</p>\r\n', '1644571583_1641289134-ropz-750x501.jpg', 5, 13, 6, '2022-02-11 10:26:23', NULL),
(10, 'IEM Katowice 2022: Izvu??eni parovi', '<p><strong>Od 15. februara gledamo jedan od najve??ih i najpopularnijih CS:GO turnira IEM Katowice, na kom ??e se 24 tima boriti za nagradni fond od milion dolara.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Poljska ??e jo&scaron; jednom ugostiti najbolje timove sveta u borbi za presti??ni CS:GO trofej. Osam ekipa se ve?? nalazi u glavnoj fazi takmi??enja, dok ??e preostalih 16 u??esnika morati da se izbori kroz bara??.</p>\r\n\r\n<p>U grupi A glavnog dela turnira na??i ??e se&nbsp;<strong>Vitality</strong>,&nbsp;<strong>Heroic</strong>,&nbsp;<strong>Virtus.pro</strong>,&nbsp;<strong>Gambit</strong>&nbsp;i ??etiri tima iz bara??a, dok u grubi B gledamo&nbsp;<strong>Na&rsquo;Vi</strong>,&nbsp;<strong>G2</strong>,&nbsp;<strong>FURIU</strong>,&nbsp;<strong>Team Liquid</strong>&nbsp;i ??etiri ekipe iz plejin faze.</p>\r\n\r\n<p>Kada je re?? o plejinu koji ??e se igrati po sistemu duplih eliminacija, evo i kako izgledaju parovi prvog kola:</p>\r\n\r\n<p><strong>Ninjas in Pyjamas &ndash; Wisla Krakow</strong></p>\r\n\r\n<p><strong>Copenhagen Flames &ndash; Fnatic</strong></p>\r\n\r\n<p><strong>GODSENT &ndash; MOUZ</strong></p>\r\n\r\n<p><strong>Sprout &ndash; FaZe Clan</strong></p>\r\n\r\n<p><strong>OG &ndash; Renegades</strong></p>\r\n\r\n<p><strong>ENCE &ndash; Entropiq</strong></p>\r\n\r\n<p><strong>Complexity &ndash; BIG</strong></p>\r\n\r\n<p><strong>Astralis &ndash; MiBR</strong></p>\r\n\r\n<p>Svaki tim koji do??e do dve pobede prolazi dalje, dok se sa dva poraza ispada sa turnira.</p>\r\n\r\n<p>U prvom paru o??ekuje se da ??e Ninjas in Pyjamas i Fnatic voditi glavnu re??, ukoliko CPH Flames ne prona??u u me??uvremenu formu sa Majora. FaZe Clan je veliki favorit protiv Sprouta i pobednika me??a GODSENT &ndash; MOUZ, nakon &scaron;to su pokazali odli??nu igru u grupnoj fazi prole??nog BLAST-a.</p>\r\n\r\n<p>Iz istog razloga i OG bi trebalo da iza??e na kraj sa svojim rivalima, ali poznato je da timovi kao &scaron;to su Renegades i Entropiq umeju da iznenade kada se to najmanje o??ekuje.</p>\r\n\r\n<p>Astralis i BIG su igrali dva puta tokom BLAST-a, a oba puta je nema??ki tim izlazio kao pobednik. Dancima je ovo poslednja &scaron;ansa za iskupljenje pre nego &scaron;to se upale crvene lampice u timu, ali da bi ponovo gledali njihov duel oni prvo moraju pro??i pored ekipa Complexity i MiBR.</p>\r\n\r\n<p>https://twitter.com/ESLCS/status/1491094632599638025</p>\r\n\r\n<p>Slabije rangirani timovi ??e imati priliku da se uigraju tokom bara??a, a onda ??e pred njima biti izuzetno te??ak zadatak protiv CS:GO sila kao &scaron;to su Na&rsquo;Vi, Gambit, Vitality i G2.</p>\r\n\r\n<p>Jedno je sigurno, IEM Katowice 2022 ??e nam pokazati da li ??e se Na&rsquo;Vi razbuditi nakon relativno slabe (za njihov standard) igre na BLAST-u, ili ??e neo??ekivano brzo do??i do smene na vrhu.</p>\r\n', '1644571729_iem-katowice-120927-750x500 (1).jpeg', 5, 13, 6, '2022-02-11 10:28:49', NULL),
(11, 'FaZe, G2, NaVi me??u u??esnicima BLAST Premier Spring Finalsa', '<p><strong>Pobedom ekipe BIG protiv Astralisa okon??ana je grupna faza prole??nog BLAST turnira, a pored nema??ke ekipe plasman u zavr&scaron;nicu turnira obezbedili su jo&scaron; i G2, Na&#39;Vi, Vitality, OG i FaZe Clan.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Nakon zavr&scaron;etka BLAST Premier Springs grupne faze poznato je &scaron;est od osam u??esnika finalnog dela turnira. U plejin fazi prvi je prolaz dalje obezbedio Vitality koji je slavio u derbiju protiv G2 Esportsa 2-1 (16-10 Inferno, 4-16 Mirage, 16-12 Dust2). Francusko-danski miks je odli??no izgledao u novoj postavi i ??ini se da je pred nama po??etak (odnosno nastavak) jednog velikog rivalstva.</p>\r\n\r\n<p>Slede??i je na red do&scaron;ao OG koji je pobedio NiP 2-1 nakon produ??etaka na odlu??uju??oj mapi (16-4 Overpass, 14-16 Ancient, 19-17 Mirage). Nemanja &bdquo;nexa&ldquo; Isakovi?? je imao derbi iz snova za OG koji izgleda kao veoma sna??na ekipa na startu nove takmi??arske sezone.</p>\r\n\r\n<p>Veoma interesantan me?? su odigrali FaZe i BIG, u kom je FaZe poveo tesnom 16-14 pobedom na Dust2, da bi potom gledali dve potpuno jednostrane mape. BIG je uzeo Overpass 16-2, da bi ih FaZe ponizio na Nuke rezultatom 16-1 u odlu??uju??oj tre??oj partiji.</p>\r\n\r\n<p>U narednom danu na programu su bila poslednja tri me??a za preostale slotove na finalnom turniru. G2 je lako iza&scaron;ao na kraj sa ekipom MiBr (16-5 Ancient, 16-6 Inferno), Na&rsquo;Vi se izvukao i pored velikih oscilacija u igri uspeo da do??e do plasmana u drugi krug, pobediv&scaron;i NiP 2-0 (16-6 Nuke, 16-14 Overpass, dok je BIG kao &scaron;to smo ve?? napomenuli savladao bledi Astralis 2-0 (16-14 Ancient, 16-9 Dust2.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Ostala su jo&scaron; samo dva mesta na BLAST Premier Spring Finals, koja ??e pripasti pobednicima Showdown turnira na kom ??e se takmi??iti ukupno 16 timova.</p>\r\n', '1644571792_1639825687-s1mple-750x500.jpg', 5, 13, 6, '2022-02-11 10:29:52', NULL),
(12, 'Kralj Monte Karla: Leb slavio u Fordu za po??etak nove ere!', '<p><strong>Devetostruki svetski &scaron;ampion Sebastijan Leb trijumfovao je na Reliju Monte Karlo kojim je startovao ovogodi&scaron;nji Svetski reli &scaron;ampionat (WRC), a na kojem je nastupio kao gostuju??i voza??.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Legendarni Francuz je u Kne??evini upisao svoju prvu pobedu za volanom Forda, ujedno prvu uop&scaron;te koju nije ostvario za nekog proizvo??a??a automobila koji nije Sitroen, a ukupno 80. Poslednja me??u trijumfima koje je ostvario brane??i boje francuskog proizvo??a??a bila je na Reliju Katalonije 2018. godine, a ostvario ju je sa suvoza??em Danijem Elenom, kojeg je nasledila Izabel Galmi&scaron;, kojoj je to prvi trijumf.</p>\r\n\r\n<p>Leb je u Monte Karlu slavio po osmi put, ??ime se izjedna??io po broju pobeda sa Sebastijanom O??ijeom, koji je od pro&scaron;le godine samostalno dr??ao rekord. Upravo njih dvojica su vodili borbu za trijumf na ovogodi&scaron;njem izdanju legendarnog relija, a ona je odlu??ena u samom fini&scaron;u. Aktuelni svetski &scaron;ampion je, ina??e, isto u Kne??evini nastupio kao gostuju??i voza??, po&scaron;to ??e ove godine voziti tek nekoliko relija za Tojotu.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Dvojica Francuza su se od ??etvrtka smenjivali u vo??stvu, a u nedelju ujutro se ??inilo da je O??ije uradio ono &scaron;to je potrebno da bi odneo trijumf. Me??utim, na pretposlednjem specijalu mu je pukla guma, &scaron;to je Leb iskoristio i preuzeo vo??stvo i uspeo da ga zadr??i do kraja, a tako ujedno na savr&scaron;eni na??in ozna??i po??etak nove hibridne ere u WRC. 47-godi&scaron;nji Francuz je na kraju imao 20 sekundi prednosti u odnosu na svog sunarodnika, dok se na tre??em stepeniku pobedni??kog postolja na&scaron;ao Kreg Brin, u jo&scaron; jednoj Ford Pumi.</p>\r\n\r\n<p>Do pobede na superspecijalu do&scaron;ao je Kale Rovanpera u Jarisu i tako osvojio dodatnih pet bodova u generalnom plasmanu, ispred Elfina Evansa u sli??nom modelu. Leb je bio ??etvrti, pa su mu pripala dva boda, dok je O??ije osvojio poslednji bod zahvaljuju??i petom mestu.</p>\r\n\r\n<p>Svetski reli &scaron;ampionat nastavlja se Relijem &Scaron;vedske koji je na programu od 24. do 27. februara.</p>\r\n', '1644572287_1642942424-SI202201220122_hires_jpeg_24bit_rgb-750x500.jpg', 4, 12, 7, '2022-02-11 10:38:07', NULL),
(13, 'Aston Martin predstavio bolid za 2022. godinu', '<p><strong>Aston Martin je predstavio bolid &bdquo;AMR22&ldquo; na sve??anosti odr??anoj u sedi&scaron;tu kompanije u Gejdonu (Velika Britanija).</strong></p>\r\n\r\n<p>Novi model ima promenjen aerodinam??ki dizajn u odnosu na pro&scaron;logodi&scaron;nji i trebalo bi da bude zna??ajno kompetitivniji u &scaron;ampionatu Formule 1. Novost je i ve??e prisustvo nijasni ??ute boje na zelenom vozilu.</p>\r\n\r\n<p>Za tim Astona Martina kao i pro&scaron;le sezone u kojoj su zauzeli sedmo mesto u konkurenciji konstruktora vozi??e ??etvrorostruki &scaron;ampion sveta Sebastijan Fetel i Lans Strol.</p>\r\n\r\n<p>&bdquo;<em>Nastavljamo uspon ka vrhu Formule 1. Da bi pobedili u &scaron;ampionatu sve mora da bude na pravom mestu. Potrebni su pravi ljudi na svim pozicijama. Mislim da mi idemo dobrim putem&ldquo;</em>, rekao je Lorens Strol, izvr&scaron;ni direktor Aston Martina.</p>\r\n\r\n<p>Za ne&scaron;to manje od dve nedelje sve ekipe ??e po??eti testiranja u Barseloni, a kasnije ??e pre??i u Bahrein. Start &scaron;ampionata je zakazan za 20. mart upravo u Bahreinu, a sve 23 trke sa svim treninzima i kvalifikacijama i ove godine mo??i ??ete ekskluzivno da pratite na kanalima Sport kluba.</p>\r\n', '1644572362_1644511770-Aston-Martin-750x500.jpg', 4, 11, 7, '2022-02-11 10:39:22', NULL),
(14, 'Meklaren tera udvara??e, Noris ostaje do 2025.', '<p><strong>Ekipa Meklarena produ??ila je ugovor sa Landom Norisom do 2025. godine, a Skaj pi&scaron;e da je na taj na??in ovaj tim &quot;oterao&quot; sve one timove Formule 1 koji bi bili zainteresovani za mladog Britanca.</strong></p>\r\n\r\n<p>Lando Noris i Meklaren su prvi koji su potpisali ugovor pred novu sezonu, a Noris je voza?? koji ima najdu??i ugovor u Formuli 1. On se zavr&scaron;ava tek 2025. godine i on zna??i da ovaj britanski duet ulazi u novu eru Formule 1 na duge staze. Tako??e je cilj da se Meklaren vrati na puteve stare slave na kojima je osvajao i titule.</p>\r\n\r\n<p>Noris je 2021. godine potpisao ve?? produ??enje ugovora po&scaron;to mu je 2020. bila fantasti??na. U 2021. je osvojio prvi pol i bio je ??etiri puta na podijumu, a pamti??e je i po riziku kog je preuzeo u So??iju kada je ostao na mokroj stazi sa gumama za suvo.</p>\r\n\r\n<p>&bdquo;Odrastao sam u ovom timu i deo sam ovog putovanja u kojem smo svi mi. ??elim da nastavim sa poku&scaron;ajima da ostvarimo na&scaron;e snove i da probamo da pobe??ujemo u trkama&ldquo;, rekao je&nbsp;<strong>Noris</strong>.</p>\r\n\r\n<p>&bdquo;Pokazao je pro&scaron;le godine da je u pravom timu i pravom bolidu i u svojoj tre??oj sezoni u Fomruli 1 je bio na pol poziciji. Prirodno je bilo da ga obezbedimo za sebe koliko god je dugo mogu??e kako bismo u Meklarenu imali kontinuitet i konstantnost&ldquo;, rekao je direktor tima&nbsp;<strong>Andreas Sajdl</strong>.</p>\r\n\r\n<p>Norisov timski kolega je od pro&scaron;le godine Danijel Rikardo, a ??ak je i njega Lando zasenio iako se radi o daleko iskusnijem igra??u.</p>\r\n', '1644572475_1644403055-1007136127-750x500.jpg', 4, 11, 7, '2022-02-11 10:41:15', NULL),
(15, '???Vratio sam se!???', '<p><strong>Britanski automobilista Luis Hamilton oglasio se na dru&scaron;tvenim mre??ama prvi put nakon okon??anja prethodne sezone &ndash; trke za Veliku nagradu Abu Dabiju na kojoj mu je u poslednjem krugu izmakla rekordna osma titula.</strong></p>\r\n\r\n<p>U prili??no zagonetnoj objavi na dru&scaron;tvenim mre??ama 37-godi&scaron;njak iz Stivened??a je podelio svoju sliku uz kratak tekst.</p>\r\n\r\n<p>&bdquo;Nije me bilo. Sada sam se vratio!&ldquo;, napisao je&nbsp;<strong>Luis Hamilton</strong>.</p>\r\n\r\n<p>Mnogo se govorilo o tome da li ??e se Hamilton vratiti u F1 u narednoj sezoni i voziti u timu Mercedesa zajedno sa D??ord??om Raselom, a mediji su prenosili da je Britanac veoma nezadovoljan ishodom poslednje trke prethodne sezone.</p>\r\n\r\n<p>Da li ova objava sugeri&scaron;e da ??e se Hamilton takmi??iti i u predstoje??oj sezoni, koja po??inje 20. marta trkom za Veliku nagradu Bahreina, ostaje da se vidi.</p>\r\n', '1644572515_1644086034-Lewis-Hamilton-750x500.jpg', 4, 11, 7, '2022-02-11 10:41:55', NULL),
(16, 'Leb vodi ispred O??ijea u Monte Karlu', '<p><strong>Francuz Sebastijan Leb, as Forda, vodi posle drugog dana Relija Monte Carlo, prve trke Svetskog prvenstva (WRC), ispred svog sunarodnika i aktuelnog prvaka Sebastijana O??ijea, voza??a Tojote.</strong></p>\r\n\r\n<p>Deveterostruki svetski prvak Leb ima prednost od deset sekundi u odnosu na osmostrukog prvaka O??ijea posle osam od ukupno 17 brzinskih ispita ovog relija, koji je ve?? u&scaron;ao u istoriju kao prvi s hibridnim automobilima.</p>\r\n\r\n<p>Vel&scaron;anin Elfin Evans (Tojota) je tre??i s 22 sekunde zaostatka, dok je ??etvrti voza?? Hjundaija, Belgijanac Tijeri Nojvil, koji kasni 48 sekundi.</p>\r\n\r\n<p>Reli Monte Karlo ima epitet najglamuroznijeg relija na svetu, a ovo jubilarno 90. izdanje nije tradicionalno zapo??elo u alpskom gradu Gapu, ve?? u Monte Karlu. ??ak 95 posto rute izmenjeno je u odnosu na pro&scaron;lu godinu.</p>\r\n', '1644572559_1642794877-GettyImages-1237868505-750x500.jpg', 4, 12, 7, '2022-02-11 10:42:39', NULL),
(17, 'Naj??uveniji reli suvoza?? zavr??ava karijeru', '<p><strong>??ulijen Ingrasija, 42-godi&scaron;nji Francuz, zavr&scaron;ava karijeru reli-suvoza??a na kraju ove godine. To je na Tviteru potvrdio i njegov dugogodi&scaron;nji voza??, svetski &scaron;ampion Sebastijan O??ije.</strong></p>\r\n\r\n<p>&bdquo;<em>??ulijen zavr&scaron;ava karijeru na kraju godine i mogu samo da podr??im njegovu odluku. Bio je klju??ni ??ovek svih mojih uspeha u poslednjih 16 godina, koliko sam na najve??oj sceni. Sve smo radili zajedno, na kraju ispunili mnoge snove i osvojili sedam svetskih titula. Ostala su nam jo&scaron; dva relija i ??elimo da ih odvezemo u na&scaron;em stilu</em>&bdquo;, napisao je O??ije, koji je na dobrom putu da osvoji i osmu titulu, po&scaron;to trenutno ima 24 boda prednosti u odnosu na drugoplasiranog Elfina Evansa.</p>\r\n\r\n<p>&bdquo;<em>Za mene nema dileme, ti si najbolji suvoza?? ikada. Ko zna kakva ??e biti moja karijera bez tebe? Hvala na svemu, znam da ??e&scaron; me pratiti i bi??e nemogu??e zameniti te. ??elim ti sve najbolje u ??ivotu, u??ivaj u njemu!</em>&bdquo;, dodao je na kraju veliki Seb.</p>\r\n\r\n<p>Ingrasija, nekada komercijalista u Koka-Koli, ro??en je 1979. godine u Eks An-Provanu, gradu koji se nalazi u blizi Marseja. Par godina bio je reli-voza??, ali od 2006. i profesionalni suvoza?? Sebastijana O??ijea. U??estvovao je u osvajanju svih sedam titula svetskog &scaron;ampiona &ndash; ??etiri sa Folksvagen Polom, dve sa M-Sportom u Ford Fijesti i jednom sa Tojotom. Upisao je 53 pobede u planetarnom Reli &scaron;ampionatu.</p>\r\n\r\n<p>Ve?? je poznato da ??e ??ulijena naredne sezone u Sebastijanovoj Tojoti naslediti Ben??amin Veja, sa kojim je O??ije ve?? odradio nekoliko test vo??nji.</p>\r\n', '1644572635_1642794877-GettyImages-1237868505-750x500.jpg', 4, 12, 7, '2022-02-11 10:43:55', NULL),
(18, 'WTA: Napredak srpskih teniserki', '<p><strong>Nina Stojanovi?? je i dalje najbolje rangirana srpska teniserka. Na WTA listi je napredovala za dva mesta i trenutno je 119.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Nedaleko iza nje nalazi se Aleksandra Kruni??, koja je sa 128. sko??ila na 125. poziciju. Olga Danilovi?? se sa 143. popela na 142.</p>\r\n\r\n<p>U vrhu nije bilo promene. Australijanka E&scaron;li Barti je lider sa 8.330 bodova. Slede Beloruskinja Arina Sabalenka i ??ehinja Barbora Krej??ikova.</p>\r\n\r\n<p>Karolina Pli&scaron;kova je napredovala na ??etvrto mesto, peta je Paula Badosa, &scaron;esta Garbinje Mugurusa, a sedma Marija Sakari. Top 10 kompletiraju Iga &Scaron;vjontek, Anet Kontavejt i Ons ??abur.</p>\r\n', '1644574919_1642830838-Nina-Stojanovic-750x500.jpg', 3, 10, 5, '2022-02-11 11:22:00', NULL),
(19, 'Marti?? pala posle tri seta, kraj i za Juvan', '<p><strong>Hrvatska teniserka Petra Marti?? nije uspela da se plasira u ??etvrtfinale turnira u Sankt Peterburgu, po&scaron;to je posle velike borbe izgubila od Belgijanke Eliz Mertens 6:4, 3:6, 6:2.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Osma favoritkinja turnira slavila je za sva sata i 15 minuta igre.</p>\r\n\r\n<p>Belgijanka je igrala agresivno od samog po??etka, pa je napala servise rivalke u uvodnim gemovima. Uz dva brejka povela je 5:1. Imala je potom i set lopte na servise Marti??eve, ali je Hrvatica uspela da se izvu??e. Nagovestila je bolju igru Petra, vratila je jedan brejk, ali je izgubila set.</p>\r\n\r\n<p>Ujedna??ena borba vodila se u nastavku. Marti?? je klju??ni brejk napravila u &scaron;estom gemu. Potom je iskoristila drugu set loptu.</p>\r\n\r\n<p>Bolje je Hrvatica po??ela odlu??uju??i set, pa je u prvom gemu napravila brejk. Me??utim, u nastavku je ritam diktirala Mertens, potpuno je nadigrala rivalku i ubedljivo dobila tre??i set.</p>\r\n\r\n<p>Naredna protivnica bi??e joj prva favoritkinja turnira Marija Sakari. Grkinja je sa 6:2, 6:4 eliminisala Ruskinju Ekatarinu Aleksandrovu.</p>\r\n\r\n<p>Takmi??enje je zavr&scaron;eno i za Kaju Juvan. Slovenka je izgubila od petog nosioca Belinde Ben??i?? sa 6:1, 7:6 (2).</p>\r\n\r\n<p>&Scaron;vajcarkinja ??e u ??etvrtfinalu igrati protiv druge favoritkinje Anet Kontavejt. Estonka je bila bolja od Sorane Kirstee 6:4, 7:5.</p>\r\n', '1644574972_1625082778-Petra-Martic-750x475.jpg', 3, 10, 5, '2022-02-11 11:22:52', NULL),
(20, 'Serena: Penzija? Pripremam se za to ve?? deset godina', '<p><strong>Ameri??ka teniserka Serena Vilijams izjavila je da se ve?? deceniju sprema za odlazak u penziju.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Serena, koja je u karijeri osvojila 23 grend slem titule, nije igrala od Vimbldona, kada je zbog povrede predala me?? prvog kola.</p>\r\n\r\n<p>&bdquo;Ponovo treniram, &scaron;to je uzbudljivo. Trudim se da u??em u formu, da se moje telo navikne na teniski trening, koji se razlikuje od obi??nog. Vide??emo &scaron;ta ??e biti, ne ose??am pritisak&ldquo;, rekla je Amerikanka.</p>\r\n\r\n<p>&bdquo;Spremna sam za taj dan, pripremam se za to ve?? vi&scaron;e od decenije. Moj otac Ri??ard je uvek govorio da morate da budete spremni, tako da sam se ja pripremila. Na kraju krajeva, uvek je va??no da imate plan&ldquo;.</p>\r\n\r\n<p>Serena je 2017. godine postala majka, rodila je k??erku Olimpiju. Sada je otkrila da ??eli jo&scaron; dece.</p>\r\n\r\n<p>&bdquo;Definitivno ??elim da imam jo&scaron; dece. Uvek se pitamo jesmo li spremni. Znam da sat otkucava. Shvati??u kada je pravo vreme. Nadam se da ??e biti uskoro, kada vi&scaron;e ne budem ose??ala pritisak&ldquo;.</p>\r\n\r\n<p>&Scaron;ta mislite, ho??e li Vilijamsova izjedna??iti rekord Margaret Kort od 24 grend slem titule?</p>\r\n', '1644575021_1636199522-21299071183758-750x500.jpg', 3, 10, 5, '2022-02-11 11:23:41', NULL),
(21, 'Halep ne??e novog trenera: Ceo ??ivot mi govore ??ta da radim', '<p><strong>Rumunska teniserka Simona Halep odlu??ila je da ne anga??uje novog trenera, ve?? da u nastavku sezone radi samostalno.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Dvostruka grend slem &scaron;ampionka je posle Australijan opena raskinula saradnju sa Adrijanom Markuom i Danijelom Dobreom. Posle toga je otkrila da ne planira da anga??uje novog trenera.</p>\r\n\r\n<p>&bdquo;Nemam trenera i u ovom trenutku ne ??elim da anga??ujem nikog. ??elim da vidim kako ??e mi i??i kad sam sama. Ceo ??ivot su mi govorili da li je ono &scaron;to radim dobro ili lo&scaron;e. Sada ??elim da sve to spoznam sama, da se razvijem kao li??nost&ldquo;, objasnila je Simona.</p>\r\n\r\n<p>Rumunka dodaje da ??e joj od velike koristi biti sve &scaron;to je nau??ila od Darina Kejhila, sa kojim je radila &scaron;est godina.</p>\r\n\r\n<p>&bdquo;Sve savete koje mi je Daren dao ??u primeniti u praksi. Ose??am se veoma dobro, nema pritiska. ??elim da sama radim. Imam mnogo ideja i znam kako da se nosim sa ovom situacijom. Pomo??i ??u sebi, ulo??i??u u svoj razvoj. Ne znam kakva ??e biti budu??nost, ali ??elim da odlo??im kraj karijere koliko je to mogu??e&ldquo;.</p>\r\n\r\n<p>Halep ima 30 godina. U karijeri je osvojila 23 titule, od kojih dve na grend slemovima (Rolan Garos, Vimbldon). Bila je i prva teniserka sveta.</p>\r\n', '1644575060_1642682978-GettyImages-1365836873-750x500.jpg', 3, 10, 5, '2022-02-11 11:24:20', NULL),
(22, 'Filip imao set i brejk i ispao, Mari izbacio Bublika', '<p><strong>Srpski teniser Filip Krajinovi?? pora??en je u prvom kolu turnira iz serije 500 u Roterdamu, po&scaron;to je bolji od njega bio Marton Fu??ovi?? sa 3:6, 6:3, 6:2.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>U prva ??etiri gema videli smo tri brejka, Filip je vodio sa 3:1 i onda je u petom gemu spasao brejk loptu. U naredna dva gema na svoj servis je bio siguran i poveo je u setovima.</p>\r\n\r\n<p>Kada je u prvom gemu drugog seta napravio brejk, ??inilo se da je Krajinovi?? znatno bli??i pobedi. Ipak, usledio je neverovatan pad srpskog tenisera &ndash; ??etiri izgubljena gema u nizu za de fakto kraj drugog seta.</p>\r\n\r\n<p>U tre??em tako??e Krajinovi?? nije pru??io jak otpor, odmah na startu je pretrpeo brejk, zatim jo&scaron; jedan u petom gemu, pa je Ma??ar stigao do pobede, prve u ??etvrtom okr&scaron;aju s Krajinovi??em.</p>\r\n\r\n<p>Fu??ovi??a u drugom kolu ??eka doma??i teniser Talon Grikspor, koji je u utorak preokrenuo u okr&scaron;aju sa Aslanom Karacevom.</p>\r\n\r\n<p>Endi Mari je u dva seta eliminisao pobednika turnira u Monpeljeu Aleksandra Bublika 7:6 (6), 6:4 i plasirao se u drugo kolo, a prvu prepreku uspe&scaron;no su presko??ili jo&scaron; Ilja Iva&scaron;ka, Feliks O??e Alijasim i Sonvu Kvon.</p>\r\n\r\n<p>U ??etvrtfinalu su Lorenco Museti, koji je bio bolji od Huberta Hurka??a 6:4, 5:7, 6:3, Kameron Nori trijumfom protiv Karena Ha??anova 6:4, 7:6 (5) i Aleks De Minor koji je savladao Mekenzija Mekdonalda 7:6 (6), 1:6, 6:4</p>\r\n', '1644575115_1642682978-GettyImages-1365836873-750x500.jpg', 3, 9, 5, '2022-02-11 11:25:15', NULL),
(23, '??varcman kroz dva taj-brejka do ??etvrtfinala Buenos Ajresa', '<p><strong>Dijego &Scaron;varcman je dobio ??aumea Munara 7:6 i 7:6 i tako se plasirao u ??etvrtinu finala na turniru u svojoj zemlji. Tokom no??i se igralo i u Dalasu gde je Rajli Opelka pro&scaron;ao Sedrika &Scaron;tebe, a Adrijan Manarino je izbacio Jo&scaron;ihitu Ni&scaron;ioku.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&Scaron;varcman je u duelu protiv Munara prvi napravio brejk, ali je servis i izgubio kada je pri rezultatu 5:4 servirao za prvi set. U taj-brejku je drugi nosilac bio mnogo bolji pa je zavr&scaron;io taj deo seta 7:2. U drugom setu su teniseri po dva puta razmenili brejkove, mogao je &Scaron;varcman da zavr&scaron;i me?? pre taj-brejka jer je imao dve me?? lopte u 10. gemu ali je opet bilo 6:6. U taj-brejku je vodio 6:0 i iskoristio je tek petu me?? loptu.</p>\r\n\r\n<p>U ??etvrtini finala ??e Dijego igrati sa Franciskom ??erundolom koji je izbacio Miomira Kecmanovi??a i koji je trenutno 107. igra?? sveta.</p>\r\n\r\n<p>Rajli Opelka je za dva sata izbacio &Scaron;tebea koji je 200 mesta lo&scaron;ije plasiran na ATP listi od njega. Jeste Rajli dobio u dva seta ali u oba je igrao taj-brejk. Prvi set je dobio za 51 minut, u taj brejku je bilo 7:3, dok je u taj-brejku drugog seta bilo 10:8. Drugi set je trajao ne&scaron;to vi&scaron;e od dva sata, a interesantno u ovom duelu nije bilo brejk &scaron;ansi.</p>\r\n\r\n<p>Manarino je ne&scaron;to lak&scaron;i posao imao protiv Ni&scaron;ioke kome je prepustio ??etiri gema. Bilo je 6:3 i 6:1 za sat i &scaron;est minuta igre.</p>\r\n', '1644575170_1644563799-GettyImages-1238364980-750x518.jpg', 3, 9, 5, '2022-02-11 11:26:10', NULL),
(24, 'Cicipas i Rubljov lako do ??etvrtfinala, Mari eliminisan', '<p><strong>Grk Stefanos Cicipas lako se izborio mesto u ??etvrtfinalu turnira serije 500 u Roterdamu.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>??etvrti teniser sveta u drugom kolu pobedio je Belorusa Ilju Iva&scaron;ku 6:4, 6:1 za 71 minut igre. Cicipas ??e se u petak u borbi za plasman u polufinale sastati sa Aleksom de Minorom, koji je dan ranije bio bolji od Mekenzija Mekdonalda 6:7 (6), 6:1, 6:4.</p>\r\n\r\n<p>Grk je u drugom i ??etvrtom gemu prvog seta prokockao ??etiri brejk lopte, a nakon &scaron;to je u devetom spasao jedinu za Belorusa, u slede??em je oduzeo servir protivniku i taj deo me??a dobio sa 6:4. U drugom setu nije bilo neizvesnosti &ndash; prvi nosilac je poveo sa 5:0 uz dva brejka i lako zavr&scaron;io duel.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Cicipas u me??usobnim duelima sa De Minorom ima maksimalan u??inak &ndash; 8:0.</p>\r\n\r\n<p>Plasman u ??etvrtfinale u dva seta obezbedio je i Andrej Rubljov trijumfom protiv Sonvo Kvona iz Ju??ne Koreje 6:3, 6:3.</p>\r\n\r\n<p>Duel je trajao sat i 20 minuta, a sedmi teniser na ATP listi je iskoristio tri od 13 brejk lopti. Rus je u prvom setu jednom oduzeo servis rivalu i dva puta u drugom. Kvon nije realizovao nijednu od ??etiri brejk lote.</p>\r\n\r\n<p>Rubljova u ??etvrtfinalu o??ekuje me?? sa Martonom Fu??ovi??em ili Talonom Griksporom.</p>\r\n\r\n<p>Kana??anin Feliks O??e Alijasim je tako??e bio maksimalan protiv Endija Marija 6:3, 6:4 za ne&scaron;to vi&scaron;e od sat i po igre.</p>\r\n\r\n<p>Tre??i nosilac je ??etiri puta oduzeo servis Britancu, po dva puta u oba seta, tako da mu nije mnogo na&scaron;kodilo to &scaron;to je nekada&scaron;nji broj jedan napravio dva brejka (2/2).</p>\r\n\r\n<p>O??e Alijasim ??e u ??etvrtfinalu igrati sa Kameronom Norijem.</p>\r\n\r\n<p>??e&scaron;ki kvalifikant Jir??i Legecka, koji je na startu savladao Denisa &Scaron;apovalova, eliminisao je Holan??anina Botika Van De Zand&scaron;lupa 1:6, 6:4, 6:4. Dvadesetogodi&scaron;njak, trenutno 137. teniser sveta, u narednom kolu sasta??e se sa Lorencom Muzetijem.</p>\r\n', '1644575255_1626444219-RTXEDHBJ-750x560.jpg', 3, 9, 5, '2022-02-11 11:27:35', NULL),
(25, 'Kecmanovi?? poklekao protiv ??erundola', '<p><strong>Srpski teniser Miomir Kecmanovi?? nije uspeo da se plasira u ??etvrtfinale ATP turnira serije 250 u Buenos Ajresu, po&scaron;to je u tri seta pora??en od doma??eg tenisera Franciska ??erundola 6:3, 2:6, 6:2.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Kao &scaron;to i sam rezultat pokazuje me?? je obilovao oscilacijama. Obojica tenisera i&scaron;la su od sjaja do o??aja. Kecmanovi?? je u prvom setu imao brejk prednosti i vodio 2:1, ali je ipak uspeo da izgubi set, po&scaron;to je do kraja osvojio samo jedan gem.</p>\r\n\r\n<p>U drugom je Srbin ponovo stekao brejk prednosti i poveo 3:1. Ali ga je ponovo i izgubio i to momentalno. Me??utim, ovog puta je bio istrajniji, ve?? u narednom gemu poveo 4:2 i jako fini&scaron;irao za izjedna??enje.</p>\r\n\r\n<p>Taman je krenuo da iskoristi psiholo&scaron;ku prednost, iskoristio na startu tre??u brejk loptu i poveo 1:0. Ali onda je usledio pad, momentalno izgubljen brejk, a onda jo&scaron; samo jedan osvojen gem do kraja me??a.</p>\r\n\r\n<p>??erundolo ??e se u ??etvrtfinalu sastati sa pobednikom me??a Munar &ndash; &Scaron;varcman. U preostalim me??evima dana Fonjini &ndash; Martines 2:0 (6:4, 7:6) i Anduhar &ndash; Delbonis 0:2 (4:6, 4:6).</p>\r\n', '1644575294_1638375217-Miomir-Kecmanovic-750x472.jpg', 3, 9, 5, '2022-02-11 11:28:14', NULL),
(26, 'Lukina poruka da mo??e bez Porzingisa, 51 poen Klipersima', '<p>D??ej Krauder, Kameron D??onson i D??aval Mekgi koji su svi bili dvocifreni. Janis Adetokunbo je ostao na tek 18 poena uz &scaron;ut iz igre 5/14, a da je bio van fokusa pokazuju i penali 8/14 kao i tri izgubljene lopte. Midlton i Holidej su imali po 21 poen.</p>\r\n\r\n<p>Toronto je dobio Hjuston Roketse u najboljoj partiji sezone za Gerija Trenta. Ubacio je 42 poena pa je sada Toronto na osam uzastopnih trijumfa. Kod Hjustona je Kevin Porter imao 30 poena. Majami nije ni&scaron;ta prepu&scaron;tao slu??aju protiv Nju Orleansa 112:97, vodio je tokom ??itavog drugog poluvremena a najbolji su bili Bem Adebajo i D??imi Batler sa 29 poena. Ruki Hoze Alvarado je za Pelikanse ubacio 17 poena. D??a Morent je jo&scaron; jednom pokazao za&scaron;to je Ol star starter. Ubacio je 23 poena u pobedi Memfisa nad Detroitom 132:107. D??erami Grent je kod Pistonsa imao 20 poena</p>\r\n', '1644599142_luka_doncic.jpg', 2, 6, 4, '2022-02-11 17:59:48', '2022-02-11 18:05:42'),
(27, 'Kakva petorka: Jokic, Lebron, Janis???', '<p><strong>Poznate su petorke za predstoje??i Ol Star koji se odr??ava u Klivlendu. Srpski predstavnik Nikola Joki?? igra??e u timu koji predvodi Lebron D??ejms.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Ovaj format u kojem dva igra??a sa najvi&scaron;e glasova biraju petorke, prakti??no je doktorirao Lebron D??ejms. U sva ??etiri prethodna izdanja njegov tim je ostvario pobede. A izgleda da je tajna u izboru petorke. Jer kada se pogledaju petorke za ovogodi&scaron;nji Ol Star me?? u Klivlendu, utisak je da je D??ejms ozbiljno izdominirao u odnosu na Durenta.</p>\r\n\r\n<p>D??ejms u svom sastavu ima osvaja??e poslednje tri MVP nagrade Nikolu Joki??a i Janisa Adetokumpa. A na bekovskim pozicijama tu su stra&scaron;ni Stef Kari i ??ovek koji igra ko&scaron;arku karijere Demar Derozan.</p>\r\n\r\n<p>Na drugoj strani ima Kevin Durent respektabilnu petorku. Tu su D??oel Embid, D??ejson Tejtum, D??eja Morant, Trj Jang i Endru Vigins. Durent ne??e igrati zbog povrede kolena.</p>\r\n\r\n<p>Treba dodati da je u Lebronovom timu me??u rezervama i prva zvezda Dalasa Luka Don??i??.</p>\r\n\r\n<p>Ol Star vikend na programu je od 18. do 20. februara u Klivlendu.&nbsp;</p>\r\n', '1644599115_nikola_jokic_all_star.jpg', 2, 6, 4, '2022-02-11 18:01:34', '2022-02-11 18:05:15'),
(28, 'Harden trejdovan za trojicu!', '<p><strong>Ko&scaron;arka&scaron; Bruklina D??ejms Harden trejdovan je u Filadelfiju, preneo je novinar ESPN Adrian Vojnarovski.</strong></p>\r\n\r\n<p>Tokom dana pojavila se informacija da iskusni bek ??eli da napusti Netse, ali da ne??e da podnese zvani??an zahtev za trgovinu zbog straha od reakcije javnosti.</p>\r\n\r\n<p>Ipak, pre isteka roka (10. februar u 21 ??as po srednjoevropskom vremenu) Bruklin i Siksersi su se dogovodili i 32-godi&scaron;nji Harden ??e karijeru nastaviti u petoplasiranom timu Isto??ne konferencije u zamenu za Bena Simonsa, koji ove sezone nije odigrao nijedan me?? zbog sukoba sa upravom, Seta Karija, Andrea Dramonda i dva pika sa drafta.</p>\r\n\r\n<p>Pored Hardena, put Pensilvanije ??e i Pol Milsap.</p>\r\n\r\n<p>Netsi ??e u zamenu dobiti neza&scaron;ti??enog pika iz prve runde drafta 2022. sa pravom na odlaganje do 2023. i pik iz prve runde 2027.</p>\r\n\r\n<p>Harden je pre godinu dana iz Hjustona trejdovan u Bruklin, a ove sezone prose??no bele??i 22.5 poena, 8 skokova i 10.2 asistencije.</p>\r\n\r\n<p>Pre nego &scaron;to se preselio u Bruklin, Ol-star ko&scaron;arka&scaron; je osam i po sezona bio ??lan Hjustona. Prvi NBA klub bio mu je Oklahoma (2009-2012).</p>\r\n', '1644599238_Dzejms-Harden-1-scaled-e1619002228826-750x418.jpg', 2, 6, 4, '2022-02-11 18:07:18', NULL),
(29, 'Dragi?? za sada u San Antoniju, ??eka se nova destinacija', '<p><strong>Nije se Goran Dragi?? dugo zadr??ao u Toronto Reprtorsima.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Nekada&scaron;nji reprezentativac Slovenije posle samo nekoliko meseci u Kanadi, karijeru u NBA ligi nastavi??e u San Antonio Sparsima. Prema navodima medija u suprotnom pravcu idu Ted Jang.</p>\r\n\r\n<p>Me??utim, izvesno je da Dragi?? ne??e dugo ostati u ekipi iz Teksasa i o??ekuje se da uskoro zavr&scaron;i u nekoj ekipi koja ??eli da otkupi njegov ugovor. Me??u kandidatima je i Dalas za koji igra Luka Don??i??.</p>\r\n\r\n<p>Dragi??u nikako nije prijao odlazak u Kanadu. Ove sezone u proseku bele??i osam poena, uz 1,8 asisencija i 2,8 skokova po me??u. Poslednji me?? za Toronto odigrao je jo&scaron; 13. novembra pro&scaron;le godine protiv Detroita.</p>\r\n\r\n<p>Od tada se nalazi van tima, a kao razlog su navedeni nepoznati li??ni problemi. O??igledno je da je iskusni Slovenac ??eleo po svaku cenu da napusti Reptorse.</p>\r\n\r\n<p>U dosada&scaron;njoj ve?? 14 godina dugo NBA karijeri, Dragi?? je pored Toronta i&nbsp;</p>\r\n', '1644599359_1644513057-GettyImages-1348150492-750x500.jpg', 2, 6, 4, '2022-02-11 18:09:19', NULL);
INSERT INTO `posts` (`id`, `name`, `description`, `image_path`, `category_id`, `heading_id`, `user_id`, `created_at`, `updated_at`) VALUES
(30, 'Bogdanovi?? i Juta zaustavili GSW, Nurki?? odli??an protiv LAL', '<p><strong>Ko&scaron;arka&scaron;i Jute D??eza ubedljivo su savladali Golden Stejt Voriorse 111:85, te tako upisali ??etvrtu uzastopnu pobedu.</strong></p>\r\n\r\n<p>Okon??an je niz &lsquo;ratnika&rsquo; od devet pobeda. Juta je bila dominantna u no??i izme??u srede i ??etvrtka.</p>\r\n\r\n<p>Ravnopravna borba vodila se samo u uvodnih 12 minuta, posle ??ega su &lsquo;d??ezeri&rsquo; zagospodarili terenom.</p>\r\n\r\n<p>Bojan Bogdanovi?? je predvodio Jutu sa 23 poena (7-16 iz igre, 3-7 za tri), uz 6 skokova. Donovan Mi??el je upisao 14 poena (5-14 iz igre, 4-10 za tri), uz 10 skokova i 8 asistencija, po 13 su ubacili Majk Konli i D??ordan Klarkson.</p>\r\n\r\n<p>D??ordan Pul je na drugoj strani zabele??io 18 poena (5-14 iz igre), Stef Kari je ubacio 16 (5-13 iz igre, 3-8 za tri), dok je Endrju Vigins imao 13 poena (5-11 iz igre, 2-5 za tri). Nemanja Bjelica nije bio u timu.</p>\r\n\r\n<p>Juta je ??etvrta na Zapadu sa skorom 34-21, dok je Golden Stejt na drugoj poziciji sa 41-14.</p>\r\n\r\n<p>Portland Blejzersi savladali su Los An??eles Lejkerse 107:105.</p>\r\n\r\n<p>Uzbudljivo je bilo u zavr&scaron;nici. Posle pogotka Lebrona na 27 sekundi do kraja bilo je 105:102 za Portland. Blejzersi su potom imali napad, koji je zavr&scaron;en proma&scaron;ajem. Ipak, Monk je napravio faul na tri sekunde do kraja, a Simons je bio precizan sa linije za slobodna bacanja za 107:102. Lebron je trojkom u poslednjoj sekundi samo ubla??io poraz svog tima.</p>\r\n\r\n<p>Anferni Simons je bio najbolji u pobedni??kom timu sa 29 poena (11-23 iz igre, 5-11 za tri), Jusuf Nurki?? je ubacio 19 poena (8-11 iz igre), uz 12 skokova.</p>\r\n\r\n<p>Lebron D??ejms je na drugoj strani zabele??io 30 poena (13-22 iz igre, 3-7 za tri), po 7 skokova i asistencija, Entoni Dejvis je imao 17 poena (8-11 iz igre).</p>\r\n\r\n<p>Portland je prekinuo niz od &scaron;est poraza i sada je 11. na Zapadu sa 22-34. Lejkersi su na devetom mestu sa 26-30.</p>\r\n\r\n<p>Sakramento Kingsi su bili bolji od Minesota Timbervulvsa 132:119.</p>\r\n\r\n<p>Harison Barns je ubacio 30 poena (8-11 iz igre, 4-5 za tri), Diandre Foks je dodao 27 poena (10-20 iz igre), a Domantas Sabonis je debitovao dabl-dabl u??inkom od 22 poena (10-19 iz igre) i 14 skokova.</p>\r\n\r\n<p>U pora??enoj ekipi istakao se Dian??elo Rasel sa 29 poena (10-20 iz igre, 6-13 za tri) i 10 asistencija, Entoni Edvards je imao 26 poena (10-25 iz igre), dok je Karl-Entoni Tauns stao na 21 poenu (9-17 iz igre).</p>\r\n\r\n<p>Minesota je pora??ena posle pet uzastopnih pobeda i sada je sedma na Zapadu sa 28-26. Kingsi su 12. u poretku sa 21-36.</p>\r\n', '1644599678_1621837843-Bojan-Bogdanovic-1200x800.jpg', 2, 6, 4, '2022-02-11 18:14:38', NULL),
(31, 'Felipe Rejes ??? legenda Evrolige', '<p><strong>Jedan od najupe??atljivijih ko&scaron;arka&scaron;a ovog milenijuma, Felipe Rejes u petak, pred po??etak utakmice izme??u Reala i Barselone, ??e zvani??no biti progla&scaron;en legendom Evrolige.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Rejes se povukao u ko&scaron;arka&scaron;ku penziju pro&scaron;le godine sa punom 41 godinom nakon 23 godine igranja. Za to vreme osvojio je 24 titule, sve sem jedne sa Realom za koji je igrao 17 godina.</p>\r\n\r\n<p>U Evroligi debitovao je sa 20 godina sa Estudijantesom za koji je igrao do 2004. I to je bio tek po??etak. Kada je re&scaron;io da se povu??e u ovom takmi??enju bio je rekorder po broju ofanzivnih skokova (705), drugi u ukupnom broju skokova (1.799), u realizovanim poenima sa linije za slobodna bacanja (967) ali i iznu??enih faulova (1.308). Tre??i je po broju odigranih utakmica u takmi??enju (357), &scaron;esti po indeksu korisnosti (3.775) i osmi po broju posignutih poena (3.029).</p>\r\n\r\n<p>Rejes je sedmi igra?? kome ??e na ovaj na??in biti odato priznanje za sjajnu karijeru, pre njega su legendama Evrolige imenovani &Scaron;arunas Jasikevi??ijus, Huan Karlos Navaro, Ramunas &Scaron;i&scaron;kauskas, Teodoros Papalukas, Dimitris Dijamantidis i Mirsad Turkd??an.</p>\r\n\r\n<p>Od trenera je ovu nagradu dobio Du&scaron;an Ivkovi??, a od rukovodilaca klubova &Scaron;imon Mizrai iz Makabija.</p>\r\n', '1644695193_1644496362-unnamed-750x415.png', 2, 8, 4, '2022-02-12 20:46:33', NULL),
(32, 'Perasovi??: Zvezda se uvek bori', '<p><strong>Crvena zvezda u 26. kolu Evrolige gostuje Uniksu u Kazanju. Jedno od najzahtevnijih putovanja i gostovanja je pred crveno belima, a kazanjski tim ima imperativ pobede kako bi se zadr??ao na nekoj od pozicija koja vodi u plej-of.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Sa 8-14 Zvezda je na ??etiri pobede zaostatka od Fenerbah??ea koji je na osmoj poziciji. ??ak je pet timova ispred Crvene zvezde u borbi za plej-of tako da ??e ekipi Dejana Radonji??a biti ba&scaron; te&scaron;ko da stignu do doigravanja. Uniks sa druge strane igra odli??no cele sezone i sa 13-10 je trenutno sedmi.</p>\r\n\r\n<p>&bdquo;Zvezda je veoma jak, veoma sna??an tim, jedna od najboljih odbrana Evrolige. Izgubili su neke utakmice, ali kako god oni se uvek bore. Ovaj me?? je veoma va??an za nas. Moramo da zadr??imo na&scaron;u poziciju koja vodi u plej of. Borba se nastavlja&ldquo;, rekao je&nbsp;<strong>Velimir Perasovi??</strong>.</p>\r\n\r\n<p>Tako??e o utakmici sa Zvezdom je govorio i bek &scaron;uter Ajzea Kenan.</p>\r\n\r\n<p>&bdquo;Jo&scaron; jedna va??na evroliga&scaron;ka utakmica. Zvezda je ozbiljan protivnik, imale su dobre me??eve nedavno. Na&scaron; cilj je da uradimo sve kako bismo dobili. Ra??unamo na podr&scaron;ku navija??a&ldquo;, rekao je&nbsp;<strong>Kenan</strong>.</p>\r\n\r\n<p>Uniks cele godine igra fenomenalno predvo??en Mariom Hezonjom, a odli??no igraju i D??on Braun, biv&scaron;i igra?? Zvezde Lorenzo Braun, dok su tu i Ajzea Kenan, O D??ej Mejo&hellip; Me?? u petak gledajte na Sport Klubu 1 od 17 ??asova.</p>\r\n', '1644695297_1644578495-1238041341-750x507.jpg', 2, 8, 4, '2022-02-12 20:48:17', NULL),
(33, 'CSKA razbijen u Tel Avivu, ??ok za Obradovi??a', '<p><strong>Ko&scaron;arka&scaron;i Makabija lako su pobedili moskovski CSKA u Tel Avivu u 26. kolu Evrolige - 84:75.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&bdquo;Ponos Izraela&ldquo; je potvrdio da je u dobroj formi i posle ??etvrtog trijumfa u poslednjih pet utakmica ima u??inak 11-12, dok su Armejci na 14-10.</p>\r\n\r\n<p>Tim Janisa Sfaropulosa je drugu ??etvrtinu dobio ubedljivo 26:11 i na odmor je oti&scaron;ao sa ogromnih 49:28. Pitanje pobednika je ve?? tada bilo re&scaron;eno, a gosti iz Moskve su u fini&scaron;u utakmice malo popravili utisak i minus smanjili na jednocifreni.</p>\r\n\r\n<p>Makabi je ubacio deset trojki iz 26 poku&scaron;aja, a najefikasniji je bio Skoti Vilbekin sa 23 poena (5/8 za tri), Ante ??i??i?? je upisao 14 /7/9 za dva), a Kenan Evans 11. Ife Lundberg je predvodio CSKA sa 17 poena i po 4 skoka i asistencije, a Nikola Milutinov je dodao 12 (6/9 za dva) uz 6 skokova za 26 minuta.</p>\r\n\r\n<p>Izraelci u slede??em kolu gostuju Efesu, a Armejci idu u Minhen.</p>\r\n\r\n<p>Monako je pred svojim navija??ima neo??ekivano pora??en od &bdquo;fenjera&scaron;a&ldquo; ??algirisa 83:82.</p>\r\n\r\n<p>Ekipa trenera Sa&scaron;e Obradovi??a od prvog do poslednjeg minuta imao je prednost, maksimalno plus 13 u tre??oj deonici, ali su rastere??eni Litvanci uvek nalazili na??in da se vrate, a vo??stvo za kona??nih 83:82 ujedno je i jedino koje su imali. Odlu??uju??i ko&scaron; postigao je Lukas Lekavi??ijus na 17 sekundi pre kraja.</p>\r\n\r\n<p>Monako je pretrpeo tek drugi poraz u poslednjih osam utakmica, ali na kraju mo??e da bude i presudan u borbi za plej-of.</p>\r\n\r\n<p>Nils Gifaj je bio najbolji u liztvanskom timu sa 15 poena, Arturas Milaknis je zabele??io 14, a ??ofri Lovernj 13. U doma??oj ekipi Dvejn Bejkon i Majk D??ejms su upisali po 18 poena, dok se Danilo An??u&scaron;i?? nije upisao u strelce za ne&scaron;to vi&scaron;e od dva minuta na terenu.</p>\r\n\r\n<p>Ekipa iz Kne??evine u slede??em me??u do??ekuje Uniks, a ??algiris u Kaunasu igra sa Realom.</p>\r\n\r\n<p>Olimpija je u Milanu bila bolja od Baskonije 89:78 uz 23 poena Devona Hola i 14 Serhija Rodrigesa. U pora??enoim timu Met Kostelo je upisao 23 poena.</p>\r\n\r\n<p>Italijanska ekipa je tre??a sa 17-7, a Baskonija 16. sa 7-17.</p>\r\n', '1644696063_1644528116-1238360638-750x500.jpg', 2, 8, 4, '2022-02-12 21:01:03', NULL),
(34, 'Slukas trojkom u poslednjoj sekundi sru??io Efes', '<p><strong>Ko&scaron;arka&scaron;i Olimpijakosa trojkom Kostasa Slukasa u poslednjem sekundu produ??etka pobedili su Anadolu Efes 87:85 u 26. kolu Evrolige.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Ekipa iz Pireja je prekinula seriju od &scaron;est poraza od tima iz Istanbula, a malo je nedostajalo da aktuelni &scaron;ampion Evrope nastavi niz. Efes je imao napad kod rezultata 85:84, me??utim, Vasilije Mici?? nije poentirao nakon prodora, &scaron;to je Slukas iskoristio i iz &bdquo;kornera&ldquo; doneo veliko slavlje navija??ima crveno-belih.</p>\r\n\r\n<p>Olimpijakos je na deobi ??etvrte pozicije sa u??inkom 14-9, dok je Efes deveti sa 12-12.</p>\r\n\r\n<p>U regularnih 40 minuta ekipe su se ??esto smenjivale u vo??stvu, a crveno-beli su maksimalnih plus 9 imali na kraju prve ??etvrtine (26:17).</p>\r\n\r\n<p>Slukas je bio najefikasniji sa 23 poena (4/6 za tri) uz 5 skokova i 6 asistencija, Sa&scaron;a Vezenkov je upisao 16, a Mustafa Fal 10. Na drugoj strani Tibor Plajs je imao 14, Rodrigo Bobua 13, a Mici?? 12 poena (4/6 za dva, 1/7 za tri, 1/1 slobodna bacanja) uz 3 skoka i 13 asistencija.</p>\r\n\r\n<p>Olimpijakos u slede??em kolu do??ekuje Olimpiju iz Milana, a Efes u Istanbulu igra sa Makabijem.</p>\r\n\r\n<p>Alba je u Berlinu pobedila Zenit rezultatom 68:62 i posle drugog trijumfa u poslednje tri utakmice na 14. poziciji izjedna??ila se sa Crvenom zvezdom s tim &scaron;to srpski tim ima dva me??a manje.</p>\r\n\r\n<p>Ruski tim je ??etvrti sa u??inkom 14-9 koliko.</p>\r\n\r\n<p>Doma??i su prvu ??etvrtinu dobili 23:12, drugu su izgubili 22:11 i na poluvremenu je bilo nere&scaron;eno. Posle izjedna??ene tre??e deonice, Albatrosi su u poslednjoj konstantno imali izme??u pet i devet poena prednosti.</p>\r\n\r\n<p>Lo je bio najefikasniji u nema??kom timu sa 14 poena, dok su kod gostiju Beron i Kuzminskas imali po 18.</p>\r\n\r\n<p>Alba u slede??em kolu gostuje Asvelu, a Zenit na svom parketu igra sa Barselonom.</p>\r\n', '1644696482_1644524866-1238358861-750x478.jpg', 2, 8, 4, '2022-02-12 21:08:02', NULL),
(35, 'Radonji??: Kratak period za pripremu, ??elimo nove bodove', '<p><strong>Trener ko&scaron;arka&scaron;a Crvene zvezde Dejan Radonji?? nada se da ??e njegovi igra??i spremni do??ekati duel sa Zadrom, posle velike pobede koju su ostvarili nad Uniksom.</strong></p>\r\n\r\n<p>Crveno-beli su savladali Uniks u Evroligi u petak, a ve?? u nedelju ??e igrati protiv Zadra u okviru 20. kola ABA lige.</p>\r\n\r\n<p>Posle Kazanja i izuzetno kratkog vremenskog perioda o??ekuje nas utakmica sa Zadrom. Postoji veliko zadovoljstvo zbog pobede u Kazanju, posebno zbog ??injenice da su pojedini igra??i odigrali dobro i po??eli da se vra??aju u stanje u kome su bili pre korone i svega &scaron;to smo nakon toga imali kao posledicu toga&ldquo;, rekao je Radonji?? i dodao:</p>\r\n\r\n<p>&bdquo;Naravno posle velike potro&scaron;nje u Kazanju poku&scaron;a??emo da iskoristimo taj izuzetno kratak period od samo jednog dana kako napravili pripremu i u&scaron;li &scaron;to spremniji u utakmicu sa Zadrom, odigrali je dovoljno dobro kako bi osvojili nove bodove&ldquo;.</p>\r\n\r\n<p>Zvezda u regionalnom takmi??enju ima skor 16-1, dok je Zadar na 6-11. U prvom ovosezonskom duelu crveno-beli su slavili sa 83:73.</p>\r\n\r\n<p>Utakmica u hali Aleksandar Nikoli?? igra se od 19 ??asova.</p>\r\n', '1644696927_1640896955-Dejan-Radonjic-750x500.jpg', 2, 7, 4, '2022-02-12 21:15:27', NULL),
(36, 'Mur spasao Partizan: Crno-beli u zavr??nici slomili FMP', '<p><strong>Ko&scaron;arka&scaron;i Partizana pobedili su FMP u ??elezniku rezultatom 86:80 u 20. kolu ABA lige.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Crno-beli su do slavlja nad Panterima stigli u neizvesnoj zavr&scaron;nici, i to po&scaron;to su ve??im delom utakmice bili u zaostatku.</p>\r\n\r\n<p>??ovek odluke je ameri??ki plejmejker Dalas Mur, koji je u fini&scaron;u ubacio gotovo sve poene Partizana i predstavljao nere&scaron;ivu enigmu za Pantere.</p>\r\n\r\n<p>FMP je od prvog minuta imao vo??stvo. Na visokom nivou je igrao doma??in i pred odlazak na poluvreme je stekao +8 (46:38). Uspevao je Partizan nekako da se odr??i na jednocifrenom minusu, pre nego &scaron;to je u drugom delu tre??e ??etvrtine u&scaron;ao u egal.</p>\r\n\r\n<p>Igrao se poen za poenom u nastavku, ekipe su se ??esto smenjivale u vo??stvu, pre nego &scaron;to je Mur prelomio me?? u poslednjem minutu.</p>\r\n\r\n<p>Reprezentativac Albanije imao je 21 poen (10/13 za dva, 0/6 za tri). Kevin Panter ga je pratio sa 17, Uro&scaron; Trifunovi?? sa 16, a Matijas Lesor sa 11 uz pet skokova. Dobru partiju prikazao je i Bal&scaron;a Koprivica sa devet poena i 11 skokova.</p>\r\n\r\n<p>Kod FMP, Danilo Tasi?? je imao 16 poena, Marko Radonji?? 13, Ebuka Izundu 11, a Brajs D??ons 10 i ??ak 14 asistencija.</p>\r\n\r\n<p>Crno-beli imaju skor 16-3. Panteri su na 10-8.</p>\r\n', '1644697051_1644695944-normal_fmp_partizan_18.jpg', 2, 7, 4, '2022-02-12 21:17:32', NULL),
(37, 'Di D??ej Sili: Mega je prilika da se iskupimo navija??ima', '<p><strong>Ko&scaron;arka&scaron;i Budu??nosti primorani su da arhiviraju poraz od Venecije u minulom kolu Evrokupa, te veoma slabo prvo poluvreme, jer ih 13. februara, sa po??etkom u 17 ??asova o??ekuje duel sa Megom u 20. kolu ABA lige.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Podgori??ani imaju skor 13-3, a Mega posle ubedljivog poraza od SC Derbija u glavnom gradu Crne Gore, pre nekoliko dana, 8-10. Podse??anja radi, u prvom delu sezone, Mega je nanela, jedan od tri poraza ekipi Budu??nosti.</p>\r\n\r\n<p><em>&ldquo;Moramo da iza??emo na parket sa mnogo vi&scaron;e energije i agresivnosti u odnosu na prethodni duel protiv Venecije. Imamo obavezu prema navija??ima da odigramo kvalitetan me??, da se iskupimo za spomenuti poraz, da se vratimo na pobedni??ki kolosek&rdquo;,</em>&nbsp;naglasio je&nbsp;<strong>Di D??ej Sili</strong>, pa nastavio:</p>\r\n\r\n<p><em>&ldquo;Mega ima izuzetno mladu i talentovanu ekipu. Pobedili su nas u prvom delu sezone, insistiraju na igri sa mnogo tranzicije, imaju dosta momaka sa ofanzivnim potencijalom, dobri su u ofanzivnom skoku. Sve su to stvari koje moramo i verujem da ??emo uspeti da neutrali&scaron;emo na putu ka cilju, a to je pobeda u me??u koji sledi. Ponavljam jo&scaron; jednom, o??ekujem podr&scaron;ku navija??a, a nastoja??emo da ovoga puta opravdamo njihova o??ekivanja, kao &scaron;to smo to radili u dosada&scaron;njem delu sezone&rdquo;.</em></p>\r\n\r\n<p>Utakmica izme??u Budu??nosti i Mege na program je 13. februara sa po??etkom u 17 ??asova. Nakon pomenutog me??a, sledi mini pauza, zbog drugog FIBA prozora, zbog kvalifikacionih me??eva za Mundbasket, koje mo??ete da pratite na kanalima Sport Kluba.</p>\r\n\r\n<p>Crnu Goru o??ekuje dvome?? sa Ma??arskom koji je slobodno se mo??e re??i od vitalnog zna??aja kada je borba za mesto na Svetskom prvenstvu u pitanju.</p>\r\n', '1644697188_1642014310-sili-750x464.jpg', 2, 7, 4, '2022-02-12 21:19:48', NULL),
(38, '??avi prelomio ??? Alves nije licenciran za Ligu Evrope', '<p><strong>Defanzivac Barselone Dani Alves nije prijavljen za zavr&scaron;nicu Lige Evrope, potvrdio je klub sa &quot;Kamp Nou&quot; stadiona.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Prema pravilima UEFA, trener Katalonaca ??avi Ernandes je imao pravo da licencira najvi&scaron;e trojicu novih fudbalera i odlu??io se za&nbsp;<strong>Adamu Traorea</strong>,&nbsp;<strong>Ferana Toresa</strong>&nbsp;i&nbsp;<strong>Pjera Emerika Obamejanga</strong>.</p>\r\n\r\n<p>Me&scaron;u prijavljenim igralima je i napada??&nbsp;<strong>Usman Dembele</strong>.</p>\r\n\r\n<p>Tridesetosmogodi&scaron;nj<strong>i Alves</strong>&nbsp;je bio prvi novajlija u<strong>&nbsp;??avijevoj</strong>&nbsp;eri na klupi Barselone, a odigrao je ??etiri utakmice i upisao dve asistencije.</p>\r\n\r\n<p>Barselona ??e se u 1/16 finala Lige Evrope sastati sa Napolijem. Prva utakmica je 17. februara na &bdquo;Kamp Nou&ldquo;, a revan&scaron; nedelju dana kasnije u Napulju.</p>\r\n\r\n<p>Crvena zvezda se kao pobednik grupe F direktno plasirala u osminu finala drugog po ja??ini klupskog takmi??enja u Evropi.</p>\r\n', '1644697523_1643824689-GettyImages-1347078476-750x539.jpg', 1, 4, 3, '2022-02-12 21:25:23', NULL),
(39, 'Mediji: Ili??i?? zbog psihi??kih problema bez licence za Evropu', '<p><strong>Vezni fudbaler Atalante Josip Ili??i?? nije uvr&scaron;ten u sastav tima za nokaut fazu Lige Evrope, prenosi portal Football Italia.</strong></p>\r\n\r\n<p>Prema njihovim saznanjima, stru??ni &scaron;tab kluba iz Bergama odluku je doneo posle razgovora sa slovena??kim igra??em, koji je ve?? neko vreme van takmi??arskog pogona zbog psihi??kih problema.</p>\r\n\r\n<p>Trideset??etvorogodi&scaron;nji fudbaler nije&nbsp;bio u timu u poslednja tri me??a, a trener Atalante ??an Pjero Gasperini je posle duela sa Lacijom 22. januara pri??ao o problemima svog igra??a.</p>\r\n\r\n<p>&bdquo;Nije mi lako da pri??am o ovakvim situacijama jer su jako li??ne. Bili smo i uvek c??emo biti uz njega. Svakom od nas u glavi se vrte razli??ite misli. Ostaje nam samo da se nadamo da c??e se uskoro izboriti sa tim. Postoje situacije koje su iznad fudbala. Josip je ove godine radio kao nikada. Ne znamo kada c??e nam ponovo biti dostupan. Na&scaron;a svest je kao d??ungla. To je posao kojim se bave psihijatri. Nadam da ??e se vratiti i ponovo otkriti igru zbog koje ??e u??ivati na terenu,&ldquo; izjavio je Gasperini.</p>\r\n\r\n<p>Ili??i?? je u leto 2020. godine napustio ekipu zbog depresije i tek na jesen je ponovo obukao dres kluba u koji je do&scaron;ao 2017. iz Fiorentine. Slovenac nikad nije otvoreno govorio o ovom problemu.</p>\r\n\r\n<p>Atalanta ??e se u 1/16 finala Lige Evrope sastati sa Olimpijakosom. Prvi me?? je u Italiji 17. februara, a revan&scaron; nedelju dana kasnije u Pireju.</p>\r\n\r\n<p>Slovenac je ove sezone upisao 19 me??eva u Seriji A i postigao je tri gola uz ??etiri asistencije. U ??etiri utakmice Lige &scaron;ampiona ima gol i asistenciju.</p>\r\n', '1644697660_josip-ilicic-150253-750x499.jpeg', 1, 4, 3, '2022-02-12 21:27:40', NULL),
(40, 'Zvezdin spisak za evropsko prole??e bez Dionija', '<p><strong>Crvena zvezda prijavila je tim za evropsko prole??e. Na njemu su se na&scaron;li igra??i koji su tim Dejana Stankovi??a poja??ali u zimskom prelaznom roku, ali nema Loija Dionija.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Naravno, na spisku nema igra??a koji su napustili klub tokom zimske pauze, Njego&scaron;a Petrovi??a i Marka Lazeti??a, ali nema ni Dionija za koga Dejan Stankovi?? ka??e da se nije uklopio u ekipu i da Crvena zvezda nema vremena nikoga da ??eka.</p>\r\n\r\n<p>Prijavljeni su za nastavak takmi??enja u Ligi Evrope Kristijano Pi??ini, Nemanja Motika i Ohi Omoid??uanfro, kao i mladi igra??i Nikola Stankovi??, Andrej ??uri?? i Andrija Radulovi??.</p>\r\n\r\n<p>Evo i celog spiska koji je iz Crvene zvezde poslat na adresu UEFA:</p>\r\n\r\n<p><strong>Golmani:</strong></p>\r\n\r\n<p>Milan Borjan, Zoran Popovi??, Milo&scaron; Gordi??, Stefan Marinkovi??</p>\r\n\r\n<p><strong>Odbrana:</strong></p>\r\n\r\n<p>Milan Gaji??, Radovan Pankov, Andrej ??uri??, Aleksandar Dragovi??, Milan Rodi??, Kristijano Pi??ini, Strahinja Erakovi??, Marko Gobelji??</p>\r\n\r\n<p><strong>Vezni red:</strong></p>\r\n\r\n<p>Nikola Stankovi??, Mirko Ivani??, Nenad Krsti??i??, Gelor Kanga, Aleksandar Katai, Nemanja Motika, Petar Stani??, Veljko Nikoli??, Mohamed El Fardu Ben, Seku Sanogo, Andrija Radulovi??, Slavoljub Srni??, Aksel Bakajoko</p>\r\n\r\n<p><strong>Napad:</strong></p>\r\n\r\n<p>Milan Pavkov, Ri&scaron;airo ??ivkovi??, Filipo Falko, Ohi Omoid??uanfro.</p>\r\n', '1644697720_1625582754-E5nYLUAWYAEbAxW-750x552.jpg', 1, 4, 3, '2022-02-12 21:28:40', NULL),
(41, 'Inter precrtao Kolarova', '<p><strong>Levi bek Intera i nekada&scaron;nji kapiten reprezentacije Srbije Aleksandar Kolarov nije licenciran za nokaut fazu Lige &scaron;ampiona.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Trener &bdquo;Neroazura&ldquo; Simone Inzagi je odlu??io da za nastavak sezone u Evropi prijavi novajlije, Ekvadorca&nbsp;<strong>Felipea Saiseda</strong>&nbsp;i Nemca&nbsp;<strong>Robina Gosensa</strong>, a pored Kolarova na spisku nema&nbsp;<strong>Stefana Sensija</strong>&nbsp;koji je pozajmljen Sampdoriji.</p>\r\n\r\n<p>Kako prenose italijanski mediji, srpski internacionalac jo&scaron; nije odlu??io da li ??e karijeru da zavr&scaron;i pre isteka ugovora u junu.</p>\r\n\r\n<p>Trideset&scaron;estogodi&scaron;nji levi bek je ove sezone odigrao ??etiri utakmice u svim takmi??enjima, odnosno samo 48 minuta. U Ligi &scaron;ampiona je upisao &scaron;est minuta protiv &Scaron;erifa iz Tiraspolja.</p>\r\n\r\n<p>Kolarov je u Inter do&scaron;ao u septembru 2020, a prethodno je igrao za Romu, Man??ester Siti, Lacio, OFK Beograd i ??ukari??ki.</p>\r\n\r\n<p>Inter ??e 16. februara ugostiti Liverpul u prvom me??u osmine finala Lige &scaron;ampiona, a revan&scaron; je 8. marta na Enfildu.</p>\r\n', '1644697896_1643836904-GettyImages-1231069431-750x467.jpg', 1, 3, 3, '2022-02-12 21:31:36', NULL),
(42, 'Del Pjero: Sa Vlahovi??em napad na finale Lige ??ampiona', '<p><strong>Alesandro Del Pjero, slavni as Juventusa, veruje da bjanko-neri iz Torina dolaskom Du&scaron;ana Vlahovi??a imaju tim za velika dela.</strong></p>\r\n\r\n<p>Nekada&scaron;nji reprezenativac Italije ka??e da ga sada&scaron;nja ekipa podse??a na onu koja je 2017. godine stigla do finala Lige &scaron;ampiona. Tada su u napadu igrala tri igra??a i to uglavnom: Iguain, Dibala i Mand??uki??.</p>\r\n\r\n<p><em>Mislim da trener radi pravu stvar &scaron;to stavlja u isti tim Dibalu, Vlahovi??a i Moratu. Dibala je vi&scaron;e na desnoj strani, Morata je odli??an na levoj strani. Puno tr??i, poma??e timu i nikada ne odustaje. Vlahovi?? ??e sigurno doprineti efikasnosti&ldquo;</em>, ka??e Del Pjero.</p>\r\n\r\n<p>??uvena desetka misli da Juve mo??e daleko da dogura u elitnom fudbalskom takmi??enju.</p>\r\n\r\n<p>&bdquo;<em>Odli??ni su u odbrani, solidni u sredini terena. Napad je najbolji deo tima i Alegri je potpuno u pravu &scaron;to forsira igru sa tri napada??a. Mogu da napadnu kao i 2017. godine finale Lige &scaron;ampiona&ldquo;</em>.</p>\r\n\r\n<p>Juventus ??e u osmini finala Lige &scaron;ampiona igrati protiv Viljareala. Prvi me?? je na programu 22. februara u &Scaron;paniji, a revan&scaron; je 16. marta u Torinu.</p>\r\n', '1644698053_1644582292-GettyImages-1130569790-750x498 (1).jpg', 1, 3, 3, '2022-02-12 21:34:13', NULL),
(43, 'L?? mladi: Hajduk ispao na penale od Atletika', '<p><strong>Mladi fudbaleri Hajduka pora??eni su u Splitu protiv madridskog Atletika u plej-ofu Lige &scaron;ampiona za juniore posle izvo??enja jedanaesteraca. Posle 90 minuta bilo je 0:0.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Hrabro su se borili juniori Hajduka, ba&scaron; kao i tokom ??itavog ciklusa Lige &scaron;ampiona. Pred skoro devet hiljada gledalaca na Poljudu pru??ili su odli??nu partiju protiv Madri??ana. Me??utim, nije bilo golova ni na jednoj, ni na drugoj strani, pa su odlu??ivali penali.</p>\r\n\r\n<p>Posle prve dve serije pojavila se nada. Doma??in je pogodio oba penala preko Hrgovi??a i Vrci??a, dok je za Atletiko penal proma&scaron;io Alisiturija. Me??utim, u naredne dve serije Spli??ani su proma&scaron;ili oba penala, a Madri??ani oba pogodili i na kraju ipak izborili plasman u osminu finala Lige &scaron;ampiona.</p>\r\n', '1644698134_1644434335-hajduk-750x375.jpg', 1, 3, 3, '2022-02-12 21:35:34', NULL),
(44, 'Levandovski: Prvi smo favoriti za osvajanje Lige ??ampiona', '<p><strong>Robert Levandovski, najbolji igra?? sveta u izboru FIFA, veliki je optimista uo??i nastavka takmi??enja u Ligi &scaron;ampiona.</strong></p>\r\n\r\n<p>Bajern ??e se u me??u osmine finala sastati sa austrijskim Red Bul Salcburgom. Prvi me?? na programu je 16. februara, a revan&scaron; je zakazan za 8. mart.</p>\r\n\r\n<p>&bdquo;<em>Mi smo glavni favoriti da osvojimo trofej. Pogledajte kako igramo i kakav tim imamo. Jasno je da smo me??u najja??im timova u Ligi &scaron;ampiona. Najve??nije je da svi budemo zdravi kada budu odlu??uju??i me??evi i da u najboljoj formi budemo u pravom trenutku&ldquo;</em>, istakao je sjajni poljski napada??.</p>\r\n\r\n<p>Bajern je poslednji put titulu prvaka Starog kontinenta osvojio 2020. godine kada su Bavarci u finalu pobedili PS?? 1:0. Pehar od pro&scaron;le sezone brani londonski ??elsi.</p>\r\n', '1644698221_1643980528-GettyImages-1366488793-750x500.jpg', 1, 3, 3, '2022-02-12 21:37:01', NULL),
(45, '??eferin: Razmi??ljamo o uvo??enju Fajnal fora u L??', '<p><strong>Predsednik UEFA Aleksander ??eferin rekao je da postoji mogu??nost da se zavr&scaron;nica Lige &scaron;ampiona organizuje po uzoru na onu u ko&scaron;arka&scaron;koj Evroligi, organizacijom Fajnal fora.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>UEFA je pre dve sezone bila primorana da organizuje takav zavr&scaron;etak sezone L&Scaron; zbog pandemije, &scaron;to se ??elnim ljudima o??igledno svidelo.</p>\r\n\r\n<p>&bdquo;Nismo o tome stigli da pregovaramo zbog pandemije koronavirusa. Ali,&nbsp; smatram da bi to bila sjajna stvar. Bilo bi neizvesnije takmi??enje i mnogo interesantnije navija??ima. Pri??ao sam o tome sa nekim predsednicima klubova, kao &scaron;to je Al-Kelaifi (PS??) i on se sla??e sa mnom&ldquo;, rekao je ??eferin, pa potom dodao da je novac taj koji diktira trendove u sportu:</p>\r\n\r\n<p>&bdquo;Evropski fudbal je recimo ve??i od NFL, ali je Super boul ogroman spektakl. Moramo da re&scaron;imo jednostavnu jedna??inu: da klubovima obezbedimo kompenzaciju za novac koji ??e izgubiti kao doma??ini polufinalnih utakmica. Mislim da bi sve moglo najranije da za??ivi u sezoni 2024/25, ne verujem da mo??e br??e&ldquo;, poru??io je Slovenac.</p>\r\n', '1644698308_1632815171-Aleksander-Ceferin-750x500.jpg', 1, 3, 3, '2022-02-12 21:38:28', '2022-02-12 21:38:34'),
(46, 'Bajern se izblamirao u Bohumu', '<p><strong>U subotu je odigrano pet utakmica 21. kola Bundeslige Nema??ke. Najve??e iznena??enje priredio je Bohum, koji je slavio protiv Bajerna. Klub iz Minhena je u septembru u utakmici petog kola urnisao Plave rezultatom 7:0, tako da su sada do??ekali svoj trenutak za osvetu.</strong></p>\r\n\r\n<p>Fudbaleri Bohuma napravili su najve??e iznena??enje ove subote u Nema??koj pobediv&scaron;i lidera prvenstva rezultatom 4:2. Bavarci su poveli u devetom minutu golom Roberta Levandovskog, ali je Antvi-A??ei samo pet minuta potom izjedna??io.</p>\r\n\r\n<p>Igrao se 38. minut kada su doma??ini uspeli da do??u do vo??stva. Posle igranja rukom u kaznenom prostoru, dosu??en je penal, koji je realizovao Lokadija.</p>\r\n\r\n<p>Samo dva minuta kasnije posle odli??ne akcije Bohuma Gamboa je postigao gol za 3:1. U samom fini&scaron;u prvog poluvremena Holtman je &scaron;utirao sa ivice kaznenog prostora i tako povisio prednost Plavih.</p>\r\n\r\n<p>Do kraja me??a Bajern je poku&scaron;avao da preokrene, ali sve &scaron;to je uspeo je da postigne jo&scaron; jedan pogodak. Strelac je opet bio Levandovski u 75. minutu.</p>\r\n\r\n<p>Ipak, ovaj poraz ne??e uticati na plasman na Bajerna, koji je sa devet bodova prednosti u odnosu na drugoplasirani&nbsp; Dortmund apsolutni lider nema??kog prvenstva. S druge strane, Bohum zauzima 11. poziciju.</p>\r\n', '1644698397_1636329211-GettyImages-1351691368-750x514.jpg', 1, 5, 3, '2022-02-12 21:39:57', NULL),
(47, '??est golova, tri u samom fini??u, i pobeda Bajera', '<p><strong>U poslednjem subotnjem me??u 22. kola Bundeslige Bajer Leverkuzen savladoa je na svom terenu &Scaron;tutgart rezultatom 4:2 (1:0).</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Bajer je po??eo dobro, Patrik &Scaron;ik imao je odli??nu priliku u 13. minutu, kontorlisali su doma??i igru i posed.</p>\r\n\r\n<p>&Scaron;tutgart je prvi put ozbiljnije pripretio u 28. minutu preko Tijaga Tomasa koji je sjajno &scaron;utirao, ali je pogodio pre??ku.</p>\r\n\r\n<p>Prvi put se mre??a gostiju zatresla u 34. minutu, ali je Frlorijan Vric bio u ofsajdu.</p>\r\n\r\n<p>Doma??in do prednosti dolazi u 41. minutu. Musa Dijabi je do&scaron;ao do odbijene lopte i sjajnom rekacijom je poslao u ra&scaron;lje.</p>\r\n\r\n<p>Tek &scaron;to je me?? nastavljen u drugom poluvremenu Tijago Tomas odli??no prima loptu koju mu je poslao Orel Mangala i pribrano je &scaron;alje u mre??u za izjedna??enje. Igrao se 49. minut.</p>\r\n\r\n<p>Nije radost gostiju dugo trajala. Samo tri minuta nakon izjedna??enje Amin Adli se odlobodio ??uvara, ispratio je igru i u gol pretvorio centar&scaron;ut Kerema Demirbaja.</p>\r\n\r\n<p>Igrao se 86. minut kada je Florijan Vric pogodio za 3:1, ali ovom me??u ni tu nije bio kraj.</p>\r\n\r\n<p>Dva minuta kasnije odgovorio je Tijago Tomas, a u 90. minutu rezultat je na kona??nih 4:2 postavio Patrik &Scaron;ik, Vric je ovoga puta bio asistent.</p>\r\n\r\n<p>Nakon ??etvrte vezane pobede, a 12. u sezoni Bajer na tre??em mestu na tabeli ima 41 bod, samo dva manje od Borusije Dortmund koja ipak ima me?? manje.</p>\r\n\r\n<p>&Scaron;tutgart je do??iveo 12. poraz, ??etvrti vezani, i pretposledlji je na tabeli sa svega 18 bodova.</p>\r\n\r\n<p>U slede??em kolu &Scaron;tutgart ??e do??ekati Bohum, a Bajer ??e u goste Majncu.</p>\r\n', '1644698491_1644693361-bajer-750x540.jpg', 1, 5, 3, '2022-02-12 21:41:31', NULL),
(48, 'Nagelsman posle te??kog poraza: Nismo smeli ovo da dozvolimo', '<p><strong>Trener Bajerna bio je nezadovoljan posle te&scaron;koh poraza njegovog tima od Bohuma u nedelju.</strong></p>\r\n\r\n<p>Minhenski tim pora??en je sa 4:2 u 22. kolu nema??kog prvenstva. Poveli su Bavarci ve?? u devetom minutu preko Levandovskog, ali je usledila goleada Bohuma, koji je do kraja poluvremena imao 4:1. Kona??ni rezultat postavio je Levandovski u 75. minutu.</p>\r\n\r\n<p>&bdquo;??estitam Bohumu, igrali su dobro, zaslu??ili su pobedu. Za nas je ovo bio u??asan me??, nismo smeli da dozvolimo da se ovo desi. Prvo poluvreme smo odigrali veoma lo&scaron;e. Imali smo plan, koji nije uspeo. Trebalo je da reagujem ranije&ldquo;, ocenio je Nagelsman.</p>\r\n\r\n<p>&bdquo;Posle njihova dva gola, bilo je te&scaron;ko. Takvi golovi se ne daju svaki dan. Mi smo u prvom poluvrmenu bili previ&scaron;e pasivni. U drugom poluvremenu smo bili bolji. Da smo dali ranije drugi gol, mo??da bi bilo uzbudljivo. Na kraju, zaslu??ena pobeda Bohuma&ldquo;.</p>\r\n\r\n<p>Bajern je pretrpeo ??etvrti poraz u sezoni. I dalje je prvi na tabeli, sa devet bodova vi&scaron;e od Borusije iz Dortmunda, koja ima me?? manje.</p>\r\n', '1644698592_1639827768-21331700713732-750x485.jpg', 1, 5, 3, '2022-02-12 21:43:12', NULL),
(49, 'Mina neprecizan sa bele ta??ke, Selti samo bod u Kadisu', '<p><strong>Deul izme??u Kadisa i Selte u 24. kolu &scaron;panske La Lige zavr&scaron;en je bez golova, podelom bodova.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Imali su gosti iz Viga vi&scaron;e vremena loptu u posedu u prvom delu utakmice, ali je Kadis imao &scaron;ut u okvir gola rivala.</p>\r\n\r\n<p>Po??etkom drugog poluvremena doma??i su imali &scaron;ansu da povedu. Lozano je primio pas, na&scaron;ao se sam ispred golmana i odlu??io je da &scaron;utira sna??no po sredini gola. Dituro je odbranio.</p>\r\n\r\n<p>U 85. minutu su gosti imali veliku &scaron;ansu da do??u do vo??stva. Posle ??estokog starta Ledemasa, sudija je pokazao na belu ta??ku. Santi Mina je izveo kazneni udarac, ali je golman doma??ih spasao svoju mre??u.</p>\r\n\r\n<p>Rezultat se do kraja me??a nije menjao.</p>\r\n\r\n<p>Selta je sa 31 bodom na devetom mestu na tabeli. Kadis je sa 19 u zoni ispadanja na 18. poziciji.</p>\r\n', '1644698824_1644677803-GettyImages-1370141665-750x500.jpg', 1, 2, 3, '2022-02-12 21:47:04', NULL),
(50, 'Jovi??u pre??ka ???ukrala??? status heroja: Nula Reala', '<p><strong>Fudbaleri Real Madrida remizirali su sa Viljarealom na gostovanju 0:0 u 24. kolu La Lige.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Kraljevski klub je nastavio sa promenljivim partijama u poslednje vreme i propustio &scaron;ansu da se vrati na +6 u odnosu na drugoplasiranu Sevilju.</p>\r\n\r\n<p>Viljareal se bodom popeo na petu poziciju uz isti broj poena poput &scaron;estoplasiranog Atletika, koji ima dve utakmice manje.</p>\r\n\r\n<p>U junaka duela na stadionu Keramika mogao je da izraste srpski napada?? Luka Jovi??.</p>\r\n\r\n<p>Dobio je Jovi?? &scaron;ansu u 75. minutu umesto Gareta Bejla i u nadoknadi je lako mogao da donese trijumf Madri??anima. Sjajno je pobegao odbrani doma??ina, lobovao Heronima Ruljija, ali je pre??ka bila saveznik Viljareala.</p>\r\n\r\n<p>Real je i do tog momenta bio bolji rival, naro??ito u drugom poluvremenu. Imao je &scaron;anse preko Vinisijusa i Bejla, me??utim, Rulji je dobrim odbranama poneo epitet igra??a utakmice.</p>\r\n\r\n<p>Ekipa Karla An??elotija u slede??em me??u ??eka Alaves 19. februara. ??etiri dana ranije gostuje Pari Sen ??ermenu u prvom me??u osmine finala Lige &scaron;ampiona.</p>\r\n\r\n<p>Sastav Unaija Emerija narednog vikenda gostuje Granadi.</p>\r\n\r\n<p>&nbsp;</p>\r\n', '1644698921_1644686141-1009636590-750x476.jpg', 1, 2, 3, '2022-02-12 21:48:41', NULL),
(51, 'Osasuna slavila, Rajo do??iveo tre??i poraz u nizu', '<p><strong>Fudbaleri Osasune slavili su sa 3:0 na gostovanju Rajo Valjekanu u 24. kolu &scaron;panske Primere.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Oba tima su imala dvocifren broj udaraca ka golu rivala, ali su poga??ali samo gosti.</p>\r\n\r\n<p>Povela je Osasuna ve?? u osmom minutu. Posle asistencije Avile, u strelce se upisao Monkajola.</p>\r\n\r\n<p>Ante Budimir imao veliku &scaron;ansu u 33. minutu, ali je lopta oti&scaron;la iznad pre??ke.</p>\r\n\r\n<p>Prednost gostiju vrlo brzo je duplirao Ruben Garsija, fantasti??nim golom u 40. minutu.</p>\r\n\r\n<p>U drugom delu utakmice su oba tima imala izgledne prilike, pretili su i doma??i, ali nisu uspeli da savladaju Ereru.</p>\r\n\r\n<p>U tre??em minutu sudijske nadoknade Kike Garsija je postavio kona??ni rezultat.</p>\r\n\r\n<p>Osasuna je zabele??ila osmu pobedu u sezoni i sa 32 boda je na devetom mestu na tabeli. Rajo Valjekano je pora??en tre??i put zaredom, 10. u sezoni, te se sa 31 bodom nalazi na 11. mestu.</p>\r\n', '1644699018_1634495182-GettyImages-1347094535-750x499.jpg', 1, 2, 3, '2022-02-12 21:50:18', NULL),
(52, 'Pep: Sterling je sjajan kad ne misli mnogo', '<p><strong>Menad??er Man??ester Sitija Pep Gvardiola zadovoljan je na??inom na koji je njegov tim do&scaron;ao do trijumfa protiv Nori??a, a na poseban na??in je pohvalio strelca het-trika Rahima Sterlinga.</strong></p>\r\n\r\n<p>Gra??ani su sa 4:0 slavili na Kerou roudu u 25. kolu Premijer lige.</p>\r\n\r\n<p>&bdquo;Pobeda je va??na, ali je veoma bitno i na koji na??in smo igrali. Na&scaron;e pona&scaron;anje na terenu je bio odli??no, koncentracija na visokom nivou. Sa strane mo??da deluje da je lagano, ali je zapravo veoma te&scaron;ko raditi ono &scaron;to mi radimo&ldquo;, rekao je Pep.</p>\r\n\r\n<p>Me?? je obele??io Rahim Sterling, koji je postigao tri gola.</p>\r\n\r\n<p>&bdquo;Veoma zna??ajno na polju samopouzdanja. Prvi gol je bio fantasti??an. Rahim je uvek sjajan kada re&scaron;ava situacije bez mnogo razmi&scaron;ljanja&ldquo;, zaklju??io je Gvardiola.</p>\r\n\r\n<p>&Scaron;ampion Engleske lider je Premijer lige sa 63 boda, 12 vi&scaron;e od Liverpula uz dve utakmice vi&scaron;e.</p>\r\n', '1644699207_1644698241-22043705723976-750x504.jpg', 1, 1, 3, '2022-02-12 21:53:28', NULL),
(53, 'Het-trik Sterlinga za ubedljiv trijumf Sitija', '<p><strong>Fudbaleri ??elsija pobedili su Nori?? na strani sa 4:0 u 25. kolu Premijer lige, uz het-trik Rahima Sterlinga.</strong></p>\r\n\r\n<p>&Scaron;ampion Engleske na dominantan na??in je savladao Kanarince za beg na +12 drugoplasiranom Liverpulu, koji ima i dve utakmice manje.</p>\r\n\r\n<p>Rahim Sterling je goleadu otvorio u 31. minutu fantasti??nim udarcem sa ivice &scaron;esnaesterca. Ostao je taj rezultat aktuelan do 48. kada je Fil Foden udvostru??io prednost, da bi Sterling novim pogotkom u 70. otklonio sve dileme.</p>\r\n\r\n<p>Engleski napada?? je ta??ku na odli??nu partiju stavio je u 90. Preuzeo je odgovornost iz penala, udarac mu je odbranio Angus Gan, ali je zatim Sterling vratio loptu u nebranjenu mre??u.</p>\r\n\r\n<p>U me??uvremenu, Nori?? je uspeo da stvori nekoliko prilika. Najbolju je imao Grant Hanli, koji je u prvom poluvremenu pogodio stativu.</p>\r\n\r\n<p>Ekipa Pepa Gvardiole 15. februara gostuje Sportingu u prvom me??u osmine finala Lige &scaron;ampiona. ??etiri dana kasnije do??ekuje Totenhem u 26. rundi Premijer lige.</p>\r\n\r\n<p>Sastav Dina Smita putuje na Enfild Liverpulu u slede??em kolu.</p>\r\n', '1644699280_1644693825-22043687515315-750x520.jpg', 1, 1, 3, '2022-02-12 21:54:40', NULL),
(54, 'Lampard: Ponosan sam, sada moramo da nastavimo da radimo', '<p><strong>Menad??er Evertona Frenk Lampard nije krio zadovoljstvo posle pobede nad Lidsom u subotu.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Everton je savladao Lids sa ubedljivih 3:0. Lampard je zabele??io prvi premijerliga&scaron;ki trijumf na klupi Karamela.</p>\r\n\r\n<p>&bdquo;Bilo je lepo, neverovatno popodne. Uradili smo ne&scaron;to posebno. Pokazali smo stav, bili smo agresivni&ldquo;, rekao je Lampard.</p>\r\n\r\n<p>&bdquo;Vidim talenat, momci su sposobni. Stvar je u tome da budemo jaka zajednica i da se borimo za navija??e. Treba da iskoristimo ovo kao osnovu za ono &scaron;to ??elimo&ldquo;.</p>\r\n\r\n<p>Everton je prekinuo niz od ??etiri uzastopna poraza u prvenstvu.</p>\r\n\r\n<p>&bdquo;Olak&scaron;anje je &scaron;to smo osvojili tri boda, tabela ve?? izgleda bolje. Ponosan sam na partiju koju smo pru??ili. Ovakvo prvo poluvreme nisam dugo video. Sre??an sam zbog toga. Sada moramo da nastavimo da radimo&ldquo;.</p>\r\n\r\n<p>Novi menad??er ima veliku podr&scaron;ku navija??a Karamela.</p>\r\n\r\n<p>&bdquo;Dobio sam veliku podr&scaron;ku kada sam do&scaron;ao u klub. Sre??an sam &scaron;to imam takvu podr&scaron;ku navija??a. Ovde sam dve nedelje. Navija??i strasno vole ovaj klub. Ovo je njihov ??ivot. Mnogo toga mo??emo da uradimo ovde&ldquo;, zaklju??io je Lampard.</p>\r\n', '1644700984_lampard.jpg', 1, 1, 3, '2022-02-12 22:14:17', '2022-02-12 22:23:04'),
(55, 'Jo?? jedan poraz Paunovi??a i slavlje Mitrovi??a', '<p><strong>U subotu je odigrano deset utakmica 32. kola ??empion&scaron;ipa.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Ekipa Redinga je nastavila sa lo&scaron;im partijama u prvenstvu jer je u 32. kolu do??ivela sedmi poraz u nizu.</p>\r\n\r\n<p>Doma??i su poveli u 23. minutu, nakon odli??nog centar&scaron;uta D??uniora Hojleta, gol je postigao Lukas ??oao.</p>\r\n\r\n<p>Tim Veljka Paunovi??a, nije uspeo da zadr??i prednost jer je Gustavo Hamer uspeo da donese izjedna??enje ekipi Koventrija. Iako je pola tima Redinga bilo u &scaron;esnaestercu, lopta je zavr&scaron;ila u mre??i, koju je dotakao kapiten Hajam.</p>\r\n\r\n<p>Gosti, koji su bili najprijatnije iznan??enje na po??etku sezone, drugo poluvreme su zapo??eli u istom stilu. &Scaron;toper, Majkl Rouz je doneo preokret u 48. minutu. Popularni &bdquo;rojalsi&ldquo; izjedna??ili su u 59. Ponovo je odli??no centrirao Hojlet, a prvi gol u prvenstvu postigao je reprezentativac Gane i desni bek Endi Jiadom.</p>\r\n\r\n<p>Va??an momenat dogodio se u 63. minutu kada je Hojlet dobio drugi ??uti, odnosno crveni karton. Koventri je to iskoristio samo dva minuta kasnije, kada je 19-godi&scaron;nji pozajmljeni igra?? ??elsija Matsen, lobovao Hajna.</p>\r\n\r\n<p>Reding je i dalje tik iznad opasne zone, ali je pitanje koliko ??e jo&scaron; Veljko Paunovi?? ostati na klupi &bdquo;rojalsa&ldquo;, koji su poslednji put pobedili u ligi krajem novembra.</p>\r\n\r\n<p>S druge strane Fulam je predvo??en Aleksandrom Mitrovi??em slavio na gostovanju Halu minimalnim rezultatom. Srpski napada?? je odlu??uju??i gol postigao u 57. minutu me??a i stigao do svog 31. gola u ??empion&scaron;ipu ove sezone ??ime je izjedna??io rekord Ivana Tonija od pro&scaron;le sezone.</p>\r\n', '1644700547_1644355434-GettyImages-1369408713-750x457.jpg', 1, 1, 3, '2022-02-12 22:15:47', NULL),
(56, 'Lampard se upisao, krizi Votforda nema kraja', '<p><strong>Fudbaleri Evertona pobedili su Lids kod ku??e sa 3:0 u 25. kolu Premijer lige. Trijumf je upisao i Brajton na gostovanju Votfordu (2:0), dok je me?? Brentforda i Kristal Palasa okon??an bez golova.</strong></p>\r\n\r\n<p>Frenk Lampard je zabele??io prvi premijerliga&scaron;ki trijumf na klupi Karamela, kojim je prekinut niz od ??etiri uzastopna poraza.</p>\r\n\r\n<p>&Scaron;ejmus Kolmen je doveo doma??ina do prednosti u 10. minutu po&scaron;to se dobro sna&scaron;ao kod stative. Majkl Kin je u 23. povisio rezultat i najavio slavlje, da bi kona??na potvrda stigla u 78. kad je Ri??arlison preciznim udarcem sa distance stavio ta??ku.</p>\r\n\r\n<p>Lids je tek na momente pretio Evertonu, a me?? je okon??ao bez udarca u okvir gola.</p>\r\n\r\n<p>Brajton je na rutinski na??in savladao Votford na gostovanju &ndash; 2:0.</p>\r\n\r\n<p>Nil Mopej je doveo Galebove do vo??stva u 44. minutu, a Adam Vebster postavio kona??an rezultat u 82.</p>\r\n\r\n<p>Sastav Grejema Potera je do&scaron;ao do pobede posle tri uzastopna remija u ligi. Votford nastavlja sa katastrofalnim rezultatima i pod Rojem Hod??sonom. U poslednjih 11 me??eva osvojio je samo dva boda i nezadr??ivo srlja ka povratku u ??empion&scaron;ip.</p>\r\n\r\n<p>Okr&scaron;aj Brentforda i Kristal Palasa nije doneo golove. Skromnu predstavu pru??ili su P??ele i Orlovi sa tek po jednom prilikom na obe strane.</p>\r\n\r\n<p>&nbsp;</p>\r\n', '1644700823_1644684493-1009774099-750x438.jpg', 1, 1, 3, '2022-02-12 22:20:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_tag`
--

CREATE TABLE `post_tag` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post_tag`
--

INSERT INTO `post_tag` (`post_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 3),
(2, 4),
(2, 5),
(3, 6),
(3, 7),
(4, 2),
(4, 31),
(5, 2),
(5, 3),
(5, 8),
(5, 9),
(5, 10),
(6, 12),
(6, 13),
(6, 15),
(6, 17),
(7, 12),
(7, 13),
(7, 14),
(7, 18),
(8, 12),
(8, 19),
(8, 20),
(8, 21),
(8, 22),
(8, 23),
(9, 12),
(9, 27),
(9, 29),
(9, 30),
(10, 11),
(10, 12),
(10, 14),
(10, 24),
(10, 25),
(10, 26),
(10, 27),
(10, 28),
(11, 11),
(11, 12),
(11, 14),
(11, 19),
(11, 20),
(11, 24),
(12, 32),
(12, 33),
(12, 34),
(12, 35),
(13, 38),
(13, 39),
(13, 40),
(13, 44),
(14, 41),
(14, 42),
(14, 43),
(15, 44),
(15, 45),
(16, 33),
(16, 34),
(16, 35),
(17, 34),
(17, 35),
(17, 36),
(18, 70),
(18, 71),
(18, 72),
(19, 66),
(19, 67),
(19, 68),
(19, 69),
(20, 64),
(20, 65),
(21, 63),
(21, 64),
(22, 54),
(22, 55),
(22, 56),
(23, 57),
(23, 58),
(23, 59),
(23, 60),
(23, 61),
(23, 62),
(24, 49),
(24, 50),
(24, 51),
(24, 52),
(24, 53),
(25, 46),
(25, 47),
(25, 48),
(26, 76),
(26, 80),
(26, 83),
(26, 93),
(26, 94),
(26, 95),
(26, 96),
(26, 97),
(26, 98),
(26, 99),
(26, 100),
(26, 102),
(26, 103),
(26, 104),
(26, 105),
(26, 106),
(27, 87),
(27, 88),
(27, 89),
(27, 90),
(27, 91),
(27, 92),
(28, 83),
(28, 84),
(28, 85),
(28, 86),
(29, 105),
(29, 123),
(29, 124),
(30, 75),
(30, 76),
(30, 77),
(30, 78),
(30, 79),
(30, 80),
(30, 81),
(30, 82),
(31, 107),
(31, 108),
(32, 109),
(32, 110),
(32, 125),
(33, 107),
(33, 113),
(33, 115),
(33, 117),
(33, 118),
(33, 120),
(33, 121),
(33, 122),
(34, 107),
(34, 112),
(34, 113),
(34, 114),
(34, 115),
(34, 116),
(34, 117),
(34, 118),
(34, 119),
(34, 126),
(35, 109),
(35, 111),
(36, 127),
(36, 128),
(37, 129),
(37, 130),
(37, 131),
(37, 132),
(38, 133),
(38, 134),
(38, 135),
(39, 135),
(39, 136),
(39, 137),
(39, 138),
(40, 135),
(40, 139),
(41, 140),
(41, 141),
(41, 142),
(41, 143),
(42, 144),
(42, 145),
(42, 146),
(43, 147),
(43, 148),
(43, 149),
(44, 150),
(44, 151),
(45, 152),
(45, 153),
(46, 150),
(46, 154),
(47, 155),
(47, 156),
(48, 150),
(48, 157),
(49, 158),
(49, 159),
(49, 160),
(50, 161),
(50, 162),
(50, 163),
(51, 164),
(51, 165),
(52, 166),
(52, 167),
(52, 168),
(53, 166),
(53, 168),
(53, 169),
(54, 170),
(54, 171),
(54, 172),
(55, 173),
(55, 174),
(55, 175),
(56, 170),
(56, 176),
(56, 177),
(56, 178),
(56, 179),
(56, 180);

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `likes` tinyint(1) NOT NULL,
  `disslikes` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`comment_id`, `user_id`, `likes`, `disslikes`) VALUES
(1, 8, 1, 0),
(1, 9, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Journalist'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'FORTUNA', '2022-02-11 08:39:52', NULL),
(2, 'LEC', '2022-02-11 08:40:04', NULL),
(3, 'LOL', '2022-02-11 08:40:13', NULL),
(4, 'NOVI HEROJ', '2022-02-11 08:40:22', NULL),
(5, 'RENATA', '2022-02-11 08:40:36', NULL),
(6, 'T1', '2022-02-11 08:40:43', NULL),
(7, 'LCK', '2022-02-11 08:40:51', NULL),
(8, 'ADVIENNE', '2022-02-11 08:41:58', '2022-02-11 10:13:19'),
(9, 'EXCEL', '2022-02-11 08:42:06', NULL),
(10, 'MIKYX', '2022-02-11 08:42:19', NULL),
(11, 'VITALITY', '2022-02-11 08:42:34', NULL),
(12, 'CS GO', '2022-02-11 08:42:44', NULL),
(13, 'G2 ESPORTS', '2022-02-11 08:42:56', NULL),
(14, 'G2', '2022-02-11 08:43:05', NULL),
(15, 'HUNTER', '2022-02-11 08:43:13', NULL),
(16, 'NIKO', '2022-02-11 08:43:22', NULL),
(17, 'NEMANJA KOVAC', '2022-02-11 08:44:02', NULL),
(18, 'NIKOLA KOVAC', '2022-02-11 08:44:10', NULL),
(19, 'BLAST', '2022-02-11 08:44:18', NULL),
(20, 'NATUS VINCERE', '2022-02-11 08:44:29', NULL),
(21, 'NEXA', '2022-02-11 08:44:40', NULL),
(22, 'OG', '2022-02-11 08:44:45', NULL),
(23, 'S1MPLE', '2022-02-11 08:44:52', NULL),
(24, 'FAZE', '2022-02-11 08:45:02', NULL),
(25, 'ASTRALIS', '2022-02-11 08:45:08', NULL),
(26, 'GAMBIT', '2022-02-11 08:45:15', NULL),
(27, 'IEM KATOWICE 2022', '2022-02-11 08:50:18', NULL),
(28, 'NA VI', '2022-02-11 08:50:59', NULL),
(29, 'FAZE CLAN', '2022-02-11 08:51:28', NULL),
(30, 'ROPZ', '2022-02-11 08:51:46', NULL),
(31, 'MAD LIONS', '2022-02-11 10:10:27', NULL),
(32, 'RALLYE MONTE CARLO', '2022-02-11 10:32:14', NULL),
(33, 'SEBASTIAN LOEB', '2022-02-11 10:32:24', NULL),
(34, 'SEBASTIAN OGIER', '2022-02-11 10:32:35', NULL),
(35, 'WRC', '2022-02-11 10:32:43', NULL),
(36, 'JULIEN INGRASSIA', '2022-02-11 10:33:35', NULL),
(37, 'FORMULA', '2022-02-11 10:34:02', NULL),
(38, 'ASTON MARTIN', '2022-02-11 10:34:13', NULL),
(39, 'SEBASTIAN VETTEL', '2022-02-11 10:34:26', NULL),
(40, 'LANCE STROLL', '2022-02-11 10:34:35', NULL),
(41, 'MCLAREN', '2022-02-11 10:34:44', NULL),
(42, 'LANDO NORRIS', '2022-02-11 10:34:57', NULL),
(43, 'ANDREAS SEIDL', '2022-02-11 10:35:29', NULL),
(44, 'FORMULA 1', '2022-02-11 10:35:41', NULL),
(45, 'LEWIS HAMILTON', '2022-02-11 10:35:57', NULL),
(46, 'ATP BUENOS AIRES', '2022-02-11 10:49:28', NULL),
(47, 'MIOMIR KECMANOVIC', '2022-02-11 10:50:49', NULL),
(48, 'FRANCISCO CERNDUOLO', '2022-02-11 10:51:22', NULL),
(49, 'ANDREY RUBLEV', '2022-02-11 11:07:55', NULL),
(50, 'ANDY MURRAY', '2022-02-11 11:08:09', NULL),
(51, 'ATP ROTERDAM', '2022-02-11 11:08:31', NULL),
(52, 'FELIX AUGER-ALISSIME', '2022-02-11 11:13:17', NULL),
(53, 'STEFANOS TSITSIPAS', '2022-02-11 11:15:40', NULL),
(54, 'ATP TOUR', '2022-02-11 11:16:07', NULL),
(55, 'FILIP KRAJINOVIC', '2022-02-11 11:16:16', NULL),
(56, 'MARTON FUCSOVICS', '2022-02-11 11:16:30', NULL),
(57, 'ADRIAN MANNARINO', '2022-02-11 11:17:01', NULL),
(58, 'CEDRIK-MARCEL STEBE', '2022-02-11 11:17:11', NULL),
(59, 'DIEGO SCHWARTZMAN', '2022-02-11 11:17:23', NULL),
(60, 'JAUME MUNOR', '2022-02-11 11:17:41', NULL),
(61, 'REILLY OPELKA', '2022-02-11 11:17:54', NULL),
(62, 'YOSHIHITO NISHIOKA', '2022-02-11 11:18:08', NULL),
(63, 'SIMONA HALEP', '2022-02-11 11:18:24', NULL),
(64, 'WTA TOUR', '2022-02-11 11:18:32', NULL),
(65, 'SERENA WILLIAMS', '2022-02-11 11:18:42', NULL),
(66, 'ANNET KOTAVEIT', '2022-02-11 11:19:21', NULL),
(67, 'KAJA JUVAN', '2022-02-11 11:19:29', NULL),
(68, 'MARIA SAKKARI', '2022-02-11 11:19:42', NULL),
(69, 'PETRA MARTIC', '2022-02-11 11:19:49', NULL),
(70, 'ALEKSANDRA KRUNIC', '2022-02-11 11:20:00', NULL),
(71, 'NINA STOJANOVIC', '2022-02-11 11:20:20', NULL),
(72, 'OLGA DANILOVIC', '2022-02-11 11:20:31', NULL),
(73, 'DJORDJE TOPALOVIC', '2022-02-11 11:30:00', NULL),
(74, 'KK ROGASKA', '2022-02-11 11:51:11', NULL),
(75, 'BOGDAN BOGDANOVIC', '2022-02-11 11:52:12', NULL),
(76, 'GOLDEN STATE WARRIORS', '2022-02-11 11:52:24', NULL),
(77, 'JUSUF NURKIC', '2022-02-11 11:52:38', NULL),
(78, 'LOS ANGELES LAKERS', '2022-02-11 11:52:52', NULL),
(79, 'MINNESOTA TIMBERWOLVES', '2022-02-11 11:53:08', NULL),
(80, 'PORTLAND TRAILBLAZERS', '2022-02-11 11:53:22', NULL),
(81, 'SACAMENTO KINGS', '2022-02-11 11:55:00', NULL),
(82, 'UTAH JAZZ', '2022-02-11 11:55:30', NULL),
(83, 'BROKLYN NETS', '2022-02-11 11:56:14', NULL),
(84, 'JAMES HARDEN', '2022-02-11 11:56:24', NULL),
(85, 'NBA', '2022-02-11 11:56:30', NULL),
(86, 'PHILADELPHIA 76ERS', '2022-02-11 11:56:45', NULL),
(87, 'GIANNIS ANTETOKOUNMPO', '2022-02-11 11:57:10', NULL),
(88, 'KEVIN DURENT', '2022-02-11 11:57:18', NULL),
(89, 'LEBRON JAMES', '2022-02-11 11:57:35', NULL),
(90, 'NBA ALL STAR', '2022-02-11 11:57:58', NULL),
(91, 'NIKOLA JOKIC', '2022-02-11 11:58:15', NULL),
(92, 'STEPH CURRY', '2022-02-11 11:58:27', NULL),
(93, 'DALLAS MAVERICKS', '2022-02-11 11:58:39', NULL),
(94, 'DETROIT PISTONS', '2022-02-11 11:59:49', NULL),
(95, 'HUSTON ROCKETS', '2022-02-11 12:02:25', NULL),
(96, 'KRISTPAS PORZINGIS', '2022-02-11 12:02:35', NULL),
(97, 'LOS ANGELES CLIPERS', '2022-02-11 12:02:45', NULL),
(98, 'LUKA DONCIC', '2022-02-11 12:02:55', NULL),
(99, 'MEMPHIS GRIZZLIES', '2022-02-11 12:03:06', NULL),
(100, 'MIAMI HEAT', '2022-02-11 12:03:14', NULL),
(101, 'MILWAUKEE BUCKS', '2022-02-11 12:03:24', NULL),
(102, 'NEW ORLEANS PELICANS', '2022-02-11 12:03:38', NULL),
(103, 'NEW YORK KNICKS', '2022-02-11 12:03:46', NULL),
(104, 'PHEONIX SUNS', '2022-02-11 12:03:56', NULL),
(105, 'TORONTO RAPTORS', '2022-02-11 12:04:05', NULL),
(106, 'WASHINGTON WIZARDS', '2022-02-11 12:04:20', NULL),
(107, 'EUROLEAGUE', '2022-02-11 12:05:10', NULL),
(108, 'FELIPE REYES', '2022-02-11 12:05:18', NULL),
(109, 'KK CRVENA ZVEZDA MTS', '2022-02-11 12:05:28', '2022-02-12 21:15:15'),
(110, 'BC UNICS', '2022-02-11 12:05:35', NULL),
(111, 'DEJAN RADONJIC', '2022-02-11 12:05:45', '2022-02-12 21:12:32'),
(112, 'ALBA BERLIN', '2022-02-11 12:05:53', NULL),
(113, 'AC MONACO BASKET', '2022-02-11 12:06:02', NULL),
(114, 'BC OLYMPIACOS PIREUS', '2022-02-11 12:06:14', NULL),
(115, 'BC ZALGIRIS PIREUS', '2022-02-11 12:06:25', NULL),
(116, 'BC ZENIT SANTPETESBURG', '2022-02-11 12:06:40', NULL),
(117, 'CSKA MOSCOW BC', '2022-02-11 12:06:49', NULL),
(118, 'MAKABI TEL AVIV BC', '2022-02-11 12:07:01', NULL),
(119, 'VASILIJE MICIC', '2022-02-11 12:07:11', NULL),
(120, 'BASCONIA VICTORIA GASTEIZ', '2022-02-11 12:08:17', NULL),
(121, 'EA7 EMPORIO ARMANI MILANO', '2022-02-11 12:08:30', '2022-02-11 12:08:44'),
(122, 'NIKOLA MILUTINOV', '2022-02-11 12:08:54', NULL),
(123, 'GORAN DRAGIC', '2022-02-11 18:08:39', NULL),
(124, 'SAN ANTONIO SPURS', '2022-02-11 18:08:51', NULL),
(125, 'Vladimir Perasovic', '2022-02-12 20:47:26', NULL),
(126, 'ANADOLU EFES SK', '2022-02-12 21:06:55', NULL),
(127, 'KK FMP ZELEZNIK', '2022-02-12 21:15:48', NULL),
(128, 'KK PARTIZAN NIS', '2022-02-12 21:16:04', NULL),
(129, 'KK MEGA', '2022-02-12 21:18:04', NULL),
(130, 'KK BUDUCNOST VOLI', '2022-02-12 21:18:14', NULL),
(131, 'ALEKSANDAR DZIKIC', '2022-02-12 21:18:23', NULL),
(132, 'DJ SEELEY', '2022-02-12 21:18:40', NULL),
(133, 'DANI ALVES', '2022-02-12 21:23:43', NULL),
(134, 'FC BARSELONA', '2022-02-12 21:23:54', NULL),
(135, 'UEFA EUROPA LEAGUE', '2022-02-12 21:24:17', NULL),
(136, 'Atalanta Bergamasca', '2022-02-12 21:25:54', NULL),
(137, 'JOSIP ILICIC', '2022-02-12 21:26:04', NULL),
(138, 'OLYMPIACOS FC', '2022-02-12 21:26:31', NULL),
(139, 'FK CRVENA ZVEZDA', '2022-02-12 21:28:24', NULL),
(140, 'ALEKSANDAR KOLAROV', '2022-02-12 21:29:37', NULL),
(141, 'INTER MILAN', '2022-02-12 21:30:22', NULL),
(142, 'LIVERPOOL FC', '2022-02-12 21:30:33', NULL),
(143, 'UEFA CHAMPIONS LEAGUE', '2022-02-12 21:30:50', NULL),
(144, 'DUSAN VLAHOVIC', '2022-02-12 21:33:17', NULL),
(145, 'JUVENTUS FC', '2022-02-12 21:33:25', NULL),
(146, 'ALESSANDRO DEL PIERO', '2022-02-12 21:33:45', NULL),
(147, 'ATLETICO MADRID', '2022-02-12 21:34:38', NULL),
(148, 'HNK HAJDUK SPLIT', '2022-02-12 21:34:47', NULL),
(149, 'UEFA YOUTH LEAGUE', '2022-02-12 21:35:02', NULL),
(150, 'BAYERN MUNICH', '2022-02-12 21:36:30', NULL),
(151, 'ROBERT LEVANDOWSKI', '2022-02-12 21:36:50', NULL),
(152, 'UEFA', '2022-02-12 21:37:52', NULL),
(153, 'ALEKSANDER CEFERIN', '2022-02-12 21:38:21', NULL),
(154, 'VFL BOCHUM', '2022-02-12 21:39:07', NULL),
(155, 'BAYER LEVERKUSEN', '2022-02-12 21:40:23', NULL),
(156, 'VFB STUTTGART', '2022-02-12 21:40:46', NULL),
(157, 'JULEAN NAGELSMANN', '2022-02-12 21:42:41', NULL),
(158, 'CADIZ FC', '2022-02-12 21:45:27', NULL),
(159, 'CELTA DA VIGO', '2022-02-12 21:45:40', NULL),
(160, 'PRIMERA DIVISION', '2022-02-12 21:45:51', NULL),
(161, 'LUKA JOVIC', '2022-02-12 21:47:56', NULL),
(162, 'REAL MADRID FC', '2022-02-12 21:48:08', NULL),
(163, 'VILLAREAL FC', '2022-02-12 21:48:19', NULL),
(164, 'CA OSASUNA', '2022-02-12 21:49:35', NULL),
(165, 'RAYO VALLACANO', '2022-02-12 21:49:51', NULL),
(166, 'MANCHESTER CITY', '2022-02-12 21:51:01', '2022-02-12 21:51:05'),
(167, 'PEP GUARDIOLA', '2022-02-12 21:51:20', NULL),
(168, 'RAHEEM STERLING', '2022-02-12 21:51:27', NULL),
(169, 'NORWICH CITY FC', '2022-02-12 21:54:26', NULL),
(170, 'EVERTON FC', '2022-02-12 22:13:08', NULL),
(171, 'PREMIER LEAGUE', '2022-02-12 22:13:26', NULL),
(172, 'FRANK LAMPARD', '2022-02-12 22:13:54', '2022-02-12 22:14:05'),
(173, 'CHAMPIONSHIP', '2022-02-12 22:14:43', NULL),
(174, 'FULHAM FC', '2022-02-12 22:14:55', NULL),
(175, 'READING FC', '2022-02-12 22:15:03', NULL),
(176, 'BRENTFORD FC', '2022-02-12 22:16:11', NULL),
(177, 'CRYSTAL PALACE', '2022-02-12 22:16:26', NULL),
(178, 'LEEDS UNITED FC', '2022-02-12 22:16:44', NULL),
(179, 'WATFORD FC', '2022-02-12 22:16:58', NULL),
(180, 'BRIGHTON  & HOVE ALBION FC', '2022-02-12 22:17:46', NULL),
(181, 'Dusan Tadi??', '2022-02-21 02:00:43', NULL),
(182, 'Nemanja Mati??', '2022-02-21 02:00:52', '2022-02-21 02:01:12');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `description`, `created_at`, `user_id`) VALUES
(0, '<p>Kreirati detaljnu analizu za sledece kolo najevcih takmicenja u fudbalu!</p>\n', '0000-00-00 00:00:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`, `updated_at`, `role_id`, `category_id`) VALUES
(1, 'Petar', 'Sandi??', 'petarsandic17@gmail.com', '773d5ed2b68e3f4126def1d9060b221c', '2022-02-05 23:49:30', NULL, 1, NULL),
(3, 'Milojko', 'Panti??', 'milojkopantic56@gmail.com', '680af29922a749860637249bb6dcc638', '2022-02-05 23:52:24', NULL, 2, 1),
(4, 'Jasna', '??trbac', 'jasnastrbac11@gmail.com', '376a650cf9d8ac48b5da8990dedd2e37', '2022-02-05 23:56:33', NULL, 2, 2),
(5, 'Janko', 'Veselinovi??', 'jankoveselinovic@gmail.com', 'b74aca8b1126104dbb57c148563fb0c1', '2022-02-05 23:57:24', NULL, 2, 3),
(6, 'Pavle', 'Vujisi??', 'pavlevujisi??01@gmail.com', 'edf598696bfd7f557245c16cd0f2da2f', '2022-02-06 00:02:51', NULL, 2, 5),
(7, 'Petar', 'Sin??eli??', 'petarsindjelic23@gmail.com', '7f14a0170c56b64dc88818fb54739c4b', '2022-02-06 00:03:30', NULL, 2, 4),
(8, 'Sre??ko', 'Petrovi??', 'petrovicsrecko15@gmail.com', '56986103a1b76da00838c7f3c6777105', '2022-02-17 23:52:07', '2022-02-21 02:14:42', 3, NULL),
(9, 'Sima', 'Jovi??i??', 'mihailojovicic62@yahoo.com', '1fe496bde5256ccb5d864a9a13b7fca0', '2022-02-20 17:34:24', '2022-02-23 14:11:50', 3, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `id_post` (`id_post`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `headings`
--
ALTER TABLE `headings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `heading_tag`
--
ALTER TABLE `heading_tag`
  ADD KEY `heading_id` (`heading_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `heading_id` (`heading_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD KEY `post_id` (`post_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD UNIQUE KEY `id_3` (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_4` (`id`),
  ADD KEY `id_5` (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `description` (`description`) USING HASH,
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `headings`
--
ALTER TABLE `headings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`);

--
-- Constraints for table `headings`
--
ALTER TABLE `headings`
  ADD CONSTRAINT `headings_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `heading_tag`
--
ALTER TABLE `heading_tag`
  ADD CONSTRAINT `heading_tag_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`),
  ADD CONSTRAINT `heading_tag_ibfk_2` FOREIGN KEY (`heading_id`) REFERENCES `headings` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`heading_id`) REFERENCES `headings` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`),
  ADD CONSTRAINT `post_tag_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `reactions`
--
ALTER TABLE `reactions`
  ADD CONSTRAINT `reactions_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `reactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
