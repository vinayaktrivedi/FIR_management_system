
--
-- Create schema fir
--

DROP TABLE IF EXISTS `fir_details`;
CREATE TABLE `fir_details` (
  'F_id' INTEGER  PRIMARY KEY NOT NULL,
  `date` datetime NOT NULL,
  `time` datetime NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `crime_id` int(10)  NOT NULL,
  `id_proof_type` varchar(45) NOT NULL,
  `id_proof_no` int(10)  NOT NULL,
  `crimelocation` varchar(45) NOT NULL,
  `reg_id` int(10)  NOT NULL,
  `criminal_id` int(10)  NOT NULL,
  `victim_id` int(10)  NOT NULL,
  `dt_time` datetime DEFAULT NULL,
  `area_id` int(10)  DEFAULT NULL,
  FOREIGN KEY (`crime_id`) REFERENCES `crimetype` (`crime_id`),
  FOREIGN KEY (`reg_id`) REFERENCES `profile` (`id`),
  FOREIGN KEY (`criminal_id`) REFERENCES `profile` (`id`),
  FOREIGN KEY (`victim_id`) REFERENCES `profile` (`id`),
  FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`)
);

DROP TABLE IF EXISTS `area`;
CREATE TABLE `area` (
  `area_id` INTEGER  PRIMARY KEY  NOT NULL,
  `area_name` varchar(45) NOT NULL,
  `pincode` int(10)  NOT NULL,
  `city_id` int(10)  NOT NULL,
  FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`)
);

DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `city_id` INTEGER  PRIMARY KEY NOT NULL,
  `city_name` varchar(45) NOT NULL
  
);


DROP TABLE IF EXISTS `crimetype`;
CREATE TABLE `crimetype` (
  `crime_id` INTEGER  PRIMARY KEY  NOT NULL,
  `crime_type` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL
  
);

DROP TABLE IF EXISTS `designation`;
CREATE TABLE `designation` (
  `desi_id` INTEGER  PRIMARY KEY  NOT NULL,
  `desi_name` varchar(45) NOT NULL
) ;


DROP TABLE IF EXISTS `missingcitizens`;
CREATE TABLE `missingcitizens` (
  `missing_id` INTEGER  PRIMARY KEY  NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `middle_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `gander` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `city_id` int(10)  NOT NULL,
  `area_id` int(10)  NOT NULL,
  `special_clue` varchar(45) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`),
  FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`)
);

DROP TABLE IF EXISTS `officer`;
CREATE TABLE `officer` (
  `username` varchar(45) NOT NULL,
  `Jdate` datetime NOT NULL,
  `desi_id` int(10)  NOT NULL,
  `poilcestation_id` int(10)  NOT NULL,
  FOREIGN KEY (`desi_id`) REFERENCES `designation` (`desi_id`),
  FOREIGN KEY (`poilcestation_id`) REFERENCES `policestation` (`poilcestation_id`) ON DELETE CASCADE ON UPDATE CASCADE
);


DROP TABLE IF EXISTS `policestation`;
CREATE TABLE `policestation` (
  `poilcestation_id` INTEGER PRIMARY KEY  NOT NULL,
  `area_id` int(10)  NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_no` int(10)  NOT NULL,
  `Email_id` varchar(255) NOT NULL,
  `contact_person` varchar(45) NOT NULL,
  `starting_date` datetime NOT NULL,
  `policestation_name` varchar(45) NOT NULL,
  `city_id` int(10)  NOT NULL,
  FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`),
  FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`)
);

DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `first_name` varchar(45) NOT NULL,
  `middle_name` varchar(15) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `gender` varchar(45) NOT NULL,
  `Dob` datetime DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `emailid` varchar(255) NOT NULL,
  `username` varchar(45) NOT NULL,
  `city_id` int(10)  NOT NULL,
  `id` INTEGER PRIMARY KEY   NOT NULL,
  `pincode` int(10)  NOT NULL,
  `area_id` int(10)  DEFAULT NULL,
  FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`),
  FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`)
);

 PRAGMA foreign_keys = ON;


 INSERT INTO `city` (`city_name`) VALUES 
 ('Ahmedabad'),
 ('Baroda'),
 ('Surat'),
 ('Gandhinagar'),
 ('Surendranagar');

