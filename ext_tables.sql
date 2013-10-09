#
# Table structure for table 'tx_thrating_domain_model_ratingobject'
#
CREATE TABLE tx_thrating_domain_model_ratingobject (
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
	INDEX objcheck (ratetable)
);


#
# Table structure for table 'tx_thrating_domain_model_config'
#
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
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),
	INDEX configcheck (ratingobject,steporder)
);


#
# Table structure for table 'tx_thrating_domain_model_rating'
#
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
	INDEX ratingcheck (ratingobject,ratedobjectuid)
);

#
# Table structure for table 'tx_thrating_domain_model_vote'
#
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
	INDEX votecheck (rating,voter)
);
