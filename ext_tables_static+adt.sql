#
# Table structure for table "tx_thrating_domain_model_ratingobject"
#
DROP TABLE IF EXISTS tx_thrating_domain_model_ratingobject;
CREATE TABLE `tx_thrating_domain_model_ratingobject` (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	ratetable varchar(64) DEFAULT '' NOT NULL,
	ratefield varchar(64) DEFAULT '' NOT NULL,
	stepconfs  int(11) DEFAULT '0' NOT NULL,
	ratings  int(11) DEFAULT '0' NOT NULL,
	
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	INDEX objcheck (ratetable,ratefield,pid)
);

DELETE FROM `tx_thrating_domain_model_ratingobject` WHERE uid=1;
INSERT INTO `tx_thrating_domain_model_ratingobject` VALUES (1,1,'tt_content','uid',4,0,1297109577,1297109577,0,0,0);


#
# Table structure for table "tx_thrating_domain_model_stepconf"
#
#DROP TABLE IF EXISTS tx_thrating_domain_model_stepconf;
CREATE TABLE tx_thrating_domain_model_stepconf (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	ratingobject 	int(11) DEFAULT '0' NOT NULL,
	steporder 		int(11) DEFAULT '0' NOT NULL,
	stepweight 		int(11) DEFAULT '1' NOT NULL,
	stepname  		varchar(64) DEFAULT '0' NOT NULL,
	votes  			int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	INDEX configcheck (ratingobject,steporder,pid)
);
DELETE FROM `tx_thrating_domain_model_stepconf` WHERE uid<=4;
INSERT INTO `tx_thrating_domain_model_stepconf` VALUES (1,1,1,1,1,'LLL:Schlecht',1,1297443418,1297110110,2,0,0);
INSERT INTO `tx_thrating_domain_model_stepconf` VALUES (2,1,1,2,1,'LLL:Besser',0,1297443418,1297443418,2,0,0);
INSERT INTO `tx_thrating_domain_model_stepconf` VALUES (3,1,1,3,1,'LLL:Gut',0,1297443418,1297443418,2,0,0);
INSERT INTO `tx_thrating_domain_model_stepconf` VALUES (4,1,1,4,1,'LLL:Spitze',0,1297443418,1297443418,2,0,0);

#
# Table structure for table 'tx_thrating_domain_model_rating'
#
#DROP TABLE IF EXISTS tx_thrating_domain_model_rating;
CREATE TABLE tx_thrating_domain_model_rating (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	ratingobject int(11) DEFAULT '0' NOT NULL,
	ratedobjectuid int(11) DEFAULT '0' NOT NULL,
	votes  int(11) DEFAULT '0' NOT NULL,
	currentrates  varchar(255) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	INDEX ratingcheck (ratingobject,ratedobjectuid,pid)
);
DELETE FROM `tx_thrating_domain_model_rating` WHERE uid=1;
INSERT INTO `tx_thrating_domain_model_rating` VALUES (1,1,1,1,1,'{"weightedVotes":{"1":0,"2":0,"3":1,"4":0},"sumWeightedVotes":{"1":0,"2":0,"3":3,"4":0},"numAllVotes":1}',1297443418,1297110110,0,0,0);

#
# Table structure for table 'tx_thrating_domain_model_vote'
#
#DROP TABLE IF EXISTS tx_thrating_domain_model_vote;
CREATE TABLE tx_thrating_domain_model_vote (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	rating int(11) DEFAULT '0' NOT NULL,
	voter int(11) DEFAULT '0' NOT NULL,
	vote int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	INDEX votecheck (rating,voter,pid)
);
DELETE FROM `tx_thrating_domain_model_vote` WHERE uid=1;
INSERT INTO `tx_thrating_domain_model_vote` VALUES (1,1,1,2,3,1297443418,1297110110,0,0,0);
