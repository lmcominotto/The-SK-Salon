/*
Database table for admin and other users storing ID number (within table/database),
first name, last name, user ID (username), and password
*/

DROP TABLE IF EXISTS siteUser;
CREATE TABLE siteUser
(
	id 			int(11) NOT NULL auto_increment,
	firstName	varchar(128) NOT NULL,
	lastName	varchar(128) NOT NULL,
	userID		varchar(128) NOT NULL,
	password	varchar(1000) NOT NULL,

	PRIMARY KEY (id)	
);