-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 01, 2015 at 09:18 PM
-- Server version: 5.6.24-0ubuntu2
-- PHP Version: 5.6.4-4ubuntu6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `easylaughs`
--

-- --------------------------------------------------------

--
-- Table structure for table `actors`
--

CREATE TABLE IF NOT EXISTS `actors` (
`id` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `description` mediumtext NOT NULL,
  `mugshot` varchar(30) NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `actors`
--

INSERT INTO `actors` (`id`, `first_name`, `last_name`, `description`, `mugshot`, `display`) VALUES
(3, 'Jim', 'Buddin', 'Hes amaxing', 'img/jimbuddin.jpg', 1),
(4, 'Ben', 'Silburn', 'Ben started writing and performing comedy while at University. Spurred on by the overwhelming positive reaction from the audience (ie small groups of his friends) he felt compelled to push it further. He joined the Cambridge Footlights and went on to perform in numerous comedy shows with partners Will Ing and Dan Gaster - including five years at the Edinburgh Fringe Festival. He writes and presents for BBC Radio and Television (BBC World''s &quot;Fast Track&quot;), which would be great except he lives in Amsterdam. Ben spends a lot of his time on planes. ', 'img/bensilburn.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
`id` int(11) NOT NULL,
  `course_title` varchar(30) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `show_date` date NOT NULL,
  `weeks` int(11) NOT NULL,
  `course_location` int(11) NOT NULL,
  `course_description` varchar(500) NOT NULL,
  `course_time` varchar(10) NOT NULL,
  `price` decimal(22,2) NOT NULL,
  `max_places` int(2) NOT NULL,
  `teacher1` int(4) NOT NULL,
  `teacher2` int(4) DEFAULT NULL,
  `display` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `formats`
--

CREATE TABLE IF NOT EXISTS `formats` (
`id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `short_desc` varchar(500) NOT NULL,
  `icon` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `formats`
--

INSERT INTO `formats` (`id`, `title`, `short_desc`, `icon`) VALUES
(1, 'Impro Flow', 'Its show with flow. A great philosopher once said, &quot;Get into the groove, cos you''ve got to prove your love to me&quot; and we think that behind the literal meaning lies a metaphor; go and see the easylaughs Impro Flow show.', 'img/improflow.jpg'),
(2, 'Superscene', ' Its Amsterdam''s answer to the Cannes Film festival, and its your last chance this season to catch Superscene! Five international directors will present scenes from their newest movies. You get to decide which Director makes it through each round, until eventually, finally, ultimately we get to see the Superscene. ', 'img/superscene.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `add_1` varchar(30) NOT NULL,
  `add_2` varchar(30) NOT NULL,
  `postcode` varchar(12) NOT NULL,
  `map` varchar(750) NOT NULL,
  `special_info` varchar(250) DEFAULT NULL,
  `access_public_transport` varchar(500) DEFAULT NULL,
  `access_car` varchar(500) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `add_1`, `add_2`, `postcode`, `map`, `special_info`, `access_public_transport`, `access_car`) VALUES
(1, 'Crea 2.01', 'Nieuwe Achtergracht 170', '(enter via Sarphatistraat)', '', '&lt;iframe src=&quot;https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d19491.437180941044!2d4.909258!3d52.362629!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c609992789c201%3A0x968347dca0663042!2sNieuwe+Achtergracht+170%2C+University+of+Amsterdam%2C+1018+WV+Amsterdam%2C+Netherlands!5e0!3m2!1sen!2s!4v1430747528580&quot; width=&quot;600&quot; height=&quot;450&quot; frameborder=&quot;0&quot; style=&quot;border:0&quot;&gt;&lt;/iframe&gt;', '', 'From Leidseplein or the West, take the tram 7 or 10, get off at Korte ''s Gravesandestraat. Go down the little street with the lamppost (Pancrasstraat) and follow the signs.\r\n\r\nFrom Central station the easiest way is to take the Metro to Weesperplein,', 'We''d advise you to come by public transport as the CREA Cafe is in the middle of the old city centre. Parking in the area is limited. If you come by car, the best parking is around Plantage Muidergracht. Then cross the two little bridges to get to the CREA.');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`user_id`, `time`) VALUES
(1, '1430738095');

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE IF NOT EXISTS `shows` (
`id` int(11) NOT NULL,
  `date` date NOT NULL,
  `early_show` int(11) NOT NULL,
  `early_show_info` varchar(250) NOT NULL,
  `late_show` int(11) NOT NULL,
  `late_show_info` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`id`, `date`, `early_show`, `early_show_info`, `late_show`, `late_show_info`) VALUES
(1, '2015-05-08', 1, 'Stories flow into each other like tributaries and streams, sometimes they cross paths, and sometimes they remain forever parallel. This show is the same but with improv.', 2, 'And even better than that, Pathe Unlimited and Cineville card carriers get in for free, so roll out the red carpet and get your improv comedy movie buff on.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  `editor` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `salt`, `editor`) VALUES
(1, 'test_user', 'test@example.com', '00807432eae173f652f2064bdca1b61b290b52d40e429a7d295d76a71084aa96c0233b82f1feac45529e0726559645acaed6f3ae58a286b9f075916ebf66cacc', 'f9aab579fc1b41ed0c44fe4ecdbfcdb4cb99b9023abb241a6db833288f4eea3c02f76e0d35204a8695077dcf81932aa59006423976224be0390395bae152d4ef', 1),
(2, 'jimbuddin', 'jimbuddin@hotmail.com', '642d8cc7425596e6f124b7a6e36ab830bf3bd4a08588698b130bf08733fc4759c79feb068b54e5881dad495019a5c18c54d8b76b862fc020d054040184bad060', '3366473028bfe2fa20f3cc3d4e1dcb08ce8de4d2599631568735df213af117223ce04117345e537e39dfb0e19b33d00868e6e39c766768a2313feeb48903a305', 0);

-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE IF NOT EXISTS `workshops` (
`id` int(11) NOT NULL,
  `date` date NOT NULL,
  `title` varchar(30) NOT NULL,
  `actor_id` int(11) NOT NULL,
  `actor2_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workshops`
--

INSERT INTO `workshops` (`id`, `date`, `title`, `actor_id`, `actor2_id`, `location_id`) VALUES
(1, '2015-05-10', 'Get your Groove On', 3, 4, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actors`
--
ALTER TABLE `actors`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `formats`
--
ALTER TABLE `formats`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shows`
--
ALTER TABLE `shows`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workshops`
--
ALTER TABLE `workshops`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actors`
--
ALTER TABLE `actors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `formats`
--
ALTER TABLE `formats`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `shows`
--
ALTER TABLE `shows`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