INSERT INTO `area` (`area_name`,`pincode`,`city_id`) VALUES 
 ('Vasna',380000,1),
 ('Mamnagar',380052,1),
 ('Navarangpura',380006,1),
 ('Vastrapur',380001,1),
 ('Karelibag',400001,2),
 ('Alkapuri',400002,2);


 INSERT INTO `policestation` (`area_id`,`address`,`contact_no`,`Email_id`,`contact_person`,`starting_date`,`policestation_name`,`city_id`) VALUES 
 (1,'Vasna Police Station,Nr.Telephone Ex. Office',26576156,'vasna_ps@yahoo.com','Rajeshbhai','2009-10-10 00:00:00','Vasna Police Station',1),
 (1,'Navarangpura Police Station,Nr.Post Office',26500000,'navarangpua_ps@yahoo.com','Chandreshbhai','2008-10-10 00:00:00','Navarangpura Police Station',1),
 (6,'Nr.Head Post Office,\r\nKarelibag Road,\r\nVadodara.',28585858,'karelibag_ps@yahoo.com','Abhijit Jadeja','0000-00-00 00:00:00','Karelibag Police Station',2),
 (6,'Nr.Post Office',236545,'aps@yahoo.com','Yadavbhai','2010-04-06 00:00:00','Alkapuri Police Station',1),
 (3,'Nr.Post Office',236545,'aps@yahoo.com','Yadavbhai','2010-04-06 00:00:00','Alkapuri Police Station',1);


INSERT INTO `designation` (`desi_name`) VALUES 
 ('PSI'),
 ('Head Constable'),
 ('Constable'),
 ('PI');

 INSERT INTO `crimetype` (`crime_type`,`description`) VALUES 
 ('MURDER','very denger'),
 ('THEFT','U have to be careful.');

 INSERT INTO `officer` (`username`,`Jdate`,`desi_id`,`poilcestation_id`) VALUES 
 ('param','2010-04-13 00:00:00',4,4),
 ('komal','2010-04-05 00:00:00',2,1),
 ('kinjal','2010-04-19 00:00:00',2,2),
 ('pradeep','2010-04-19 00:00:00',2,3);

