
-- Dump of TYPO3 Connection "Default"
-- MySQL dump 10.18  Distrib 10.3.27-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: db    Database: db
-- ------------------------------------------------------
-- Server version	10.2.34-MariaDB-1:10.2.34+maria~bionic-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `backend_layout`
--

DROP TABLE IF EXISTS `backend_layout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backend_layout` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `sorting` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t3_origuid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_oid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_id` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `t3ver_wsid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_state` smallint(6) NOT NULL DEFAULT 0,
  `t3ver_stage` int(11) NOT NULL DEFAULT 0,
  `t3ver_count` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_move_id` int(10) unsigned NOT NULL DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `config` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_layout`
--

LOCK TABLES `backend_layout` WRITE;
/*!40000 ALTER TABLE `backend_layout` DISABLE KEYS */;
/*!40000 ALTER TABLE `backend_layout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `be_groups`
--

DROP TABLE IF EXISTS `be_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `be_groups` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `non_exclude_fields` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `explicit_allowdeny` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allowed_languages` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `custom_options` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_mountpoints` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pagetypes_select` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tables_select` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tables_modify` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groupMods` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_mountpoints` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_permissions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lockToDomain` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `TSconfig` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subgroup` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workspace_perms` smallint(6) NOT NULL DEFAULT 1,
  `category_perms` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `availableWidgets` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `be_groups`
--

LOCK TABLES `be_groups` WRITE;
/*!40000 ALTER TABLE `be_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `be_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `be_sessions`
--

DROP TABLE IF EXISTS `be_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `be_sessions` (
  `ses_id` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ses_iplock` varchar(39) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ses_userid` int(10) unsigned NOT NULL DEFAULT 0,
  `ses_tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `ses_data` longblob DEFAULT NULL,
  `ses_backuserid` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ses_id`),
  KEY `ses_tstamp` (`ses_tstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `be_sessions`
--

LOCK TABLES `be_sessions` WRITE;
/*!40000 ALTER TABLE `be_sessions` DISABLE KEYS */;
INSERT INTO `be_sessions` VALUES ('951b13b43e9483165b6472a8d31c0f14','172.18.0.6',1,1617612631,'a:2:{s:26:\"formProtectionSessionToken\";s:64:\"01b244eabb6fc463b27af01a96bc3c3660b2cd06473e8bd61d13fb34056179dc\";s:27:\"core.template.flashMessages\";N;}',0),('b5d99da091af52f13a693bb3a54c1274','172.18.0.6',1,1617457915,'a:4:{s:26:\"formProtectionSessionToken\";s:64:\"6aaf4e9ea75ab3c1a30882e32f67ecf94f93a0b8b6af9c17b2592d0037b2b061\";s:27:\"core.template.flashMessages\";N;s:46:\"extbase.flashmessages.tx_belog_system_beloglog\";N;s:52:\"TYPO3\\CMS\\Recordlist\\Controller\\RecordListController\";a:1:{s:12:\"search_field\";N;}}',0),('f9b9a320a07a3d32398340d44c5cd90e','[DISABLED]',1,1617612812,'a:3:{s:26:\"formProtectionSessionToken\";s:64:\"2e591a27eba8b203f452d3da7bb18839b91f5ad060285b01eaa052fa82c01533\";s:27:\"core.template.flashMessages\";N;s:52:\"TYPO3\\CMS\\Recordlist\\Controller\\RecordListController\";a:1:{s:12:\"search_field\";s:0:\"\";}}',0);
/*!40000 ALTER TABLE `be_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `be_users`
--

DROP TABLE IF EXISTS `be_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `be_users` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `disable` smallint(5) unsigned NOT NULL DEFAULT 0,
  `starttime` int(10) unsigned NOT NULL DEFAULT 0,
  `endtime` int(10) unsigned NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `avatar` int(10) unsigned NOT NULL DEFAULT 0,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `admin` smallint(5) unsigned NOT NULL DEFAULT 0,
  `usergroup` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `lang` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `db_mountpoints` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` smallint(5) unsigned NOT NULL DEFAULT 0,
  `realName` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `userMods` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allowed_languages` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `uc` mediumblob DEFAULT NULL,
  `file_mountpoints` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_permissions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workspace_perms` smallint(6) NOT NULL DEFAULT 1,
  `lockToDomain` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `disableIPlock` smallint(5) unsigned NOT NULL DEFAULT 0,
  `TSconfig` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastlogin` int(10) unsigned NOT NULL DEFAULT 0,
  `createdByAction` int(11) NOT NULL DEFAULT 0,
  `usergroup_cached_list` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workspace_id` int(11) NOT NULL DEFAULT 0,
  `category_perms` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`),
  KEY `username` (`username`),
  KEY `parent` (`pid`,`deleted`,`disable`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `be_users`
--

LOCK TABLES `be_users` WRITE;
/*!40000 ALTER TABLE `be_users` DISABLE KEYS */;
INSERT INTO `be_users` VALUES (1,0,1617373894,1617373894,0,0,0,0,0,NULL,'admin',0,'$argon2i$v=19$m=65536,t=16,p=1$L2NmMUVkNGhJRS5FSmhtbw$S+kvVMKYn00F4Q3FHUq5VjuDNeXLBQZX4mUqXs7rzKo',1,'','','',NULL,0,'',NULL,'','a:16:{s:14:\"interfaceSetup\";s:7:\"backend\";s:10:\"moduleData\";a:6:{s:8:\"web_list\";a:0:{}s:10:\"FormEngine\";a:2:{i:0;a:1:{s:32:\"20ed475662b97ac33d3aa853a74f9c9c\";a:4:{i:0;s:19:\"<em>[No title]</em>\";i:1;a:6:{s:4:\"edit\";a:1:{s:5:\"pages\";a:1:{i:2;s:4:\"edit\";}}s:7:\"defVals\";N;s:12:\"overrideVals\";N;s:11:\"columnsOnly\";N;s:6:\"noView\";N;s:9:\"workspace\";N;}i:2;s:28:\"&edit%5Bpages%5D%5B2%5D=edit\";i:3;a:5:{s:5:\"table\";s:5:\"pages\";s:3:\"uid\";i:2;s:3:\"pid\";i:0;s:3:\"cmd\";s:4:\"edit\";s:12:\"deleteAccess\";b:1;}}}i:1;s:32:\"c312013d83c1a6ad7fec8b36a37ba3c8\";}s:57:\"TYPO3\\CMS\\Backend\\Utility\\BackendUtility::getUpdateSignal\";a:0:{}s:47:\"TYPO3\\CMS\\Belog\\Controller\\BackendLogController\";s:352:\"O:39:\"TYPO3\\CMS\\Belog\\Domain\\Model\\Constraint\":12:{s:14:\"\0*\0userOrGroup\";s:1:\"0\";s:9:\"\0*\0number\";i:20;s:15:\"\0*\0workspaceUid\";i:-99;s:12:\"\0*\0timeFrame\";i:0;s:9:\"\0*\0action\";i:0;s:14:\"\0*\0groupByPage\";b:0;s:17:\"\0*\0startTimestamp\";i:0;s:15:\"\0*\0endTimestamp\";i:0;s:18:\"\0*\0manualDateStart\";N;s:17:\"\0*\0manualDateStop\";N;s:9:\"\0*\0pageId\";i:0;s:8:\"\0*\0depth\";i:0;}\";s:16:\"opendocs::recent\";a:2:{s:32:\"c312013d83c1a6ad7fec8b36a37ba3c8\";a:4:{i:0;s:19:\"<em>[No title]</em>\";i:1;a:6:{s:4:\"edit\";a:1:{s:10:\"tt_content\";a:1:{i:1;s:4:\"edit\";}}s:7:\"defVals\";N;s:12:\"overrideVals\";N;s:11:\"columnsOnly\";N;s:6:\"noView\";N;s:9:\"workspace\";N;}i:2;s:33:\"&edit%5Btt_content%5D%5B1%5D=edit\";i:3;a:5:{s:5:\"table\";s:10:\"tt_content\";s:3:\"uid\";i:1;s:3:\"pid\";i:1;s:3:\"cmd\";s:4:\"edit\";s:12:\"deleteAccess\";b:1;}}s:32:\"86205c5935270b8ee413592ec1b62292\";a:4:{i:0;s:25:\"Main TypoScript Rendering\";i:1;a:6:{s:4:\"edit\";a:1:{s:12:\"sys_template\";a:1:{i:1;s:4:\"edit\";}}s:7:\"defVals\";N;s:12:\"overrideVals\";N;s:11:\"columnsOnly\";N;s:6:\"noView\";N;s:9:\"workspace\";N;}i:2;s:35:\"&edit%5Bsys_template%5D%5B1%5D=edit\";i:3;a:5:{s:5:\"table\";s:12:\"sys_template\";s:3:\"uid\";i:1;s:3:\"pid\";i:1;s:3:\"cmd\";s:4:\"edit\";s:12:\"deleteAccess\";b:1;}}}s:6:\"web_ts\";a:2:{s:8:\"function\";s:88:\"TYPO3\\CMS\\Tstemplate\\Controller\\TypoScriptTemplateConstantEditorModuleFunctionController\";s:19:\"constant_editor_cat\";s:14:\"frontend login\";}}s:19:\"thumbnailsByDefault\";i:1;s:14:\"emailMeAtLogin\";i:0;s:11:\"startModule\";s:15:\"help_AboutAbout\";s:8:\"titleLen\";i:50;s:8:\"edit_RTE\";s:1:\"1\";s:20:\"edit_docModuleUpload\";s:1:\"1\";s:15:\"resizeTextareas\";i:1;s:25:\"resizeTextareas_MaxHeight\";i:500;s:24:\"resizeTextareas_Flexible\";i:0;s:4:\"lang\";s:0:\"\";s:19:\"firstLoginTimeStamp\";i:1617374604;s:15:\"moduleSessionID\";a:6:{s:8:\"web_list\";s:40:\"3a7bf02961ee2df64baa20c80d67d25c440785e4\";s:10:\"FormEngine\";s:40:\"bfe8d42208d203a6249716d7393b372e0dbec83e\";s:57:\"TYPO3\\CMS\\Backend\\Utility\\BackendUtility::getUpdateSignal\";s:40:\"bfe8d42208d203a6249716d7393b372e0dbec83e\";s:47:\"TYPO3\\CMS\\Belog\\Controller\\BackendLogController\";s:40:\"bfe8d42208d203a6249716d7393b372e0dbec83e\";s:16:\"opendocs::recent\";s:40:\"bfe8d42208d203a6249716d7393b372e0dbec83e\";s:6:\"web_ts\";s:40:\"bfe8d42208d203a6249716d7393b372e0dbec83e\";}s:17:\"systeminformation\";s:45:\"{\"system_BelogLog\":{\"lastAccess\":1617456778}}\";s:17:\"BackendComponents\";a:1:{s:6:\"States\";a:1:{s:8:\"Pagetree\";a:1:{s:9:\"stateHash\";a:1:{s:3:\"0_1\";s:1:\"1\";}}}}}',NULL,NULL,1,'',0,NULL,1617612783,0,NULL,0,NULL,''),(2,0,1617373907,1617373907,0,0,0,0,0,NULL,'_cli_',0,'$argon2i$v=19$m=65536,t=16,p=1$cEtmZHdseTlsWDJ0WnFqVA$RCkSJs/abQfJ8pnniaQreaXKgwYvw5ta4dxV6GMX94o',1,'','','',NULL,0,'',NULL,'','a:13:{s:14:\"interfaceSetup\";s:0:\"\";s:10:\"moduleData\";a:0:{}s:19:\"thumbnailsByDefault\";i:1;s:14:\"emailMeAtLogin\";i:0;s:11:\"startModule\";s:15:\"help_AboutAbout\";s:8:\"titleLen\";i:50;s:8:\"edit_RTE\";s:1:\"1\";s:20:\"edit_docModuleUpload\";s:1:\"1\";s:15:\"resizeTextareas\";i:1;s:25:\"resizeTextareas_MaxHeight\";i:500;s:24:\"resizeTextareas_Flexible\";i:0;s:4:\"lang\";s:0:\"\";s:19:\"firstLoginTimeStamp\";i:1617373907;}',NULL,NULL,1,'',0,NULL,0,0,NULL,0,NULL,'');
/*!40000 ALTER TABLE `be_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_hash`
--

DROP TABLE IF EXISTS `cache_hash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_hash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_hash`
--

LOCK TABLES `cache_hash` WRITE;
/*!40000 ALTER TABLE `cache_hash` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_hash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_hash_tags`
--

DROP TABLE IF EXISTS `cache_hash_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_hash_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_hash_tags`
--

LOCK TABLES `cache_hash_tags` WRITE;
/*!40000 ALTER TABLE `cache_hash_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_hash_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_imagesizes`
--

DROP TABLE IF EXISTS `cache_imagesizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_imagesizes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_imagesizes`
--

LOCK TABLES `cache_imagesizes` WRITE;
/*!40000 ALTER TABLE `cache_imagesizes` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_imagesizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_imagesizes_tags`
--

DROP TABLE IF EXISTS `cache_imagesizes_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_imagesizes_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_imagesizes_tags`
--

LOCK TABLES `cache_imagesizes_tags` WRITE;
/*!40000 ALTER TABLE `cache_imagesizes_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_imagesizes_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_pages`
--

DROP TABLE IF EXISTS `cache_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_pages`
--

LOCK TABLES `cache_pages` WRITE;
/*!40000 ALTER TABLE `cache_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_pages_tags`
--

DROP TABLE IF EXISTS `cache_pages_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_pages_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_pages_tags`
--

LOCK TABLES `cache_pages_tags` WRITE;
/*!40000 ALTER TABLE `cache_pages_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_pages_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_pagesection`
--

DROP TABLE IF EXISTS `cache_pagesection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_pagesection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_pagesection`
--

LOCK TABLES `cache_pagesection` WRITE;
/*!40000 ALTER TABLE `cache_pagesection` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_pagesection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_pagesection_tags`
--

DROP TABLE IF EXISTS `cache_pagesection_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_pagesection_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_pagesection_tags`
--

LOCK TABLES `cache_pagesection_tags` WRITE;
/*!40000 ALTER TABLE `cache_pagesection_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_pagesection_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_rootline`
--

DROP TABLE IF EXISTS `cache_rootline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_rootline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_rootline`
--

LOCK TABLES `cache_rootline` WRITE;
/*!40000 ALTER TABLE `cache_rootline` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_rootline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_rootline_tags`
--

DROP TABLE IF EXISTS `cache_rootline_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_rootline_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_rootline_tags`
--

LOCK TABLES `cache_rootline_tags` WRITE;
/*!40000 ALTER TABLE `cache_rootline_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_rootline_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_treelist`
--

DROP TABLE IF EXISTS `cache_treelist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_treelist` (
  `md5hash` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT 0,
  `treelist` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tstamp` int(11) NOT NULL DEFAULT 0,
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`md5hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_treelist`
--

LOCK TABLES `cache_treelist` WRITE;
/*!40000 ALTER TABLE `cache_treelist` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_treelist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_adminpanel_requestcache`
--

DROP TABLE IF EXISTS `cf_adminpanel_requestcache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_adminpanel_requestcache` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_adminpanel_requestcache`
--

LOCK TABLES `cf_adminpanel_requestcache` WRITE;
/*!40000 ALTER TABLE `cf_adminpanel_requestcache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_adminpanel_requestcache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_adminpanel_requestcache_tags`
--

DROP TABLE IF EXISTS `cf_adminpanel_requestcache_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_adminpanel_requestcache_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_adminpanel_requestcache_tags`
--

LOCK TABLES `cf_adminpanel_requestcache_tags` WRITE;
/*!40000 ALTER TABLE `cf_adminpanel_requestcache_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_adminpanel_requestcache_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_hash`
--

DROP TABLE IF EXISTS `cf_cache_hash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_hash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_hash`
--

LOCK TABLES `cf_cache_hash` WRITE;
/*!40000 ALTER TABLE `cf_cache_hash` DISABLE KEYS */;
INSERT INTO `cf_cache_hash` VALUES (1,'a341977e40078ac89538934c8436cc57',2145909600,'a:2:{i:0;a:3:{s:8:\"TSconfig\";a:3:{s:8:\"options.\";a:8:{s:15:\"enableBookmarks\";s:1:\"1\";s:10:\"file_list.\";a:4:{s:28:\"enableDisplayBigControlPanel\";s:10:\"selectable\";s:23:\"enableDisplayThumbnails\";s:10:\"selectable\";s:15:\"enableClipBoard\";s:10:\"selectable\";s:10:\"thumbnail.\";a:2:{s:5:\"width\";s:2:\"64\";s:6:\"height\";s:2:\"64\";}}s:9:\"pageTree.\";a:1:{s:31:\"doktypesToShowInNewPageDragArea\";s:21:\"1,6,4,7,3,254,255,199\";}s:12:\"contextMenu.\";a:1:{s:6:\"table.\";a:3:{s:6:\"pages.\";a:2:{s:12:\"disableItems\";s:0:\"\";s:5:\"tree.\";a:1:{s:12:\"disableItems\";s:0:\"\";}}s:9:\"sys_file.\";a:2:{s:12:\"disableItems\";s:0:\"\";s:5:\"tree.\";a:1:{s:12:\"disableItems\";s:0:\"\";}}s:15:\"sys_filemounts.\";a:2:{s:12:\"disableItems\";s:0:\"\";s:5:\"tree.\";a:1:{s:12:\"disableItems\";s:0:\"\";}}}}s:11:\"saveDocView\";s:1:\"1\";s:10:\"saveDocNew\";s:1:\"1\";s:11:\"saveDocNew.\";a:3:{s:5:\"pages\";s:1:\"0\";s:8:\"sys_file\";s:1:\"0\";s:17:\"sys_file_metadata\";s:1:\"0\";}s:14:\"disableDelete.\";a:1:{s:8:\"sys_file\";s:1:\"1\";}}s:9:\"admPanel.\";a:1:{s:7:\"enable.\";a:1:{s:3:\"all\";s:1:\"1\";}}s:12:\"TCAdefaults.\";a:1:{s:9:\"sys_note.\";a:2:{s:6:\"author\";s:0:\"\";s:5:\"email\";s:0:\"\";}}}s:8:\"sections\";a:0:{}s:5:\"match\";a:0:{}}i:1;s:32:\"a328e976dab15166dfc3cdbdaad9b3da\";}'),(2,'46b26a83740b2dcae6c7196fede5a962',2145909600,'a:2:{s:9:\"constants\";a:2:{s:7:\"styles.\";a:2:{s:8:\"content.\";a:6:{s:10:\"loginform.\";a:21:{s:3:\"pid\";s:1:\"2\";s:9:\"recursive\";s:1:\"0\";s:12:\"templateFile\";s:58:\"EXT:felogin/Resources/Private/Templates/FrontendLogin.html\";s:14:\"feloginBaseURL\";s:0:\"\";s:10:\"dateFormat\";s:9:\"Y-m-d H:i\";s:22:\"showForgotPasswordLink\";s:1:\"0\";s:14:\"showPermaLogin\";s:1:\"0\";s:24:\"showLogoutFormAfterLogin\";s:1:\"0\";s:9:\"emailFrom\";s:0:\"\";s:13:\"emailFromName\";s:0:\"\";s:12:\"replyToEmail\";s:0:\"\";s:12:\"redirectMode\";s:0:\"\";s:19:\"redirectFirstMethod\";s:1:\"0\";s:17:\"redirectPageLogin\";s:1:\"0\";s:22:\"redirectPageLoginError\";s:1:\"0\";s:18:\"redirectPageLogout\";s:1:\"0\";s:15:\"redirectDisable\";s:1:\"0\";s:23:\"forgotLinkHashValidTime\";s:2:\"12\";s:20:\"newPasswordMinLength\";s:1:\"6\";s:7:\"domains\";s:0:\"\";s:43:\"exposeNonexistentUserInForgotPasswordDialog\";s:1:\"0\";}s:17:\"defaultHeaderType\";s:1:\"2\";s:9:\"shortcut.\";a:1:{s:6:\"tables\";s:10:\"tt_content\";}s:9:\"allowTags\";s:392:\"a, abbr, acronym, address, article, aside, b, bdo, big, blockquote, br, caption, center, cite, code, col, colgroup, dd, del, dfn, dl, div, dt, em, font, footer, header, h1, h2, h3, h4, h5, h6, hr, i, img, ins, kbd, label, li, link, meta, nav, ol, p, pre, q, s, samp, sdfield, section, small, span, strike, strong, style, sub, sup, table, thead, tbody, tfoot, td, th, tr, title, tt, u, ul, var\";s:10:\"textmedia.\";a:9:{s:4:\"maxW\";s:3:\"600\";s:10:\"maxWInText\";s:3:\"300\";s:13:\"columnSpacing\";s:2:\"10\";s:10:\"rowSpacing\";s:2:\"10\";s:10:\"textMargin\";s:2:\"10\";s:11:\"borderColor\";s:7:\"#000000\";s:11:\"borderWidth\";s:1:\"2\";s:13:\"borderPadding\";s:1:\"0\";s:9:\"linkWrap.\";a:6:{s:5:\"width\";s:4:\"800m\";s:6:\"height\";s:4:\"600m\";s:9:\"newWindow\";s:1:\"0\";s:15:\"lightboxEnabled\";s:1:\"0\";s:16:\"lightboxCssClass\";s:8:\"lightbox\";s:20:\"lightboxRelAttribute\";s:21:\"lightbox[{field:uid}]\";}}s:6:\"links.\";a:2:{s:9:\"extTarget\";s:6:\"_blank\";s:4:\"keep\";s:4:\"path\";}}s:10:\"templates.\";a:3:{s:16:\"templateRootPath\";s:0:\"\";s:15:\"partialRootPath\";s:0:\"\";s:14:\"layoutRootPath\";s:0:\"\";}}s:7:\"plugin.\";a:1:{s:12:\"tx_thrating.\";a:2:{s:7:\"config.\";a:5:{s:10:\"loadJQuery\";s:1:\"1\";s:12:\"mapAnonymous\";s:1:\"0\";s:14:\"cookieLifetime\";s:1:\"0\";s:12:\"showNoFEUser\";s:1:\"0\";s:24:\"showMissingStepconfError\";s:1:\"0\";}s:9:\"settings.\";a:1:{s:16:\"pluginStoragePid\";s:1:\"2\";}}}}s:5:\"setup\";a:15:{s:7:\"config.\";a:2:{s:19:\"pageTitleProviders.\";a:3:{s:13:\"altPageTitle.\";a:2:{s:8:\"provider\";s:45:\"TYPO3\\CMS\\Core\\PageTitle\\AltPageTitleProvider\";s:6:\"before\";s:6:\"record\";}s:7:\"record.\";a:1:{s:8:\"provider\";s:48:\"TYPO3\\CMS\\Core\\PageTitle\\RecordPageTitleProvider\";}s:4:\"seo.\";a:3:{s:8:\"provider\";s:49:\"TYPO3\\CMS\\Seo\\PageTitle\\SeoTitlePageTitleProvider\";s:6:\"before\";s:6:\"record\";s:5:\"after\";s:12:\"altPageTitle\";}}s:11:\"tx_extbase.\";a:4:{s:4:\"mvc.\";a:2:{s:16:\"requestHandlers.\";a:4:{s:48:\"TYPO3\\CMS\\Extbase\\Mvc\\Web\\FrontendRequestHandler\";s:48:\"TYPO3\\CMS\\Extbase\\Mvc\\Web\\FrontendRequestHandler\";s:47:\"TYPO3\\CMS\\Extbase\\Mvc\\Web\\BackendRequestHandler\";s:47:\"TYPO3\\CMS\\Extbase\\Mvc\\Web\\BackendRequestHandler\";s:40:\"TYPO3\\CMS\\Extbase\\Mvc\\Cli\\RequestHandler\";s:40:\"TYPO3\\CMS\\Extbase\\Mvc\\Cli\\RequestHandler\";s:48:\"TYPO3\\CMS\\Fluid\\Core\\Widget\\WidgetRequestHandler\";s:48:\"TYPO3\\CMS\\Fluid\\Core\\Widget\\WidgetRequestHandler\";}s:48:\"throwPageNotFoundExceptionIfActionCantBeResolved\";s:1:\"0\";}s:12:\"persistence.\";a:3:{s:28:\"enableAutomaticCacheClearing\";s:1:\"1\";s:20:\"updateReferenceIndex\";s:1:\"0\";s:8:\"classes.\";a:11:{s:41:\"TYPO3\\CMS\\Extbase\\Domain\\Model\\FileMount.\";a:1:{s:8:\"mapping.\";a:2:{s:9:\"tableName\";s:14:\"sys_filemounts\";s:8:\"columns.\";a:3:{s:6:\"title.\";a:1:{s:13:\"mapOnProperty\";s:5:\"title\";}s:5:\"path.\";a:1:{s:13:\"mapOnProperty\";s:4:\"path\";}s:5:\"base.\";a:1:{s:13:\"mapOnProperty\";s:14:\"isAbsolutePath\";}}}}s:45:\"TYPO3\\CMS\\Extbase\\Domain\\Model\\FileReference.\";a:1:{s:8:\"mapping.\";a:1:{s:9:\"tableName\";s:18:\"sys_file_reference\";}}s:36:\"TYPO3\\CMS\\Extbase\\Domain\\Model\\File.\";a:1:{s:8:\"mapping.\";a:1:{s:9:\"tableName\";s:8:\"sys_file\";}}s:43:\"TYPO3\\CMS\\Extbase\\Domain\\Model\\BackendUser.\";a:1:{s:8:\"mapping.\";a:2:{s:9:\"tableName\";s:8:\"be_users\";s:8:\"columns.\";a:8:{s:9:\"username.\";a:1:{s:13:\"mapOnProperty\";s:8:\"userName\";}s:6:\"admin.\";a:1:{s:13:\"mapOnProperty\";s:15:\"isAdministrator\";}s:8:\"disable.\";a:1:{s:13:\"mapOnProperty\";s:10:\"isDisabled\";}s:9:\"realName.\";a:1:{s:13:\"mapOnProperty\";s:8:\"realName\";}s:10:\"starttime.\";a:1:{s:13:\"mapOnProperty\";s:16:\"startDateAndTime\";}s:8:\"endtime.\";a:1:{s:13:\"mapOnProperty\";s:14:\"endDateAndTime\";}s:14:\"disableIPlock.\";a:1:{s:13:\"mapOnProperty\";s:16:\"ipLockIsDisabled\";}s:10:\"lastlogin.\";a:1:{s:13:\"mapOnProperty\";s:20:\"lastLoginDateAndTime\";}}}}s:48:\"TYPO3\\CMS\\Extbase\\Domain\\Model\\BackendUserGroup.\";a:1:{s:8:\"mapping.\";a:2:{s:9:\"tableName\";s:9:\"be_groups\";s:8:\"columns.\";a:13:{s:9:\"subgroup.\";a:1:{s:13:\"mapOnProperty\";s:9:\"subGroups\";}s:10:\"groupMods.\";a:1:{s:13:\"mapOnProperty\";s:7:\"modules\";}s:14:\"tables_select.\";a:1:{s:13:\"mapOnProperty\";s:15:\"tablesListening\";}s:14:\"tables_modify.\";a:1:{s:13:\"mapOnProperty\";s:12:\"tablesModify\";}s:17:\"pagetypes_select.\";a:1:{s:13:\"mapOnProperty\";s:9:\"pageTypes\";}s:19:\"non_exclude_fields.\";a:1:{s:13:\"mapOnProperty\";s:20:\"allowedExcludeFields\";}s:19:\"explicit_allowdeny.\";a:1:{s:13:\"mapOnProperty\";s:22:\"explicitlyAllowAndDeny\";}s:18:\"allowed_languages.\";a:1:{s:13:\"mapOnProperty\";s:16:\"allowedLanguages\";}s:16:\"workspace_perms.\";a:1:{s:13:\"mapOnProperty\";s:19:\"workspacePermission\";}s:15:\"db_mountpoints.\";a:1:{s:13:\"mapOnProperty\";s:14:\"databaseMounts\";}s:17:\"file_permissions.\";a:1:{s:13:\"mapOnProperty\";s:24:\"fileOperationPermissions\";}s:13:\"lockToDomain.\";a:1:{s:13:\"mapOnProperty\";s:12:\"lockToDomain\";}s:9:\"TSconfig.\";a:1:{s:13:\"mapOnProperty\";s:8:\"tsConfig\";}}}}s:44:\"TYPO3\\CMS\\Extbase\\Domain\\Model\\FrontendUser.\";a:1:{s:8:\"mapping.\";a:3:{s:9:\"tableName\";s:8:\"fe_users\";s:8:\"columns.\";a:1:{s:13:\"lockToDomain.\";a:1:{s:13:\"mapOnProperty\";s:12:\"lockToDomain\";}}s:11:\"subclasses.\";a:1:{s:30:\"Tx_ThRating_Domain_Model_Voter\";s:34:\"Thucke\\ThRating\\Domain\\Model\\Voter\";}}}s:49:\"TYPO3\\CMS\\Extbase\\Domain\\Model\\FrontendUserGroup.\";a:1:{s:8:\"mapping.\";a:2:{s:9:\"tableName\";s:9:\"fe_groups\";s:8:\"columns.\";a:1:{s:13:\"lockToDomain.\";a:1:{s:13:\"mapOnProperty\";s:12:\"lockToDomain\";}}}}s:40:\"TYPO3\\CMS\\Extbase\\Domain\\Model\\Category.\";a:1:{s:8:\"mapping.\";a:1:{s:9:\"tableName\";s:12:\"sys_category\";}}s:42:\"TYPO3\\CMS\\Beuser\\Domain\\Model\\BackendUser.\";a:1:{s:8:\"mapping.\";a:2:{s:9:\"tableName\";s:8:\"be_users\";s:8:\"columns.\";a:4:{s:18:\"allowed_languages.\";a:1:{s:13:\"mapOnProperty\";s:16:\"allowedLanguages\";}s:17:\"file_mountpoints.\";a:1:{s:13:\"mapOnProperty\";s:15:\"fileMountPoints\";}s:15:\"db_mountpoints.\";a:1:{s:13:\"mapOnProperty\";s:13:\"dbMountPoints\";}s:10:\"usergroup.\";a:1:{s:13:\"mapOnProperty\";s:17:\"backendUserGroups\";}}}}s:47:\"TYPO3\\CMS\\Beuser\\Domain\\Model\\BackendUserGroup.\";a:1:{s:8:\"mapping.\";a:2:{s:9:\"tableName\";s:9:\"be_groups\";s:8:\"columns.\";a:1:{s:9:\"subgroup.\";a:1:{s:13:\"mapOnProperty\";s:9:\"subGroups\";}}}}s:35:\"Thucke\\ThRating\\Domain\\Model\\Voter.\";a:1:{s:8:\"mapping.\";a:1:{s:9:\"tableName\";s:8:\"fe_users\";}}}}s:9:\"features.\";a:4:{s:20:\"skipDefaultArguments\";s:1:\"0\";s:25:\"ignoreAllEnableFieldsInBe\";s:1:\"0\";s:38:\"requireCHashArgumentForActionArguments\";s:1:\"1\";s:36:\"consistentTranslationOverlayHandling\";s:1:\"1\";}s:7:\"legacy.\";a:1:{s:32:\"enableLegacyFlashMessageHandling\";s:1:\"0\";}}}s:7:\"styles.\";a:1:{s:8:\"content.\";a:2:{s:3:\"get\";s:7:\"CONTENT\";s:4:\"get.\";a:2:{s:5:\"table\";s:10:\"tt_content\";s:7:\"select.\";a:2:{s:7:\"orderBy\";s:7:\"sorting\";s:5:\"where\";s:11:\"{#colPos}=0\";}}}}s:10:\"tt_content\";s:4:\"CASE\";s:11:\"tt_content.\";a:54:{s:4:\"key.\";a:1:{s:5:\"field\";s:5:\"CType\";}s:7:\"default\";s:4:\"TEXT\";s:8:\"default.\";a:4:{s:5:\"field\";s:5:\"CType\";s:16:\"htmlSpecialChars\";s:1:\"1\";s:4:\"wrap\";s:165:\"<p style=\"background-color: yellow; padding: 0.5em 1em;\"><strong>ERROR:</strong> Content Element with uid \"{field:uid}\" and type \"|\" has no rendering definition!</p>\";s:5:\"wrap.\";a:1:{s:10:\"insertData\";s:1:\"1\";}}s:5:\"login\";s:20:\"< lib.contentElement\";s:6:\"login.\";a:2:{s:12:\"templateName\";s:7:\"Generic\";s:10:\"variables.\";a:1:{s:7:\"content\";s:23:\"< plugin.tx_felogin_pi1\";}}s:8:\"stdWrap.\";a:2:{s:9:\"editPanel\";s:1:\"1\";s:10:\"editPanel.\";a:5:{s:5:\"allow\";s:29:\"move, new, edit, hide, delete\";s:5:\"label\";s:2:\"%s\";s:14:\"onlyCurrentPid\";s:1:\"1\";s:13:\"previewBorder\";s:1:\"1\";s:5:\"edit.\";a:1:{s:13:\"displayRecord\";s:1:\"1\";}}}s:7:\"bullets\";s:20:\"< lib.contentElement\";s:8:\"bullets.\";a:3:{s:12:\"templateName\";s:7:\"Bullets\";s:15:\"dataProcessing.\";a:4:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\SplitProcessor\";s:3:\"10.\";a:4:{s:3:\"if.\";a:2:{s:5:\"value\";s:1:\"2\";s:11:\"isLessThan.\";a:1:{s:5:\"field\";s:12:\"bullets_type\";}}s:9:\"fieldName\";s:8:\"bodytext\";s:18:\"removeEmptyEntries\";s:1:\"1\";s:2:\"as\";s:7:\"bullets\";}i:20;s:62:\"TYPO3\\CMS\\Frontend\\DataProcessing\\CommaSeparatedValueProcessor\";s:3:\"20.\";a:4:{s:9:\"fieldName\";s:8:\"bodytext\";s:3:\"if.\";a:2:{s:5:\"value\";s:1:\"2\";s:7:\"equals.\";a:1:{s:5:\"field\";s:12:\"bullets_type\";}}s:14:\"fieldDelimiter\";s:1:\"|\";s:2:\"as\";s:7:\"bullets\";}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:59:\"tt_content: header [header_layout], bodytext [bullets_type]\";s:10:\"editIcons.\";a:2:{s:13:\"beforeLastTag\";s:1:\"1\";s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:92:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.bullets\";}}}}s:3:\"div\";s:20:\"< lib.contentElement\";s:4:\"div.\";a:1:{s:12:\"templateName\";s:3:\"Div\";}s:6:\"header\";s:20:\"< lib.contentElement\";s:7:\"header.\";a:2:{s:12:\"templateName\";s:6:\"Header\";s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:63:\"tt_content: header [header_layout|header_link], subheader, date\";s:10:\"editIcons.\";a:2:{s:13:\"beforeLastTag\";s:1:\"1\";s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:91:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.header\";}}}}s:4:\"html\";s:20:\"< lib.contentElement\";s:5:\"html.\";a:2:{s:12:\"templateName\";s:4:\"Html\";s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:20:\"tt_content: bodytext\";s:10:\"editIcons.\";a:2:{s:13:\"beforeLastTag\";s:1:\"1\";s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.html\";}}}}s:5:\"image\";s:20:\"< lib.contentElement\";s:6:\"image.\";a:3:{s:12:\"templateName\";s:5:\"Image\";s:15:\"dataProcessing.\";a:4:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"image\";}}i:20;s:50:\"TYPO3\\CMS\\Frontend\\DataProcessing\\GalleryProcessor\";s:3:\"20.\";a:5:{s:15:\"maxGalleryWidth\";s:3:\"600\";s:21:\"maxGalleryWidthInText\";s:3:\"300\";s:13:\"columnSpacing\";s:2:\"10\";s:11:\"borderWidth\";s:1:\"2\";s:13:\"borderPadding\";s:1:\"0\";}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:92:\"tt_content : image [imageorient|imagewidth|imageheight], [imagecols|imageborder], image_zoom\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:90:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.image\";}}}}s:4:\"list\";s:20:\"< lib.contentElement\";s:5:\"list.\";a:3:{s:12:\"templateName\";s:4:\"List\";s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:72:\"tt_content: header [header_layout], list_type, layout, pages [recursive]\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.list\";}}}s:3:\"20.\";a:2:{s:12:\"thrating_pi1\";s:4:\"USER\";s:13:\"thrating_pi1.\";a:4:{s:8:\"userFunc\";s:37:\"TYPO3\\CMS\\Extbase\\Core\\Bootstrap->run\";s:13:\"extensionName\";s:8:\"ThRating\";s:10:\"pluginName\";s:3:\"Pi1\";s:10:\"vendorName\";s:6:\"Thucke\";}}}s:8:\"shortcut\";s:20:\"< lib.contentElement\";s:9:\"shortcut.\";a:3:{s:12:\"templateName\";s:8:\"Shortcut\";s:10:\"variables.\";a:2:{s:9:\"shortcuts\";s:7:\"RECORDS\";s:10:\"shortcuts.\";a:2:{s:7:\"source.\";a:1:{s:5:\"field\";s:7:\"records\";}s:6:\"tables\";s:10:\"tt_content\";}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:43:\"tt_content: header [header_layout], records\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:93:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.shortcut\";}}}}s:5:\"table\";s:20:\"< lib.contentElement\";s:6:\"table.\";a:3:{s:12:\"templateName\";s:5:\"Table\";s:15:\"dataProcessing.\";a:2:{i:10;s:62:\"TYPO3\\CMS\\Frontend\\DataProcessing\\CommaSeparatedValueProcessor\";s:3:\"10.\";a:5:{s:9:\"fieldName\";s:8:\"bodytext\";s:15:\"fieldDelimiter.\";a:1:{s:5:\"char.\";a:2:{s:7:\"cObject\";s:4:\"TEXT\";s:8:\"cObject.\";a:1:{s:5:\"field\";s:15:\"table_delimiter\";}}}s:15:\"fieldEnclosure.\";a:2:{s:5:\"char.\";a:2:{s:7:\"cObject\";s:4:\"TEXT\";s:8:\"cObject.\";a:1:{s:5:\"field\";s:15:\"table_enclosure\";}}s:3:\"if.\";a:3:{s:5:\"value\";s:1:\"0\";s:7:\"equals.\";a:1:{s:5:\"field\";s:15:\"table_enclosure\";}s:6:\"negate\";s:1:\"1\";}}s:15:\"maximumColumns.\";a:1:{s:5:\"field\";s:4:\"cols\";}s:2:\"as\";s:5:\"table\";}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:100:\"tt_content: header [header_layout], bodytext, [table_caption|cols|table_header_position|table_tfoot]\";s:10:\"editIcons.\";a:2:{s:13:\"beforeLastTag\";s:1:\"1\";s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:90:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.table\";}}}}s:4:\"text\";s:20:\"< lib.contentElement\";s:5:\"text.\";a:2:{s:12:\"templateName\";s:4:\"Text\";s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:20:\"tt_content: bodytext\";s:10:\"editIcons.\";a:2:{s:13:\"beforeLastTag\";s:1:\"1\";s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.html\";}}}}s:9:\"textmedia\";s:20:\"< lib.contentElement\";s:10:\"textmedia.\";a:3:{s:12:\"templateName\";s:9:\"Textmedia\";s:15:\"dataProcessing.\";a:4:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:6:\"assets\";}}i:20;s:50:\"TYPO3\\CMS\\Frontend\\DataProcessing\\GalleryProcessor\";s:3:\"20.\";a:5:{s:15:\"maxGalleryWidth\";s:3:\"600\";s:21:\"maxGalleryWidthInText\";s:3:\"300\";s:13:\"columnSpacing\";s:2:\"10\";s:11:\"borderWidth\";s:1:\"2\";s:13:\"borderPadding\";s:1:\"0\";}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:126:\"tt_content: header [header_layout], bodytext, assets [imageorient|imagewidth|imageheight], [imagecols|imageborder], image_zoom\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:94:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.textmedia\";}}}}s:7:\"textpic\";s:20:\"< lib.contentElement\";s:8:\"textpic.\";a:3:{s:12:\"templateName\";s:7:\"Textpic\";s:15:\"dataProcessing.\";a:4:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"image\";}}i:20;s:50:\"TYPO3\\CMS\\Frontend\\DataProcessing\\GalleryProcessor\";s:3:\"20.\";a:5:{s:15:\"maxGalleryWidth\";s:3:\"600\";s:21:\"maxGalleryWidthInText\";s:3:\"300\";s:13:\"columnSpacing\";s:2:\"10\";s:11:\"borderWidth\";s:1:\"2\";s:13:\"borderPadding\";s:1:\"0\";}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:125:\"tt_content: header [header_layout], bodytext, image [imageorient|imagewidth|imageheight], [imagecols|imageborder], image_zoom\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:92:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.textpic\";}}}}s:7:\"uploads\";s:20:\"< lib.contentElement\";s:8:\"uploads.\";a:3:{s:12:\"templateName\";s:7:\"Uploads\";s:15:\"dataProcessing.\";a:2:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:3:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"media\";}s:12:\"collections.\";a:1:{s:5:\"field\";s:16:\"file_collections\";}s:8:\"sorting.\";a:2:{s:5:\"field\";s:16:\"filelink_sorting\";s:10:\"direction.\";a:1:{s:5:\"field\";s:26:\"filelink_sorting_direction\";}}}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:127:\"tt_content: header [header_layout], media, file_collections, filelink_sorting, [filelink_size|uploads_description|uploads_type]\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:92:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.uploads\";}}}}s:13:\"menu_abstract\";s:20:\"< lib.contentElement\";s:14:\"menu_abstract.\";a:3:{s:12:\"templateName\";s:12:\"MenuAbstract\";s:15:\"dataProcessing.\";a:2:{i:10;s:47:\"TYPO3\\CMS\\Frontend\\DataProcessing\\MenuProcessor\";s:3:\"10.\";a:3:{s:7:\"special\";s:9:\"directory\";s:8:\"special.\";a:1:{s:6:\"value.\";a:1:{s:5:\"field\";s:5:\"pages\";}}s:15:\"dataProcessing.\";a:2:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"media\";}}}}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:41:\"tt_content: header [header_layout], pages\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.menu\";}}}}s:24:\"menu_categorized_content\";s:20:\"< lib.contentElement\";s:25:\"menu_categorized_content.\";a:3:{s:12:\"templateName\";s:22:\"MenuCategorizedContent\";s:15:\"dataProcessing.\";a:2:{i:10;s:56:\"TYPO3\\CMS\\Frontend\\DataProcessing\\DatabaseQueryProcessor\";s:3:\"10.\";a:10:{s:5:\"table\";s:10:\"tt_content\";s:12:\"selectFields\";s:12:\"tt_content.*\";s:7:\"groupBy\";s:3:\"uid\";s:10:\"pidInList.\";a:1:{s:4:\"data\";s:12:\"leveluid : 0\";}s:9:\"recursive\";s:2:\"99\";s:5:\"join.\";a:2:{s:4:\"data\";s:25:\"field:selected_categories\";s:4:\"wrap\";s:109:\"sys_category_record_mm ON uid = sys_category_record_mm.uid_foreign AND sys_category_record_mm.uid_local IN(|)\";}s:6:\"where.\";a:2:{s:4:\"data\";s:20:\"field:category_field\";s:4:\"wrap\";s:41:\"tablenames=\'tt_content\' and fieldname=\'|\'\";}s:7:\"orderBy\";s:18:\"tt_content.sorting\";s:2:\"as\";s:7:\"content\";s:15:\"dataProcessing.\";a:2:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"image\";}}}}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:71:\"tt_content: header [header_layout], selected_categories, category_field\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.menu\";}}}}s:22:\"menu_categorized_pages\";s:20:\"< lib.contentElement\";s:23:\"menu_categorized_pages.\";a:3:{s:12:\"templateName\";s:20:\"MenuCategorizedPages\";s:15:\"dataProcessing.\";a:2:{i:10;s:47:\"TYPO3\\CMS\\Frontend\\DataProcessing\\MenuProcessor\";s:3:\"10.\";a:3:{s:7:\"special\";s:10:\"categories\";s:8:\"special.\";a:4:{s:6:\"value.\";a:1:{s:5:\"field\";s:19:\"selected_categories\";}s:9:\"relation.\";a:1:{s:5:\"field\";s:14:\"category_field\";}s:7:\"sorting\";s:5:\"title\";s:5:\"order\";s:3:\"asc\";}s:15:\"dataProcessing.\";a:2:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"media\";}}}}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:71:\"tt_content: header [header_layout], selected_categories, category_field\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.menu\";}}}}s:10:\"menu_pages\";s:20:\"< lib.contentElement\";s:11:\"menu_pages.\";a:3:{s:12:\"templateName\";s:9:\"MenuPages\";s:15:\"dataProcessing.\";a:2:{i:10;s:47:\"TYPO3\\CMS\\Frontend\\DataProcessing\\MenuProcessor\";s:3:\"10.\";a:3:{s:7:\"special\";s:4:\"list\";s:8:\"special.\";a:1:{s:6:\"value.\";a:1:{s:5:\"field\";s:5:\"pages\";}}s:15:\"dataProcessing.\";a:2:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"media\";}}}}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:41:\"tt_content: header [header_layout], pages\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.menu\";}}}}s:13:\"menu_subpages\";s:20:\"< lib.contentElement\";s:14:\"menu_subpages.\";a:3:{s:12:\"templateName\";s:12:\"MenuSubpages\";s:15:\"dataProcessing.\";a:2:{i:10;s:47:\"TYPO3\\CMS\\Frontend\\DataProcessing\\MenuProcessor\";s:3:\"10.\";a:3:{s:7:\"special\";s:9:\"directory\";s:8:\"special.\";a:1:{s:6:\"value.\";a:1:{s:5:\"field\";s:5:\"pages\";}}s:15:\"dataProcessing.\";a:2:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"media\";}}}}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:41:\"tt_content: header [header_layout], pages\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.menu\";}}}}s:12:\"menu_section\";s:20:\"< lib.contentElement\";s:13:\"menu_section.\";a:3:{s:12:\"templateName\";s:11:\"MenuSection\";s:15:\"dataProcessing.\";a:2:{i:10;s:47:\"TYPO3\\CMS\\Frontend\\DataProcessing\\MenuProcessor\";s:3:\"10.\";a:4:{s:17:\"includeNotInMenu.\";a:2:{s:8:\"override\";s:1:\"1\";s:9:\"override.\";a:1:{s:3:\"if.\";a:1:{s:8:\"isFalse.\";a:1:{s:5:\"field\";s:5:\"pages\";}}}}s:7:\"special\";s:4:\"list\";s:8:\"special.\";a:1:{s:6:\"value.\";a:2:{s:5:\"field\";s:5:\"pages\";s:9:\"override.\";a:2:{s:4:\"data\";s:8:\"page:uid\";s:3:\"if.\";a:1:{s:8:\"isFalse.\";a:1:{s:5:\"field\";s:5:\"pages\";}}}}}s:15:\"dataProcessing.\";a:4:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"media\";}}i:20;s:56:\"TYPO3\\CMS\\Frontend\\DataProcessing\\DatabaseQueryProcessor\";s:3:\"20.\";a:6:{s:5:\"table\";s:10:\"tt_content\";s:10:\"pidInList.\";a:1:{s:5:\"field\";s:3:\"uid\";}s:2:\"as\";s:7:\"content\";s:5:\"where\";s:16:\"sectionIndex = 1\";s:7:\"orderBy\";s:7:\"sorting\";s:15:\"dataProcessing.\";a:2:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"image\";}}}}}}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:41:\"tt_content: header [header_layout], pages\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.menu\";}}}}s:18:\"menu_section_pages\";s:20:\"< lib.contentElement\";s:19:\"menu_section_pages.\";a:3:{s:12:\"templateName\";s:16:\"MenuSectionPages\";s:15:\"dataProcessing.\";a:2:{i:10;s:47:\"TYPO3\\CMS\\Frontend\\DataProcessing\\MenuProcessor\";s:3:\"10.\";a:3:{s:7:\"special\";s:9:\"directory\";s:8:\"special.\";a:1:{s:6:\"value.\";a:1:{s:5:\"field\";s:5:\"pages\";}}s:15:\"dataProcessing.\";a:4:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"media\";}}i:20;s:56:\"TYPO3\\CMS\\Frontend\\DataProcessing\\DatabaseQueryProcessor\";s:3:\"20.\";a:5:{s:5:\"table\";s:10:\"tt_content\";s:10:\"pidInList.\";a:1:{s:5:\"field\";s:3:\"uid\";}s:7:\"orderBy\";s:7:\"sorting\";s:2:\"as\";s:7:\"content\";s:15:\"dataProcessing.\";a:2:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"image\";}}}}}}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:41:\"tt_content: header [header_layout], pages\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.menu\";}}}}s:21:\"menu_recently_updated\";s:20:\"< lib.contentElement\";s:22:\"menu_recently_updated.\";a:3:{s:12:\"templateName\";s:19:\"MenuRecentlyUpdated\";s:15:\"dataProcessing.\";a:2:{i:10;s:47:\"TYPO3\\CMS\\Frontend\\DataProcessing\\MenuProcessor\";s:3:\"10.\";a:3:{s:7:\"special\";s:7:\"updated\";s:8:\"special.\";a:3:{s:6:\"value.\";a:1:{s:5:\"field\";s:5:\"pages\";}s:6:\"maxAge\";s:9:\"3600*24*7\";s:20:\"excludeNoSearchPages\";s:1:\"1\";}s:15:\"dataProcessing.\";a:2:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"media\";}}}}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:41:\"tt_content: header [header_layout], pages\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.menu\";}}}}s:18:\"menu_related_pages\";s:20:\"< lib.contentElement\";s:19:\"menu_related_pages.\";a:3:{s:12:\"templateName\";s:16:\"MenuRelatedPages\";s:15:\"dataProcessing.\";a:2:{i:10;s:47:\"TYPO3\\CMS\\Frontend\\DataProcessing\\MenuProcessor\";s:3:\"10.\";a:4:{s:7:\"special\";s:8:\"keywords\";s:8:\"special.\";a:2:{s:6:\"value.\";a:1:{s:5:\"field\";s:5:\"pages\";}s:20:\"excludeNoSearchPages\";s:1:\"1\";}s:23:\"alternativeSortingField\";s:5:\"title\";s:15:\"dataProcessing.\";a:2:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"media\";}}}}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:41:\"tt_content: header [header_layout], pages\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.menu\";}}}}s:12:\"menu_sitemap\";s:20:\"< lib.contentElement\";s:13:\"menu_sitemap.\";a:3:{s:12:\"templateName\";s:11:\"MenuSitemap\";s:15:\"dataProcessing.\";a:2:{i:10;s:47:\"TYPO3\\CMS\\Frontend\\DataProcessing\\MenuProcessor\";s:3:\"10.\";a:2:{s:6:\"levels\";s:1:\"7\";s:15:\"dataProcessing.\";a:2:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"media\";}}}}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:41:\"tt_content: header [header_layout], pages\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.menu\";}}}}s:18:\"menu_sitemap_pages\";s:20:\"< lib.contentElement\";s:19:\"menu_sitemap_pages.\";a:3:{s:12:\"templateName\";s:16:\"MenuSitemapPages\";s:15:\"dataProcessing.\";a:2:{i:10;s:47:\"TYPO3\\CMS\\Frontend\\DataProcessing\\MenuProcessor\";s:3:\"10.\";a:4:{s:7:\"special\";s:9:\"directory\";s:8:\"special.\";a:1:{s:6:\"value.\";a:1:{s:5:\"field\";s:5:\"pages\";}}s:6:\"levels\";s:1:\"7\";s:15:\"dataProcessing.\";a:2:{i:10;s:48:\"TYPO3\\CMS\\Frontend\\DataProcessing\\FilesProcessor\";s:3:\"10.\";a:1:{s:11:\"references.\";a:1:{s:9:\"fieldName\";s:5:\"media\";}}}}}s:8:\"stdWrap.\";a:2:{s:9:\"editIcons\";s:41:\"tt_content: header [header_layout], pages\";s:10:\"editIcons.\";a:1:{s:10:\"iconTitle.\";a:1:{s:4:\"data\";s:89:\"LLL:EXT:fluid_styled_content/Resources/Private/Language/FrontendEditing.xlf:editIcon.menu\";}}}}s:18:\"form_formframework\";s:20:\"< lib.contentElement\";s:19:\"form_formframework.\";a:3:{s:12:\"templateName\";s:7:\"Generic\";i:20;s:4:\"USER\";s:3:\"20.\";a:4:{s:8:\"userFunc\";s:37:\"TYPO3\\CMS\\Extbase\\Core\\Bootstrap->run\";s:13:\"extensionName\";s:4:\"Form\";s:10:\"pluginName\";s:13:\"Formframework\";s:10:\"vendorName\";s:9:\"TYPO3\\CMS\";}}}s:7:\"module.\";a:4:{s:8:\"tx_form.\";a:2:{s:9:\"settings.\";a:1:{s:19:\"yamlConfigurations.\";a:3:{i:10;s:42:\"EXT:form/Configuration/Yaml/BaseSetup.yaml\";i:20;s:48:\"EXT:form/Configuration/Yaml/FormEditorSetup.yaml\";i:30;s:48:\"EXT:form/Configuration/Yaml/FormEngineSetup.yaml\";}}s:5:\"view.\";a:3:{s:18:\"templateRootPaths.\";a:1:{i:10;s:45:\"EXT:form/Resources/Private/Backend/Templates/\";}s:17:\"partialRootPaths.\";a:1:{i:10;s:44:\"EXT:form/Resources/Private/Backend/Partials/\";}s:16:\"layoutRootPaths.\";a:1:{i:10;s:43:\"EXT:form/Resources/Private/Backend/Layouts/\";}}}s:9:\"tx_belog.\";a:2:{s:12:\"persistence.\";a:1:{s:8:\"classes.\";a:2:{s:38:\"TYPO3\\CMS\\Belog\\Domain\\Model\\LogEntry.\";a:1:{s:8:\"mapping.\";a:2:{s:9:\"tableName\";s:7:\"sys_log\";s:8:\"columns.\";a:8:{s:7:\"userid.\";a:1:{s:13:\"mapOnProperty\";s:14:\"backendUserUid\";}s:7:\"recuid.\";a:1:{s:13:\"mapOnProperty\";s:9:\"recordUid\";}s:10:\"tablename.\";a:1:{s:13:\"mapOnProperty\";s:9:\"tableName\";}s:7:\"recpid.\";a:1:{s:13:\"mapOnProperty\";s:9:\"recordPid\";}s:11:\"details_nr.\";a:1:{s:13:\"mapOnProperty\";s:13:\"detailsNumber\";}s:3:\"IP.\";a:1:{s:13:\"mapOnProperty\";s:2:\"ip\";}s:10:\"workspace.\";a:1:{s:13:\"mapOnProperty\";s:12:\"workspaceUid\";}s:6:\"NEWid.\";a:1:{s:13:\"mapOnProperty\";s:5:\"newId\";}}}}s:39:\"TYPO3\\CMS\\Belog\\Domain\\Model\\Workspace.\";a:1:{s:8:\"mapping.\";a:1:{s:9:\"tableName\";s:13:\"sys_workspace\";}}}}s:9:\"settings.\";a:3:{s:29:\"selectableNumberOfLogEntries.\";a:7:{i:20;s:2:\"20\";i:50;s:2:\"50\";i:100;s:3:\"100\";i:200;s:3:\"200\";i:500;s:3:\"500\";i:1000;s:4:\"1000\";i:1000000;s:3:\"any\";}s:21:\"selectableTimeFrames.\";a:8:{i:0;s:8:\"thisWeek\";i:1;s:8:\"lastWeek\";i:2;s:9:\"last7Days\";i:10;s:9:\"thisMonth\";i:11;s:9:\"lastMonth\";i:12;s:10:\"last31Days\";i:20;s:7:\"noLimit\";i:30;s:11:\"userDefined\";}s:18:\"selectableActions.\";a:7:{i:0;s:3:\"any\";i:1;s:14:\"actionDatabase\";i:2;s:10:\"actionFile\";i:3;s:11:\"actionCache\";i:254;s:14:\"actionSettings\";i:255;s:11:\"actionLogin\";i:-1;s:12:\"actionErrors\";}}}s:10:\"tx_beuser.\";a:2:{s:12:\"persistence.\";a:1:{s:10:\"storagePid\";s:1:\"0\";}s:9:\"settings.\";a:1:{s:5:\"dummy\";s:3:\"foo\";}}s:20:\"tx_extensionmanager.\";a:1:{s:9:\"features.\";a:1:{s:20:\"skipDefaultArguments\";s:1:\"0\";}}}s:7:\"plugin.\";a:5:{s:14:\"tx_felogin_pi1\";s:8:\"USER_INT\";s:15:\"tx_felogin_pi1.\";a:45:{s:8:\"userFunc\";s:58:\"TYPO3\\CMS\\Felogin\\Controller\\FrontendLoginController->main\";s:10:\"storagePid\";s:1:\"2\";s:9:\"recursive\";s:1:\"0\";s:12:\"templateFile\";s:58:\"EXT:felogin/Resources/Private/Templates/FrontendLogin.html\";s:14:\"feloginBaseURL\";s:0:\"\";s:10:\"dateFormat\";s:9:\"Y-m-d H:i\";s:22:\"showForgotPasswordLink\";s:1:\"0\";s:14:\"showPermaLogin\";s:1:\"0\";s:24:\"showLogoutFormAfterLogin\";s:1:\"0\";s:10:\"email_from\";s:0:\"\";s:14:\"email_fromName\";s:0:\"\";s:7:\"replyTo\";s:0:\"\";s:12:\"redirectMode\";s:0:\"\";s:19:\"redirectFirstMethod\";s:1:\"0\";s:17:\"redirectPageLogin\";s:1:\"0\";s:22:\"redirectPageLoginError\";s:1:\"0\";s:18:\"redirectPageLogout\";s:1:\"0\";s:15:\"redirectDisable\";s:1:\"0\";s:23:\"forgotLinkHashValidTime\";s:2:\"12\";s:20:\"newPasswordMinLength\";s:1:\"6\";s:7:\"domains\";s:0:\"\";s:43:\"exposeNonexistentUserInForgotPasswordDialog\";s:1:\"0\";s:22:\"wrapContentInBaseClass\";s:1:\"1\";s:11:\"linkConfig.\";a:2:{s:6:\"target\";s:0:\"\";s:10:\"ATagParams\";s:14:\"rel=\"nofollow\"\";}s:15:\"preserveGETvars\";s:3:\"all\";s:22:\"welcomeHeader_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:10:\"<h3>|</h3>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:22:\"successHeader_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:10:\"<h3>|</h3>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:21:\"logoutHeader_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:10:\"<h3>|</h3>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:20:\"errorHeader_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:10:\"<h3>|</h3>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:21:\"forgotHeader_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:10:\"<h3>|</h3>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:29:\"changePasswordHeader_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:10:\"<h3>|</h3>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:23:\"welcomeMessage_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:12:\"<div>|</div>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:23:\"successMessage_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:12:\"<div>|</div>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:22:\"logoutMessage_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:12:\"<div>|</div>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:21:\"errorMessage_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:12:\"<div>|</div>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:22:\"forgotMessage_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:12:\"<div>|</div>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:27:\"forgotErrorMessage_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:12:\"<div>|</div>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:43:\"forgotResetMessageEmailSentMessage_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:12:\"<div>|</div>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:38:\"changePasswordNotValidMessage_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:12:\"<div>|</div>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:38:\"changePasswordTooShortMessage_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:12:\"<div>|</div>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:38:\"changePasswordNotEqualMessage_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:12:\"<div>|</div>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:30:\"changePasswordMessage_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:12:\"<div>|</div>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:34:\"changePasswordDoneMessage_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:12:\"<div>|</div>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:22:\"cookieWarning_stdWrap.\";a:3:{s:8:\"required\";s:1:\"1\";s:4:\"wrap\";s:45:\"<p style=\"color:red; font-weight:bold;\">|</p>\";s:16:\"htmlSpecialChars\";s:1:\"1\";}s:11:\"userfields.\";a:1:{s:9:\"username.\";a:2:{s:16:\"htmlSpecialChars\";s:1:\"1\";s:4:\"wrap\";s:18:\"<strong>|</strong>\";}}}s:12:\"tx_frontend.\";a:1:{s:18:\"_CSS_DEFAULT_STYLE\";s:3311:\"    .ce-align-left { text-align: left; }\n    .ce-align-center { text-align: center; }\n    .ce-align-right { text-align: right; }\n\n    .ce-table td, .ce-table th { vertical-align: top; }\n\n    .ce-textpic, .ce-image, .ce-nowrap .ce-bodytext, .ce-gallery, .ce-row, .ce-uploads li, .ce-uploads div { overflow: hidden; }\n\n    .ce-left .ce-gallery, .ce-column { float: left; }\n    .ce-center .ce-outer { position: relative; float: right; right: 50%; }\n    .ce-center .ce-inner { position: relative; float: right; right: -50%; }\n    .ce-right .ce-gallery { float: right; }\n\n    .ce-gallery figure { display: table; margin: 0; }\n    .ce-gallery figcaption { display: table-caption; caption-side: bottom; }\n    .ce-gallery img { display: block; }\n    .ce-gallery iframe { border-width: 0; }\n    .ce-border img,\n    .ce-border iframe {\n        border: 2px solid #000000;\n        padding: 0px;\n    }\n\n    .ce-intext.ce-right .ce-gallery, .ce-intext.ce-left .ce-gallery, .ce-above .ce-gallery {\n        margin-bottom: 10px;\n    }\n    .ce-intext.ce-right .ce-gallery { margin-left: 10px; }\n    .ce-intext.ce-left .ce-gallery { margin-right: 10px; }\n    .ce-below .ce-gallery { margin-top: 10px; }\n\n    .ce-column { margin-right: 10px; }\n    .ce-column:last-child { margin-right: 0; }\n\n    .ce-row { margin-bottom: 10px; }\n    .ce-row:last-child { margin-bottom: 0; }\n\n    .ce-above .ce-bodytext { clear: both; }\n\n    .ce-intext.ce-left ol, .ce-intext.ce-left ul { padding-left: 40px; overflow: auto; }\n\n    /* Headline */\n    .ce-headline-left { text-align: left; }\n    .ce-headline-center { text-align: center; }\n    .ce-headline-right { text-align: right; }\n\n    /* Uploads */\n    .ce-uploads { margin: 0; padding: 0; }\n    .ce-uploads li { list-style: none outside none; margin: 1em 0; }\n    .ce-uploads img { float: left; padding-right: 1em; vertical-align: top; }\n    .ce-uploads span { display: block; }\n\n    /* Table */\n    .ce-table { width: 100%; max-width: 100%; }\n    .ce-table th, .ce-table td { padding: 0.5em 0.75em; vertical-align: top; }\n    .ce-table thead th { border-bottom: 2px solid #dadada; }\n    .ce-table th, .ce-table td { border-top: 1px solid #dadada; }\n    .ce-table-striped tbody tr:nth-of-type(odd) { background-color: rgba(0,0,0,.05); }\n    .ce-table-bordered th, .ce-table-bordered td { border: 1px solid #dadada; }\n\n    /* Space */\n    .frame-space-before-extra-small { margin-top: 1em; }\n    .frame-space-before-small { margin-top: 2em; }\n    .frame-space-before-medium { margin-top: 3em; }\n    .frame-space-before-large { margin-top: 4em; }\n    .frame-space-before-extra-large { margin-top: 5em; }\n    .frame-space-after-extra-small { margin-bottom: 1em; }\n    .frame-space-after-small { margin-bottom: 2em; }\n    .frame-space-after-medium { margin-bottom: 3em; }\n    .frame-space-after-large { margin-bottom: 4em; }\n    .frame-space-after-extra-large { margin-bottom: 5em; }\n\n    /* Frame */\n    .frame-ruler-before:before { content: \'\'; display: block; border-top: 1px solid rgba(0,0,0,0.25); margin-bottom: 2em; }\n    .frame-ruler-after:after { content: \'\'; display: block; border-bottom: 1px solid rgba(0,0,0,0.25); margin-top: 2em; }\n    .frame-indent { margin-left: 15%; margin-right: 15%; }\n    .frame-indent-left { margin-left: 33%; }\n    .frame-indent-right { margin-right: 33%; }\";}s:11:\"tx_thrating\";s:4:\"USER\";s:12:\"tx_thrating.\";a:14:{s:8:\"userFunc\";s:37:\"TYPO3\\CMS\\Extbase\\Core\\Bootstrap->run\";s:10:\"pluginName\";s:3:\"Pi1\";s:13:\"extensionName\";s:8:\"ThRating\";s:10:\"vendorName\";s:6:\"Thucke\";s:10:\"controller\";s:4:\"Vote\";s:4:\"mvc.\";a:1:{s:39:\"callDefaultActionIfActionCantBeResolved\";s:1:\"1\";}s:17:\"feUsersStoragePid\";s:1:\"2\";s:10:\"storagePid\";s:1:\"2\";s:28:\"switchableControllerActions.\";a:1:{s:5:\"Vote.\";a:8:{i:1;s:11:\"ratinglinks\";i:2;s:7:\"polling\";i:3;s:4:\"mark\";i:4;s:5:\"index\";i:5;s:4:\"show\";i:6;s:6:\"create\";i:7;s:3:\"new\";i:8;s:9:\"singleton\";}}s:9:\"settings.\";a:11:{s:7:\"display\";s:5:\"stars\";s:24:\"showMissingStepconfError\";s:1:\"0\";s:12:\"showNoFEUser\";s:1:\"0\";s:12:\"mapAnonymous\";s:1:\"0\";s:14:\"cookieLifetime\";s:1:\"0\";s:13:\"ratingContext\";s:14:\"defaultContext\";s:27:\"defaultRatingConfiguration.\";a:3:{s:11:\"ratinglinks\";s:5:\"stars\";s:7:\"polling\";s:7:\"polling\";s:4:\"mark\";s:11:\"smileyLikes\";}s:8:\"logging.\";a:8:{s:10:\"emergency.\";a:2:{s:4:\"file\";s:27:\"typo3temp/logs/ThRating.log\";s:5:\"table\";s:7:\"sys_log\";}s:6:\"alert.\";a:1:{s:5:\"table\";s:7:\"sys_log\";}s:9:\"critical.\";a:1:{s:5:\"table\";s:7:\"sys_log\";}s:6:\"error.\";a:1:{s:5:\"table\";s:7:\"sys_log\";}s:8:\"warning.\";a:0:{}s:7:\"notice.\";a:0:{}s:5:\"info.\";a:0:{}s:6:\"debug.\";a:0:{}}s:6:\"fluid.\";a:3:{s:8:\"layouts.\";a:1:{s:8:\"default.\";a:3:{s:11:\"showSummary\";s:1:\"0\";s:16:\"showCurrentRates\";s:1:\"1\";s:18:\"showSectionContent\";s:1:\"1\";}}s:10:\"templates.\";a:1:{s:12:\"ratinglinks.\";a:2:{s:9:\"likesMode\";s:1:\"0\";s:8:\"tooltips\";s:1:\"0\";}}s:9:\"partials.\";a:2:{s:12:\"usersRating.\";a:2:{s:12:\"showTextInfo\";s:1:\"1\";s:15:\"showGraphicInfo\";s:1:\"0\";}s:10:\"infoBlock.\";a:1:{s:18:\"showAnonymousVotes\";s:1:\"1\";}}}s:14:\"defaultObject.\";a:3:{s:9:\"ratetable\";s:10:\"tt_content\";s:9:\"ratefield\";s:3:\"uid\";s:18:\"richSnippetFields.\";a:2:{s:4:\"name\";s:6:\"header\";s:11:\"description\";s:8:\"bodytext\";}}s:21:\"ratingConfigurations.\";a:7:{s:20:\"exampleRatingConfig.\";a:5:{s:9:\"imagefile\";s:59:\"typo3conf/ext/th_rating/Resources/Public/Css/rating_bar.png\";s:8:\"barimage\";s:1:\"1\";s:4:\"tilt\";s:1:\"0\";s:9:\"settings.\";a:5:{s:12:\"showNoFEUser\";s:1:\"1\";s:12:\"showNotRated\";s:1:\"1\";s:12:\"mapAnonymous\";s:1:\"0\";s:11:\"displayOnly\";s:1:\"0\";s:14:\"cookieLifetime\";s:1:\"0\";}s:6:\"fluid.\";a:3:{s:8:\"layouts.\";a:1:{s:8:\"default.\";a:3:{s:11:\"showSummary\";s:1:\"1\";s:16:\"showCurrentRates\";s:1:\"1\";s:18:\"showSectionContent\";s:1:\"1\";}}s:10:\"templates.\";a:1:{s:12:\"ratinglinks.\";a:2:{s:9:\"likesMode\";s:1:\"0\";s:8:\"tooltips\";s:1:\"1\";}}s:9:\"partials.\";a:2:{s:12:\"usersRating.\";a:2:{s:12:\"showTextInfo\";s:1:\"1\";s:15:\"showGraphicInfo\";s:1:\"0\";}s:10:\"infoBlock.\";a:1:{s:18:\"showAnonymousVotes\";s:1:\"1\";}}}}s:6:\"stars.\";a:3:{s:9:\"imagefile\";s:54:\"typo3conf/ext/th_rating/Resources/Public/Css/stars.gif\";s:8:\"barimage\";s:1:\"0\";s:4:\"tilt\";s:1:\"0\";}s:10:\"starsTilt.\";a:3:{s:9:\"imagefile\";s:58:\"typo3conf/ext/th_rating/Resources/Public/Css/starsTilt.gif\";s:8:\"barimage\";s:1:\"0\";s:4:\"tilt\";s:1:\"1\";}s:13:\"facesbartilt.\";a:3:{s:9:\"imagefile\";s:61:\"typo3conf/ext/th_rating/Resources/Public/Css/facesbarTilt.gif\";s:8:\"barimage\";s:1:\"1\";s:4:\"tilt\";s:1:\"1\";}s:10:\"barrating.\";a:3:{s:9:\"imagefile\";s:59:\"typo3conf/ext/th_rating/Resources/Public/Css/rating_bar.png\";s:8:\"barimage\";s:1:\"1\";s:4:\"tilt\";s:1:\"0\";}s:12:\"smileyLikes.\";a:5:{s:9:\"imagefile\";s:55:\"typo3conf/ext/th_rating/Resources/Public/Css/smiley.gif\";s:8:\"barimage\";s:1:\"0\";s:4:\"tilt\";s:1:\"0\";s:9:\"settings.\";a:3:{s:12:\"showNoFEUser\";s:1:\"0\";s:12:\"showNotRated\";s:1:\"0\";s:14:\"cookieLifetime\";s:3:\"365\";}s:6:\"fluid.\";a:3:{s:8:\"layouts.\";a:1:{s:8:\"default.\";a:3:{s:11:\"showSummary\";s:1:\"0\";s:16:\"showCurrentRates\";s:1:\"0\";s:18:\"showSectionContent\";s:1:\"1\";}}s:10:\"templates.\";a:1:{s:12:\"ratinglinks.\";a:2:{s:9:\"likesMode\";s:1:\"1\";s:8:\"tooltips\";s:1:\"0\";}}s:9:\"partials.\";a:2:{s:12:\"usersRating.\";a:2:{s:12:\"showTextInfo\";s:1:\"0\";s:15:\"showGraphicInfo\";s:1:\"1\";}s:10:\"infoBlock.\";a:1:{s:18:\"showAnonymousVotes\";s:1:\"0\";}}}}s:8:\"polling.\";a:3:{s:9:\"imagefile\";s:56:\"typo3conf/ext/th_rating/Resources/Public/Css/polling.png\";s:8:\"barimage\";s:1:\"0\";s:4:\"tilt\";s:1:\"0\";}}}s:8:\"ratings.\";a:1:{s:20:\"exampleRatingConfig.\";a:5:{s:9:\"imagefile\";s:59:\"typo3conf/ext/th_rating/Resources/Public/Css/rating_bar.png\";s:8:\"barimage\";s:1:\"1\";s:4:\"tilt\";s:1:\"0\";s:9:\"settings.\";a:5:{s:12:\"showNoFEUser\";s:1:\"1\";s:12:\"showNotRated\";s:1:\"1\";s:12:\"mapAnonymous\";s:1:\"0\";s:11:\"displayOnly\";s:1:\"0\";s:14:\"cookieLifetime\";s:1:\"0\";}s:6:\"fluid.\";a:3:{s:8:\"layouts.\";a:1:{s:8:\"default.\";a:3:{s:11:\"showSummary\";s:1:\"1\";s:16:\"showCurrentRates\";s:1:\"1\";s:18:\"showSectionContent\";s:1:\"1\";}}s:10:\"templates.\";a:1:{s:12:\"ratinglinks.\";a:2:{s:9:\"likesMode\";s:1:\"0\";s:8:\"tooltips\";s:1:\"1\";}}s:9:\"partials.\";a:2:{s:12:\"usersRating.\";a:2:{s:12:\"showTextInfo\";s:1:\"1\";s:15:\"showGraphicInfo\";s:1:\"0\";}s:10:\"infoBlock.\";a:1:{s:18:\"showAnonymousVotes\";s:1:\"1\";}}}}}s:12:\"persistence.\";a:3:{s:10:\"storagePid\";s:1:\"2\";s:8:\"classes.\";a:1:{s:42:\"Thucke\\ThRating\\Domain\\Model\\Ratingobject.\";a:1:{s:19:\"newRecordStoragePid\";s:1:\"2\";}}s:27:\"enhancedLazyLoadingStrategy\";s:1:\"0\";}s:5:\"view.\";a:3:{s:18:\"templateRootPaths.\";a:1:{i:0;s:42:\"EXT:th_rating/Resources/Private/Templates/\";}s:17:\"partialRootPaths.\";a:1:{i:0;s:41:\"EXT:th_rating/Resources/Private/Partials/\";}s:16:\"layoutRootPaths.\";a:1:{i:0;s:40:\"EXT:th_rating/Resources/Private/Layouts/\";}}s:12:\"_LOCAL_LANG.\";a:1:{s:8:\"default.\";a:1:{s:9:\"read_more\";s:7:\"more >>\";}}}}s:4:\"lib.\";a:5:{s:14:\"contentElement\";s:13:\"FLUIDTEMPLATE\";s:15:\"contentElement.\";a:5:{s:12:\"templateName\";s:7:\"Default\";s:18:\"templateRootPaths.\";a:2:{i:0;s:53:\"EXT:fluid_styled_content/Resources/Private/Templates/\";i:10;s:0:\"\";}s:17:\"partialRootPaths.\";a:2:{i:0;s:52:\"EXT:fluid_styled_content/Resources/Private/Partials/\";i:10;s:0:\"\";}s:16:\"layoutRootPaths.\";a:2:{i:0;s:51:\"EXT:fluid_styled_content/Resources/Private/Layouts/\";i:10;s:0:\"\";}s:9:\"settings.\";a:2:{s:17:\"defaultHeaderType\";s:1:\"2\";s:6:\"media.\";a:2:{s:6:\"popup.\";a:9:{s:7:\"bodyTag\";s:41:\"<body style=\"margin:0; background:#fff;\">\";s:4:\"wrap\";s:37:\"<a href=\"javascript:close();\"> | </a>\";s:5:\"width\";s:4:\"800m\";s:6:\"height\";s:4:\"600m\";s:5:\"crop.\";a:1:{s:4:\"data\";s:17:\"file:current:crop\";}s:8:\"JSwindow\";s:1:\"1\";s:9:\"JSwindow.\";a:2:{s:9:\"newWindow\";s:1:\"0\";s:3:\"if.\";a:1:{s:7:\"isFalse\";s:1:\"0\";}}s:15:\"directImageLink\";s:1:\"0\";s:11:\"linkParams.\";a:1:{s:11:\"ATagParams.\";a:1:{s:8:\"dataWrap\";s:44:\"class=\"lightbox\" rel=\"lightbox[{field:uid}]\"\";}}}s:17:\"additionalConfig.\";a:1:{s:9:\"no-cookie\";s:1:\"1\";}}}}s:10:\"parseFunc.\";a:8:{s:9:\"makelinks\";s:1:\"1\";s:10:\"makelinks.\";a:2:{s:5:\"http.\";a:2:{s:4:\"keep\";s:4:\"path\";s:9:\"extTarget\";s:6:\"_blank\";}s:7:\"mailto.\";a:1:{s:4:\"keep\";s:4:\"path\";}}s:5:\"tags.\";a:4:{s:4:\"link\";s:4:\"TEXT\";s:5:\"link.\";a:3:{s:7:\"current\";s:1:\"1\";s:9:\"typolink.\";a:2:{s:10:\"parameter.\";a:1:{s:4:\"data\";s:22:\"parameters : allParams\";}s:9:\"extTarget\";s:6:\"_blank\";}s:10:\"parseFunc.\";a:1:{s:9:\"constants\";s:1:\"1\";}}s:1:\"a\";s:4:\"TEXT\";s:2:\"a.\";a:2:{s:7:\"current\";s:1:\"1\";s:9:\"typolink.\";a:5:{s:10:\"parameter.\";a:1:{s:4:\"data\";s:15:\"parameters:href\";}s:6:\"title.\";a:1:{s:4:\"data\";s:16:\"parameters:title\";}s:11:\"ATagParams.\";a:1:{s:4:\"data\";s:20:\"parameters:allParams\";}s:7:\"target.\";a:1:{s:8:\"ifEmpty.\";a:1:{s:4:\"data\";s:17:\"parameters:target\";}}s:10:\"extTarget.\";a:2:{s:8:\"ifEmpty.\";a:1:{s:8:\"override\";s:6:\"_blank\";}s:9:\"override.\";a:1:{s:4:\"data\";s:17:\"parameters:target\";}}}}}s:9:\"allowTags\";s:392:\"a, abbr, acronym, address, article, aside, b, bdo, big, blockquote, br, caption, center, cite, code, col, colgroup, dd, del, dfn, dl, div, dt, em, font, footer, header, h1, h2, h3, h4, h5, h6, hr, i, img, ins, kbd, label, li, link, meta, nav, ol, p, pre, q, s, samp, sdfield, section, small, span, strike, strong, style, sub, sup, table, thead, tbody, tfoot, td, th, tr, title, tt, u, ul, var\";s:8:\"denyTags\";s:1:\"*\";s:5:\"sword\";s:31:\"<span class=\"ce-sword\">|</span>\";s:9:\"constants\";s:1:\"1\";s:18:\"nonTypoTagStdWrap.\";a:2:{s:10:\"HTMLparser\";s:1:\"1\";s:11:\"HTMLparser.\";a:2:{s:18:\"keepNonMatchedTags\";s:1:\"1\";s:16:\"htmlSpecialChars\";s:1:\"2\";}}}s:14:\"parseFunc_RTE.\";a:10:{s:9:\"makelinks\";s:1:\"1\";s:10:\"makelinks.\";a:2:{s:5:\"http.\";a:2:{s:4:\"keep\";s:4:\"path\";s:9:\"extTarget\";s:6:\"_blank\";}s:7:\"mailto.\";a:1:{s:4:\"keep\";s:4:\"path\";}}s:5:\"tags.\";a:4:{s:4:\"link\";s:4:\"TEXT\";s:5:\"link.\";a:3:{s:7:\"current\";s:1:\"1\";s:9:\"typolink.\";a:2:{s:10:\"parameter.\";a:1:{s:4:\"data\";s:22:\"parameters : allParams\";}s:9:\"extTarget\";s:6:\"_blank\";}s:10:\"parseFunc.\";a:1:{s:9:\"constants\";s:1:\"1\";}}s:1:\"a\";s:4:\"TEXT\";s:2:\"a.\";a:2:{s:7:\"current\";s:1:\"1\";s:9:\"typolink.\";a:5:{s:10:\"parameter.\";a:1:{s:4:\"data\";s:15:\"parameters:href\";}s:6:\"title.\";a:1:{s:4:\"data\";s:16:\"parameters:title\";}s:11:\"ATagParams.\";a:1:{s:4:\"data\";s:20:\"parameters:allParams\";}s:7:\"target.\";a:1:{s:8:\"ifEmpty.\";a:1:{s:4:\"data\";s:17:\"parameters:target\";}}s:10:\"extTarget.\";a:2:{s:8:\"ifEmpty.\";a:1:{s:8:\"override\";s:6:\"_blank\";}s:9:\"override.\";a:1:{s:4:\"data\";s:17:\"parameters:target\";}}}}}s:9:\"allowTags\";s:392:\"a, abbr, acronym, address, article, aside, b, bdo, big, blockquote, br, caption, center, cite, code, col, colgroup, dd, del, dfn, dl, div, dt, em, font, footer, header, h1, h2, h3, h4, h5, h6, hr, i, img, ins, kbd, label, li, link, meta, nav, ol, p, pre, q, s, samp, sdfield, section, small, span, strike, strong, style, sub, sup, table, thead, tbody, tfoot, td, th, tr, title, tt, u, ul, var\";s:8:\"denyTags\";s:1:\"*\";s:5:\"sword\";s:31:\"<span class=\"ce-sword\">|</span>\";s:9:\"constants\";s:1:\"1\";s:18:\"nonTypoTagStdWrap.\";a:3:{s:10:\"HTMLparser\";s:1:\"1\";s:11:\"HTMLparser.\";a:2:{s:18:\"keepNonMatchedTags\";s:1:\"1\";s:16:\"htmlSpecialChars\";s:1:\"2\";}s:12:\"encapsLines.\";a:4:{s:13:\"encapsTagList\";s:29:\"p,pre,h1,h2,h3,h4,h5,h6,hr,dt\";s:9:\"remapTag.\";a:1:{s:3:\"DIV\";s:1:\"P\";}s:13:\"nonWrappedTag\";s:1:\"P\";s:17:\"innerStdWrap_all.\";a:1:{s:7:\"ifBlank\";s:6:\"&nbsp;\";}}}s:14:\"externalBlocks\";s:89:\"article, aside, blockquote, div, dd, dl, footer, header, nav, ol, section, table, ul, pre\";s:15:\"externalBlocks.\";a:14:{s:3:\"ol.\";a:2:{s:7:\"stripNL\";s:1:\"1\";s:8:\"stdWrap.\";a:1:{s:9:\"parseFunc\";s:15:\"< lib.parseFunc\";}}s:3:\"ul.\";a:2:{s:7:\"stripNL\";s:1:\"1\";s:8:\"stdWrap.\";a:1:{s:9:\"parseFunc\";s:15:\"< lib.parseFunc\";}}s:4:\"pre.\";a:1:{s:8:\"stdWrap.\";a:1:{s:10:\"parseFunc.\";a:8:{s:9:\"makelinks\";s:1:\"1\";s:10:\"makelinks.\";a:2:{s:5:\"http.\";a:2:{s:4:\"keep\";s:4:\"path\";s:9:\"extTarget\";s:6:\"_blank\";}s:7:\"mailto.\";a:1:{s:4:\"keep\";s:4:\"path\";}}s:5:\"tags.\";a:4:{s:4:\"link\";s:4:\"TEXT\";s:5:\"link.\";a:3:{s:7:\"current\";s:1:\"1\";s:9:\"typolink.\";a:2:{s:10:\"parameter.\";a:1:{s:4:\"data\";s:22:\"parameters : allParams\";}s:9:\"extTarget\";s:6:\"_blank\";}s:10:\"parseFunc.\";a:1:{s:9:\"constants\";s:1:\"1\";}}s:1:\"a\";s:4:\"TEXT\";s:2:\"a.\";a:2:{s:7:\"current\";s:1:\"1\";s:9:\"typolink.\";a:5:{s:10:\"parameter.\";a:1:{s:4:\"data\";s:15:\"parameters:href\";}s:6:\"title.\";a:1:{s:4:\"data\";s:16:\"parameters:title\";}s:11:\"ATagParams.\";a:1:{s:4:\"data\";s:20:\"parameters:allParams\";}s:7:\"target.\";a:1:{s:8:\"ifEmpty.\";a:1:{s:4:\"data\";s:17:\"parameters:target\";}}s:10:\"extTarget.\";a:2:{s:8:\"ifEmpty.\";a:1:{s:8:\"override\";s:6:\"_blank\";}s:9:\"override.\";a:1:{s:4:\"data\";s:17:\"parameters:target\";}}}}}s:9:\"allowTags\";s:392:\"a, abbr, acronym, address, article, aside, b, bdo, big, blockquote, br, caption, center, cite, code, col, colgroup, dd, del, dfn, dl, div, dt, em, font, footer, header, h1, h2, h3, h4, h5, h6, hr, i, img, ins, kbd, label, li, link, meta, nav, ol, p, pre, q, s, samp, sdfield, section, small, span, strike, strong, style, sub, sup, table, thead, tbody, tfoot, td, th, tr, title, tt, u, ul, var\";s:8:\"denyTags\";s:1:\"*\";s:5:\"sword\";s:31:\"<span class=\"ce-sword\">|</span>\";s:9:\"constants\";s:1:\"1\";s:18:\"nonTypoTagStdWrap.\";a:2:{s:10:\"HTMLparser\";s:1:\"1\";s:11:\"HTMLparser.\";a:2:{s:18:\"keepNonMatchedTags\";s:1:\"1\";s:16:\"htmlSpecialChars\";s:1:\"2\";}}}}}s:6:\"table.\";a:4:{s:7:\"stripNL\";s:1:\"1\";s:8:\"stdWrap.\";a:2:{s:10:\"HTMLparser\";s:1:\"1\";s:11:\"HTMLparser.\";a:2:{s:5:\"tags.\";a:1:{s:6:\"table.\";a:1:{s:10:\"fixAttrib.\";a:1:{s:6:\"class.\";a:3:{s:7:\"default\";s:12:\"contenttable\";s:6:\"always\";s:1:\"1\";s:4:\"list\";s:12:\"contenttable\";}}}}s:18:\"keepNonMatchedTags\";s:1:\"1\";}}s:14:\"HTMLtableCells\";s:1:\"1\";s:15:\"HTMLtableCells.\";a:2:{s:8:\"default.\";a:1:{s:8:\"stdWrap.\";a:2:{s:9:\"parseFunc\";s:19:\"< lib.parseFunc_RTE\";s:10:\"parseFunc.\";a:1:{s:18:\"nonTypoTagStdWrap.\";a:1:{s:12:\"encapsLines.\";a:1:{s:13:\"nonWrappedTag\";s:0:\"\";}}}}}s:25:\"addChr10BetweenParagraphs\";s:1:\"1\";}}s:4:\"div.\";a:2:{s:7:\"stripNL\";s:1:\"1\";s:13:\"callRecursive\";s:1:\"1\";}s:8:\"article.\";a:2:{s:7:\"stripNL\";s:1:\"1\";s:13:\"callRecursive\";s:1:\"1\";}s:6:\"aside.\";a:2:{s:7:\"stripNL\";s:1:\"1\";s:13:\"callRecursive\";s:1:\"1\";}s:11:\"blockquote.\";a:2:{s:7:\"stripNL\";s:1:\"1\";s:13:\"callRecursive\";s:1:\"1\";}s:7:\"footer.\";a:2:{s:7:\"stripNL\";s:1:\"1\";s:13:\"callRecursive\";s:1:\"1\";}s:7:\"header.\";a:2:{s:7:\"stripNL\";s:1:\"1\";s:13:\"callRecursive\";s:1:\"1\";}s:4:\"nav.\";a:2:{s:7:\"stripNL\";s:1:\"1\";s:13:\"callRecursive\";s:1:\"1\";}s:8:\"section.\";a:2:{s:7:\"stripNL\";s:1:\"1\";s:13:\"callRecursive\";s:1:\"1\";}s:3:\"dl.\";a:2:{s:7:\"stripNL\";s:1:\"1\";s:13:\"callRecursive\";s:1:\"1\";}s:3:\"dd.\";a:2:{s:7:\"stripNL\";s:1:\"1\";s:13:\"callRecursive\";s:1:\"1\";}}}s:9:\"thrating.\";a:2:{s:17:\"ratingInstanceUrl\";s:3:\"COA\";s:18:\"ratingInstanceUrl.\";a:6:{i:1;s:4:\"TEXT\";s:2:\"1.\";a:1:{s:4:\"data\";s:31:\"getIndpEnv:TYPO3_REQUEST_SCRIPT\";}i:2;s:4:\"TEXT\";s:2:\"2.\";a:1:{s:5:\"value\";s:4:\"?id=\";}i:3;s:4:\"TEXT\";s:2:\"3.\";a:1:{s:4:\"data\";s:7:\"TSFE:id\";}}}}s:5:\"page.\";a:6:{s:20:\"includeJSFooterlibs.\";a:2:{s:6:\"jquery\";s:58:\"//ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js\";s:7:\"jquery.\";a:3:{s:10:\"compressed\";s:1:\"1\";s:8:\"external\";s:1:\"1\";s:10:\"forceOnTop\";s:1:\"1\";}}s:16:\"includeJSFooter.\";a:4:{s:16:\"jQueryFormPlugin\";s:60:\"EXT:th_rating/Resources/Public/JavaScript/jquery.form.min.js\";s:17:\"jQueryFormPlugin.\";a:1:{s:5:\"async\";s:1:\"0\";}s:7:\"actions\";s:52:\"EXT:th_rating/Resources/Public/JavaScript/actions.js\";s:8:\"actions.\";a:1:{s:5:\"async\";s:1:\"0\";}}s:11:\"includeCSS.\";a:2:{s:11:\"thRatingdyn\";s:25:\"typo3temp/thratingDyn.css\";s:8:\"thRating\";s:45:\"EXT:th_rating/Resources/Public/Css/styles.css\";}i:1288250055;s:4:\"USER\";s:11:\"1288250055.\";a:15:{s:8:\"userFunc\";s:37:\"TYPO3\\CMS\\Extbase\\Core\\Bootstrap->run\";s:10:\"pluginName\";s:3:\"Pi1\";s:13:\"extensionName\";s:8:\"ThRating\";s:10:\"vendorName\";s:6:\"Thucke\";s:10:\"controller\";s:4:\"Vote\";s:4:\"mvc.\";a:1:{s:39:\"callDefaultActionIfActionCantBeResolved\";s:1:\"1\";}s:17:\"feUsersStoragePid\";s:1:\"2\";s:10:\"storagePid\";s:1:\"2\";s:28:\"switchableControllerActions.\";a:1:{s:5:\"Vote.\";a:8:{i:1;s:9:\"singleton\";i:2;s:7:\"polling\";i:3;s:4:\"mark\";i:4;s:5:\"index\";i:5;s:4:\"show\";i:6;s:6:\"create\";i:7;s:3:\"new\";i:8;s:9:\"singleton\";}}s:9:\"settings.\";a:11:{s:7:\"display\";s:5:\"stars\";s:24:\"showMissingStepconfError\";s:1:\"0\";s:12:\"showNoFEUser\";s:1:\"0\";s:12:\"mapAnonymous\";s:1:\"0\";s:14:\"cookieLifetime\";s:1:\"0\";s:13:\"ratingContext\";s:14:\"defaultContext\";s:27:\"defaultRatingConfiguration.\";a:3:{s:11:\"ratinglinks\";s:5:\"stars\";s:7:\"polling\";s:7:\"polling\";s:4:\"mark\";s:11:\"smileyLikes\";}s:8:\"logging.\";a:8:{s:10:\"emergency.\";a:2:{s:4:\"file\";s:27:\"typo3temp/logs/ThRating.log\";s:5:\"table\";s:7:\"sys_log\";}s:6:\"alert.\";a:1:{s:5:\"table\";s:7:\"sys_log\";}s:9:\"critical.\";a:1:{s:5:\"table\";s:7:\"sys_log\";}s:6:\"error.\";a:1:{s:5:\"table\";s:7:\"sys_log\";}s:8:\"warning.\";a:0:{}s:7:\"notice.\";a:0:{}s:5:\"info.\";a:0:{}s:6:\"debug.\";a:0:{}}s:6:\"fluid.\";a:3:{s:8:\"layouts.\";a:1:{s:8:\"default.\";a:3:{s:11:\"showSummary\";s:1:\"0\";s:16:\"showCurrentRates\";s:1:\"1\";s:18:\"showSectionContent\";s:1:\"1\";}}s:10:\"templates.\";a:1:{s:12:\"ratinglinks.\";a:2:{s:9:\"likesMode\";s:1:\"0\";s:8:\"tooltips\";s:1:\"0\";}}s:9:\"partials.\";a:2:{s:12:\"usersRating.\";a:2:{s:12:\"showTextInfo\";s:1:\"1\";s:15:\"showGraphicInfo\";s:1:\"0\";}s:10:\"infoBlock.\";a:1:{s:18:\"showAnonymousVotes\";s:1:\"1\";}}}s:14:\"defaultObject.\";a:3:{s:9:\"ratetable\";s:10:\"tt_content\";s:9:\"ratefield\";s:3:\"uid\";s:18:\"richSnippetFields.\";a:2:{s:4:\"name\";s:6:\"header\";s:11:\"description\";s:8:\"bodytext\";}}s:21:\"ratingConfigurations.\";a:7:{s:20:\"exampleRatingConfig.\";a:5:{s:9:\"imagefile\";s:59:\"typo3conf/ext/th_rating/Resources/Public/Css/rating_bar.png\";s:8:\"barimage\";s:1:\"1\";s:4:\"tilt\";s:1:\"0\";s:9:\"settings.\";a:5:{s:12:\"showNoFEUser\";s:1:\"1\";s:12:\"showNotRated\";s:1:\"1\";s:12:\"mapAnonymous\";s:1:\"0\";s:11:\"displayOnly\";s:1:\"0\";s:14:\"cookieLifetime\";s:1:\"0\";}s:6:\"fluid.\";a:3:{s:8:\"layouts.\";a:1:{s:8:\"default.\";a:3:{s:11:\"showSummary\";s:1:\"1\";s:16:\"showCurrentRates\";s:1:\"1\";s:18:\"showSectionContent\";s:1:\"1\";}}s:10:\"templates.\";a:1:{s:12:\"ratinglinks.\";a:2:{s:9:\"likesMode\";s:1:\"0\";s:8:\"tooltips\";s:1:\"1\";}}s:9:\"partials.\";a:2:{s:12:\"usersRating.\";a:2:{s:12:\"showTextInfo\";s:1:\"1\";s:15:\"showGraphicInfo\";s:1:\"0\";}s:10:\"infoBlock.\";a:1:{s:18:\"showAnonymousVotes\";s:1:\"1\";}}}}s:6:\"stars.\";a:3:{s:9:\"imagefile\";s:54:\"typo3conf/ext/th_rating/Resources/Public/Css/stars.gif\";s:8:\"barimage\";s:1:\"0\";s:4:\"tilt\";s:1:\"0\";}s:10:\"starsTilt.\";a:3:{s:9:\"imagefile\";s:58:\"typo3conf/ext/th_rating/Resources/Public/Css/starsTilt.gif\";s:8:\"barimage\";s:1:\"0\";s:4:\"tilt\";s:1:\"1\";}s:13:\"facesbartilt.\";a:3:{s:9:\"imagefile\";s:61:\"typo3conf/ext/th_rating/Resources/Public/Css/facesbarTilt.gif\";s:8:\"barimage\";s:1:\"1\";s:4:\"tilt\";s:1:\"1\";}s:10:\"barrating.\";a:3:{s:9:\"imagefile\";s:59:\"typo3conf/ext/th_rating/Resources/Public/Css/rating_bar.png\";s:8:\"barimage\";s:1:\"1\";s:4:\"tilt\";s:1:\"0\";}s:12:\"smileyLikes.\";a:5:{s:9:\"imagefile\";s:55:\"typo3conf/ext/th_rating/Resources/Public/Css/smiley.gif\";s:8:\"barimage\";s:1:\"0\";s:4:\"tilt\";s:1:\"0\";s:9:\"settings.\";a:3:{s:12:\"showNoFEUser\";s:1:\"0\";s:12:\"showNotRated\";s:1:\"0\";s:14:\"cookieLifetime\";s:3:\"365\";}s:6:\"fluid.\";a:3:{s:8:\"layouts.\";a:1:{s:8:\"default.\";a:3:{s:11:\"showSummary\";s:1:\"0\";s:16:\"showCurrentRates\";s:1:\"0\";s:18:\"showSectionContent\";s:1:\"1\";}}s:10:\"templates.\";a:1:{s:12:\"ratinglinks.\";a:2:{s:9:\"likesMode\";s:1:\"1\";s:8:\"tooltips\";s:1:\"0\";}}s:9:\"partials.\";a:2:{s:12:\"usersRating.\";a:2:{s:12:\"showTextInfo\";s:1:\"0\";s:15:\"showGraphicInfo\";s:1:\"1\";}s:10:\"infoBlock.\";a:1:{s:18:\"showAnonymousVotes\";s:1:\"0\";}}}}s:8:\"polling.\";a:3:{s:9:\"imagefile\";s:56:\"typo3conf/ext/th_rating/Resources/Public/Css/polling.png\";s:8:\"barimage\";s:1:\"0\";s:4:\"tilt\";s:1:\"0\";}}}s:8:\"ratings.\";a:1:{s:20:\"exampleRatingConfig.\";a:5:{s:9:\"imagefile\";s:59:\"typo3conf/ext/th_rating/Resources/Public/Css/rating_bar.png\";s:8:\"barimage\";s:1:\"1\";s:4:\"tilt\";s:1:\"0\";s:9:\"settings.\";a:5:{s:12:\"showNoFEUser\";s:1:\"1\";s:12:\"showNotRated\";s:1:\"1\";s:12:\"mapAnonymous\";s:1:\"0\";s:11:\"displayOnly\";s:1:\"0\";s:14:\"cookieLifetime\";s:1:\"0\";}s:6:\"fluid.\";a:3:{s:8:\"layouts.\";a:1:{s:8:\"default.\";a:3:{s:11:\"showSummary\";s:1:\"1\";s:16:\"showCurrentRates\";s:1:\"1\";s:18:\"showSectionContent\";s:1:\"1\";}}s:10:\"templates.\";a:1:{s:12:\"ratinglinks.\";a:2:{s:9:\"likesMode\";s:1:\"0\";s:8:\"tooltips\";s:1:\"1\";}}s:9:\"partials.\";a:2:{s:12:\"usersRating.\";a:2:{s:12:\"showTextInfo\";s:1:\"1\";s:15:\"showGraphicInfo\";s:1:\"0\";}s:10:\"infoBlock.\";a:1:{s:18:\"showAnonymousVotes\";s:1:\"1\";}}}}}s:12:\"persistence.\";a:3:{s:10:\"storagePid\";s:1:\"2\";s:8:\"classes.\";a:1:{s:42:\"Thucke\\ThRating\\Domain\\Model\\Ratingobject.\";a:1:{s:19:\"newRecordStoragePid\";s:1:\"2\";}}s:27:\"enhancedLazyLoadingStrategy\";s:1:\"0\";}s:5:\"view.\";a:3:{s:18:\"templateRootPaths.\";a:1:{i:0;s:42:\"EXT:th_rating/Resources/Private/Templates/\";}s:17:\"partialRootPaths.\";a:1:{i:0;s:41:\"EXT:th_rating/Resources/Private/Partials/\";}s:16:\"layoutRootPaths.\";a:1:{i:0;s:40:\"EXT:th_rating/Resources/Private/Layouts/\";}}s:12:\"_LOCAL_LANG.\";a:1:{s:8:\"default.\";a:1:{s:9:\"read_more\";s:7:\"more >>\";}}s:6:\"action\";s:9:\"singleton\";}i:100;s:20:\"< styles.content.get\";}s:13:\"thrating_ajax\";s:4:\"PAGE\";s:14:\"thrating_ajax.\";a:4:{s:7:\"typeNum\";s:10:\"1349058974\";s:7:\"config.\";a:5:{s:20:\"disableAllHeaderCode\";s:1:\"1\";s:8:\"no_cache\";s:1:\"1\";s:8:\"admPanel\";s:1:\"0\";s:5:\"debug\";s:1:\"1\";s:11:\"metaCharset\";s:5:\"utf-8\";}i:10;s:4:\"USER\";s:3:\"10.\";a:14:{s:8:\"userFunc\";s:37:\"TYPO3\\CMS\\Extbase\\Core\\Bootstrap->run\";s:10:\"pluginName\";s:3:\"Pi1\";s:13:\"extensionName\";s:8:\"ThRating\";s:10:\"vendorName\";s:6:\"Thucke\";s:10:\"controller\";s:4:\"Vote\";s:4:\"mvc.\";a:1:{s:39:\"callDefaultActionIfActionCantBeResolved\";s:1:\"1\";}s:17:\"feUsersStoragePid\";s:1:\"2\";s:10:\"storagePid\";s:1:\"2\";s:28:\"switchableControllerActions.\";a:1:{s:5:\"Vote.\";a:8:{i:1;s:11:\"ratinglinks\";i:2;s:7:\"polling\";i:3;s:4:\"mark\";i:4;s:5:\"index\";i:5;s:4:\"show\";i:6;s:6:\"create\";i:7;s:3:\"new\";i:8;s:9:\"singleton\";}}s:9:\"settings.\";a:11:{s:7:\"display\";s:5:\"stars\";s:24:\"showMissingStepconfError\";s:1:\"0\";s:12:\"showNoFEUser\";s:1:\"0\";s:12:\"mapAnonymous\";s:1:\"0\";s:14:\"cookieLifetime\";s:1:\"0\";s:13:\"ratingContext\";s:14:\"defaultContext\";s:27:\"defaultRatingConfiguration.\";a:3:{s:11:\"ratinglinks\";s:5:\"stars\";s:7:\"polling\";s:7:\"polling\";s:4:\"mark\";s:11:\"smileyLikes\";}s:8:\"logging.\";a:8:{s:10:\"emergency.\";a:2:{s:4:\"file\";s:27:\"typo3temp/logs/ThRating.log\";s:5:\"table\";s:7:\"sys_log\";}s:6:\"alert.\";a:1:{s:5:\"table\";s:7:\"sys_log\";}s:9:\"critical.\";a:1:{s:5:\"table\";s:7:\"sys_log\";}s:6:\"error.\";a:1:{s:5:\"table\";s:7:\"sys_log\";}s:8:\"warning.\";a:0:{}s:7:\"notice.\";a:0:{}s:5:\"info.\";a:0:{}s:6:\"debug.\";a:0:{}}s:6:\"fluid.\";a:3:{s:8:\"layouts.\";a:1:{s:8:\"default.\";a:3:{s:11:\"showSummary\";s:1:\"0\";s:16:\"showCurrentRates\";s:1:\"1\";s:18:\"showSectionContent\";s:1:\"1\";}}s:10:\"templates.\";a:1:{s:12:\"ratinglinks.\";a:2:{s:9:\"likesMode\";s:1:\"0\";s:8:\"tooltips\";s:1:\"0\";}}s:9:\"partials.\";a:2:{s:12:\"usersRating.\";a:2:{s:12:\"showTextInfo\";s:1:\"1\";s:15:\"showGraphicInfo\";s:1:\"0\";}s:10:\"infoBlock.\";a:1:{s:18:\"showAnonymousVotes\";s:1:\"1\";}}}s:14:\"defaultObject.\";a:3:{s:9:\"ratetable\";s:10:\"tt_content\";s:9:\"ratefield\";s:3:\"uid\";s:18:\"richSnippetFields.\";a:2:{s:4:\"name\";s:6:\"header\";s:11:\"description\";s:8:\"bodytext\";}}s:21:\"ratingConfigurations.\";a:7:{s:20:\"exampleRatingConfig.\";a:5:{s:9:\"imagefile\";s:59:\"typo3conf/ext/th_rating/Resources/Public/Css/rating_bar.png\";s:8:\"barimage\";s:1:\"1\";s:4:\"tilt\";s:1:\"0\";s:9:\"settings.\";a:5:{s:12:\"showNoFEUser\";s:1:\"1\";s:12:\"showNotRated\";s:1:\"1\";s:12:\"mapAnonymous\";s:1:\"0\";s:11:\"displayOnly\";s:1:\"0\";s:14:\"cookieLifetime\";s:1:\"0\";}s:6:\"fluid.\";a:3:{s:8:\"layouts.\";a:1:{s:8:\"default.\";a:3:{s:11:\"showSummary\";s:1:\"1\";s:16:\"showCurrentRates\";s:1:\"1\";s:18:\"showSectionContent\";s:1:\"1\";}}s:10:\"templates.\";a:1:{s:12:\"ratinglinks.\";a:2:{s:9:\"likesMode\";s:1:\"0\";s:8:\"tooltips\";s:1:\"1\";}}s:9:\"partials.\";a:2:{s:12:\"usersRating.\";a:2:{s:12:\"showTextInfo\";s:1:\"1\";s:15:\"showGraphicInfo\";s:1:\"0\";}s:10:\"infoBlock.\";a:1:{s:18:\"showAnonymousVotes\";s:1:\"1\";}}}}s:6:\"stars.\";a:3:{s:9:\"imagefile\";s:54:\"typo3conf/ext/th_rating/Resources/Public/Css/stars.gif\";s:8:\"barimage\";s:1:\"0\";s:4:\"tilt\";s:1:\"0\";}s:10:\"starsTilt.\";a:3:{s:9:\"imagefile\";s:58:\"typo3conf/ext/th_rating/Resources/Public/Css/starsTilt.gif\";s:8:\"barimage\";s:1:\"0\";s:4:\"tilt\";s:1:\"1\";}s:13:\"facesbartilt.\";a:3:{s:9:\"imagefile\";s:61:\"typo3conf/ext/th_rating/Resources/Public/Css/facesbarTilt.gif\";s:8:\"barimage\";s:1:\"1\";s:4:\"tilt\";s:1:\"1\";}s:10:\"barrating.\";a:3:{s:9:\"imagefile\";s:59:\"typo3conf/ext/th_rating/Resources/Public/Css/rating_bar.png\";s:8:\"barimage\";s:1:\"1\";s:4:\"tilt\";s:1:\"0\";}s:12:\"smileyLikes.\";a:5:{s:9:\"imagefile\";s:55:\"typo3conf/ext/th_rating/Resources/Public/Css/smiley.gif\";s:8:\"barimage\";s:1:\"0\";s:4:\"tilt\";s:1:\"0\";s:9:\"settings.\";a:3:{s:12:\"showNoFEUser\";s:1:\"0\";s:12:\"showNotRated\";s:1:\"0\";s:14:\"cookieLifetime\";s:3:\"365\";}s:6:\"fluid.\";a:3:{s:8:\"layouts.\";a:1:{s:8:\"default.\";a:3:{s:11:\"showSummary\";s:1:\"0\";s:16:\"showCurrentRates\";s:1:\"0\";s:18:\"showSectionContent\";s:1:\"1\";}}s:10:\"templates.\";a:1:{s:12:\"ratinglinks.\";a:2:{s:9:\"likesMode\";s:1:\"1\";s:8:\"tooltips\";s:1:\"0\";}}s:9:\"partials.\";a:2:{s:12:\"usersRating.\";a:2:{s:12:\"showTextInfo\";s:1:\"0\";s:15:\"showGraphicInfo\";s:1:\"1\";}s:10:\"infoBlock.\";a:1:{s:18:\"showAnonymousVotes\";s:1:\"0\";}}}}s:8:\"polling.\";a:3:{s:9:\"imagefile\";s:56:\"typo3conf/ext/th_rating/Resources/Public/Css/polling.png\";s:8:\"barimage\";s:1:\"0\";s:4:\"tilt\";s:1:\"0\";}}}s:8:\"ratings.\";a:1:{s:20:\"exampleRatingConfig.\";a:5:{s:9:\"imagefile\";s:59:\"typo3conf/ext/th_rating/Resources/Public/Css/rating_bar.png\";s:8:\"barimage\";s:1:\"1\";s:4:\"tilt\";s:1:\"0\";s:9:\"settings.\";a:5:{s:12:\"showNoFEUser\";s:1:\"1\";s:12:\"showNotRated\";s:1:\"1\";s:12:\"mapAnonymous\";s:1:\"0\";s:11:\"displayOnly\";s:1:\"0\";s:14:\"cookieLifetime\";s:1:\"0\";}s:6:\"fluid.\";a:3:{s:8:\"layouts.\";a:1:{s:8:\"default.\";a:3:{s:11:\"showSummary\";s:1:\"1\";s:16:\"showCurrentRates\";s:1:\"1\";s:18:\"showSectionContent\";s:1:\"1\";}}s:10:\"templates.\";a:1:{s:12:\"ratinglinks.\";a:2:{s:9:\"likesMode\";s:1:\"0\";s:8:\"tooltips\";s:1:\"1\";}}s:9:\"partials.\";a:2:{s:12:\"usersRating.\";a:2:{s:12:\"showTextInfo\";s:1:\"1\";s:15:\"showGraphicInfo\";s:1:\"0\";}s:10:\"infoBlock.\";a:1:{s:18:\"showAnonymousVotes\";s:1:\"1\";}}}}}s:12:\"persistence.\";a:3:{s:10:\"storagePid\";s:1:\"2\";s:8:\"classes.\";a:1:{s:42:\"Thucke\\ThRating\\Domain\\Model\\Ratingobject.\";a:1:{s:19:\"newRecordStoragePid\";s:1:\"2\";}}s:27:\"enhancedLazyLoadingStrategy\";s:1:\"0\";}s:5:\"view.\";a:3:{s:18:\"templateRootPaths.\";a:1:{i:0;s:42:\"EXT:th_rating/Resources/Private/Templates/\";}s:17:\"partialRootPaths.\";a:1:{i:0;s:41:\"EXT:th_rating/Resources/Private/Partials/\";}s:16:\"layoutRootPaths.\";a:1:{i:0;s:40:\"EXT:th_rating/Resources/Private/Layouts/\";}}s:12:\"_LOCAL_LANG.\";a:1:{s:8:\"default.\";a:1:{s:9:\"read_more\";s:7:\"more >>\";}}}}s:23:\"fluidAjaxWidgetResponse\";s:4:\"PAGE\";s:24:\"fluidAjaxWidgetResponse.\";a:4:{s:7:\"typeNum\";s:4:\"7076\";s:7:\"config.\";a:4:{s:8:\"no_cache\";s:1:\"1\";s:20:\"disableAllHeaderCode\";s:1:\"1\";s:18:\"additionalHeaders.\";a:1:{s:3:\"10.\";a:2:{s:6:\"header\";s:24:\"Content-Type: text/plain\";s:7:\"replace\";s:1:\"1\";}}s:5:\"debug\";s:1:\"0\";}i:10;s:8:\"USER_INT\";s:3:\"10.\";a:1:{s:8:\"userFunc\";s:42:\"TYPO3\\CMS\\Fluid\\Core\\Widget\\Bootstrap->run\";}}s:4:\"page\";s:4:\"PAGE\";s:9:\"sitetitle\";s:22:\"New TYPO3 Console site\";s:6:\"types.\";a:3:{i:1349058974;s:13:\"thrating_ajax\";i:7076;s:23:\"fluidAjaxWidgetResponse\";i:0;s:4:\"page\";}}}'),(3,'1ae8972c1b639a1a14ed8dd9019e47b0',2145909600,'a:1:{s:32:\"ffb7c399fe1d1c6c494fdaf47b419bd4\";s:8:\"[1 == 1]\";}'),(5,'1ec8f63a9ef0161106cdb7dabfbb3eae',1617699020,'a:1:{i:0;a:3:{s:11:\"doNotLinkIt\";s:1:\"1\";s:14:\"wrapItemAndSub\";s:3:\"{|}\";s:8:\"stdWrap.\";a:2:{s:7:\"cObject\";s:3:\"COA\";s:8:\"cObject.\";a:25:{i:1;s:13:\"LOAD_REGISTER\";s:2:\"1.\";a:1:{s:11:\"languageId.\";a:2:{s:7:\"cObject\";s:4:\"TEXT\";s:8:\"cObject.\";a:2:{s:6:\"value.\";a:1:{s:4:\"data\";s:24:\"register:languages_HMENU\";}s:8:\"listNum.\";a:2:{s:8:\"stdWrap.\";a:2:{s:4:\"data\";s:28:\"register:count_HMENU_MENUOBJ\";s:4:\"wrap\";s:3:\"|-1\";}s:9:\"splitChar\";s:1:\",\";}}}}i:10;s:4:\"TEXT\";s:3:\"10.\";a:2:{s:8:\"stdWrap.\";a:1:{s:4:\"data\";s:19:\"register:languageId\";}s:4:\"wrap\";s:14:\"\"languageId\":|\";}i:11;s:4:\"USER\";s:3:\"11.\";a:4:{s:8:\"userFunc\";s:71:\"TYPO3\\CMS\\Frontend\\DataProcessing\\LanguageMenuProcessor->getFieldAsJson\";s:9:\"language.\";a:1:{s:4:\"data\";s:19:\"register:languageId\";}s:5:\"field\";s:6:\"locale\";s:8:\"stdWrap.\";a:1:{s:4:\"wrap\";s:11:\",\"locale\":|\";}}i:20;s:4:\"USER\";s:3:\"20.\";a:4:{s:8:\"userFunc\";s:71:\"TYPO3\\CMS\\Frontend\\DataProcessing\\LanguageMenuProcessor->getFieldAsJson\";s:9:\"language.\";a:1:{s:4:\"data\";s:19:\"register:languageId\";}s:5:\"field\";s:5:\"title\";s:8:\"stdWrap.\";a:1:{s:4:\"wrap\";s:10:\",\"title\":|\";}}i:21;s:4:\"USER\";s:3:\"21.\";a:4:{s:8:\"userFunc\";s:71:\"TYPO3\\CMS\\Frontend\\DataProcessing\\LanguageMenuProcessor->getFieldAsJson\";s:9:\"language.\";a:1:{s:4:\"data\";s:19:\"register:languageId\";}s:5:\"field\";s:15:\"navigationTitle\";s:8:\"stdWrap.\";a:1:{s:4:\"wrap\";s:20:\",\"navigationTitle\":|\";}}i:22;s:4:\"USER\";s:3:\"22.\";a:4:{s:8:\"userFunc\";s:71:\"TYPO3\\CMS\\Frontend\\DataProcessing\\LanguageMenuProcessor->getFieldAsJson\";s:9:\"language.\";a:1:{s:4:\"data\";s:19:\"register:languageId\";}s:5:\"field\";s:16:\"twoLetterIsoCode\";s:8:\"stdWrap.\";a:1:{s:4:\"wrap\";s:21:\",\"twoLetterIsoCode\":|\";}}i:23;s:4:\"USER\";s:3:\"23.\";a:4:{s:8:\"userFunc\";s:71:\"TYPO3\\CMS\\Frontend\\DataProcessing\\LanguageMenuProcessor->getFieldAsJson\";s:9:\"language.\";a:1:{s:4:\"data\";s:19:\"register:languageId\";}s:5:\"field\";s:8:\"hreflang\";s:8:\"stdWrap.\";a:1:{s:4:\"wrap\";s:13:\",\"hreflang\":|\";}}i:24;s:4:\"USER\";s:3:\"24.\";a:4:{s:8:\"userFunc\";s:71:\"TYPO3\\CMS\\Frontend\\DataProcessing\\LanguageMenuProcessor->getFieldAsJson\";s:9:\"language.\";a:1:{s:4:\"data\";s:19:\"register:languageId\";}s:5:\"field\";s:9:\"direction\";s:8:\"stdWrap.\";a:1:{s:4:\"wrap\";s:14:\",\"direction\":|\";}}i:90;s:4:\"TEXT\";s:3:\"90.\";a:2:{s:5:\"value\";s:21:\"###LINKPLACEHOLDER###\";s:4:\"wrap\";s:9:\",\"link\":|\";}i:91;s:4:\"TEXT\";s:3:\"91.\";a:2:{s:5:\"value\";s:1:\"1\";s:4:\"wrap\";s:11:\",\"active\":|\";}i:92;s:4:\"TEXT\";s:3:\"92.\";a:2:{s:5:\"value\";s:1:\"0\";s:4:\"wrap\";s:12:\",\"current\":|\";}i:93;s:4:\"TEXT\";s:3:\"93.\";a:2:{s:5:\"value\";s:1:\"1\";s:4:\"wrap\";s:14:\",\"available\":|\";}i:99;s:16:\"RESTORE_REGISTER\";}}}}');
/*!40000 ALTER TABLE `cf_cache_hash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_hash_tags`
--

DROP TABLE IF EXISTS `cf_cache_hash_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_hash_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_hash_tags`
--

LOCK TABLES `cf_cache_hash_tags` WRITE;
/*!40000 ALTER TABLE `cf_cache_hash_tags` DISABLE KEYS */;
INSERT INTO `cf_cache_hash_tags` VALUES (1,'a341977e40078ac89538934c8436cc57','ident_userTS_TSconfig'),(2,'46b26a83740b2dcae6c7196fede5a962','ident_TS_TEMPLATE'),(3,'1ae8972c1b639a1a14ed8dd9019e47b0','ident_TMPL_CONDITIONS_ALL'),(5,'1ec8f63a9ef0161106cdb7dabfbb3eae','ident_MENUDATA');
/*!40000 ALTER TABLE `cf_cache_hash_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_imagesizes`
--

DROP TABLE IF EXISTS `cf_cache_imagesizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_imagesizes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_imagesizes`
--

LOCK TABLES `cf_cache_imagesizes` WRITE;
/*!40000 ALTER TABLE `cf_cache_imagesizes` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_cache_imagesizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_imagesizes_tags`
--

DROP TABLE IF EXISTS `cf_cache_imagesizes_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_imagesizes_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_imagesizes_tags`
--

LOCK TABLES `cf_cache_imagesizes_tags` WRITE;
/*!40000 ALTER TABLE `cf_cache_imagesizes_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_cache_imagesizes_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_pages`
--

DROP TABLE IF EXISTS `cf_cache_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_pages`
--

LOCK TABLES `cf_cache_pages` WRITE;
/*!40000 ALTER TABLE `cf_cache_pages` DISABLE KEYS */;
INSERT INTO `cf_cache_pages` VALUES (3,'redirects',1617616220,'x�K�2���\0O�'),(4,'abc91c46c989c97ffbcf36975f63a82d',1617699020,'x��=�s���k�W�j�7cKZ};N��N��e?K����h�]J�x���l������J�Xrr���t��$@@\0��s�s|P��}���?�yT~ԝ�2�ݚ�h��N��\'��;�����Ug��v��M�ȇ_�A�J\\&�L�i�j���_����:)͒y���!�S���E9H�r)`��E��{i\\�Zμ�Ϟ�y�J�E1O^��d������핞�n8���-�~�K��B��{��}	z����J~/�������Q��=��6\0�J���X��4ry�G�/]��6�?O#6�\"��~� �/�g	��=�<*\rn�f�C��^)�]�P��Խ��:߷�v��>򧳤T�v;{Nթ��d�~����\"��F���Ɍ�Q)�\0�&�&r�(�n���,89\\���T��R$���RI���/�i�����Q����lx~�6&޸�h��j��k�qëV;u�YOj�iA��i����Ѷ0�7���^\rv������w�;��@���[C\ZзO��\'��퓇��������h�59�����wOCF��S���,�ދ�[+�܀���%�$����	K�D���{����i�W-��\Z�G�р���w�|���4��G�_j�\r`��K�������Ѡw}v5���-��;��ٸ����^��xʛ\rs8��p&�\r�IiyQ��W�%���QS���**�\r���9��Kf�[8�[����x\"B�!�b	�L@Ӆ��r)�I�(/E�����DvY�[r7�G����+���y��tϟ�|�|���t<¦?����Vot��N�ݐe��^L&���cV팝I��jQ�^�;n�Og�ZW���iR���3߃=C�ce�\Z�\">�Qģ��?\\k�˥%Rh?�]���R��x�<�Dd#M��Y(3�eh�+�Hi�2�o|VMSܜ��?���2L�^��\'w���Z�UwZ�:w�U�VmV�|2��?oR�)�zg\reM��T$ϳe��`tT�^}Sf���T6T�de]��\0D\\S�U����6��e�ܣ�8\n����6�hw�M�ӭ��l�4:�Z���4ƻ�0������(�yl���$�^f�\\CvWӪ�r5zz�Mq�z��,,��s��^����r���9�6<ީ���Z��-^�W��ۮ�l2�Z�q�R��=�p?�\ru$�\'b�>\r|M���N�F���������|\n�a��7*�M�l�UFN��<������g%��M0(���`��v�%2p#O/q\'�R������X번|�B����;�_�7q��Կ���\r6:���\\?��h�=��v�˔AV�>:W趹̝��V~��oKz`�%��u�M�I�A�,�����J��^�\\�&����\0���c�yP�������}OD��zda���`<cL�Տ��\"�A:��K�X+���%lA��(�1�W�vm�.,�����2��e6I�U��S�� 79a`�1���\rR����ͨ^�x���\\�@/5�Q�p��X������O#�z�9�uJ�\0��ؤ7_��	���@�N�������{S��������}���4�N�Ѝ��lr$����W���\"Xr�M�*U�\0Yi�����d�\0f�q��Rв���j�^�F=�\Z��\0���	�8Dtz�.�IJ�T����&űQ+��1t��/�ǃ��~�/`VIN��l��AdL\r��`����nQB��lY|����yh�\'��Ĩ��VX��e�l�{%��5�c���# \rj�!�Tn��Q���*M@CH��n�H)C��ԪR��Q��p�Aj��ڪ��:���^\Z�G{QR�L��x��Ju�\\t֣��u�%�~��ü�>��M���D\rA�<?��>�\0���1�����z����[���8a؋���v!��|���WH����А-W�X���*������,O�\r��$�G��Qmϱm~D$g���&>|�t�3v%3N��ku��i{�|��k�NC�`�G�a�/\rxlD�5�`D��<M����!w�<@�O������9!Q�tT���C�p@I(B0�� �8�<J���F�p��`�w��w�d$[�����\'\n�\n��\0	g�t8³���� Q̹!dP�\'	�|�珢�ZW\0��T!l���x$7Ѕ�a�B��]@��PۮZL��,�G��A �P\"���)�\0�Zc(H:�`2��֠��3�k�$�)�G������{?�g�7�Y��{���@9\r�@r�����{7ґ����F)��<$��k��-�P-�^ݝ��4�:��n�BT��)�r����2���9�b�F��V�cw��#c�G�#��~Q\r�u�Z�I R�\\I�\'��:����M��~���\0�a������e:�ԛ��ζ~�ʨ)�,I#nqn��8�s�#}\0a{����\\c�FO�{J��Y���\r�\nr���)��v*\"�W�KG�N�-�a��8����G���w���0S��̵�y>�5�Ѽ���\n����M�\\,���ہ�s�ch������;C>_�J�b�2f\'��k�6�ҪR)l�ox���|S~��8w�;.Z[Xx�vnB{��7S|Z�Lv�Fׇ̕�$DrR�q���rO�]P��~�Y\"2Ye$�8{*���Қ./&�8��1Q�-�Yl�H��֪Zι�3����3�N�@��UA��tY��Q����c6O�J��^�P��T�A�Z>�P\'�m���Ju%1���P������s9�l\\��R���e@n1�#�������7�q�Fc��:�f1\n���x*u���n�/����bۓvcT5(Vm4���O�Е�^D���\n��n�b�e��z�0\'��j3\'͊A\n�\r\0�ʯ�::�u-�juDٽ ���\0��A3gaj��� ����]sLI���Ϛ���\"��J P��^Y���o��!������;��2�2�Ҭ�]�m�@�����v�<̈́�Q�#�9�V���y��?�4�Tbn�B��Z�4���\ZE,39<�v��\Z�i�\rk�ר��h��1QGͮ^�n�\Z�;b�\\�Fj����\ZaE\"�j����G�^��M�옺B0��_�k\r��t~-n׉�!�\rsp�(x~d�B딯�I\ng�)r��N,���Rs%�����\"����&�~ݬn}\0m9����|��c`���I��W�S�l\rF�&�4ֆ��5E��5���*�zlwS%����M3�_E��5��_M�(��s�\n�U��������J\rK�����և��*�0בZ��Օ�][HWE��XiT�.F�E�@5k02��܈�&!��Զ���7Ës�\"Z\'J\\V_4�x��� seka�����c�[�oV_�c���yT��Fߤ�BY�%���ں�����k�Ѥ�\"���z-US�:�\"Ǡ�d�l!���܂s�*�	��o�U�9��ͣ��u\'��(dr�M��#UX�ۡrb08�o���	��Sm��B^\0�l��&�Y�F���ǅk$k\n)���\r�$\n�:QaIݤ�.x�(Fz��Sa�5��_�߫`٫Vu!IT֟M��XV��|fWx�G�[\ZW�$��Y����4��Vk�y���D�eKF���d����M��O��x����[�k$�U�>4�@Gֱ���\n{i���u���E�.o��t��o�w.�m7�,b%?y��N���S�B�cj�UК]Y+Mi��!��W`w���{�Ne�6��Z��fx\'נhl8�#r�l7��f*� �JC�,�Y6��B\Z�b�RѢ���\"λ-X��*.�+t0,�����~�g�n���[��6c�(�j�M��Ϫ^h\n�I�7�dC���oS��\"M6ʎ�� ;��x��u+wV_��I��u�vga��i].�Ŀ����um��(\"���̕m��U�v���\r�TSF\n�J�C�+p�(6�����t��sK�\rXVh��To�ݰ�U�z����o��Ƶc7=<��@�c�YNnx򏡄�n\n�xB�DQ�w48�\ZIl�5$�W��#I˝cRG8�5�m�qt֗�k;O�zRl�h��\'�[O\Zek\rI���16;[\"�ԨN�η_\n�!iy<Ьm�%.Bsvq��dk4gs����1ۋף������n�S�Rd1w�\'������I���x�5*:�(�ٛ���;)�p��G,rg�˂����_�^�\r��c�a�s��k>œ�u�EcVdxy}����f�aQPoD��;��:?\Z�jo��*\0_��\0���Ύs(�a �%�/���Z�yj`����!�װ����3\0����lxu�?��^����筠{�\"��SSG^�!n֑�=�tydV�9l�N��\ZN9�6_ȂV��h���&ո��N�TM��z�|S<�_��x\0n��eϰԠ�8����ڵ�%��ea�Z���\rFi�</�u�8��±���4�}&H�t����	G\"�6ަ�����F���0_}\"	MzCy��W�$�\'�U����>�nT1u>-j����r\Z�ǘn���R�}t)F;J̘�k�&�Û9Y��;�y>�m*�%F7rum]\'��0�åթr��@�b ��q	�y�꯱S������_���*a�7g����������.+:9�`�U�xҜ+��x�j��Rq&��|��1I�\ZeƓtp�b�7R2��.7k7c�1͌1KHx��:��t�xI\Z���G��Y�lQ�ȳ ������k�c������M��*��=�}g�����%��d4�\'���X�a��G�囁���$HiJ���(����\0�R�y����I���I32���U颐b�&em�kj*S���zY�99v�T}bns䊂�r�I��u�P��U�I;��I�#Ȭ1/�J�8ӳ:�4���|�*��c&�T�����VM���FY�\\\Z�x5q�+g\\���✂���@��G�}����c����=,0�p8��6<]���!\Z�=�x�yR��/�����ʭ�C��u�`��l\'O�\"u�t?��۾H��(	)o�jȥD_=��҂~*����\nq��s���k��c0D�w������w�Fk��i?R���(0�o�OS}�!�md��=�U$�mdAi��K��r��(CN�>)%X\Z�ҒM$���U8��K�s��C��Q�,��]�K\r�}|)��Éx%���B��E\Z##�&�\'])\'L��r�Z�oql���e���WWW�iJa����D�	��H�����������\'���{�Np��=��v�y ޷���D� ����(X����p��9��zVȐ<��&fY9x��C�~r��-���Z���m�҂��G�.��E��{�\"__��TI˟������a�,c�3��\Z�s_g�:�\\%偈�̫sLGk������D�WW�[�܍����-��Q+!\r,���o��F\"3��dd��8E���b��gu���PO�\'V�wg\'��������{�5e�)��އ �z7��`� U�k�z�t��8j�P/�p(�!�\\m_�P�>3\0k�|�5)�W�ݛ+�I�h�:�nՍ�wL	��Y��l�P	^\"�/�9H�(��k���#��np~���:�n��E����o��8rL�����u�FG���&�U��Մ��}6��S�\\K<��f-�(\nu����c��	-�Zwj-5���u颛A4�q^��-�s�8 B��I�:}�����u��T,����H�_*���:���ct��I�f�)�Z��]_>9D^�x�d,T<�)�f��(Wʕ��T\\��\'����L8��T�M���[d�Py��Z��ʡ���\" 9�Qm�M��Sx�G�\'�SДw\n��{F0�X\rC-y#נ���j�J�0�U��M|\Z��>�1H���� (..�1uuv�����^mc\ršJ�[9\0ZΡ �U��\r&{��+ryR�c��Q���T]�t>��������!�:���rQ�N�<�D�\rc���������}W��uL�C_e�A��w�S|KW�:g�d�3}|؛a�\Z/�e\0�S����� ����z�SC:fa6�x��Gs������](��\Z>N�B���zZ������P�ty��|��(��d�\\�0�f\ZO|U|����,<6H4�O�m����$\Z����@5���X�<�)6\r�X_3|�t?��y���ե�>h��ׅ�Bы0Y�\"Ud{�����cUq�rX\\ϰ����,�kn���:xˀ�٤ot�k.�i��&��b���f�f��l�N�P��~�b�룈���,e�JK5�s�,��&��H�h4����شL�g�Y�8M���\"���\\��ƕ��sa�~%�$���$%�N��Zo�\"��GJ���0!W(�^��=�(US�Nc�]�[M����E�	Vu���1Ēi��5%,�V�O��`l������V�^��-�2���\0�K�h�4�ɚ��.ػ���V�K_���\'���!�Ǚ���*\ZF��kYV�X\\s����,wby9��D�C���%�ǜ��?�.\n����Fȡ�\'��S�Lc�`�X����\nV�o���Ѳ2׃��Ȍ�tz�Y]�C��I����,u�^��z�f:���l��kBͲ�7��Z�a)lM����������G3^[�Bf=�\nM���\n�b���YCb���c��Y����2�a��X���B�z��ݙ2�aVh����0�w͍���QO�ʱ�ʅ��\'��Q��N榵���Y�Q��K�mc�(����3sV�7�l��M��(��8�?���ShW)���WL*`�W�وb&�ĕ�t�l%��+�����m_��@crT�%=B�e��:@|,�ra�a#�Nw���h����嗡<\rk2� ��e툩G�Д��W\"�S_��Փ���11��1�մ���\"����[���FWʟ��r\\0�)�����M��%��?Z��N��H�H9�]UyP��m*b�чx\"�1�\'��	�&V*�0��T�i�����׹,�\0h��R�o�W�p|Q���G�7���zh�+\\��q���Ջ�b{�W(��*^��xm�M�ݘV���<[��hVD)]4��1`�W�9�i�x�6�W��[-̪�d!�WG��[ٺ�\n5�\r07w�kr|n��#��~iebF*�fs-�V�in$�g��o 郱O`Jy�V�y=Z�����bt���𑕃�~oF����\n���N�/��#|�DƝ�9���a��3y�T��Ys7�\"�)><(ܡ��W>�T~nT~!���0:�l@���@�7�������\'��O�\r�Y.�l������o������p��6�!<�a-u7͒CY��߇�C��\r���;\\\Z\0g��\\�.��9U���s���\rd���җ�du�)=�!�����ZhP`�.�9�?���3%n�g�oEZ����H�����?��o�?ƺ���Δ�Y�BmVl��|�;�t�`���Z��c�o/;Pt�*����~�����~�����~�����~���Ŧg�E��N��\n���?�u/��O#	-+:� �\\0?�l���z�G��Cao�+��~���\"⟌C�Ȧ�X���h���tvĤ\"k��L ��r�T����V��������Ї9����5����B��c��O��V4^R��VAA�q��h骘 �N�C,���n�<q�0�G�RX�����Ùe�hl�Q#�DT��2�.��>�԰px�����~�Y0�y�y��Y̬�g�����ZM�q�w�m���p�@��-�����7�U���P11�1=��bu��׏x��UH����F+��\\�`�_>��Tg�<��ҫ\Z�Q�R��!��*���_=��ٿ�C�Y%�a���|	e�j����*��뽢�&�Uv��Z�> ���S9t��~I�[�:�\"������T�@�Sgef1�,	��3j�J�K���\0�)Q��YY>�NT��G��N\rZ��!ڷ���k��w�OQ�6��0Y(��(�5��*�܇��Ǎf�ԩ��\Zq���ޔoFm�0N\0�ˍ� Z�p��16%���E9=�K\0��8��p0/��OTa�`ڛ3$���/5,C9ى�A�c�\r︘�;PZ�R�3��6ˢ�^����l��\'��m�ҏv�QB�@ ��g���2[��T��*H����M�n��:��m�F���v{����/H�ҥtl�J¤q��XW`�1�<����2~9jh��Q�/w��b]����l��Q�=��ޝZ�������S���v�U24��:Ȟ��\n�m!n�%��	;�E�4:o�Aݤj��=kg�V�6������{t�wgp�ȯ&cڸ����}��θ:��BDI�\"1v�|[>�\nvV�$R˫{*ֱ3�>�Ʀs��S��ώ��.���2b�����J�B4֬g[C||q��w��H��O/}i6�������f.�Z��etPi����P��:�:<��iF�H�`;K=_��g@�B���2��{����\ZJg˲U�o�\rV�K3���dA5���Q~�P�7���q�O��u��C�\r��Q�ܤ��|�:�����0Ρ��Ű�eIջ�S��\'�=��w�=\re��,wc̪A�ߞ����Q	O�<�1��Iغ�b��g\rVeݪ2��8V���F��`��f�_�z���	R��^kY�`�m�eW������L�矘�孕ʯ�EAQk��Y��V8첎F`\"/Hx\n���Cr�h\n�\Z�m���j;/�Om�5����bC�9dq�;��A>W[����9���_���\n���t��F!��z��<��Fc�g��NwP�\'m;��lu�UG�����UsZ�~J�|gL�Fa釢�t�O����G��V<��Nk��G�tr��Ethg�#���~~');
/*!40000 ALTER TABLE `cf_cache_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_pages_tags`
--

DROP TABLE IF EXISTS `cf_cache_pages_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_pages_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_pages_tags`
--

LOCK TABLES `cf_cache_pages_tags` WRITE;
/*!40000 ALTER TABLE `cf_cache_pages_tags` DISABLE KEYS */;
INSERT INTO `cf_cache_pages_tags` VALUES (2,'abc91c46c989c97ffbcf36975f63a82d','pageId_1');
/*!40000 ALTER TABLE `cf_cache_pages_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_pagesection`
--

DROP TABLE IF EXISTS `cf_cache_pagesection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_pagesection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_pagesection`
--

LOCK TABLES `cf_cache_pagesection` WRITE;
/*!40000 ALTER TABLE `cf_cache_pagesection` DISABLE KEYS */;
INSERT INTO `cf_cache_pagesection` VALUES (1,'1_222419149',1620049011,'x�Řm��6ǿ���\0!ꋵ�t\'�Uu�J��	p�#l�eS���y��Z��M�|8��翏m�q����p�lI�M;�C\Zfx�9P/�� �7�!\'?L}o�澳�q;�{o�>x8�[ۮ�PYI�\\,^�\r\Z:�X�l��m5]˃�&v>�:��j0^�a��TD���+S�j,?vE�ޮ�����9]W%9\'�woς�� v8��F\r����򜖃rE�+F�0vh����@�c-�J����+��*pދ]�V�H��$�Ե��B�d��Dy`Gg�Y�����%aeƛ\\��5b2�LQ=�ȅhJ���!Ø>�q�ő�I!�q0�JI�\r��N���Q$��)Ż�Z�jq�5��ŀ���a錟+��J첚U��	�Ӛ�G�-Ҏ���`��M��y`�a��I�+�9(�*�}�LS�D�>�v9�@��}��&]prW4�o�bP���(v��{��������&m�Iǁ�U�3�Sb	1����¶�S\"Ǻ�Z���D�^�Q	������\n��۽h��y#i=L}DdF�+S¨R�����ϳ1�D��ݠ����ؿn����rqO���w\r�[5)g�����J q_V1��W��ϵ�N���	�8�^����\Z�#��yS>�����Z�_�2���	\ZZ�\Z�T3�]�9U����s���v8�������|�)_8$��S�h.�_�w�x�B�}d�=%�.\\o.��I�*k� �,4�{�r����Bӻ�v�鑁Мt�q��C#V�~�!��׊���64=>���<��h���JU��R�\"xV���z5����S;��X�x!�/���N.��5흈тe:|��)��\rz��������B�顃f{a4 �t<=��u�D3��ׯU�)�âe}�\\C�)+^�J������U�A�)��l�^�����c2IUs�R��&z�Pݟ(��v��0ʚ');
/*!40000 ALTER TABLE `cf_cache_pagesection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_pagesection_tags`
--

DROP TABLE IF EXISTS `cf_cache_pagesection_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_pagesection_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_pagesection_tags`
--

LOCK TABLES `cf_cache_pagesection_tags` WRITE;
/*!40000 ALTER TABLE `cf_cache_pagesection_tags` DISABLE KEYS */;
INSERT INTO `cf_cache_pagesection_tags` VALUES (1,'1_222419149','pageId_1'),(2,'1_222419149','mpvarHash_222419149');
/*!40000 ALTER TABLE `cf_cache_pagesection_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_rootline`
--

DROP TABLE IF EXISTS `cf_cache_rootline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_rootline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_rootline`
--

LOCK TABLES `cf_cache_rootline` WRITE;
/*!40000 ALTER TABLE `cf_cache_rootline` DISABLE KEYS */;
INSERT INTO `cf_cache_rootline` VALUES (1,'1__0_0',1620049011,'a:1:{i:0;a:23:{s:3:\"pid\";i:0;s:3:\"uid\";i:1;s:9:\"t3ver_oid\";i:0;s:10:\"t3ver_wsid\";i:0;s:11:\"t3ver_state\";i:0;s:5:\"title\";s:4:\"Home\";s:5:\"alias\";s:0:\"\";s:9:\"nav_title\";s:0:\"\";s:5:\"media\";s:0:\"\";s:6:\"layout\";i:0;s:6:\"hidden\";i:0;s:9:\"starttime\";i:0;s:7:\"endtime\";i:0;s:8:\"fe_group\";s:1:\"0\";s:16:\"extendToSubpages\";i:0;s:7:\"doktype\";i:1;s:8:\"TSconfig\";N;s:17:\"tsconfig_includes\";N;s:11:\"is_siteroot\";i:1;s:9:\"mount_pid\";i:0;s:12:\"mount_pid_ol\";i:0;s:13:\"fe_login_mode\";i:0;s:25:\"backend_layout_next_level\";s:0:\"\";}}'),(2,'1__0_-99',1620204624,'a:1:{i:0;a:23:{s:3:\"pid\";i:0;s:3:\"uid\";i:1;s:9:\"t3ver_oid\";i:0;s:10:\"t3ver_wsid\";i:0;s:11:\"t3ver_state\";i:0;s:5:\"title\";s:4:\"Home\";s:5:\"alias\";s:0:\"\";s:9:\"nav_title\";s:0:\"\";s:5:\"media\";s:0:\"\";s:6:\"layout\";i:0;s:6:\"hidden\";i:0;s:9:\"starttime\";i:0;s:7:\"endtime\";i:0;s:8:\"fe_group\";s:1:\"0\";s:16:\"extendToSubpages\";i:0;s:7:\"doktype\";i:1;s:8:\"TSconfig\";N;s:17:\"tsconfig_includes\";N;s:11:\"is_siteroot\";i:1;s:9:\"mount_pid\";i:0;s:12:\"mount_pid_ol\";i:0;s:13:\"fe_login_mode\";i:0;s:25:\"backend_layout_next_level\";s:0:\"\";}}');
/*!40000 ALTER TABLE `cf_cache_rootline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_cache_rootline_tags`
--

DROP TABLE IF EXISTS `cf_cache_rootline_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_cache_rootline_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_cache_rootline_tags`
--

LOCK TABLES `cf_cache_rootline_tags` WRITE;
/*!40000 ALTER TABLE `cf_cache_rootline_tags` DISABLE KEYS */;
INSERT INTO `cf_cache_rootline_tags` VALUES (1,'1__0_0','pageId_1'),(2,'1__0_-99','pageId_1');
/*!40000 ALTER TABLE `cf_cache_rootline_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_extbase_datamapfactory_datamap`
--

DROP TABLE IF EXISTS `cf_extbase_datamapfactory_datamap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_extbase_datamapfactory_datamap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_extbase_datamapfactory_datamap`
--

LOCK TABLES `cf_extbase_datamapfactory_datamap` WRITE;
/*!40000 ALTER TABLE `cf_extbase_datamapfactory_datamap` DISABLE KEYS */;
INSERT INTO `cf_extbase_datamapfactory_datamap` VALUES (4,'Thucke%ThRating%Domain%Model%Ratingobject',1617616220,'O:52:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\DataMap\":20:{s:12:\"\0*\0className\";s:41:\"Thucke\\ThRating\\Domain\\Model\\Ratingobject\";s:12:\"\0*\0tableName\";s:37:\"tx_thrating_domain_model_ratingobject\";s:13:\"\0*\0recordType\";N;s:13:\"\0*\0subclasses\";a:0:{}s:13:\"\0*\0columnMaps\";a:7:{s:3:\"pid\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:3:\"pid\";s:13:\"\0*\0columnName\";s:3:\"pid\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:4:\"NONE\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:6:\"hidden\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:6:\"hidden\";s:13:\"\0*\0columnName\";s:6:\"hidden\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:5:\"CHECK\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:9:\"ratetable\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:9:\"ratetable\";s:13:\"\0*\0columnName\";s:9:\"ratetable\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:5:\"INPUT\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:9:\"ratefield\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:9:\"ratefield\";s:13:\"\0*\0columnName\";s:9:\"ratefield\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:5:\"INPUT\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:3:\"uid\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:3:\"uid\";s:13:\"\0*\0columnName\";s:3:\"uid\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:4:\"NONE\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:9:\"stepconfs\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:9:\"stepconfs\";s:13:\"\0*\0columnName\";s:9:\"stepconfs\";s:17:\"\0*\0typeOfRelation\";s:17:\"RELATION_HAS_MANY\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";s:33:\"tx_thrating_domain_model_stepconf\";s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";s:12:\"ratingobject\";s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:6:\"INLINE\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:7:\"ratings\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:7:\"ratings\";s:13:\"\0*\0columnName\";s:7:\"ratings\";s:17:\"\0*\0typeOfRelation\";s:17:\"RELATION_HAS_MANY\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";s:31:\"tx_thrating_domain_model_rating\";s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";s:12:\"ratingobject\";s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:6:\"INLINE\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}}s:19:\"\0*\0pageIdColumnName\";s:3:\"pid\";s:23:\"\0*\0languageIdColumnName\";N;s:30:\"\0*\0translationOriginColumnName\";N;s:34:\"\0*\0translationOriginDiffSourceName\";N;s:29:\"\0*\0modificationDateColumnName\";s:6:\"tstamp\";s:25:\"\0*\0creationDateColumnName\";s:6:\"crdate\";s:20:\"\0*\0creatorColumnName\";s:9:\"cruser_id\";s:24:\"\0*\0deletedFlagColumnName\";s:7:\"deleted\";s:25:\"\0*\0disabledFlagColumnName\";s:6:\"hidden\";s:22:\"\0*\0startTimeColumnName\";N;s:20:\"\0*\0endTimeColumnName\";N;s:30:\"\0*\0frontendUserGroupColumnName\";N;s:23:\"\0*\0recordTypeColumnName\";N;s:11:\"\0*\0isStatic\";b:0;s:12:\"\0*\0rootLevel\";b:0;}'),(5,'Thucke%ThRating%Domain%Model%Rating',1617616220,'O:52:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\DataMap\":20:{s:12:\"\0*\0className\";s:35:\"Thucke\\ThRating\\Domain\\Model\\Rating\";s:12:\"\0*\0tableName\";s:31:\"tx_thrating_domain_model_rating\";s:13:\"\0*\0recordType\";N;s:13:\"\0*\0subclasses\";a:0:{}s:13:\"\0*\0columnMaps\";a:7:{s:3:\"pid\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:3:\"pid\";s:13:\"\0*\0columnName\";s:3:\"pid\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:4:\"NONE\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:6:\"hidden\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:6:\"hidden\";s:13:\"\0*\0columnName\";s:6:\"hidden\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:5:\"CHECK\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:12:\"ratingobject\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:12:\"ratingobject\";s:13:\"\0*\0columnName\";s:12:\"ratingobject\";s:17:\"\0*\0typeOfRelation\";s:16:\"RELATION_HAS_ONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";s:37:\"tx_thrating_domain_model_ratingobject\";s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:6:\"SELECT\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:14:\"ratedobjectuid\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:14:\"ratedobjectuid\";s:13:\"\0*\0columnName\";s:14:\"ratedobjectuid\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:5:\"INPUT\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:5:\"votes\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:5:\"votes\";s:13:\"\0*\0columnName\";s:5:\"votes\";s:17:\"\0*\0typeOfRelation\";s:17:\"RELATION_HAS_MANY\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";s:29:\"tx_thrating_domain_model_vote\";s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";s:6:\"rating\";s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:6:\"INLINE\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:12:\"currentrates\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:12:\"currentrates\";s:13:\"\0*\0columnName\";s:12:\"currentrates\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:4:\"NONE\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:3:\"uid\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:3:\"uid\";s:13:\"\0*\0columnName\";s:3:\"uid\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:4:\"NONE\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}}s:19:\"\0*\0pageIdColumnName\";s:3:\"pid\";s:23:\"\0*\0languageIdColumnName\";N;s:30:\"\0*\0translationOriginColumnName\";N;s:34:\"\0*\0translationOriginDiffSourceName\";N;s:29:\"\0*\0modificationDateColumnName\";s:6:\"tstamp\";s:25:\"\0*\0creationDateColumnName\";s:6:\"crdate\";s:20:\"\0*\0creatorColumnName\";s:9:\"cruser_id\";s:24:\"\0*\0deletedFlagColumnName\";s:7:\"deleted\";s:25:\"\0*\0disabledFlagColumnName\";s:6:\"hidden\";s:22:\"\0*\0startTimeColumnName\";N;s:20:\"\0*\0endTimeColumnName\";N;s:30:\"\0*\0frontendUserGroupColumnName\";N;s:23:\"\0*\0recordTypeColumnName\";N;s:11:\"\0*\0isStatic\";b:0;s:12:\"\0*\0rootLevel\";b:0;}'),(6,'Thucke%ThRating%Domain%Model%Stepconf',1617616220,'O:52:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\DataMap\":20:{s:12:\"\0*\0className\";s:37:\"Thucke\\ThRating\\Domain\\Model\\Stepconf\";s:12:\"\0*\0tableName\";s:33:\"tx_thrating_domain_model_stepconf\";s:13:\"\0*\0recordType\";N;s:13:\"\0*\0subclasses\";a:0:{}s:13:\"\0*\0columnMaps\";a:8:{s:3:\"pid\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:3:\"pid\";s:13:\"\0*\0columnName\";s:3:\"pid\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:4:\"NONE\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:6:\"hidden\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:6:\"hidden\";s:13:\"\0*\0columnName\";s:6:\"hidden\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:5:\"CHECK\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:12:\"ratingobject\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:12:\"ratingobject\";s:13:\"\0*\0columnName\";s:12:\"ratingobject\";s:17:\"\0*\0typeOfRelation\";s:16:\"RELATION_HAS_ONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:11:\"PASSTHROUGH\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:9:\"steporder\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:9:\"steporder\";s:13:\"\0*\0columnName\";s:9:\"steporder\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:5:\"INPUT\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:10:\"stepweight\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:10:\"stepweight\";s:13:\"\0*\0columnName\";s:10:\"stepweight\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:5:\"INPUT\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:8:\"stepname\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:8:\"stepname\";s:13:\"\0*\0columnName\";s:8:\"stepname\";s:17:\"\0*\0typeOfRelation\";s:16:\"RELATION_HAS_ONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";s:33:\"tx_thrating_domain_model_stepname\";s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";s:8:\"stepconf\";s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:6:\"INLINE\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:5:\"votes\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:5:\"votes\";s:13:\"\0*\0columnName\";s:5:\"votes\";s:17:\"\0*\0typeOfRelation\";s:17:\"RELATION_HAS_MANY\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";s:29:\"tx_thrating_domain_model_vote\";s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";s:4:\"vote\";s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:6:\"INLINE\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}s:3:\"uid\";O:54:\"TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Mapper\\ColumnMap\":18:{s:15:\"\0*\0propertyName\";s:3:\"uid\";s:13:\"\0*\0columnName\";s:3:\"uid\";s:17:\"\0*\0typeOfRelation\";s:13:\"RELATION_NONE\";s:17:\"\0*\0childClassName\";N;s:17:\"\0*\0childTableName\";N;s:27:\"\0*\0childTableWhereStatement\";N;s:23:\"\0*\0childSortByFieldName\";N;s:20:\"\0*\0relationTableName\";N;s:32:\"\0*\0relationTablePageIdColumnName\";N;s:27:\"\0*\0relationTableMatchFields\";N;s:28:\"\0*\0relationTableInsertFields\";N;s:30:\"\0*\0relationTableWhereStatement\";N;s:21:\"\0*\0parentKeyFieldName\";N;s:23:\"\0*\0parentTableFieldName\";N;s:20:\"\0*\0childKeyFieldName\";N;s:24:\"\0*\0dateTimeStorageFormat\";N;s:7:\"\0*\0type\";O:43:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnType\":1:{s:8:\"\0*\0value\";s:11:\"PASSTHROUGH\";}s:15:\"\0*\0internalType\";O:46:\"TYPO3\\CMS\\Core\\DataHandling\\TableColumnSubType\":1:{s:8:\"\0*\0value\";s:0:\"\";}}}s:19:\"\0*\0pageIdColumnName\";s:3:\"pid\";s:23:\"\0*\0languageIdColumnName\";N;s:30:\"\0*\0translationOriginColumnName\";N;s:34:\"\0*\0translationOriginDiffSourceName\";N;s:29:\"\0*\0modificationDateColumnName\";s:6:\"tstamp\";s:25:\"\0*\0creationDateColumnName\";s:6:\"crdate\";s:20:\"\0*\0creatorColumnName\";s:9:\"cruser_id\";s:24:\"\0*\0deletedFlagColumnName\";s:7:\"deleted\";s:25:\"\0*\0disabledFlagColumnName\";s:6:\"hidden\";s:22:\"\0*\0startTimeColumnName\";N;s:20:\"\0*\0endTimeColumnName\";N;s:30:\"\0*\0frontendUserGroupColumnName\";N;s:23:\"\0*\0recordTypeColumnName\";N;s:11:\"\0*\0isStatic\";b:0;s:12:\"\0*\0rootLevel\";b:0;}');
/*!40000 ALTER TABLE `cf_extbase_datamapfactory_datamap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_extbase_datamapfactory_datamap_tags`
--

DROP TABLE IF EXISTS `cf_extbase_datamapfactory_datamap_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_extbase_datamapfactory_datamap_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_extbase_datamapfactory_datamap_tags`
--

LOCK TABLES `cf_extbase_datamapfactory_datamap_tags` WRITE;
/*!40000 ALTER TABLE `cf_extbase_datamapfactory_datamap_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_extbase_datamapfactory_datamap_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_hash`
--

DROP TABLE IF EXISTS `cf_hash`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_hash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_hash`
--

LOCK TABLES `cf_hash` WRITE;
/*!40000 ALTER TABLE `cf_hash` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_hash` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_hash_tags`
--

DROP TABLE IF EXISTS `cf_hash_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_hash_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_hash_tags`
--

LOCK TABLES `cf_hash_tags` WRITE;
/*!40000 ALTER TABLE `cf_hash_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_hash_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_imagesizes`
--

DROP TABLE IF EXISTS `cf_imagesizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_imagesizes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_imagesizes`
--

LOCK TABLES `cf_imagesizes` WRITE;
/*!40000 ALTER TABLE `cf_imagesizes` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_imagesizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_imagesizes_tags`
--

DROP TABLE IF EXISTS `cf_imagesizes_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_imagesizes_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_imagesizes_tags`
--

LOCK TABLES `cf_imagesizes_tags` WRITE;
/*!40000 ALTER TABLE `cf_imagesizes_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_imagesizes_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_pages`
--

DROP TABLE IF EXISTS `cf_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_pages`
--

LOCK TABLES `cf_pages` WRITE;
/*!40000 ALTER TABLE `cf_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_pages_tags`
--

DROP TABLE IF EXISTS `cf_pages_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_pages_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_pages_tags`
--

LOCK TABLES `cf_pages_tags` WRITE;
/*!40000 ALTER TABLE `cf_pages_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_pages_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_pagesection`
--

DROP TABLE IF EXISTS `cf_pagesection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_pagesection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_pagesection`
--

LOCK TABLES `cf_pagesection` WRITE;
/*!40000 ALTER TABLE `cf_pagesection` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_pagesection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_pagesection_tags`
--

DROP TABLE IF EXISTS `cf_pagesection_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_pagesection_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_pagesection_tags`
--

LOCK TABLES `cf_pagesection_tags` WRITE;
/*!40000 ALTER TABLE `cf_pagesection_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_pagesection_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_rootline`
--

DROP TABLE IF EXISTS `cf_rootline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_rootline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `expires` int(10) unsigned NOT NULL DEFAULT 0,
  `content` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(180),`expires`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_rootline`
--

LOCK TABLES `cf_rootline` WRITE;
/*!40000 ALTER TABLE `cf_rootline` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_rootline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cf_rootline_tags`
--

DROP TABLE IF EXISTS `cf_rootline_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cf_rootline_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cache_id` (`identifier`(191)),
  KEY `cache_tag` (`tag`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cf_rootline_tags`
--

LOCK TABLES `cf_rootline_tags` WRITE;
/*!40000 ALTER TABLE `cf_rootline_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `cf_rootline_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fe_groups`
--

DROP TABLE IF EXISTS `fe_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fe_groups` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tx_extbase_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `lockToDomain` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `subgroup` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TSconfig` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `felogin_redirectPid` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fe_groups`
--

LOCK TABLES `fe_groups` WRITE;
/*!40000 ALTER TABLE `fe_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `fe_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fe_sessions`
--

DROP TABLE IF EXISTS `fe_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fe_sessions` (
  `ses_id` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ses_iplock` varchar(39) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ses_userid` int(10) unsigned NOT NULL DEFAULT 0,
  `ses_tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `ses_data` mediumblob DEFAULT NULL,
  `ses_permanent` smallint(5) unsigned NOT NULL DEFAULT 0,
  `ses_anonymous` smallint(5) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`ses_id`),
  KEY `ses_tstamp` (`ses_tstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fe_sessions`
--

LOCK TABLES `fe_sessions` WRITE;
/*!40000 ALTER TABLE `fe_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `fe_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fe_users`
--

DROP TABLE IF EXISTS `fe_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fe_users` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `disable` smallint(5) unsigned NOT NULL DEFAULT 0,
  `starttime` int(10) unsigned NOT NULL DEFAULT 0,
  `endtime` int(10) unsigned NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tx_extbase_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `usergroup` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `middle_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `telephone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `fax` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `lockToDomain` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `uc` blob DEFAULT NULL,
  `title` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `www` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `company` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `image` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TSconfig` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastlogin` int(10) unsigned NOT NULL DEFAULT 0,
  `is_online` int(10) unsigned NOT NULL DEFAULT 0,
  `felogin_redirectPid` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `felogin_forgotHash` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`username`(100)),
  KEY `username` (`username`(100)),
  KEY `is_online` (`is_online`),
  KEY `felogin_forgotHash` (`felogin_forgotHash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fe_users`
--

LOCK TABLES `fe_users` WRITE;
/*!40000 ALTER TABLE `fe_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `fe_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `starttime` int(10) unsigned NOT NULL DEFAULT 0,
  `endtime` int(10) unsigned NOT NULL DEFAULT 0,
  `fe_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `sorting` int(11) NOT NULL DEFAULT 0,
  `rowDescription` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `editlock` smallint(5) unsigned NOT NULL DEFAULT 0,
  `sys_language_uid` int(11) NOT NULL DEFAULT 0,
  `l10n_parent` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_source` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_state` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t3_origuid` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_diffsource` mediumblob DEFAULT NULL,
  `t3ver_oid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_id` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `t3ver_wsid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_state` smallint(6) NOT NULL DEFAULT 0,
  `t3ver_stage` int(11) NOT NULL DEFAULT 0,
  `t3ver_count` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_move_id` int(10) unsigned NOT NULL DEFAULT 0,
  `perms_userid` int(10) unsigned NOT NULL DEFAULT 0,
  `perms_groupid` int(10) unsigned NOT NULL DEFAULT 0,
  `perms_user` smallint(5) unsigned NOT NULL DEFAULT 0,
  `perms_group` smallint(5) unsigned NOT NULL DEFAULT 0,
  `perms_everybody` smallint(5) unsigned NOT NULL DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doktype` int(10) unsigned NOT NULL DEFAULT 0,
  `TSconfig` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_siteroot` smallint(6) NOT NULL DEFAULT 0,
  `php_tree_stop` smallint(6) NOT NULL DEFAULT 0,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shortcut` int(10) unsigned NOT NULL DEFAULT 0,
  `shortcut_mode` int(10) unsigned NOT NULL DEFAULT 0,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `layout` int(10) unsigned NOT NULL DEFAULT 0,
  `target` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `media` int(10) unsigned NOT NULL DEFAULT 0,
  `lastUpdated` int(10) unsigned NOT NULL DEFAULT 0,
  `keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cache_timeout` int(10) unsigned NOT NULL DEFAULT 0,
  `cache_tags` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `newUntil` int(10) unsigned NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_search` smallint(5) unsigned NOT NULL DEFAULT 0,
  `SYS_LASTCHANGED` int(10) unsigned NOT NULL DEFAULT 0,
  `abstract` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `extendToSubpages` smallint(5) unsigned NOT NULL DEFAULT 0,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `author_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nav_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `nav_hide` smallint(6) NOT NULL DEFAULT 0,
  `content_from_pid` int(10) unsigned NOT NULL DEFAULT 0,
  `mount_pid` int(10) unsigned NOT NULL DEFAULT 0,
  `mount_pid_ol` smallint(6) NOT NULL DEFAULT 0,
  `alias` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `l18n_cfg` smallint(6) NOT NULL DEFAULT 0,
  `fe_login_mode` smallint(6) NOT NULL DEFAULT 0,
  `backend_layout` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `backend_layout_next_level` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tsconfig_includes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legacy_overlay_uid` int(10) unsigned NOT NULL DEFAULT 0,
  `tx_impexp_origuid` int(11) NOT NULL DEFAULT 0,
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `no_index` smallint(6) NOT NULL DEFAULT 0,
  `no_follow` smallint(6) NOT NULL DEFAULT 0,
  `og_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `og_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_image` int(10) unsigned NOT NULL DEFAULT 0,
  `twitter_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `twitter_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_image` int(10) unsigned NOT NULL DEFAULT 0,
  `canonical_link` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `categories` int(11) NOT NULL DEFAULT 0,
  `sitemap_priority` decimal(2,1) NOT NULL DEFAULT 0.5,
  `sitemap_changefreq` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `twitter_card` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`),
  KEY `alias` (`alias`),
  KEY `determineSiteRoot` (`is_siteroot`),
  KEY `language_identifier` (`l10n_parent`,`sys_language_uid`),
  KEY `slug` (`slug`(127)),
  KEY `parent` (`pid`,`deleted`,`hidden`),
  KEY `translation_source` (`l10n_source`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`),
  KEY `legacy_overlay` (`legacy_overlay_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,0,1617373901,1617373901,1,0,0,0,0,'0',0,NULL,0,0,0,0,NULL,0,NULL,0,0,'',0,0,0,0,0,0,1,1,31,31,1,'Home','/',1,NULL,1,0,'',0,0,'',0,'',0,0,NULL,0,'',0,NULL,0,1617456915,NULL,'',0,'','','',0,0,0,0,'',0,0,'','',NULL,0,0,'',0,0,'',NULL,0,'',NULL,0,'',0,0.5,'',''),(2,1,1617456861,1617456848,1,0,0,0,0,'',256,'',0,0,0,0,NULL,0,'a:12:{s:7:\"doktype\";N;s:5:\"title\";N;s:14:\"backend_layout\";N;s:25:\"backend_layout_next_level\";N;s:6:\"module\";N;s:5:\"media\";N;s:17:\"tsconfig_includes\";N;s:8:\"TSconfig\";N;s:6:\"hidden\";N;s:8:\"editlock\";N;s:10:\"categories\";N;s:14:\"rowDescription\";N;}',0,0,'',0,0,0,0,0,0,1,0,31,27,0,'Storage page','/1',254,'',0,0,'',0,0,'',0,'',0,0,'',0,'',0,'',0,0,'','',0,'','','',0,0,0,0,'',0,0,'','','',0,0,'',0,0,'','',0,'','',0,'',0,0.5,'','');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_be_shortcuts`
--

DROP TABLE IF EXISTS `sys_be_shortcuts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_be_shortcuts` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT 0,
  `module_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sorting` int(11) NOT NULL DEFAULT 0,
  `sc_group` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `event` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_be_shortcuts`
--

LOCK TABLES `sys_be_shortcuts` WRITE;
/*!40000 ALTER TABLE `sys_be_shortcuts` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_be_shortcuts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_category`
--

DROP TABLE IF EXISTS `sys_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_category` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `starttime` int(10) unsigned NOT NULL DEFAULT 0,
  `endtime` int(10) unsigned NOT NULL DEFAULT 0,
  `sorting` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sys_language_uid` int(11) NOT NULL DEFAULT 0,
  `l10n_parent` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_state` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t3_origuid` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_diffsource` mediumblob DEFAULT NULL,
  `t3ver_oid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_id` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `t3ver_wsid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_state` smallint(6) NOT NULL DEFAULT 0,
  `t3ver_stage` int(11) NOT NULL DEFAULT 0,
  `t3ver_count` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_move_id` int(10) unsigned NOT NULL DEFAULT 0,
  `title` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `items` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `category_parent` (`parent`),
  KEY `category_list` (`pid`,`deleted`,`sys_language_uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_category`
--

LOCK TABLES `sys_category` WRITE;
/*!40000 ALTER TABLE `sys_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_category_record_mm`
--

DROP TABLE IF EXISTS `sys_category_record_mm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_category_record_mm` (
  `uid_local` int(11) NOT NULL DEFAULT 0,
  `uid_foreign` int(11) NOT NULL DEFAULT 0,
  `tablenames` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `fieldname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sorting` int(11) NOT NULL DEFAULT 0,
  `sorting_foreign` int(11) NOT NULL DEFAULT 0,
  KEY `uid_local_foreign` (`uid_local`,`uid_foreign`),
  KEY `uid_foreign_tablefield` (`uid_foreign`,`tablenames`(40),`fieldname`(3),`sorting_foreign`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_category_record_mm`
--

LOCK TABLES `sys_category_record_mm` WRITE;
/*!40000 ALTER TABLE `sys_category_record_mm` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_category_record_mm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_collection`
--

DROP TABLE IF EXISTS `sys_collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_collection` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `starttime` int(10) unsigned NOT NULL DEFAULT 0,
  `endtime` int(10) unsigned NOT NULL DEFAULT 0,
  `fe_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sys_language_uid` int(11) NOT NULL DEFAULT 0,
  `l10n_parent` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_state` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t3_origuid` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_diffsource` mediumblob DEFAULT NULL,
  `t3ver_oid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_id` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `t3ver_wsid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_state` smallint(6) NOT NULL DEFAULT 0,
  `t3ver_stage` int(11) NOT NULL DEFAULT 0,
  `t3ver_count` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_move_id` int(10) unsigned NOT NULL DEFAULT 0,
  `title` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'static',
  `table_name` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_collection`
--

LOCK TABLES `sys_collection` WRITE;
/*!40000 ALTER TABLE `sys_collection` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_collection_entries`
--

DROP TABLE IF EXISTS `sys_collection_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_collection_entries` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uid_local` int(11) NOT NULL DEFAULT 0,
  `uid_foreign` int(11) NOT NULL DEFAULT 0,
  `tablenames` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sorting` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `uid_local` (`uid_local`),
  KEY `uid_foreign` (`uid_foreign`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_collection_entries`
--

LOCK TABLES `sys_collection_entries` WRITE;
/*!40000 ALTER TABLE `sys_collection_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_collection_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_domain`
--

DROP TABLE IF EXISTS `sys_domain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_domain` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `sorting` int(11) NOT NULL DEFAULT 0,
  `domainName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`),
  KEY `getSysDomain` (`hidden`),
  KEY `getDomainStartPage` (`pid`,`hidden`,`domainName`(100)),
  KEY `parent` (`pid`,`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_domain`
--

LOCK TABLES `sys_domain` WRITE;
/*!40000 ALTER TABLE `sys_domain` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_domain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file`
--

DROP TABLE IF EXISTS `sys_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_file` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `last_indexed` int(11) NOT NULL DEFAULT 0,
  `missing` smallint(6) NOT NULL DEFAULT 0,
  `storage` int(11) NOT NULL DEFAULT 0,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `metadata` int(11) NOT NULL DEFAULT 0,
  `identifier` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identifier_hash` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `folder_hash` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sha1` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `size` bigint(20) unsigned NOT NULL DEFAULT 0,
  `creation_date` int(11) NOT NULL DEFAULT 0,
  `modification_date` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `sel01` (`storage`,`identifier_hash`),
  KEY `folder` (`storage`,`folder_hash`),
  KEY `tstamp` (`tstamp`),
  KEY `lastindex` (`last_indexed`),
  KEY `sha1` (`sha1`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file`
--

LOCK TABLES `sys_file` WRITE;
/*!40000 ALTER TABLE `sys_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file_collection`
--

DROP TABLE IF EXISTS `sys_file_collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_file_collection` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `starttime` int(10) unsigned NOT NULL DEFAULT 0,
  `endtime` int(10) unsigned NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sys_language_uid` int(11) NOT NULL DEFAULT 0,
  `l10n_parent` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_state` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t3_origuid` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_diffsource` mediumblob DEFAULT NULL,
  `t3ver_oid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_id` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `t3ver_wsid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_state` smallint(6) NOT NULL DEFAULT 0,
  `t3ver_stage` int(11) NOT NULL DEFAULT 0,
  `t3ver_count` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_move_id` int(10) unsigned NOT NULL DEFAULT 0,
  `title` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'static',
  `files` int(11) NOT NULL DEFAULT 0,
  `storage` int(11) NOT NULL DEFAULT 0,
  `folder` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recursive` smallint(6) NOT NULL DEFAULT 0,
  `category` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file_collection`
--

LOCK TABLES `sys_file_collection` WRITE;
/*!40000 ALTER TABLE `sys_file_collection` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_file_collection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file_metadata`
--

DROP TABLE IF EXISTS `sys_file_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_file_metadata` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `sys_language_uid` int(11) NOT NULL DEFAULT 0,
  `l10n_parent` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_state` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t3_origuid` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_diffsource` mediumblob DEFAULT NULL,
  `t3ver_oid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_id` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `t3ver_wsid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_state` smallint(6) NOT NULL DEFAULT 0,
  `t3ver_stage` int(11) NOT NULL DEFAULT 0,
  `t3ver_count` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_move_id` int(10) unsigned NOT NULL DEFAULT 0,
  `file` int(11) NOT NULL DEFAULT 0,
  `title` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `width` int(11) NOT NULL DEFAULT 0,
  `height` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categories` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `file` (`file`),
  KEY `fal_filelist` (`l10n_parent`,`sys_language_uid`),
  KEY `parent` (`pid`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file_metadata`
--

LOCK TABLES `sys_file_metadata` WRITE;
/*!40000 ALTER TABLE `sys_file_metadata` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_file_metadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file_processedfile`
--

DROP TABLE IF EXISTS `sys_file_processedfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_file_processedfile` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `tstamp` int(11) NOT NULL DEFAULT 0,
  `crdate` int(11) NOT NULL DEFAULT 0,
  `storage` int(11) NOT NULL DEFAULT 0,
  `original` int(11) NOT NULL DEFAULT 0,
  `identifier` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `configuration` blob DEFAULT NULL,
  `configurationsha1` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `originalfilesha1` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `task_type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `checksum` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `width` int(11) DEFAULT 0,
  `height` int(11) DEFAULT 0,
  `processing_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `combined_1` (`original`,`task_type`(100),`configurationsha1`),
  KEY `identifier` (`storage`,`identifier`(180))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file_processedfile`
--

LOCK TABLES `sys_file_processedfile` WRITE;
/*!40000 ALTER TABLE `sys_file_processedfile` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_file_processedfile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file_reference`
--

DROP TABLE IF EXISTS `sys_file_reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_file_reference` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `sys_language_uid` int(11) NOT NULL DEFAULT 0,
  `l10n_parent` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_state` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l10n_diffsource` mediumblob DEFAULT NULL,
  `t3ver_oid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_id` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `t3ver_wsid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_state` smallint(6) NOT NULL DEFAULT 0,
  `t3ver_stage` int(11) NOT NULL DEFAULT 0,
  `t3ver_count` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_move_id` int(10) unsigned NOT NULL DEFAULT 0,
  `uid_local` int(11) NOT NULL DEFAULT 0,
  `uid_foreign` int(11) NOT NULL DEFAULT 0,
  `tablenames` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `fieldname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sorting_foreign` int(11) NOT NULL DEFAULT 0,
  `table_local` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `crop` varchar(4000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `autoplay` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `tablenames_fieldname` (`tablenames`(32),`fieldname`(12)),
  KEY `deleted` (`deleted`),
  KEY `uid_local` (`uid_local`),
  KEY `uid_foreign` (`uid_foreign`),
  KEY `combined_1` (`l10n_parent`,`t3ver_oid`,`t3ver_wsid`,`t3ver_state`,`deleted`),
  KEY `parent` (`pid`,`deleted`,`hidden`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file_reference`
--

LOCK TABLES `sys_file_reference` WRITE;
/*!40000 ALTER TABLE `sys_file_reference` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_file_reference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_file_storage`
--

DROP TABLE IF EXISTS `sys_file_storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_file_storage` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `driver` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `configuration` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` smallint(6) NOT NULL DEFAULT 0,
  `is_browsable` smallint(6) NOT NULL DEFAULT 0,
  `is_public` smallint(6) NOT NULL DEFAULT 0,
  `is_writable` smallint(6) NOT NULL DEFAULT 0,
  `is_online` smallint(6) NOT NULL DEFAULT 1,
  `auto_extract_metadata` smallint(6) NOT NULL DEFAULT 1,
  `processingfolder` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_file_storage`
--

LOCK TABLES `sys_file_storage` WRITE;
/*!40000 ALTER TABLE `sys_file_storage` DISABLE KEYS */;
INSERT INTO `sys_file_storage` VALUES (1,0,1617374631,1617374631,0,0,'This is the local fileadmin/ directory. This storage mount has been created automatically by TYPO3.','fileadmin/ (auto-created)','Local','<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"sDEF\">\n            <language index=\"lDEF\">\n                <field index=\"basePath\">\n                    <value index=\"vDEF\">fileadmin/</value>\n                </field>\n                <field index=\"pathType\">\n                    <value index=\"vDEF\">relative</value>\n                </field>\n                <field index=\"caseSensitive\">\n                    <value index=\"vDEF\">1</value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>',1,1,1,1,1,1,NULL);
/*!40000 ALTER TABLE `sys_file_storage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_filemounts`
--

DROP TABLE IF EXISTS `sys_filemounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_filemounts` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `sorting` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `base` int(10) unsigned NOT NULL DEFAULT 0,
  `read_only` smallint(5) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_filemounts`
--

LOCK TABLES `sys_filemounts` WRITE;
/*!40000 ALTER TABLE `sys_filemounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_filemounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_history`
--

DROP TABLE IF EXISTS `sys_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_history` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `actiontype` smallint(6) NOT NULL DEFAULT 0,
  `usertype` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BE',
  `userid` int(10) unsigned DEFAULT NULL,
  `originaluserid` int(10) unsigned DEFAULT NULL,
  `recuid` int(11) NOT NULL DEFAULT 0,
  `tablename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `history_data` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `workspace` int(11) DEFAULT 0,
  `correlation_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`),
  KEY `recordident_1` (`tablename`(100),`recuid`),
  KEY `recordident_2` (`tablename`(100),`tstamp`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_history`
--

LOCK TABLES `sys_history` WRITE;
/*!40000 ALTER TABLE `sys_history` DISABLE KEYS */;
INSERT INTO `sys_history` VALUES (1,0,1617374888,2,'BE',1,0,1,'sys_template','{\"oldRecord\":{\"config\":\"page = PAGE\\npage.10 = TEXT\\npage.10.value (\\n   <div style=\\\"width: 800px; margin: 15% auto;\\\">\\n      <div style=\\\"width: 300px;\\\">\\n        <svg xmlns=\\\"http:\\/\\/www.w3.org\\/2000\\/svg\\\" viewBox=\\\"0 0 150 42\\\"><path d=\\\"M60.2 14.4v27h-3.8v-27h-6.7v-3.3h17.1v3.3h-6.6zm20.2 12.9v14h-3.9v-14l-7.7-16.2h4.1l5.7 12.2 5.7-12.2h3.9l-7.8 16.2zm19.5 2.6h-3.6v11.4h-3.8V11.1s3.7-.3 7.3-.3c6.6 0 8.5 4.1 8.5 9.4 0 6.5-2.3 9.7-8.4 9.7m.4-16c-2.4 0-4.1.3-4.1.3v12.6h4.1c2.4 0 4.1-1.6 4.1-6.3 0-4.4-1-6.6-4.1-6.6m21.5 27.7c-7.1 0-9-5.2-9-15.8 0-10.2 1.9-15.1 9-15.1s9 4.9 9 15.1c.1 10.6-1.8 15.8-9 15.8m0-27.7c-3.9 0-5.2 2.6-5.2 12.1 0 9.3 1.3 12.4 5.2 12.4 3.9 0 5.2-3.1 5.2-12.4 0-9.4-1.3-12.1-5.2-12.1m19.9 27.7c-2.1 0-5.3-.6-5.7-.7v-3.1c1 .2 3.7.7 5.6.7 2.2 0 3.6-1.9 3.6-5.2 0-3.9-.6-6-3.7-6H138V24h3.1c3.5 0 3.7-3.6 3.7-5.3 0-3.4-1.1-4.8-3.2-4.8-1.9 0-4.1.5-5.3.7v-3.2c.5-.1 3-.7 5.2-.7 4.4 0 7 1.9 7 8.3 0 2.9-1 5.5-3.3 6.3 2.6.2 3.8 3.1 3.8 7.3 0 6.6-2.5 9-7.3 9\\\"\\/><path fill=\\\"#FF8700\\\" d=\\\"M31.7 28.8c-.6.2-1.1.2-1.7.2-5.2 0-12.9-18.2-12.9-24.3 0-2.2.5-3 1.3-3.6C12 1.9 4.3 4.2 1.9 7.2 1.3 8 1 9.1 1 10.6c0 9.5 10.1 31 17.3 31 3.3 0 8.8-5.4 13.4-12.8M28.4.5c6.6 0 13.2 1.1 13.2 4.8 0 7.6-4.8 16.7-7.2 16.7-4.4 0-9.9-12.1-9.9-18.2C24.5 1 25.6.5 28.4.5\\\"\\/><\\/svg>\\n      <\\/div>\\n      <h4 style=\\\"font-family: sans-serif;\\\">Welcome to a default website made with <a href=\\\"https:\\/\\/typo3.org\\\">TYPO3<\\/a><\\/h4>\\n   <\\/div>\\n)\\npage.100 =< styles.content.get\",\"clear\":1,\"include_static_file\":\"EXT:fluid_styled_content\\/Configuration\\/TypoScript\\/,EXT:fluid_styled_content\\/Configuration\\/TypoScript\\/Styling\\/\",\"description\":\"This is an Empty Site Package TypoScript template.\\n\\nFor each website you need a TypoScript template on the main page of your website (on the top level). For better maintenance all TypoScript should be extracted into external files via @import \'EXT:site_myproject\\/Configuration\\/TypoScript\\/setup.typoscript\'\"},\"newRecord\":{\"config\":\"page = PAGE\\r\\npage.100 =< styles.content.get\",\"clear\":\"3\",\"include_static_file\":\"EXT:fluid_styled_content\\/Configuration\\/TypoScript\\/,EXT:fluid_styled_content\\/Configuration\\/TypoScript\\/Styling\\/,EXT:th_rating\\/Configuration\\/TypoScript\",\"description\":\"This is a prapared Site Package to support automatic testing of the TYPO3 extension th_rating.\\r\\n\\r\\nIt has been manually set up and after thatbeen exported into an SQL file.\"}}',0,''),(2,0,1617456848,1,'BE',1,0,2,'pages','{\"uid\":2,\"pid\":0,\"tstamp\":1617456848,\"crdate\":1617456848,\"cruser_id\":1,\"deleted\":0,\"hidden\":0,\"starttime\":0,\"endtime\":0,\"fe_group\":\"\",\"sorting\":256,\"rowDescription\":\"\",\"editlock\":0,\"sys_language_uid\":0,\"l10n_parent\":0,\"l10n_source\":0,\"l10n_state\":null,\"t3_origuid\":0,\"l10n_diffsource\":\"\",\"t3ver_oid\":0,\"t3ver_id\":0,\"t3ver_label\":\"\",\"t3ver_wsid\":0,\"t3ver_state\":0,\"t3ver_stage\":0,\"t3ver_count\":0,\"t3ver_tstamp\":0,\"t3ver_move_id\":0,\"perms_userid\":1,\"perms_groupid\":0,\"perms_user\":31,\"perms_group\":27,\"perms_everybody\":0,\"title\":\"\",\"slug\":\"\\/\",\"doktype\":254,\"TSconfig\":\"\",\"is_siteroot\":0,\"php_tree_stop\":0,\"url\":\"\",\"shortcut\":0,\"shortcut_mode\":0,\"subtitle\":\"\",\"layout\":0,\"target\":\"\",\"media\":0,\"lastUpdated\":0,\"keywords\":\"\",\"cache_timeout\":0,\"cache_tags\":\"\",\"newUntil\":0,\"description\":\"\",\"no_search\":0,\"SYS_LASTCHANGED\":0,\"abstract\":\"\",\"module\":\"\",\"extendToSubpages\":0,\"author\":\"\",\"author_email\":\"\",\"nav_title\":\"\",\"nav_hide\":0,\"content_from_pid\":0,\"mount_pid\":0,\"mount_pid_ol\":0,\"alias\":\"\",\"l18n_cfg\":0,\"fe_login_mode\":0,\"backend_layout\":\"\",\"backend_layout_next_level\":\"\",\"tsconfig_includes\":\"\",\"legacy_overlay_uid\":0,\"tx_impexp_origuid\":0,\"seo_title\":\"\",\"no_index\":0,\"no_follow\":0,\"og_title\":\"\",\"og_description\":\"\",\"og_image\":0,\"twitter_title\":\"\",\"twitter_description\":\"\",\"twitter_image\":0,\"canonical_link\":\"\",\"categories\":0}',0,''),(3,0,1617456855,2,'BE',1,0,2,'pages','{\"oldRecord\":{\"title\":\"\",\"l10n_diffsource\":\"\"},\"newRecord\":{\"title\":\"Storage page\",\"l10n_diffsource\":\"a:12:{s:7:\\\"doktype\\\";N;s:5:\\\"title\\\";N;s:14:\\\"backend_layout\\\";N;s:25:\\\"backend_layout_next_level\\\";N;s:6:\\\"module\\\";N;s:5:\\\"media\\\";N;s:17:\\\"tsconfig_includes\\\";N;s:8:\\\"TSconfig\\\";N;s:6:\\\"hidden\\\";N;s:8:\\\"editlock\\\";N;s:10:\\\"categories\\\";N;s:14:\\\"rowDescription\\\";N;}\"}}',0,''),(4,0,1617456861,3,'BE',1,0,2,'pages','{\"oldPageId\":0,\"newPageId\":1,\"oldData\":{\"header\":\"Storage page\",\"pid\":0,\"event_pid\":2,\"t3ver_state\":0,\"_ORIG_pid\":null},\"newData\":{\"tstamp\":1617456861,\"pid\":1,\"sorting\":256}}',0,''),(5,0,1617456886,1,'BE',1,0,1,'tt_content','{\"uid\":1,\"rowDescription\":\"\",\"pid\":1,\"tstamp\":1617456886,\"crdate\":1617456886,\"cruser_id\":1,\"deleted\":0,\"hidden\":0,\"starttime\":0,\"endtime\":0,\"fe_group\":\"\",\"sorting\":256,\"editlock\":0,\"sys_language_uid\":0,\"l18n_parent\":0,\"l10n_source\":0,\"l10n_state\":null,\"t3_origuid\":0,\"l18n_diffsource\":\"\",\"t3ver_oid\":0,\"t3ver_id\":0,\"t3ver_label\":\"\",\"t3ver_wsid\":0,\"t3ver_state\":0,\"t3ver_stage\":0,\"t3ver_count\":0,\"t3ver_tstamp\":0,\"t3ver_move_id\":0,\"CType\":\"list\",\"header\":\"\",\"header_position\":\"\",\"bodytext\":\"\",\"bullets_type\":0,\"uploads_description\":0,\"uploads_type\":0,\"assets\":0,\"image\":0,\"imagewidth\":0,\"imageorient\":0,\"imagecols\":2,\"imageborder\":0,\"media\":0,\"layout\":0,\"frame_class\":\"default\",\"cols\":0,\"spaceBefore\":0,\"spaceAfter\":0,\"space_before_class\":\"\",\"space_after_class\":\"\",\"records\":null,\"pages\":null,\"colPos\":0,\"subheader\":\"\",\"header_link\":\"\",\"image_zoom\":0,\"header_layout\":\"0\",\"list_type\":\"\",\"sectionIndex\":1,\"linkToTop\":0,\"file_collections\":null,\"filelink_size\":0,\"filelink_sorting\":\"\",\"filelink_sorting_direction\":\"\",\"target\":\"\",\"date\":0,\"recursive\":0,\"imageheight\":0,\"pi_flexform\":null,\"accessibility_title\":\"\",\"accessibility_bypass\":0,\"accessibility_bypass_text\":\"\",\"selected_categories\":null,\"category_field\":\"\",\"table_class\":\"\",\"table_caption\":null,\"table_delimiter\":124,\"table_enclosure\":0,\"table_header_position\":0,\"table_tfoot\":0,\"tx_impexp_origuid\":0,\"categories\":0}',0,''),(6,0,1617456890,2,'BE',1,0,1,'tt_content','{\"oldRecord\":{\"list_type\":\"\",\"l18n_diffsource\":\"\"},\"newRecord\":{\"list_type\":\"thrating_pi1\",\"l18n_diffsource\":\"a:25:{s:5:\\\"CType\\\";N;s:6:\\\"colPos\\\";N;s:6:\\\"header\\\";N;s:13:\\\"header_layout\\\";N;s:15:\\\"header_position\\\";N;s:4:\\\"date\\\";N;s:11:\\\"header_link\\\";N;s:9:\\\"subheader\\\";N;s:9:\\\"list_type\\\";N;s:5:\\\"pages\\\";N;s:9:\\\"recursive\\\";N;s:6:\\\"layout\\\";N;s:11:\\\"frame_class\\\";N;s:18:\\\"space_before_class\\\";N;s:17:\\\"space_after_class\\\";N;s:12:\\\"sectionIndex\\\";N;s:9:\\\"linkToTop\\\";N;s:16:\\\"sys_language_uid\\\";N;s:6:\\\"hidden\\\";N;s:9:\\\"starttime\\\";N;s:7:\\\"endtime\\\";N;s:8:\\\"fe_group\\\";N;s:8:\\\"editlock\\\";N;s:10:\\\"categories\\\";N;s:14:\\\"rowDescription\\\";N;}\"}}',0,''),(7,0,1617456898,2,'BE',1,0,1,'tt_content','{\"oldRecord\":{\"pi_flexform\":null,\"l18n_diffsource\":\"a:25:{s:5:\\\"CType\\\";N;s:6:\\\"colPos\\\";N;s:6:\\\"header\\\";N;s:13:\\\"header_layout\\\";N;s:15:\\\"header_position\\\";N;s:4:\\\"date\\\";N;s:11:\\\"header_link\\\";N;s:9:\\\"subheader\\\";N;s:9:\\\"list_type\\\";N;s:5:\\\"pages\\\";N;s:9:\\\"recursive\\\";N;s:6:\\\"layout\\\";N;s:11:\\\"frame_class\\\";N;s:18:\\\"space_before_class\\\";N;s:17:\\\"space_after_class\\\";N;s:12:\\\"sectionIndex\\\";N;s:9:\\\"linkToTop\\\";N;s:16:\\\"sys_language_uid\\\";N;s:6:\\\"hidden\\\";N;s:9:\\\"starttime\\\";N;s:7:\\\"endtime\\\";N;s:8:\\\"fe_group\\\";N;s:8:\\\"editlock\\\";N;s:10:\\\"categories\\\";N;s:14:\\\"rowDescription\\\";N;}\"},\"newRecord\":{\"pi_flexform\":\"<?xml version=\\\"1.0\\\" encoding=\\\"utf-8\\\" standalone=\\\"yes\\\" ?>\\n<T3FlexForms>\\n    <data>\\n        <sheet index=\\\"sDEF\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"switchableControllerActions\\\">\\n                    <value index=\\\"vDEF\\\">Vote-&gt;ratinglinks<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.showNotRated\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.cookieLifetime\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n        <sheet index=\\\"sFluidLayoutConfig\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"settings.fluid.layouts.default.showSectionContent\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.layouts.default.showSummary\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.layouts.default.showCurrentRates\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.infoBlock.showAnonymousVotes\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.usersRating.showTextInfo\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.usersRating.showGraphicInfo\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n        <sheet index=\\\"sPaths\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"view.templateRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"view.partialRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"view.layoutRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n    <\\/data>\\n<\\/T3FlexForms>\",\"l18n_diffsource\":\"a:23:{s:5:\\\"CType\\\";N;s:6:\\\"colPos\\\";N;s:6:\\\"header\\\";N;s:13:\\\"header_layout\\\";N;s:15:\\\"header_position\\\";N;s:4:\\\"date\\\";N;s:11:\\\"header_link\\\";N;s:9:\\\"subheader\\\";N;s:9:\\\"list_type\\\";N;s:11:\\\"pi_flexform\\\";N;s:11:\\\"frame_class\\\";N;s:18:\\\"space_before_class\\\";N;s:17:\\\"space_after_class\\\";N;s:12:\\\"sectionIndex\\\";N;s:9:\\\"linkToTop\\\";N;s:16:\\\"sys_language_uid\\\";N;s:6:\\\"hidden\\\";N;s:9:\\\"starttime\\\";N;s:7:\\\"endtime\\\";N;s:8:\\\"fe_group\\\";N;s:8:\\\"editlock\\\";N;s:10:\\\"categories\\\";N;s:14:\\\"rowDescription\\\";N;}\"}}',0,''),(8,0,1617456900,2,'BE',1,0,1,'tt_content','{\"oldRecord\":{\"pi_flexform\":\"<?xml version=\\\"1.0\\\" encoding=\\\"utf-8\\\" standalone=\\\"yes\\\" ?>\\n<T3FlexForms>\\n    <data>\\n        <sheet index=\\\"sDEF\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"switchableControllerActions\\\">\\n                    <value index=\\\"vDEF\\\">Vote-&gt;ratinglinks<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.showNotRated\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.cookieLifetime\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n        <sheet index=\\\"sFluidLayoutConfig\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"settings.fluid.layouts.default.showSectionContent\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.layouts.default.showSummary\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.layouts.default.showCurrentRates\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.infoBlock.showAnonymousVotes\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.usersRating.showTextInfo\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.usersRating.showGraphicInfo\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n        <sheet index=\\\"sPaths\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"view.templateRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"view.partialRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"view.layoutRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n    <\\/data>\\n<\\/T3FlexForms>\"},\"newRecord\":{\"pi_flexform\":\"<?xml version=\\\"1.0\\\" encoding=\\\"utf-8\\\" standalone=\\\"yes\\\" ?>\\n<T3FlexForms>\\n    <data>\\n        <sheet index=\\\"sDEF\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"settings.showNotRated\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.cookieLifetime\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"switchableControllerActions\\\">\\n                    <value index=\\\"vDEF\\\">Vote-&gt;ratinglinks<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.display\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n        <sheet index=\\\"sFluidLayoutConfig\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"settings.fluid.layouts.default.showSectionContent\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.layouts.default.showSummary\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.layouts.default.showCurrentRates\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.infoBlock.showAnonymousVotes\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.usersRating.showTextInfo\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.usersRating.showGraphicInfo\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n        <sheet index=\\\"sPaths\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"view.templateRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"view.partialRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"view.layoutRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n        <sheet index=\\\"sFluidRatinglinksConfig\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"settings.fluid.templates.ratinglinks.tooltips\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.templates.ratinglinks.likesMode\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n    <\\/data>\\n<\\/T3FlexForms>\"}}',0,''),(9,0,1617456915,2,'BE',1,0,1,'tt_content','{\"oldRecord\":{\"header\":\"\",\"pi_flexform\":\"<?xml version=\\\"1.0\\\" encoding=\\\"utf-8\\\" standalone=\\\"yes\\\" ?>\\n<T3FlexForms>\\n    <data>\\n        <sheet index=\\\"sDEF\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"settings.showNotRated\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.cookieLifetime\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"switchableControllerActions\\\">\\n                    <value index=\\\"vDEF\\\">Vote-&gt;ratinglinks<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.display\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n        <sheet index=\\\"sFluidLayoutConfig\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"settings.fluid.layouts.default.showSectionContent\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.layouts.default.showSummary\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.layouts.default.showCurrentRates\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.infoBlock.showAnonymousVotes\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.usersRating.showTextInfo\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.usersRating.showGraphicInfo\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n        <sheet index=\\\"sPaths\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"view.templateRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"view.partialRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"view.layoutRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n        <sheet index=\\\"sFluidRatinglinksConfig\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"settings.fluid.templates.ratinglinks.tooltips\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.templates.ratinglinks.likesMode\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n    <\\/data>\\n<\\/T3FlexForms>\"},\"newRecord\":{\"header\":\"Acceptance test first header\",\"pi_flexform\":\"<?xml version=\\\"1.0\\\" encoding=\\\"utf-8\\\" standalone=\\\"yes\\\" ?>\\n<T3FlexForms>\\n    <data>\\n        <sheet index=\\\"sDEF\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"settings.showNotRated\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.cookieLifetime\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.display\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"switchableControllerActions\\\">\\n                    <value index=\\\"vDEF\\\">Vote-&gt;ratinglinks<\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n        <sheet index=\\\"sFluidLayoutConfig\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"settings.fluid.layouts.default.showSectionContent\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.layouts.default.showSummary\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.layouts.default.showCurrentRates\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.infoBlock.showAnonymousVotes\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.usersRating.showTextInfo\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.partials.usersRating.showGraphicInfo\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n        <sheet index=\\\"sPaths\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"view.templateRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"view.partialRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n                <field index=\\\"view.layoutRootPath\\\">\\n                    <value index=\\\"vDEF\\\"><\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n        <sheet index=\\\"sFluidRatinglinksConfig\\\">\\n            <language index=\\\"lDEF\\\">\\n                <field index=\\\"settings.fluid.templates.ratinglinks.tooltips\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n                <field index=\\\"settings.fluid.templates.ratinglinks.likesMode\\\">\\n                    <value index=\\\"vDEF\\\">0<\\/value>\\n                <\\/field>\\n            <\\/language>\\n        <\\/sheet>\\n    <\\/data>\\n<\\/T3FlexForms>\"}}',0,''),(10,0,1617456945,2,'BE',1,0,1,'sys_template','{\"oldRecord\":{\"constants\":\"\"},\"newRecord\":{\"constants\":\"\\nplugin.tx_thrating.settings.pluginStoragePid = 2\"}}',0,''),(11,0,1617456962,2,'BE',1,0,1,'sys_template','{\"oldRecord\":{\"constants\":\"\\nplugin.tx_thrating.settings.pluginStoragePid = 2\"},\"newRecord\":{\"constants\":\"\\nplugin.tx_thrating.settings.pluginStoragePid = 2\\nstyles.content.loginform.pid = 2\"}}',0,'');
/*!40000 ALTER TABLE `sys_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_language`
--

DROP TABLE IF EXISTS `sys_language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_language` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `sorting` int(11) NOT NULL DEFAULT 0,
  `title` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `flag` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `language_isocode` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `static_lang_isocode` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_language`
--

LOCK TABLES `sys_language` WRITE;
/*!40000 ALTER TABLE `sys_language` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_lockedrecords`
--

DROP TABLE IF EXISTS `sys_lockedrecords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_lockedrecords` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `record_table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `record_uid` int(11) NOT NULL DEFAULT 0,
  `record_pid` int(11) NOT NULL DEFAULT 0,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `feuserid` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `event` (`userid`,`tstamp`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_lockedrecords`
--

LOCK TABLES `sys_lockedrecords` WRITE;
/*!40000 ALTER TABLE `sys_lockedrecords` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_lockedrecords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_log`
--

DROP TABLE IF EXISTS `sys_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_log` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `userid` int(10) unsigned NOT NULL DEFAULT 0,
  `action` smallint(5) unsigned NOT NULL DEFAULT 0,
  `recuid` int(10) unsigned NOT NULL DEFAULT 0,
  `tablename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `recpid` int(11) NOT NULL DEFAULT 0,
  `error` smallint(5) unsigned NOT NULL DEFAULT 0,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` smallint(5) unsigned NOT NULL DEFAULT 0,
  `details_nr` smallint(6) NOT NULL DEFAULT 0,
  `IP` varchar(39) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `log_data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_pid` int(11) NOT NULL DEFAULT -1,
  `workspace` int(11) NOT NULL DEFAULT 0,
  `NEWid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `request_id` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `time_micro` double NOT NULL DEFAULT 0,
  `component` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `level` smallint(5) unsigned NOT NULL DEFAULT 0,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `event` (`userid`,`event_pid`),
  KEY `recuidIdx` (`recuid`),
  KEY `user_auth` (`type`,`action`,`tstamp`),
  KEY `request` (`request_id`),
  KEY `combined_1` (`tstamp`,`type`,`userid`),
  KEY `parent` (`pid`),
  KEY `errorcount` (`tstamp`,`error`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_log`
--

LOCK TABLES `sys_log` WRITE;
/*!40000 ALTER TABLE `sys_log` DISABLE KEYS */;
INSERT INTO `sys_log` VALUES (1,0,1617374589,0,3,0,'',0,3,'Login-attempt from ###IP###, username \'%s\' not found!!',255,2,'172.18.0.7','a:1:{i:0;s:1:\"m\";}',-1,-99,'','',0,'',0,NULL,NULL),(2,0,1617374604,1,1,0,'',0,0,'User %s logged in from ###IP###',255,1,'172.18.0.7','a:1:{i:0;s:5:\"admin\";}',-1,-99,'','',0,'',0,NULL,NULL),(4,0,1617374888,1,2,1,'sys_template',0,0,'Record \'%s\' (%s) was updated. (Online).',1,10,'172.18.0.7','a:3:{i:0;s:25:\"Main TypoScript Rendering\";i:1;s:14:\"sys_template:1\";s:7:\"history\";s:1:\"1\";}',1,0,'','',0,'',0,NULL,NULL),(6,0,1617376274,2,1,0,'',0,0,'User %s has cleared the cache (cacheCmd=%s)',3,0,'','a:2:{i:0;s:5:\"_cli_\";i:1;s:3:\"all\";}',-1,0,'','',0,'',0,NULL,NULL),(7,0,1617452183,2,1,0,'',0,0,'User %s has cleared the cache (cacheCmd=%s)',3,0,'','a:2:{i:0;s:5:\"_cli_\";i:1;s:3:\"all\";}',-1,0,'','',0,'',0,NULL,NULL),(22,0,1617456768,1,1,0,'',0,0,'User %s logged in from ###IP###',255,1,'172.18.0.6','a:1:{i:0;s:5:\"admin\";}',-1,-99,'','',0,'',0,NULL,NULL),(23,0,1617456848,1,1,2,'pages',0,0,'Record \'%s\' (%s) was inserted on page \'%s\' (%s)',1,10,'172.18.0.6','a:4:{i:0;s:10:\"[No title]\";i:1;s:7:\"pages:2\";i:2;s:12:\"[root-level]\";i:3;i:0;}',0,0,'NEW60686ecb96f6c261177780','',0,'',0,NULL,NULL),(24,0,1617456855,1,2,2,'pages',0,0,'Record \'%s\' (%s) was updated. (Online).',1,10,'172.18.0.6','a:3:{i:0;s:12:\"Storage page\";i:1;s:7:\"pages:2\";s:7:\"history\";s:1:\"3\";}',2,0,'','',0,'',0,NULL,NULL),(25,0,1617456861,1,4,2,'pages',0,0,'Moved record \'%s\' (%s) to page \'%s\' (%s)',1,2,'172.18.0.6','a:4:{i:0;s:12:\"Storage page\";i:1;s:7:\"pages:2\";i:2;s:4:\"Home\";i:3;i:1;}',0,0,'','',0,'',0,NULL,NULL),(26,0,1617456861,1,4,2,'pages',0,0,'Moved record \'%s\' (%s) from page \'%s\' (%s)',1,3,'172.18.0.6','a:4:{i:0;s:12:\"Storage page\";i:1;s:7:\"pages:2\";i:2;s:12:\"[root-level]\";i:3;i:0;}',1,0,'','',0,'',0,NULL,NULL),(27,0,1617456861,1,2,2,'pages',0,0,'Record \'%s\' (%s) was updated. (Online).',1,10,'172.18.0.6','a:3:{i:0;s:12:\"Storage page\";i:1;s:7:\"pages:2\";s:7:\"history\";i:0;}',2,0,'','',0,'',0,NULL,NULL),(28,0,1617456886,1,1,1,'tt_content',0,0,'Record \'%s\' (%s) was inserted on page \'%s\' (%s)',1,10,'172.18.0.6','a:4:{i:0;s:10:\"[No title]\";i:1;s:12:\"tt_content:1\";i:2;s:4:\"Home\";i:3;i:1;}',1,0,'NEW60686eefe462c838102178','',0,'',0,NULL,NULL),(29,0,1617456890,1,2,1,'tt_content',0,0,'Record \'%s\' (%s) was updated. (Online).',1,10,'172.18.0.6','a:3:{i:0;s:10:\"[No title]\";i:1;s:12:\"tt_content:1\";s:7:\"history\";s:1:\"6\";}',1,0,'','',0,'',0,NULL,NULL),(30,0,1617456898,1,2,1,'tt_content',0,0,'Record \'%s\' (%s) was updated. (Online).',1,10,'172.18.0.6','a:3:{i:0;s:10:\"[No title]\";i:1;s:12:\"tt_content:1\";s:7:\"history\";s:1:\"7\";}',1,0,'','',0,'',0,NULL,NULL),(31,0,1617456900,1,2,1,'tt_content',0,0,'Record \'%s\' (%s) was updated. (Online).',1,10,'172.18.0.6','a:3:{i:0;s:10:\"[No title]\";i:1;s:12:\"tt_content:1\";s:7:\"history\";s:1:\"8\";}',1,0,'','',0,'',0,NULL,NULL),(32,0,1617456915,1,2,1,'tt_content',0,0,'Record \'%s\' (%s) was updated. (Online).',1,10,'172.18.0.6','a:3:{i:0;s:28:\"Acceptance test first header\";i:1;s:12:\"tt_content:1\";s:7:\"history\";s:1:\"9\";}',1,0,'','',0,'',0,NULL,NULL),(33,0,1617456917,0,0,0,'',0,2,'Core: Exception handler (WEB): Uncaught TYPO3 Exception: #1403203519: Constant \"plugin.tx_thrating.settings.pluginStoragePid\" is not set. | Thucke\\ThRating\\Exception\\InvalidStoragePageException thrown in file /var/www/html/Classes/Service/ExtensionConfigurationService.php in line 178. Requested URL: https://th-rating.ddev.site/',5,0,'172.18.0.6','',-1,0,'','',0,'',0,NULL,NULL),(34,0,1617456945,1,2,1,'sys_template',0,0,'Record \'%s\' (%s) was updated. (Online).',1,10,'172.18.0.6','a:3:{i:0;s:25:\"Main TypoScript Rendering\";i:1;s:14:\"sys_template:1\";s:7:\"history\";s:2:\"10\";}',1,0,'','',0,'',0,NULL,NULL),(35,0,1617456945,1,1,0,'',0,0,'User %s has cleared the cache (cacheCmd=%s)',3,0,'172.18.0.6','a:2:{i:0;s:5:\"admin\";i:1;s:3:\"all\";}',-1,0,'','',0,'',0,NULL,NULL),(36,0,1617456947,0,0,0,'',0,2,'Core: Exception handler (WEB): Uncaught TYPO3 Exception: #1403190539: \"plugin.tx_felogin_pi1.storagePid\" not set. | Thucke\\ThRating\\Exception\\FeUserStoragePageException thrown in file /var/www/html/Classes/Service/ExtensionConfigurationService.php in line 204. Requested URL: https://th-rating.ddev.site/',5,0,'172.18.0.6','',-1,0,'','',0,'',0,NULL,NULL),(37,0,1617456948,1,0,0,'',0,2,'Core: Exception handler (WEB): Uncaught TYPO3 Exception: #1518472189: The requested page does not exist | TYPO3\\CMS\\Core\\Error\\Http\\PageNotFoundException thrown in file /var/www/html/.Build/public/typo3/sysext/frontend/Classes/Controller/ErrorController.php in line 80. Requested URL: https://th-rating.ddev.site/favicon.ico',5,0,'172.18.0.6','',-1,0,'','',0,'',0,NULL,NULL),(38,0,1617456962,1,2,1,'sys_template',0,0,'Record \'%s\' (%s) was updated. (Online).',1,10,'172.18.0.6','a:3:{i:0;s:25:\"Main TypoScript Rendering\";i:1;s:14:\"sys_template:1\";s:7:\"history\";s:2:\"11\";}',1,0,'','',0,'',0,NULL,NULL),(39,0,1617456962,1,1,0,'',0,0,'User %s has cleared the cache (cacheCmd=%s)',3,0,'172.18.0.6','a:2:{i:0;s:5:\"admin\";i:1;s:3:\"all\";}',-1,0,'','',0,'',0,NULL,NULL),(40,0,1617456983,2,1,0,'',0,0,'User %s has cleared the cache (cacheCmd=%s)',3,0,'','a:2:{i:0;s:5:\"_cli_\";i:1;s:3:\"all\";}',-1,0,'','',0,'',0,NULL,NULL),(41,0,1617457012,0,0,0,'',0,2,'Core: Exception handler (WEB): Uncaught TYPO3 Exception: #1518472189: The requested page does not exist | TYPO3\\CMS\\Core\\Error\\Http\\PageNotFoundException thrown in file /var/www/html/.Build/public/typo3/sysext/frontend/Classes/Controller/ErrorController.php in line 80. Requested URL: http://th-rating.ddev.site/show-timezone',5,0,'172.18.0.6','',-1,0,'','',0,'',0,NULL,NULL),(42,0,1617457013,0,0,0,'',0,2,'Core: Exception handler (WEB): Uncaught TYPO3 Exception: #1518472189: The requested page does not exist | TYPO3\\CMS\\Core\\Error\\Http\\PageNotFoundException thrown in file /var/www/html/.Build/public/typo3/sysext/frontend/Classes/Controller/ErrorController.php in line 80. Requested URL: http://th-rating.ddev.site/select-timezone',5,0,'172.18.0.6','',-1,0,'','',0,'',0,NULL,NULL),(43,0,1617457014,0,0,0,'',0,2,'Core: Exception handler (WEB): Uncaught TYPO3 Exception: #1518472189: The requested page does not exist | TYPO3\\CMS\\Core\\Error\\Http\\PageNotFoundException thrown in file /var/www/html/.Build/public/typo3/sysext/frontend/Classes/Controller/ErrorController.php in line 80. Requested URL: http://th-rating.ddev.site/select-timezone',5,0,'172.18.0.6','',-1,0,'','',0,'',0,NULL,NULL),(44,0,1617457915,1,0,0,'',0,2,'Core: Exception handler (WEB): Uncaught TYPO3 Exception: #1518472189: The requested page does not exist | TYPO3\\CMS\\Core\\Error\\Http\\PageNotFoundException thrown in file /var/www/html/.Build/public/typo3/sysext/frontend/Classes/Controller/ErrorController.php in line 80. Requested URL: https://th-rating.ddev.site/favicon.ico',5,0,'172.18.0.6','',-1,0,'','',0,'',0,NULL,NULL),(45,0,1617612621,0,0,0,'',0,2,'Core: Exception handler (WEB): Uncaught TYPO3 Exception: #1518472189: The requested page does not exist | TYPO3\\CMS\\Core\\Error\\Http\\PageNotFoundException thrown in file /var/www/html/.Build/public/typo3/sysext/frontend/Classes/Controller/ErrorController.php in line 80. Requested URL: https://th-rating.ddev.site/favicon.ico',5,0,'172.18.0.6','',-1,0,'','',0,'',0,NULL,NULL),(46,0,1617612629,1,1,0,'',0,0,'User %s logged in from ###IP###',255,1,'172.18.0.6','a:1:{i:0;s:5:\"admin\";}',-1,-99,'','',0,'',0,NULL,NULL),(47,0,1617612698,2,1,0,'',0,0,'User %s has cleared the cache (cacheCmd=%s)',3,0,'','a:2:{i:0;s:5:\"_cli_\";i:1;s:3:\"all\";}',-1,0,'','',0,'',0,NULL,NULL),(48,0,1617612783,1,1,0,'',0,0,'User %s logged in from ###IP###',255,1,'172.18.0.6','a:1:{i:0;s:5:\"admin\";}',-1,-99,'','',0,'',0,NULL,NULL),(49,0,1617612825,2,1,0,'',0,0,'User %s has cleared the cache (cacheCmd=%s)',3,0,'','a:2:{i:0;s:5:\"_cli_\";i:1;s:3:\"all\";}',-1,0,'','',0,'',0,NULL,NULL);
/*!40000 ALTER TABLE `sys_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_news`
--

DROP TABLE IF EXISTS `sys_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_news` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `starttime` int(10) unsigned NOT NULL DEFAULT 0,
  `endtime` int(10) unsigned NOT NULL DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_news`
--

LOCK TABLES `sys_news` WRITE;
/*!40000 ALTER TABLE `sys_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_note`
--

DROP TABLE IF EXISTS `sys_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_note` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `sorting` int(11) NOT NULL DEFAULT 0,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personal` smallint(5) unsigned NOT NULL DEFAULT 0,
  `category` smallint(5) unsigned NOT NULL DEFAULT 0,
  `position` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_note`
--

LOCK TABLES `sys_note` WRITE;
/*!40000 ALTER TABLE `sys_note` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_note` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_redirect`
--

DROP TABLE IF EXISTS `sys_redirect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_redirect` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `updatedon` int(10) unsigned NOT NULL DEFAULT 0,
  `createdon` int(10) unsigned NOT NULL DEFAULT 0,
  `createdby` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `disabled` smallint(5) unsigned NOT NULL DEFAULT 0,
  `starttime` int(10) unsigned NOT NULL DEFAULT 0,
  `endtime` int(10) unsigned NOT NULL DEFAULT 0,
  `source_host` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `source_path` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_regexp` smallint(5) unsigned NOT NULL DEFAULT 0,
  `force_https` smallint(5) unsigned NOT NULL DEFAULT 0,
  `respect_query_parameters` smallint(5) unsigned NOT NULL DEFAULT 0,
  `keep_query_parameters` smallint(5) unsigned NOT NULL DEFAULT 0,
  `target` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `target_statuscode` int(11) NOT NULL DEFAULT 307,
  `hitcount` int(11) NOT NULL DEFAULT 0,
  `lasthiton` int(11) NOT NULL DEFAULT 0,
  `disable_hitcount` smallint(5) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `index_source` (`source_host`(80),`source_path`(80)),
  KEY `parent` (`pid`,`deleted`,`disabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_redirect`
--

LOCK TABLES `sys_redirect` WRITE;
/*!40000 ALTER TABLE `sys_redirect` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_redirect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_refindex`
--

DROP TABLE IF EXISTS `sys_refindex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_refindex` (
  `hash` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tablename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `recuid` int(11) NOT NULL DEFAULT 0,
  `field` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `flexpointer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `softref_key` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `softref_id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sorting` int(11) NOT NULL DEFAULT 0,
  `deleted` smallint(6) NOT NULL DEFAULT 0,
  `workspace` int(11) NOT NULL DEFAULT 0,
  `ref_table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ref_uid` int(11) NOT NULL DEFAULT 0,
  `ref_string` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`hash`),
  KEY `lookup_rec` (`tablename`(100),`recuid`),
  KEY `lookup_uid` (`ref_table`(100),`ref_uid`),
  KEY `lookup_string` (`ref_string`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_refindex`
--

LOCK TABLES `sys_refindex` WRITE;
/*!40000 ALTER TABLE `sys_refindex` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_refindex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_registry`
--

DROP TABLE IF EXISTS `sys_registry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_registry` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_namespace` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `entry_key` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `entry_value` mediumblob DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `entry_identifier` (`entry_namespace`,`entry_key`)
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_registry`
--

LOCK TABLES `sys_registry` WRITE;
/*!40000 ALTER TABLE `sys_registry` DISABLE KEYS */;
INSERT INTO `sys_registry` VALUES (1,'installUpdate','TYPO3\\CMS\\Form\\Hooks\\FormFileExtensionUpdate','i:1;'),(2,'installUpdate','TYPO3\\CMS\\Install\\Updates\\WizardDoneToRegistry','i:1;'),(3,'installUpdate','TYPO3\\CMS\\Install\\Updates\\StartModuleUpdate','i:1;'),(4,'installUpdate','TYPO3\\CMS\\Install\\Updates\\FrontendUserImageUpdateWizard','i:1;'),(5,'installUpdate','TYPO3\\CMS\\Install\\Updates\\FillTranslationSourceField','i:1;'),(6,'installUpdate','TYPO3\\CMS\\Install\\Updates\\SectionFrameToFrameClassUpdate','i:1;'),(7,'installUpdate','TYPO3\\CMS\\Install\\Updates\\SplitMenusUpdate','i:1;'),(8,'installUpdate','TYPO3\\CMS\\Install\\Updates\\BulletContentElementUpdate','i:1;'),(9,'installUpdate','TYPO3\\CMS\\Install\\Updates\\UploadContentElementUpdate','i:1;'),(10,'installUpdate','TYPO3\\CMS\\Install\\Updates\\MigrateFscStaticTemplateUpdate','i:1;'),(11,'installUpdate','TYPO3\\CMS\\Install\\Updates\\FileReferenceUpdate','i:1;'),(12,'installUpdate','TYPO3\\CMS\\Install\\Updates\\MigrateFeSessionDataUpdate','i:1;'),(13,'installUpdate','TYPO3\\CMS\\Install\\Updates\\Compatibility7ExtractionUpdate','i:1;'),(14,'installUpdate','TYPO3\\CMS\\Install\\Updates\\FormLegacyExtractionUpdate','i:1;'),(15,'installUpdate','TYPO3\\CMS\\Install\\Updates\\RteHtmlAreaExtractionUpdate','i:1;'),(16,'installUpdate','TYPO3\\CMS\\Install\\Updates\\LanguageSortingUpdate','i:1;'),(17,'installUpdate','TYPO3\\CMS\\Install\\Updates\\Typo3DbExtractionUpdate','i:1;'),(18,'installUpdate','TYPO3\\CMS\\Install\\Updates\\FuncExtractionUpdate','i:1;'),(19,'installUpdate','TYPO3\\CMS\\Install\\Updates\\MigrateUrlTypesInPagesUpdate','i:1;'),(20,'installUpdate','TYPO3\\CMS\\Install\\Updates\\RedirectExtractionUpdate','i:1;'),(21,'installUpdate','TYPO3\\CMS\\Install\\Updates\\BackendUserStartModuleUpdate','i:1;'),(22,'installUpdate','TYPO3\\CMS\\Install\\Updates\\MigratePagesLanguageOverlayUpdate','i:1;'),(23,'installUpdate','TYPO3\\CMS\\Install\\Updates\\MigratePagesLanguageOverlayBeGroupsAccessRights','i:1;'),(24,'installUpdate','TYPO3\\CMS\\Install\\Updates\\BackendLayoutIconUpdateWizard','i:1;'),(25,'installUpdate','TYPO3\\CMS\\Install\\Updates\\RedirectsExtensionUpdate','i:1;'),(26,'installUpdate','TYPO3\\CMS\\Install\\Updates\\AdminPanelInstall','i:1;'),(27,'installUpdate','TYPO3\\CMS\\Install\\Updates\\PopulatePageSlugs','i:1;'),(28,'installUpdate','TYPO3\\CMS\\Install\\Updates\\Argon2iPasswordHashes','i:1;'),(29,'installUpdate','TYPO3\\CMS\\Install\\Updates\\BackendUserConfigurationUpdate','i:1;'),(30,'installUpdateRows','rowUpdatersDone','a:4:{i:0;s:52:\"TYPO3\\CMS\\Install\\Updates\\RowUpdater\\L10nModeUpdater\";i:1;s:53:\"TYPO3\\CMS\\Install\\Updates\\RowUpdater\\ImageCropUpdater\";i:2;s:57:\"TYPO3\\CMS\\Install\\Updates\\RowUpdater\\RteLinkSyntaxUpdater\";i:3;s:69:\"TYPO3\\CMS\\Install\\Updates\\RowUpdater\\WorkspaceVersionRecordsMigration\";}'),(31,'extensionDataImport','typo3/sysext/core/ext_tables_static+adt.sql','s:0:\"\";'),(32,'extensionDataImport','typo3/sysext/scheduler/ext_tables_static+adt.sql','s:0:\"\";'),(33,'extensionDataImport','typo3/sysext/extbase/ext_tables_static+adt.sql','s:0:\"\";'),(34,'extensionDataImport','typo3/sysext/fluid/ext_tables_static+adt.sql','s:0:\"\";'),(35,'extensionDataImport','typo3/sysext/frontend/ext_tables_static+adt.sql','s:0:\"\";'),(36,'extensionDataImport','typo3/sysext/fluid_styled_content/ext_tables_static+adt.sql','s:0:\"\";'),(37,'extensionDataImport','typo3/sysext/filelist/ext_tables_static+adt.sql','s:0:\"\";'),(38,'extensionDataImport','typo3/sysext/impexp/ext_tables_static+adt.sql','s:0:\"\";'),(39,'extensionDataImport','typo3/sysext/form/ext_tables_static+adt.sql','s:0:\"\";'),(40,'extensionDataImport','typo3/sysext/install/ext_tables_static+adt.sql','s:0:\"\";'),(41,'extensionDataImport','typo3/sysext/recordlist/ext_tables_static+adt.sql','s:0:\"\";'),(42,'extensionDataImport','typo3/sysext/backend/ext_tables_static+adt.sql','s:0:\"\";'),(43,'extensionDataImport','typo3/sysext/reports/ext_tables_static+adt.sql','s:0:\"\";'),(44,'extensionDataImport','typo3/sysext/setup/ext_tables_static+adt.sql','s:0:\"\";'),(45,'extensionDataImport','typo3/sysext/rte_ckeditor/ext_tables_static+adt.sql','s:0:\"\";'),(46,'extensionDataImport','typo3/sysext/about/ext_tables_static+adt.sql','s:0:\"\";'),(47,'extensionDataImport','typo3/sysext/adminpanel/ext_tables_static+adt.sql','s:0:\"\";'),(48,'extensionDataImport','typo3/sysext/belog/ext_tables_static+adt.sql','s:0:\"\";'),(49,'extensionDataImport','typo3/sysext/beuser/ext_tables_static+adt.sql','s:0:\"\";'),(50,'extensionDataImport','typo3/sysext/extensionmanager/ext_tables_static+adt.sql','s:32:\"9beb0be917f14fdde2c9cb940a47d38e\";'),(51,'extensionDataImport','typo3/sysext/felogin/ext_tables_static+adt.sql','s:0:\"\";'),(52,'extensionDataImport','typo3/sysext/info/ext_tables_static+adt.sql','s:0:\"\";'),(53,'extensionDataImport','typo3/sysext/redirects/ext_tables_static+adt.sql','s:0:\"\";'),(54,'extensionDataImport','typo3/sysext/seo/ext_tables_static+adt.sql','s:0:\"\";'),(55,'extensionDataImport','typo3/sysext/sys_note/ext_tables_static+adt.sql','s:0:\"\";'),(56,'extensionDataImport','typo3/sysext/t3editor/ext_tables_static+adt.sql','s:0:\"\";'),(57,'extensionDataImport','typo3/sysext/tstemplate/ext_tables_static+adt.sql','s:0:\"\";'),(58,'extensionDataImport','typo3/sysext/viewpage/ext_tables_static+adt.sql','s:0:\"\";'),(59,'extensionDataImport','typo3conf/ext/th_rating/ext_tables_static+adt.sql','s:0:\"\";'),(60,'core','formProtectionSessionToken:1','s:64:\"2e591a27eba8b203f452d3da7bb18839b91f5ad060285b01eaa052fa82c01533\";'),(61,'extensionScannerNotAffected','782a296528be3f95640e8fb1ca72b61b','s:32:\"782a296528be3f95640e8fb1ca72b61b\";'),(62,'extensionScannerNotAffected','8e57538a6b4eb5977b710dda86c19a79','s:32:\"8e57538a6b4eb5977b710dda86c19a79\";'),(63,'extensionScannerNotAffected','94935c6e14d0aff251bb66552a78774e','s:32:\"94935c6e14d0aff251bb66552a78774e\";'),(64,'extensionScannerNotAffected','d8ddb8d308daf783e702d6ff4197b630','s:32:\"d8ddb8d308daf783e702d6ff4197b630\";'),(65,'extensionScannerNotAffected','db580c43603bc85dce820925c0391148','s:32:\"db580c43603bc85dce820925c0391148\";'),(66,'extensionScannerNotAffected','d544bdbde714a2ec968cb3270273fc18','s:32:\"d544bdbde714a2ec968cb3270273fc18\";'),(67,'extensionScannerNotAffected','65d3c5339cf7b511f4f892427a5a294f','s:32:\"65d3c5339cf7b511f4f892427a5a294f\";'),(68,'extensionScannerNotAffected','ba01e41c82b0218933f2c05542aec142','s:32:\"ba01e41c82b0218933f2c05542aec142\";'),(69,'extensionScannerNotAffected','8e787af732d7f3edea4492626092bfb4','s:32:\"8e787af732d7f3edea4492626092bfb4\";'),(70,'extensionScannerNotAffected','8bcdcb5cb360544051b268949bfe5793','s:32:\"8bcdcb5cb360544051b268949bfe5793\";'),(71,'extensionScannerNotAffected','7bf45c02a5c39c6babccb5ea80a820ac','s:32:\"7bf45c02a5c39c6babccb5ea80a820ac\";'),(72,'extensionScannerNotAffected','07be8a5d35d670955b5edd1cf6fb177e','s:32:\"07be8a5d35d670955b5edd1cf6fb177e\";'),(73,'extensionScannerNotAffected','2b495b045a49a5002f033f663268e460','s:32:\"2b495b045a49a5002f033f663268e460\";'),(74,'extensionScannerNotAffected','97f1cb270f7c6ce7261e229007892f53','s:32:\"97f1cb270f7c6ce7261e229007892f53\";'),(75,'extensionScannerNotAffected','329a78b9a0cb7a8fce549d1f99750626','s:32:\"329a78b9a0cb7a8fce549d1f99750626\";'),(76,'extensionScannerNotAffected','c7d2136d519fa26627008c5c7ef0b7b8','s:32:\"c7d2136d519fa26627008c5c7ef0b7b8\";'),(77,'extensionScannerNotAffected','9522a14ae76b26966c6383c435872cf2','s:32:\"9522a14ae76b26966c6383c435872cf2\";'),(78,'extensionScannerNotAffected','f55d0a8bf02260a90d0dfd562fd3011f','s:32:\"f55d0a8bf02260a90d0dfd562fd3011f\";'),(79,'extensionScannerNotAffected','da20688d2c914dfbb71b99797a2b5231','s:32:\"da20688d2c914dfbb71b99797a2b5231\";'),(80,'extensionScannerNotAffected','91ea87d2b06ea4f647e043148d951c52','s:32:\"91ea87d2b06ea4f647e043148d951c52\";'),(81,'extensionScannerNotAffected','dfaf4db240d3f4883278b2f285c5607e','s:32:\"dfaf4db240d3f4883278b2f285c5607e\";'),(82,'extensionScannerNotAffected','747e64fff64dd7432e84a08fe738067a','s:32:\"747e64fff64dd7432e84a08fe738067a\";'),(83,'extensionScannerNotAffected','8d99ace37d1d1b36fbab3a9d6304e918','s:32:\"8d99ace37d1d1b36fbab3a9d6304e918\";'),(84,'extensionScannerNotAffected','c526c9a91d824901b33106452ac6e8ed','s:32:\"c526c9a91d824901b33106452ac6e8ed\";'),(85,'extensionScannerNotAffected','4d29c858bfb700ee214348c776bd7fee','s:32:\"4d29c858bfb700ee214348c776bd7fee\";'),(86,'extensionScannerNotAffected','515ba3726a1dfded6ef6b83d1581ec83','s:32:\"515ba3726a1dfded6ef6b83d1581ec83\";'),(87,'extensionScannerNotAffected','a2da539b9ee347a8e042edfaf888d512','s:32:\"a2da539b9ee347a8e042edfaf888d512\";'),(88,'extensionScannerNotAffected','66917c534366520df96a319aa595aadf','s:32:\"66917c534366520df96a319aa595aadf\";'),(89,'extensionScannerNotAffected','84958529cec39361876616e3725c4f9b','s:32:\"84958529cec39361876616e3725c4f9b\";'),(90,'extensionScannerNotAffected','407bdf75e994d5e754cd62fe949c9e9b','s:32:\"407bdf75e994d5e754cd62fe949c9e9b\";'),(91,'extensionScannerNotAffected','e872218b822e4a3de6e5ae039fdd2f60','s:32:\"e872218b822e4a3de6e5ae039fdd2f60\";'),(92,'extensionScannerNotAffected','509182c6331e36f9e169652eb967d4b0','s:32:\"509182c6331e36f9e169652eb967d4b0\";'),(93,'extensionScannerNotAffected','3ea2e88429bdcbbd9cfe70d1705d0823','s:32:\"3ea2e88429bdcbbd9cfe70d1705d0823\";'),(94,'extensionScannerNotAffected','3f8faefc1fe5b54d8903efdfee5ac291','s:32:\"3f8faefc1fe5b54d8903efdfee5ac291\";'),(95,'extensionScannerNotAffected','1c5a05a66768940687520074a52c2d99','s:32:\"1c5a05a66768940687520074a52c2d99\";'),(96,'extensionScannerNotAffected','e009576208e2478646761c31e62ffff8','s:32:\"e009576208e2478646761c31e62ffff8\";'),(97,'extensionScannerNotAffected','27cb6bf0a45fb36cd7ac73a2c0a572ef','s:32:\"27cb6bf0a45fb36cd7ac73a2c0a572ef\";'),(98,'extensionScannerNotAffected','c406c1b4bb1a5dfd9c08d4559bb8e8ee','s:32:\"c406c1b4bb1a5dfd9c08d4559bb8e8ee\";'),(99,'extensionScannerNotAffected','c5dd6f8903c59d422e06f980e5b36552','s:32:\"c5dd6f8903c59d422e06f980e5b36552\";'),(100,'extensionScannerNotAffected','b6058a0dc990a2c719ebaf093f5fc02f','s:32:\"b6058a0dc990a2c719ebaf093f5fc02f\";'),(101,'extensionScannerNotAffected','09d630c80626c1b76089fcc5c01a6ebb','s:32:\"09d630c80626c1b76089fcc5c01a6ebb\";'),(102,'extensionScannerNotAffected','aeba5d0706fd347bdc5272f996118fea','s:32:\"aeba5d0706fd347bdc5272f996118fea\";'),(103,'extensionScannerNotAffected','7160b22e95d6e92862b7761a18a21cb9','s:32:\"7160b22e95d6e92862b7761a18a21cb9\";'),(104,'extensionScannerNotAffected','67442386f8c3115084d1214937e3b4a8','s:32:\"67442386f8c3115084d1214937e3b4a8\";'),(105,'extensionScannerNotAffected','256574d860279e77e16ec42976515826','s:32:\"256574d860279e77e16ec42976515826\";'),(106,'extensionScannerNotAffected','2dec44f31d4d8868fe0fafe592b1c93e','s:32:\"2dec44f31d4d8868fe0fafe592b1c93e\";'),(107,'extensionScannerNotAffected','f7ffff32fb53be1a4f44895e1468fef1','s:32:\"f7ffff32fb53be1a4f44895e1468fef1\";'),(108,'extensionScannerNotAffected','3af67f0226440b92916c9ac47ecc0f45','s:32:\"3af67f0226440b92916c9ac47ecc0f45\";'),(109,'extensionScannerNotAffected','6e37d32633631b068e06299c8acffee3','s:32:\"6e37d32633631b068e06299c8acffee3\";'),(110,'extensionScannerNotAffected','53f2e9f92611d61893d2d1b9d2131d15','s:32:\"53f2e9f92611d61893d2d1b9d2131d15\";'),(111,'extensionScannerNotAffected','dd4f137389ebdeacaae2a4dec7d17993','s:32:\"dd4f137389ebdeacaae2a4dec7d17993\";'),(112,'extensionScannerNotAffected','606a1ff02c65e772c51feaa1ea681234','s:32:\"606a1ff02c65e772c51feaa1ea681234\";'),(113,'extensionScannerNotAffected','27ab68dff32c68264a8f5052ce2bfa39','s:32:\"27ab68dff32c68264a8f5052ce2bfa39\";'),(114,'extensionScannerNotAffected','6539b2eef11f6335580d5c96f1ba17de','s:32:\"6539b2eef11f6335580d5c96f1ba17de\";'),(115,'extensionScannerNotAffected','1476ca2c06acc6b6cb8bac78b0633bf6','s:32:\"1476ca2c06acc6b6cb8bac78b0633bf6\";'),(116,'extensionScannerNotAffected','ad00c9bfc110d595723c667ef024d8e9','s:32:\"ad00c9bfc110d595723c667ef024d8e9\";'),(117,'extensionScannerNotAffected','0a6f2835e55a235c905a1705df41cee7','s:32:\"0a6f2835e55a235c905a1705df41cee7\";'),(118,'extensionScannerNotAffected','96c7a3f1fc0fe11bcdc7115a31b16f93','s:32:\"96c7a3f1fc0fe11bcdc7115a31b16f93\";'),(119,'extensionScannerNotAffected','b53560dfb6ad7c0d067ec228b9d158d6','s:32:\"b53560dfb6ad7c0d067ec228b9d158d6\";'),(120,'extensionScannerNotAffected','d209ef32995636ed8252c304366460f0','s:32:\"d209ef32995636ed8252c304366460f0\";'),(121,'extensionScannerNotAffected','388a9b5cf2dc024abce1ccda0c00666b','s:32:\"388a9b5cf2dc024abce1ccda0c00666b\";'),(122,'extensionScannerNotAffected','dc7a8fcd17770995da8b75572938b712','s:32:\"dc7a8fcd17770995da8b75572938b712\";'),(123,'extensionScannerNotAffected','181fece53aa7b13396193738a08ab7a5','s:32:\"181fece53aa7b13396193738a08ab7a5\";'),(124,'extensionScannerNotAffected','a767d6a06ae489ffffd6c26bc25fb38a','s:32:\"a767d6a06ae489ffffd6c26bc25fb38a\";'),(125,'extensionScannerNotAffected','f9d942cb02be7865d4818bda14172e5e','s:32:\"f9d942cb02be7865d4818bda14172e5e\";'),(126,'extensionScannerNotAffected','aea1390a84313285af1f87cb50d8213e','s:32:\"aea1390a84313285af1f87cb50d8213e\";'),(127,'extensionScannerNotAffected','7ca777fd910da99f301f8d6791dd8477','s:32:\"7ca777fd910da99f301f8d6791dd8477\";'),(128,'extensionScannerNotAffected','dcabdff470c575a8ed319d14fb9c424f','s:32:\"dcabdff470c575a8ed319d14fb9c424f\";'),(129,'extensionScannerNotAffected','fd1adc61cb6d986a3e7a4dd65609fcba','s:32:\"fd1adc61cb6d986a3e7a4dd65609fcba\";'),(130,'extensionScannerNotAffected','c2cb531b3769bfe93d36c2d6a43a436a','s:32:\"c2cb531b3769bfe93d36c2d6a43a436a\";'),(131,'extensionScannerNotAffected','39927fae0bdc126decd803df9975697b','s:32:\"39927fae0bdc126decd803df9975697b\";'),(132,'extensionScannerNotAffected','ff0771e45e03394ed17c8783e5e083d6','s:32:\"ff0771e45e03394ed17c8783e5e083d6\";'),(133,'extensionScannerNotAffected','83d762e1a46c1363d7f5fabf77da2db4','s:32:\"83d762e1a46c1363d7f5fabf77da2db4\";'),(134,'extensionScannerNotAffected','40e5025c405909578400ab83e7761b74','s:32:\"40e5025c405909578400ab83e7761b74\";'),(135,'extensionScannerNotAffected','bf64fd0e3399cba335ba6da86212a590','s:32:\"bf64fd0e3399cba335ba6da86212a590\";'),(136,'extensionScannerNotAffected','0401d8602099bcafdbdffb88a96a7a3c','s:32:\"0401d8602099bcafdbdffb88a96a7a3c\";'),(137,'extensionScannerNotAffected','8181fb86d49358beab7d215f40f9b9d0','s:32:\"8181fb86d49358beab7d215f40f9b9d0\";'),(138,'extensionScannerNotAffected','cbd21e7f03086cafbdc9e29aca0d7de9','s:32:\"cbd21e7f03086cafbdc9e29aca0d7de9\";'),(139,'extensionScannerNotAffected','d70cecc33fb1c59414665bc6865b8684','s:32:\"d70cecc33fb1c59414665bc6865b8684\";'),(140,'extensionScannerNotAffected','9be17234d688f35a777c9476d9f3c71b','s:32:\"9be17234d688f35a777c9476d9f3c71b\";'),(141,'extensionScannerNotAffected','95a788a9e8bdf766bb7b24c46f66589b','s:32:\"95a788a9e8bdf766bb7b24c46f66589b\";'),(142,'extensionScannerNotAffected','e76d8583899c660d9b8f059f1e70b398','s:32:\"e76d8583899c660d9b8f059f1e70b398\";'),(143,'extensionScannerNotAffected','97d8364d14683e5c99cf3d61d245757b','s:32:\"97d8364d14683e5c99cf3d61d245757b\";'),(144,'extensionScannerNotAffected','2de6f2010831b2dbebe1c566382968d9','s:32:\"2de6f2010831b2dbebe1c566382968d9\";'),(145,'extensionScannerNotAffected','9f6b69352cc9437112c62aa2b5543692','s:32:\"9f6b69352cc9437112c62aa2b5543692\";'),(146,'extensionScannerNotAffected','2d7e49260d1feaedd48d810213ffb538','s:32:\"2d7e49260d1feaedd48d810213ffb538\";'),(147,'extensionScannerNotAffected','da4784251913511a4be69adb66dc6248','s:32:\"da4784251913511a4be69adb66dc6248\";'),(148,'extensionScannerNotAffected','9fe318e826cbedb8fd1a26941d19005a','s:32:\"9fe318e826cbedb8fd1a26941d19005a\";'),(149,'extensionScannerNotAffected','e145f6079b7f9d0ec06e99a2b076c0a8','s:32:\"e145f6079b7f9d0ec06e99a2b076c0a8\";'),(150,'extensionScannerNotAffected','72dcabf4098f87f91ffbd0680358d214','s:32:\"72dcabf4098f87f91ffbd0680358d214\";'),(151,'extensionScannerNotAffected','bd3841546ff3c306e782b477cda497f0','s:32:\"bd3841546ff3c306e782b477cda497f0\";'),(152,'extensionScannerNotAffected','e64f98e82453cb5e4ddcea3fbb6ea1f8','s:32:\"e64f98e82453cb5e4ddcea3fbb6ea1f8\";'),(153,'extensionScannerNotAffected','144cc46f4036b271da85fa68c7e31ec6','s:32:\"144cc46f4036b271da85fa68c7e31ec6\";'),(154,'extensionScannerNotAffected','b86bf8233a9c62ebca0cacff2f89d5e3','s:32:\"b86bf8233a9c62ebca0cacff2f89d5e3\";'),(155,'extensionScannerNotAffected','986062b4896ff2cd9eece3eef4ded45b','s:32:\"986062b4896ff2cd9eece3eef4ded45b\";'),(156,'extensionScannerNotAffected','a59be9db96adc138df8439284a35f1b1','s:32:\"a59be9db96adc138df8439284a35f1b1\";'),(157,'extensionScannerNotAffected','6b28fe44430f57ad36119ad15d1aed79','s:32:\"6b28fe44430f57ad36119ad15d1aed79\";'),(158,'extensionScannerNotAffected','538801047ed609227d9cf1ff6302f69d','s:32:\"538801047ed609227d9cf1ff6302f69d\";'),(159,'extensionScannerNotAffected','9db18807754661411e84d91946f6c47b','s:32:\"9db18807754661411e84d91946f6c47b\";'),(160,'extensionScannerNotAffected','dd717b8dee96d5b999879b4de8d35ec5','s:32:\"dd717b8dee96d5b999879b4de8d35ec5\";'),(161,'extensionScannerNotAffected','543adcda9a07c1be6be6863f4fc3de89','s:32:\"543adcda9a07c1be6be6863f4fc3de89\";'),(162,'extensionScannerNotAffected','08f23e8308e19cd3b730c99b5724f918','s:32:\"08f23e8308e19cd3b730c99b5724f918\";'),(163,'extensionScannerNotAffected','858a87554a870c3f8cba49b81e5fc3a3','s:32:\"858a87554a870c3f8cba49b81e5fc3a3\";'),(164,'extensionScannerNotAffected','66ed9c10913b6a895e8f53f17d242d2a','s:32:\"66ed9c10913b6a895e8f53f17d242d2a\";'),(165,'extensionScannerNotAffected','a2541c8ae57e07e86192ed8cc132718a','s:32:\"a2541c8ae57e07e86192ed8cc132718a\";'),(166,'extensionScannerNotAffected','97459c0367812d1fb78d00f024ff20aa','s:32:\"97459c0367812d1fb78d00f024ff20aa\";'),(167,'extensionScannerNotAffected','846385e26abb209c7484fae2f0e714a4','s:32:\"846385e26abb209c7484fae2f0e714a4\";'),(168,'extensionScannerNotAffected','ec85f46288965aa648ce9a1e37f2b58a','s:32:\"ec85f46288965aa648ce9a1e37f2b58a\";'),(169,'extensionScannerNotAffected','f7cc244676b74f17ca6bdb46707637f4','s:32:\"f7cc244676b74f17ca6bdb46707637f4\";'),(170,'extensionScannerNotAffected','51e7b5cfb13385843bcf4db3f3d80824','s:32:\"51e7b5cfb13385843bcf4db3f3d80824\";'),(171,'extensionScannerNotAffected','5d6acfcf63df912878a53dfb4f88f66c','s:32:\"5d6acfcf63df912878a53dfb4f88f66c\";'),(172,'extensionScannerNotAffected','4a1ffb6acbac6b2a1330dec6a118e9b7','s:32:\"4a1ffb6acbac6b2a1330dec6a118e9b7\";'),(173,'extensionScannerNotAffected','00d7d3a7bb4187e3a130a8207ce29332','s:32:\"00d7d3a7bb4187e3a130a8207ce29332\";'),(174,'extensionScannerNotAffected','7053139b178834fc4832de6ef3bb35e4','s:32:\"7053139b178834fc4832de6ef3bb35e4\";'),(175,'extensionScannerNotAffected','e1d1b139beff6b083fab80e2e6604a86','s:32:\"e1d1b139beff6b083fab80e2e6604a86\";'),(176,'extensionScannerNotAffected','244de3e3bf16bd6ecc7abdd9f5134baa','s:32:\"244de3e3bf16bd6ecc7abdd9f5134baa\";'),(177,'extensionScannerNotAffected','6325e8f1bf6ee47776eec4aa896ae498','s:32:\"6325e8f1bf6ee47776eec4aa896ae498\";'),(178,'extensionScannerNotAffected','4446e163f2527d13cef9b690a59d41a0','s:32:\"4446e163f2527d13cef9b690a59d41a0\";'),(179,'extensionScannerNotAffected','7f24f3339010d86836d49812532da677','s:32:\"7f24f3339010d86836d49812532da677\";'),(180,'extensionScannerNotAffected','3eae74ce8bf1dda88a3956580f0ee095','s:32:\"3eae74ce8bf1dda88a3956580f0ee095\";'),(181,'extensionScannerNotAffected','3b082c2f15d19c95a2274f2f9cf67936','s:32:\"3b082c2f15d19c95a2274f2f9cf67936\";'),(182,'extensionScannerNotAffected','e644b224460392561dd815bddc13e280','s:32:\"e644b224460392561dd815bddc13e280\";'),(183,'extensionScannerNotAffected','8c0a471eb1e62a9df7e2a0ab710144ab','s:32:\"8c0a471eb1e62a9df7e2a0ab710144ab\";'),(184,'extensionScannerNotAffected','cc57748e8798b0147782cf3a9e868015','s:32:\"cc57748e8798b0147782cf3a9e868015\";'),(185,'extensionScannerNotAffected','aab92a3622f423c5bf6364e4b3720433','s:32:\"aab92a3622f423c5bf6364e4b3720433\";'),(186,'extensionScannerNotAffected','0f72ecbde01e66ab8de6cda9f6ff6031','s:32:\"0f72ecbde01e66ab8de6cda9f6ff6031\";'),(187,'extensionScannerNotAffected','dc4027985e6fc1e36977379ef3f9dcf3','s:32:\"dc4027985e6fc1e36977379ef3f9dcf3\";'),(188,'extensionScannerNotAffected','7591886b875efd00b894eb60256ac0e9','s:32:\"7591886b875efd00b894eb60256ac0e9\";'),(189,'extensionScannerNotAffected','c310acb623b8c522450745fddb89a18b','s:32:\"c310acb623b8c522450745fddb89a18b\";'),(190,'extensionScannerNotAffected','a1ff42bfe65aa2a7250e8ef7e195bcd5','s:32:\"a1ff42bfe65aa2a7250e8ef7e195bcd5\";'),(191,'extensionScannerNotAffected','0bee48ca87fa9b61a2a7047f53e638d9','s:32:\"0bee48ca87fa9b61a2a7047f53e638d9\";'),(192,'extensionScannerNotAffected','4579e1fbe7c94b5510b7796b672c2d80','s:32:\"4579e1fbe7c94b5510b7796b672c2d80\";'),(193,'extensionScannerNotAffected','92344b99f1fe6cc5a0510fc906ec7307','s:32:\"92344b99f1fe6cc5a0510fc906ec7307\";'),(194,'extensionScannerNotAffected','c0a7d44f061cb4c2deca56a6ce548669','s:32:\"c0a7d44f061cb4c2deca56a6ce548669\";'),(195,'extensionScannerNotAffected','31eabeee23cfbd2e810ec7163f298fe2','s:32:\"31eabeee23cfbd2e810ec7163f298fe2\";'),(196,'extensionScannerNotAffected','3a288da8230d042aa0fefe3c9d010fc9','s:32:\"3a288da8230d042aa0fefe3c9d010fc9\";'),(197,'extensionScannerNotAffected','7f95a3579a446aecec1217a456433f0f','s:32:\"7f95a3579a446aecec1217a456433f0f\";'),(198,'extensionScannerNotAffected','491537cef95923e1e1df8619a5bd9924','s:32:\"491537cef95923e1e1df8619a5bd9924\";'),(199,'extensionScannerNotAffected','bd1929903ae77d7a33efa0feb711cfb6','s:32:\"bd1929903ae77d7a33efa0feb711cfb6\";'),(200,'extensionScannerNotAffected','13d6f701b41fb36f0e0083a22bb85002','s:32:\"13d6f701b41fb36f0e0083a22bb85002\";'),(201,'extensionScannerNotAffected','71ebec4960c1b84c199c5a33277b084d','s:32:\"71ebec4960c1b84c199c5a33277b084d\";'),(202,'extensionScannerNotAffected','b1ab184e4a9874ce5e04c374155c7f03','s:32:\"b1ab184e4a9874ce5e04c374155c7f03\";'),(203,'extensionScannerNotAffected','397c9a4bcca973b3b451be07aae2d85d','s:32:\"397c9a4bcca973b3b451be07aae2d85d\";'),(204,'extensionScannerNotAffected','b4310ab842bd0c4c910ee09f20037987','s:32:\"b4310ab842bd0c4c910ee09f20037987\";'),(205,'extensionScannerNotAffected','0d9fbf4a461435c9eeedb3cc130dace5','s:32:\"0d9fbf4a461435c9eeedb3cc130dace5\";'),(206,'extensionScannerNotAffected','b75fd56db65b57134ee3a392333164e6','s:32:\"b75fd56db65b57134ee3a392333164e6\";'),(207,'extensionScannerNotAffected','5dfdf6cf1184deae70be20b67437408a','s:32:\"5dfdf6cf1184deae70be20b67437408a\";'),(208,'extensionScannerNotAffected','e41e345fdcabb5d16cf9cbcaf5f6770c','s:32:\"e41e345fdcabb5d16cf9cbcaf5f6770c\";'),(209,'extensionScannerNotAffected','0de71175cd69f6922e46015ac1646084','s:32:\"0de71175cd69f6922e46015ac1646084\";'),(210,'extensionScannerNotAffected','a8b76974d80653cd9d3e19cf8fbbc54d','s:32:\"a8b76974d80653cd9d3e19cf8fbbc54d\";'),(211,'extensionScannerNotAffected','2c3b83bfc1f271ba9a860c00e99d9b6f','s:32:\"2c3b83bfc1f271ba9a860c00e99d9b6f\";'),(212,'extensionScannerNotAffected','37263679ea002b67d6c926e96199e0cb','s:32:\"37263679ea002b67d6c926e96199e0cb\";'),(213,'extensionScannerNotAffected','23bb7c19b079c8fe437d78e2e66364e8','s:32:\"23bb7c19b079c8fe437d78e2e66364e8\";'),(214,'extensionScannerNotAffected','150c7c72278375a02383fdf867b9a14e','s:32:\"150c7c72278375a02383fdf867b9a14e\";'),(215,'extensionScannerNotAffected','5e3556a907f7c423702aafe5bd21283b','s:32:\"5e3556a907f7c423702aafe5bd21283b\";'),(216,'extensionScannerNotAffected','e5fefe9c0e303befc6e3587e6015bd5f','s:32:\"e5fefe9c0e303befc6e3587e6015bd5f\";'),(217,'extensionScannerNotAffected','b6955ff14a49b23c4b55a16ceda2f53f','s:32:\"b6955ff14a49b23c4b55a16ceda2f53f\";'),(218,'extensionScannerNotAffected','e164383a65972e81d1d4ceed1b787c5c','s:32:\"e164383a65972e81d1d4ceed1b787c5c\";'),(219,'extensionScannerNotAffected','c7bfdc48f32344ba1d1ae63f65de7271','s:32:\"c7bfdc48f32344ba1d1ae63f65de7271\";'),(220,'extensionScannerNotAffected','4fdf992e0b9d01d8b36830baffa7e987','s:32:\"4fdf992e0b9d01d8b36830baffa7e987\";'),(221,'extensionScannerNotAffected','e307efdd6ecb8c3fd0bea412d0a0db1c','s:32:\"e307efdd6ecb8c3fd0bea412d0a0db1c\";'),(222,'extensionScannerNotAffected','5f19c061916be2a684833b270fd025ff','s:32:\"5f19c061916be2a684833b270fd025ff\";'),(223,'extensionScannerNotAffected','54278669581b9b9898c259be1c1d0e91','s:32:\"54278669581b9b9898c259be1c1d0e91\";'),(224,'extensionScannerNotAffected','16aab8758e3be9a5eae25ab0ffc9ac50','s:32:\"16aab8758e3be9a5eae25ab0ffc9ac50\";'),(225,'extensionScannerNotAffected','bb9a966a09e9ef5a034900a4bca6ef96','s:32:\"bb9a966a09e9ef5a034900a4bca6ef96\";'),(226,'extensionScannerNotAffected','0aaa78219033da9093ecded3a045d686','s:32:\"0aaa78219033da9093ecded3a045d686\";'),(227,'extensionScannerNotAffected','d1e1110b267f6c82aac369fe44d1026f','s:32:\"d1e1110b267f6c82aac369fe44d1026f\";'),(228,'extensionScannerNotAffected','aee3aa4544e3318e32219407712cce1c','s:32:\"aee3aa4544e3318e32219407712cce1c\";'),(229,'extensionScannerNotAffected','63052e9b8451752e184e2d932bc7dd62','s:32:\"63052e9b8451752e184e2d932bc7dd62\";'),(230,'extensionScannerNotAffected','0d60eaef00c478199d475ca60d7340c7','s:32:\"0d60eaef00c478199d475ca60d7340c7\";'),(231,'extensionScannerNotAffected','09e682d75e634e3ceb0f7f98527b1505','s:32:\"09e682d75e634e3ceb0f7f98527b1505\";'),(232,'extensionScannerNotAffected','07123938cdaa13ee58f25d01cc26690b','s:32:\"07123938cdaa13ee58f25d01cc26690b\";'),(233,'extensionScannerNotAffected','bf0cb1ebffe995bc39723cb13738ea6a','s:32:\"bf0cb1ebffe995bc39723cb13738ea6a\";'),(234,'extensionScannerNotAffected','19376586fba8888a27efd8af6a4583cf','s:32:\"19376586fba8888a27efd8af6a4583cf\";'),(235,'extensionScannerNotAffected','4fb09912c38414756af594202cb2f690','s:32:\"4fb09912c38414756af594202cb2f690\";'),(236,'extensionScannerNotAffected','e1a09d1fd8685d6062cf3e7799e126f9','s:32:\"e1a09d1fd8685d6062cf3e7799e126f9\";'),(237,'extensionScannerNotAffected','12b246daad701f9511c661587d1f4e6a','s:32:\"12b246daad701f9511c661587d1f4e6a\";'),(238,'extensionScannerNotAffected','6432bc49b3ce263444fc37946991380f','s:32:\"6432bc49b3ce263444fc37946991380f\";'),(239,'extensionScannerNotAffected','6366dd14c672aa71ebf03205723f68a2','s:32:\"6366dd14c672aa71ebf03205723f68a2\";'),(240,'extensionScannerNotAffected','02a805a392483b732732f93901406ceb','s:32:\"02a805a392483b732732f93901406ceb\";'),(241,'installUpdate','TYPO3\\CMS\\Install\\Updates\\RsaauthExtractionUpdate','i:1;'),(242,'installUpdate','TYPO3\\CMS\\Install\\Updates\\FeeditExtractionUpdate','i:1;'),(243,'installUpdate','TYPO3\\CMS\\Install\\Updates\\TaskcenterExtractionUpdate','i:1;'),(244,'installUpdate','TYPO3\\CMS\\Install\\Updates\\SysActionExtractionUpdate','i:1;');
/*!40000 ALTER TABLE `sys_registry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_template`
--

DROP TABLE IF EXISTS `sys_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_template` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `starttime` int(10) unsigned NOT NULL DEFAULT 0,
  `endtime` int(10) unsigned NOT NULL DEFAULT 0,
  `sorting` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t3_origuid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_oid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_id` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `t3ver_wsid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_state` smallint(6) NOT NULL DEFAULT 0,
  `t3ver_stage` int(11) NOT NULL DEFAULT 0,
  `t3ver_count` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_move_id` int(10) unsigned NOT NULL DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sitetitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `root` smallint(5) unsigned NOT NULL DEFAULT 0,
  `clear` smallint(5) unsigned NOT NULL DEFAULT 0,
  `include_static_file` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `constants` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `config` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nextLevel` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `basedOn` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `includeStaticAfterBasedOn` smallint(5) unsigned NOT NULL DEFAULT 0,
  `static_file_mode` smallint(5) unsigned NOT NULL DEFAULT 0,
  `tx_impexp_origuid` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `roottemplate` (`deleted`,`hidden`,`root`),
  KEY `parent` (`pid`,`deleted`,`hidden`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_template`
--

LOCK TABLES `sys_template` WRITE;
/*!40000 ALTER TABLE `sys_template` DISABLE KEYS */;
INSERT INTO `sys_template` VALUES (1,1,1617456962,1617373901,1,0,0,0,0,0,'This is a prapared Site Package to support automatic testing of the TYPO3 extension th_rating.\r\n\r\nIt has been manually set up and after thatbeen exported into an SQL file.',0,0,0,'',0,0,0,0,0,0,'Main TypoScript Rendering','New TYPO3 Console site',1,3,'EXT:fluid_styled_content/Configuration/TypoScript/,EXT:fluid_styled_content/Configuration/TypoScript/Styling/,EXT:th_rating/Configuration/TypoScript','\nplugin.tx_thrating.settings.pluginStoragePid = 2\nstyles.content.loginform.pid = 2','page = PAGE\r\npage.100 =< styles.content.get','',NULL,0,0,0);
/*!40000 ALTER TABLE `sys_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tt_content`
--

DROP TABLE IF EXISTS `tt_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tt_content` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rowDescription` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pid` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `starttime` int(10) unsigned NOT NULL DEFAULT 0,
  `endtime` int(10) unsigned NOT NULL DEFAULT 0,
  `fe_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `sorting` int(11) NOT NULL DEFAULT 0,
  `editlock` smallint(5) unsigned NOT NULL DEFAULT 0,
  `sys_language_uid` int(11) NOT NULL DEFAULT 0,
  `l18n_parent` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_source` int(10) unsigned NOT NULL DEFAULT 0,
  `l10n_state` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t3_origuid` int(10) unsigned NOT NULL DEFAULT 0,
  `l18n_diffsource` mediumblob DEFAULT NULL,
  `t3ver_oid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_id` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `t3ver_wsid` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_state` smallint(6) NOT NULL DEFAULT 0,
  `t3ver_stage` int(11) NOT NULL DEFAULT 0,
  `t3ver_count` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `t3ver_move_id` int(10) unsigned NOT NULL DEFAULT 0,
  `CType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `header` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `header_position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `bodytext` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bullets_type` smallint(5) unsigned NOT NULL DEFAULT 0,
  `uploads_description` smallint(5) unsigned NOT NULL DEFAULT 0,
  `uploads_type` smallint(5) unsigned NOT NULL DEFAULT 0,
  `assets` int(10) unsigned NOT NULL DEFAULT 0,
  `image` int(10) unsigned NOT NULL DEFAULT 0,
  `imagewidth` int(10) unsigned NOT NULL DEFAULT 0,
  `imageorient` smallint(5) unsigned NOT NULL DEFAULT 0,
  `imagecols` smallint(5) unsigned NOT NULL DEFAULT 0,
  `imageborder` smallint(5) unsigned NOT NULL DEFAULT 0,
  `media` int(10) unsigned NOT NULL DEFAULT 0,
  `layout` int(10) unsigned NOT NULL DEFAULT 0,
  `frame_class` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `cols` int(10) unsigned NOT NULL DEFAULT 0,
  `spaceBefore` smallint(5) unsigned NOT NULL DEFAULT 0,
  `spaceAfter` smallint(5) unsigned NOT NULL DEFAULT 0,
  `space_before_class` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `space_after_class` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `records` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pages` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colPos` int(10) unsigned NOT NULL DEFAULT 0,
  `subheader` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `header_link` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `image_zoom` smallint(5) unsigned NOT NULL DEFAULT 0,
  `header_layout` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `list_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sectionIndex` smallint(5) unsigned NOT NULL DEFAULT 0,
  `linkToTop` smallint(5) unsigned NOT NULL DEFAULT 0,
  `file_collections` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filelink_size` smallint(5) unsigned NOT NULL DEFAULT 0,
  `filelink_sorting` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `filelink_sorting_direction` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `target` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `date` int(10) unsigned NOT NULL DEFAULT 0,
  `recursive` smallint(5) unsigned NOT NULL DEFAULT 0,
  `imageheight` int(10) unsigned NOT NULL DEFAULT 0,
  `pi_flexform` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accessibility_title` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `accessibility_bypass` smallint(5) unsigned NOT NULL DEFAULT 0,
  `accessibility_bypass_text` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `selected_categories` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_field` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `table_class` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `table_caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_delimiter` smallint(5) unsigned NOT NULL DEFAULT 0,
  `table_enclosure` smallint(5) unsigned NOT NULL DEFAULT 0,
  `table_header_position` smallint(5) unsigned NOT NULL DEFAULT 0,
  `table_tfoot` smallint(5) unsigned NOT NULL DEFAULT 0,
  `tx_impexp_origuid` int(11) NOT NULL DEFAULT 0,
  `categories` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`sorting`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`),
  KEY `language` (`l18n_parent`,`sys_language_uid`),
  KEY `translation_source` (`l10n_source`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tt_content`
--

LOCK TABLES `tt_content` WRITE;
/*!40000 ALTER TABLE `tt_content` DISABLE KEYS */;
INSERT INTO `tt_content` VALUES (1,'',1,1617456915,1617456886,1,0,0,0,0,'',256,0,0,0,0,NULL,0,'a:23:{s:5:\"CType\";N;s:6:\"colPos\";N;s:6:\"header\";N;s:13:\"header_layout\";N;s:15:\"header_position\";N;s:4:\"date\";N;s:11:\"header_link\";N;s:9:\"subheader\";N;s:9:\"list_type\";N;s:11:\"pi_flexform\";N;s:11:\"frame_class\";N;s:18:\"space_before_class\";N;s:17:\"space_after_class\";N;s:12:\"sectionIndex\";N;s:9:\"linkToTop\";N;s:16:\"sys_language_uid\";N;s:6:\"hidden\";N;s:9:\"starttime\";N;s:7:\"endtime\";N;s:8:\"fe_group\";N;s:8:\"editlock\";N;s:10:\"categories\";N;s:14:\"rowDescription\";N;}',0,0,'',0,0,0,0,0,0,'list','Acceptance test first header','','',0,0,0,0,0,0,0,2,0,0,0,'default',0,0,0,'','',NULL,NULL,0,'','',0,'0','thrating_pi1',1,0,NULL,0,'','','',0,0,0,'<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>\n<T3FlexForms>\n    <data>\n        <sheet index=\"sDEF\">\n            <language index=\"lDEF\">\n                <field index=\"settings.showNotRated\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"settings.cookieLifetime\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"settings.display\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"switchableControllerActions\">\n                    <value index=\"vDEF\">Vote-&gt;ratinglinks</value>\n                </field>\n            </language>\n        </sheet>\n        <sheet index=\"sFluidLayoutConfig\">\n            <language index=\"lDEF\">\n                <field index=\"settings.fluid.layouts.default.showSectionContent\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"settings.fluid.layouts.default.showSummary\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"settings.fluid.layouts.default.showCurrentRates\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"settings.fluid.partials.infoBlock.showAnonymousVotes\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"settings.fluid.partials.usersRating.showTextInfo\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"settings.fluid.partials.usersRating.showGraphicInfo\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n            </language>\n        </sheet>\n        <sheet index=\"sPaths\">\n            <language index=\"lDEF\">\n                <field index=\"view.templateRootPath\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"view.partialRootPath\">\n                    <value index=\"vDEF\"></value>\n                </field>\n                <field index=\"view.layoutRootPath\">\n                    <value index=\"vDEF\"></value>\n                </field>\n            </language>\n        </sheet>\n        <sheet index=\"sFluidRatinglinksConfig\">\n            <language index=\"lDEF\">\n                <field index=\"settings.fluid.templates.ratinglinks.tooltips\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n                <field index=\"settings.fluid.templates.ratinglinks.likesMode\">\n                    <value index=\"vDEF\">0</value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>','',0,'',NULL,'','',NULL,124,0,0,0,0,0);
/*!40000 ALTER TABLE `tt_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_extensionmanager_domain_model_extension`
--

DROP TABLE IF EXISTS `tx_extensionmanager_domain_model_extension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_extensionmanager_domain_model_extension` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `extension_key` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `repository` int(10) unsigned NOT NULL DEFAULT 1,
  `version` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alldownloadcounter` int(10) unsigned NOT NULL DEFAULT 0,
  `downloadcounter` int(10) unsigned NOT NULL DEFAULT 0,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` int(11) NOT NULL DEFAULT 0,
  `review_state` int(11) NOT NULL DEFAULT 0,
  `category` int(11) NOT NULL DEFAULT 0,
  `last_updated` int(10) unsigned NOT NULL DEFAULT 0,
  `serialized_dependencies` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `author_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ownerusername` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `md5hash` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `update_comment` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorcompany` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `integer_version` int(11) NOT NULL DEFAULT 0,
  `current_version` int(11) NOT NULL DEFAULT 0,
  `lastreviewedversion` int(11) NOT NULL DEFAULT 0,
  `documentation_link` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `versionextrepo` (`extension_key`,`version`,`repository`),
  KEY `index_extrepo` (`extension_key`,`repository`),
  KEY `index_versionrepo` (`integer_version`,`repository`,`extension_key`),
  KEY `index_currentversions` (`current_version`,`review_state`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_extensionmanager_domain_model_extension`
--

LOCK TABLES `tx_extensionmanager_domain_model_extension` WRITE;
/*!40000 ALTER TABLE `tx_extensionmanager_domain_model_extension` DISABLE KEYS */;
/*!40000 ALTER TABLE `tx_extensionmanager_domain_model_extension` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_extensionmanager_domain_model_repository`
--

DROP TABLE IF EXISTS `tx_extensionmanager_domain_model_repository`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_extensionmanager_domain_model_repository` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wsdl_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mirror_list_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `last_update` int(10) unsigned NOT NULL DEFAULT 0,
  `extension_count` int(11) NOT NULL DEFAULT 0,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_extensionmanager_domain_model_repository`
--

LOCK TABLES `tx_extensionmanager_domain_model_repository` WRITE;
/*!40000 ALTER TABLE `tx_extensionmanager_domain_model_repository` DISABLE KEYS */;
INSERT INTO `tx_extensionmanager_domain_model_repository` VALUES (1,'TYPO3.org Main Repository','Main repository on typo3.org. This repository has some mirrors configured which are available with the mirror url.','https://typo3.org/wsdl/tx_ter_wsdl.php','https://repositories.typo3.org/mirrors.xml.gz',1346191200,0,0);
/*!40000 ALTER TABLE `tx_extensionmanager_domain_model_repository` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_impexp_presets`
--

DROP TABLE IF EXISTS `tx_impexp_presets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_impexp_presets` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_uid` int(10) unsigned NOT NULL DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `public` smallint(6) NOT NULL DEFAULT 0,
  `item_uid` int(11) NOT NULL DEFAULT 0,
  `preset_data` blob DEFAULT NULL,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `lookup` (`item_uid`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_impexp_presets`
--

LOCK TABLES `tx_impexp_presets` WRITE;
/*!40000 ALTER TABLE `tx_impexp_presets` DISABLE KEYS */;
/*!40000 ALTER TABLE `tx_impexp_presets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_scheduler_task`
--

DROP TABLE IF EXISTS `tx_scheduler_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_scheduler_task` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `disable` smallint(5) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nextexecution` int(10) unsigned NOT NULL DEFAULT 0,
  `lastexecution_time` int(10) unsigned NOT NULL DEFAULT 0,
  `lastexecution_failure` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastexecution_context` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `serialized_task_object` mediumblob DEFAULT NULL,
  `serialized_executions` mediumblob DEFAULT NULL,
  `task_group` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `index_nextexecution` (`nextexecution`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_scheduler_task`
--

LOCK TABLES `tx_scheduler_task` WRITE;
/*!40000 ALTER TABLE `tx_scheduler_task` DISABLE KEYS */;
/*!40000 ALTER TABLE `tx_scheduler_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_scheduler_task_group`
--

DROP TABLE IF EXISTS `tx_scheduler_task_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_scheduler_task_group` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(10) unsigned NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `sorting` int(11) NOT NULL DEFAULT 0,
  `groupName` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`,`deleted`,`hidden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_scheduler_task_group`
--

LOCK TABLES `tx_scheduler_task_group` WRITE;
/*!40000 ALTER TABLE `tx_scheduler_task_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `tx_scheduler_task_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_thrating_domain_model_rating`
--

DROP TABLE IF EXISTS `tx_thrating_domain_model_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_thrating_domain_model_rating` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `ratedobjectuid` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(11) NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `ratingobject` int(11) NOT NULL DEFAULT 0,
  `votes` int(11) NOT NULL DEFAULT 0,
  `currentrates` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_dummy_record` smallint(5) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`),
  KEY `phpunit_dummy` (`is_dummy_record`),
  KEY `tx_thrating_domain_model_rating_i1` (`ratingobject`,`ratedobjectuid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_thrating_domain_model_rating`
--

LOCK TABLES `tx_thrating_domain_model_rating` WRITE;
/*!40000 ALTER TABLE `tx_thrating_domain_model_rating` DISABLE KEYS */;
INSERT INTO `tx_thrating_domain_model_rating` VALUES (1,2,1,1617456964,1617456964,0,0,0,1,0,'0',0);
/*!40000 ALTER TABLE `tx_thrating_domain_model_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_thrating_domain_model_ratingobject`
--

DROP TABLE IF EXISTS `tx_thrating_domain_model_ratingobject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_thrating_domain_model_ratingobject` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(11) NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `ratetable` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ratefield` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `stepconfs` int(11) NOT NULL DEFAULT 0,
  `ratings` int(11) NOT NULL DEFAULT 0,
  `is_dummy_record` smallint(5) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`),
  KEY `phpunit_dummy` (`is_dummy_record`),
  KEY `tx_thrating_domain_model_ratingobject_i1` (`ratetable`,`ratefield`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_thrating_domain_model_ratingobject`
--

LOCK TABLES `tx_thrating_domain_model_ratingobject` WRITE;
/*!40000 ALTER TABLE `tx_thrating_domain_model_ratingobject` DISABLE KEYS */;
INSERT INTO `tx_thrating_domain_model_ratingobject` VALUES (1,2,1617456964,1617456964,0,0,0,'tt_content','uid',0,0,0);
/*!40000 ALTER TABLE `tx_thrating_domain_model_ratingobject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_thrating_domain_model_stepconf`
--

DROP TABLE IF EXISTS `tx_thrating_domain_model_stepconf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_thrating_domain_model_stepconf` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(11) NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(6) NOT NULL DEFAULT 0,
  `steporder,stepweight` smallint(5) unsigned NOT NULL DEFAULT 0,
  `ratingobject` int(11) NOT NULL DEFAULT 0,
  `steporder` int(11) NOT NULL DEFAULT 1,
  `stepweight` int(11) NOT NULL DEFAULT 1,
  `stepname` int(11) NOT NULL DEFAULT 0,
  `votes` int(11) NOT NULL DEFAULT 0,
  `is_dummy_record` smallint(5) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`),
  KEY `phpunit_dummy` (`is_dummy_record`),
  KEY `tx_thrating_domain_model_stepconf_i1` (`ratingobject`,`steporder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_thrating_domain_model_stepconf`
--

LOCK TABLES `tx_thrating_domain_model_stepconf` WRITE;
/*!40000 ALTER TABLE `tx_thrating_domain_model_stepconf` DISABLE KEYS */;
/*!40000 ALTER TABLE `tx_thrating_domain_model_stepconf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_thrating_domain_model_stepname`
--

DROP TABLE IF EXISTS `tx_thrating_domain_model_stepname`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_thrating_domain_model_stepname` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(11) NOT NULL DEFAULT 0,
  `t3_origuid` int(11) NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `sys_language_uid` int(11) NOT NULL DEFAULT 0,
  `l18n_parent` int(11) NOT NULL DEFAULT 0,
  `l18n_diffsource` mediumblob NOT NULL,
  `sys_language_uid,stepconf` smallint(5) unsigned NOT NULL DEFAULT 0,
  `l10n_state` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stepconf` int(11) NOT NULL DEFAULT 0,
  `stepname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_dummy_record` smallint(5) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`),
  KEY `phpunit_dummy` (`is_dummy_record`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_thrating_domain_model_stepname`
--

LOCK TABLES `tx_thrating_domain_model_stepname` WRITE;
/*!40000 ALTER TABLE `tx_thrating_domain_model_stepname` DISABLE KEYS */;
/*!40000 ALTER TABLE `tx_thrating_domain_model_stepname` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tx_thrating_domain_model_vote`
--

DROP TABLE IF EXISTS `tx_thrating_domain_model_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tx_thrating_domain_model_vote` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT 0,
  `rating` int(11) NOT NULL DEFAULT 0,
  `tstamp` int(10) unsigned NOT NULL DEFAULT 0,
  `crdate` int(10) unsigned NOT NULL DEFAULT 0,
  `cruser_id` int(11) NOT NULL DEFAULT 0,
  `deleted` smallint(5) unsigned NOT NULL DEFAULT 0,
  `hidden` smallint(5) unsigned NOT NULL DEFAULT 0,
  `voter` int(11) NOT NULL DEFAULT 0,
  `vote` int(11) NOT NULL DEFAULT 0,
  `is_dummy_record` smallint(5) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`),
  KEY `phpunit_dummy` (`is_dummy_record`),
  KEY `tx_thrating_domain_model_vote_i1` (`rating`,`voter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tx_thrating_domain_model_vote`
--

LOCK TABLES `tx_thrating_domain_model_vote` WRITE;
/*!40000 ALTER TABLE `tx_thrating_domain_model_vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `tx_thrating_domain_model_vote` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-05  8:53:47
