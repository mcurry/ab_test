
--
-- Table structure for table `ab_tests`
--

CREATE TABLE IF NOT EXISTS `ab_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
);

-- --------------------------------------------------------

--
-- Table structure for table `ab_test_variates`
--

CREATE TABLE IF NOT EXISTS `ab_test_variates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ab_test_id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `views` int(11) NOT NULL,
  `conversions` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ab_test_id_key` (`ab_test_id`,`key`)
);