INSERT INTO `profile` (`first_name`,`middle_name`,`last_name`,`gender`,`Dob`,`address`,`contact_no`,`emailid`,`username`,`city_id`,`id`,`pincode`,`area_id`) VALUES 
 ('ggg','g','ggg','Male','2010-04-20 00:00:00','ff','444444444','d@yahoo.com','ggg',1,12,444444,NULL),
 ('krishi','K','thakkar','Female','2002-05-06 00:00:00','Kareli bag','9998205920','k@gmail.com','krishi',2,13,400000,NULL),
 ('fgfgf','fff','fffffgf','Male',NULL,'gdshdh','888888888888','fg@yahoo.com','fff',1,14,464643,NULL),
 ('param','l','patel','Male',NULL,'GSEB ','5555555555','param@gmail.com','param',3,15,500000,NULL),
 ('komal','p','shah','Female',NULL,'chintamani','07926576156','koms@yahoo.com','komal',1,16,380058,NULL),
 ('kinjal','m','patel','Female',NULL,'gf','111111111111','k@gmail.com','kinjal',3,17,435555,NULL),
 ('pradeep','m','purohit','Male',NULL,'ggfdggfdg','6546687687','p@yahoo.com','pradeep',3,19,345555,NULL),
 ('sss','s','sss','Male',NULL,'ssssssxxxsssss','57657657575','s@yahoo.com','sss',2,20,400000,NULL),
 ('jjj','j','jjj','Male',NULL,'jjjj','333333333','jjj@yahoo.com','shyam',1,24,300000,NULL),
 ('hency','s','pujara','Female',NULL,'dall mil raod','9376822145','h@yahoo.com','shyam',5,40,300000,NULL),
 ('fency','f','patel','Female',NULL,'fatehnagar','9228183186','fency@yahoo.com','shyam',1,41,400000,NULL),
 ('nency','n','shah','Female',NULL,'ramnagar','9376822145','nency@gmail.com','shyam',2,42,500000,NULL),
 ('nency','n','shah','Female',NULL,'ramnagar','9376822145','nency@gmail.com','shyam',2,43,500000,NULL),
 ('Yogeshbhai','J','Joshi','Male',NULL,'Kundan Apartment ','9016625525','yogesh@gmail.com','shyam',1,44,700000,NULL),
 ('Jaiminbhai','K','Patel','Male',NULL,'Varachha Road','9016654254','jaimin@yahoo.com','shyam',3,45,800000,NULL),
 ('Bhaveshbhai','B','Prajapati','Male',NULL,'Kalupur','9016622222','bhavesh@gmail.com','shyam',1,46,900000,NULL),
 ('Bhaveshbhai','B','Prajapati','Male',NULL,'Kalupur','9016622222','bhavesh@gmail.com','shyam',1,47,900000,NULL),
 ('Rameshbhai','D','Patel','Male',NULL,'Kundan Apartment\r\nDiv-A','9909099090','ramesh@gmail.com','shyam',1,48,380380,NULL),
 ('Mahesh','K','Patel','Male',NULL,'Kundan Aprtment\r\nDiv-B','9909099091','mahesh@yahoo.com','shyam',1,49,380380,NULL),
 ('Nareshbhai','H','Patel','Male',NULL,'Kundan Apartment\r\nDiv-C','9909099092','naresh@yahoo.com','shyam',1,50,380380,NULL),
 ('Helly','h','thakkar','Female',NULL,'karelibag','9376822145','h@yahoo.com','shyam',2,51,400000,NULL),
 ('rena','m','patel','Female',NULL,'shastrinagar','9228183186','rn@yahoo.com','shyam',1,52,538987,NULL),
 ('sweta','s','tiwari','Female',NULL,'navrangpura','9998027555','s@yahoo.com','shyam',1,53,436567,NULL),
 ('sweta','s','tiwari','Female',NULL,'navrangpura','9998027555','s@yahoo.com','shyam',1,54,436567,NULL),
 ('aaa','a','aaa','Female',NULL,'paladi','9427630171','a@yahoo.com','shyam',1,55,100000,NULL);
--
INSERT INTO `fir_details` (`F_id`,`date`,`time`,`description`,`status`,`crime_id`,`id_proof_type`,`id_proof_no`,`crimelocation`,`reg_id`,`criminal_id`,`victim_id`,`dt_time`,`area_id`) VALUES 
 (1,'2010-04-25 00:00:00','2010-10-10 00:00:00','laptop','1',2,'Election Card',4294967295,'80 foot road',40,41,43,'0000-00-00 00:00:00',6),
 (2,'1995-04-05 00:00:00','2010-10-10 00:00:00','hand bag stolen','1',2,'Election Card',70707070,'Paldi',44,45,46,'0000-00-00 00:00:00',1),
 (3,'1995-04-05 00:00:00','2010-10-10 00:00:00','hand bag stolen','1',2,'Election Card',70707070,'Paldi',44,45,47,'0000-00-00 00:00:00',1),
 (4,'2010-02-02 00:00:00','2010-10-10 00:00:00','Mobile Stallen','1',2,'Election Card',380380,'At Mahalaxmi Cross Road',48,49,50,'0000-00-00 00:00:00',1),
 (5,'2010-04-01 00:00:00','2010-10-00 00:00:00','laptop','1',2,'Election Card',346875,'at ms uni road',51,52,54,NULL,6);

