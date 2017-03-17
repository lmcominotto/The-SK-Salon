--
-- Database: `sk salon`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminportal`
--

CREATE TABLE `adminportal` (
  `Stylists` text NOT NULL,
  `AboutUs` text NOT NULL,
  `Services` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `siteuser`
--

CREATE TABLE `siteuser` (
  `id` int(11) NOT NULL,
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `userID` varchar(128) NOT NULL,
  `password` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siteuser`
--

INSERT INTO `siteuser` (`id`, `firstName`, `lastName`, `userID`, `password`) VALUES
(1, 'Sandee', 'Kranz', 'skadmin', 'salon'),
(2, 'a', 'a', 'a', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `stylists`
--

CREATE TABLE `stylists` (
  `ID` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Text` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stylists`
--

INSERT INTO `stylists` (`ID`, `Title`, `Text`, `image`) VALUES
(1, 'Sandee Kranz', 'Sandee Kranz, owner of The SK Salon, has been working as a hair stylist for ___ years. A graduate of Paul Mitchell The School Huntsville, Sandee worked at Bangs Salon, The Stile Salon as Master Stylist, and now as an independent stylist for The SK Salon located in Athens, AL.', 'img/skranz.jpg'),
(2, 'Lorem Ipsem', 'This is more text', 'img/carousel2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `siteuser`
--
ALTER TABLE `siteuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stylists`
--
ALTER TABLE `stylists`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `siteuser`
--
ALTER TABLE `siteuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `stylists`
--
ALTER TABLE `stylists`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
