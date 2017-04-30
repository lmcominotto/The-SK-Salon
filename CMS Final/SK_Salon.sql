SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--
CREATE TABLE `customers` (
  `idCustomers` int(11) NOT NULL COMMENT 'Customer ID Number, Auto Increments, NOT NULL, and Unique',
  `firstName` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Customer''s First Name',
  `lastName` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Customer''s Last Name',
  `address` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Customer''s Street Address',
  `city` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Customer''s City',
  `state` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Customer''s Two Letter State',
  `zipCode` int(5) DEFAULT NULL COMMENT 'Customer''s Five Digit Zip Code',
  `email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Customer''s E-Mail Address',
  `phoneNum` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Customer''s Phone Number'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `UPC` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Unique Product Code, NOT NULL',
  `description` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Description of the Product',
  `quantityAvail` int(11) DEFAULT NULL COMMENT 'Quantity Available On Hand',
  `cost` decimal(65,2) DEFAULT NULL COMMENT 'Cost of the Item',
  `price` decimal(65,2) DEFAULT NULL COMMENT 'Retail Selling Price of the Item'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `products_sold`
--

CREATE TABLE `products_sold` (
  `idTransactions` int(11) NOT NULL COMMENT 'Transaction ID from Transaction Table',
  `UPC` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT 'UPC from Inventory Table',
  `description` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) DEFAULT NULL COMMENT 'Quantity Sold',
  `price` decimal(65,2) DEFAULT NULL COMMENT 'Price for which the Item was sold'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products_sold`
--


--
-- Triggers `products_sold`
--
DELIMITER $$
CREATE TRIGGER `updateInv` AFTER INSERT ON `products_sold` FOR EACH ROW UPDATE inventory 
     SET quantityAvail = quantityAvail - NEW.quantity
   WHERE UPC = NEW.UPC
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `UPC` varchar(16) COLLATE utf8_unicode_ci NOT NULL COMMENT 'UPC from Inventory Table',
  `description` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Quantity Sold',
  `price` decimal(65,2) DEFAULT NULL COMMENT 'Price for which the Item was sold'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `idTransactions` int(11) NOT NULL COMMENT 'Unique Transaction Identifier, NOT NULL, Unique, Auto Increment',
  `idCustomers` int(11) DEFAULT NULL COMMENT 'ID of customer who purchased items',
  `paymentType` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Payment Type Used',
  `transTime` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and Time of The Transaction',
  `total` decimal(65,2) DEFAULT NULL COMMENT 'Total of the transaction'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`idCustomers`),
  ADD UNIQUE KEY `idCustomers_UNIQUE` (`idCustomers`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`UPC`),
  ADD UNIQUE KEY `UPC_UNIQUE` (`UPC`);

--
-- Indexes for table `products_sold`
--
ALTER TABLE `products_sold`
  ADD KEY `fk_TransItems_2_idx` (`UPC`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD KEY `fk_TransItems_2_idx` (`UPC`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`idTransactions`),
  ADD UNIQUE KEY `idTransactions_UNIQUE` (`idTransactions`),
  ADD KEY `fk_Transactions_1_idx` (`idCustomers`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `idCustomers` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Customer ID Number, Auto Increments, NOT NULL, and Unique', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `idTransactions` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique Transaction Identifier, NOT NULL, Unique, Auto Increment', AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `products_sold`
--
ALTER TABLE `products_sold`
  ADD CONSTRAINT `fk_TransItems_2` FOREIGN KEY (`UPC`) REFERENCES `inventory` (`UPC`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_Transactions_1` FOREIGN KEY (`idCustomers`) REFERENCES `customers` (`idCustomers`) ON DELETE NO ACTION ON UPDATE NO ACTION;




/*Database tables*/

/*Admin Page Users*/
CREATE TABLE siteUser
(
	id 				int(11) NOT NULL auto_increment,
	firstName		varchar(128) NOT NULL,
	lastName		varchar(128) NOT NULL,
	userID			varchar(128) NOT NULL,
	password		varchar(1000) NOT NULL,

	PRIMARY KEY (id)	
);

/*Logo for all front end webpages*/
CREATE TABLE siteLogo 
(
	ID 			int(11) NOT NULL auto_increment,
	logoImg 	varchar(255) NOT NULL,

	PRIMARY KEY (ID) 
);

/*Homepage Carousel*/
CREATE TABLE carousel 
(
	ID 				int(11) NOT NULL auto_increment, 
	carouselImg 	varchar(255) NOT NULL,
	carouselInfo	text, 

	PRIMARY KEY (ID)
);

/*Homepage Bottom Contact Info Divs*/
CREATE TABLE contactHome 
(
	ID 				int(11) NOT NULL auto_increment, 
	contactTitle 	varchar(128) NOT NULL,
	contactInfo 	text NOT NULL, 
	contactLogo 	varchar(255) NOT NULL,

	PRIMARY KEY(ID)
);


/*Homepage Main Text*/
CREATE TABLE homePage
(
	ID 				int(11) NOT NULL auto_increment,
	mainInfo 		text NOT NULL,

	PRIMARY KEY(ID)
);

/*About Page*/
CREATE TABLE aboutSK
(
	ID				int(11) NOT NULL auto_increment, 
	postTitle		varchar(128),
	postInfo		varchar(5000),

	PRIMARY KEY (ID)
);

/*Services Page*/
CREATE TABLE services
(
	ID				int(11) NOT NULL auto_increment, 
	serviceTitle	varchar(128),
	serviceInfo		varchar(5000),

	PRIMARY KEY (ID)
);

/*Stylists Page*/
CREATE TABLE stylists
(
	ID				int(11) NOT NULL auto_increment, 
	stylistTitle	varchar(128) NOT NULL,
	stylistInfo		text NOT NULL,
	stylistImg		varchar(255) NOT NULL,

	PRIMARY KEY (ID)
);

/*Products Page*/
CREATE TABLE products
(
	ID				int(11) NOT NULL auto_increment, 
	productTitle	varchar(128) NOT NULL,
	productInfo		text NOT NULL,
	productImg		varchar(255) NOT NULL,

	PRIMARY KEY (ID)
);

/*Photo Gallery*/
CREATE TABLE photoGallery 
(
	ID 				int(11) NOT NULL auto_increment,
	galleryImg 		varchar(255) NOT NULL, 
	galleryInfo 	text,

	PRIMARY KEY (ID)
);

