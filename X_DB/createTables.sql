
-- Dumping structure for table hit.centers
DROP TABLE IF EXISTS `centers`;
CREATE TABLE IF NOT EXISTS `centers` (
  `rid` int(11) DEFAULT 0,
  `25list` longtext DEFAULT NULL,
  `50list` longtext DEFAULT NULL,
  `75list` longtext DEFAULT NULL,
  `100list` longtext DEFAULT NULL,
  `150list` longtext DEFAULT NULL,
  `175list` longtext DEFAULT NULL,
  `200list` longtext DEFAULT NULL,
  `250list` longtext DEFAULT NULL,
  `300list` longtext DEFAULT NULL,
  `maxlist` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Dumping structure for table hit.thearterslist
DROP TABLE IF EXISTS `thearterslist`;
CREATE TABLE IF NOT EXISTS `thearterslist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `th_id` varchar(50) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1349 DEFAULT CHARSET=utf8mb4;



-- Dumping structure for table hit.tolly_director
DROP TABLE IF EXISTS `tolly_director`;
CREATE TABLE IF NOT EXISTS `tolly_director` (
  `director_id` int(11) NOT NULL AUTO_INCREMENT,
  `director_name` varchar(250) DEFAULT NULL,
  `director_rate` double DEFAULT NULL,
  `director_grade` varchar(50) DEFAULT NULL,
  `director_pic` varchar(255) NOT NULL DEFAULT 'pic/u1.jpg',
  `director_status` varchar(250) DEFAULT NULL,
  `director_rating` double DEFAULT 0,
  PRIMARY KEY (`director_id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COMMENT='director Details';



-- Dumping structure for table hit.tolly_actor
DROP TABLE IF EXISTS `tolly_actor`;
CREATE TABLE IF NOT EXISTS `tolly_actor` (
  `actor_id` int(11) NOT NULL AUTO_INCREMENT,
  `actor_name` varchar(250) DEFAULT NULL,
  `actor_rate` double DEFAULT NULL,
  `actor_grade` varchar(50) DEFAULT NULL,
  `actor_pic` varchar(250) DEFAULT 'pic/u1.jpg',
  `actor_status` varchar(250) DEFAULT NULL,
  `actor_rating` double unsigned DEFAULT 0,
  PRIMARY KEY (`actor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COMMENT='actor Details';




-- Dumping structure for table hit.tolly_actress
DROP TABLE IF EXISTS `tolly_actress`;
CREATE TABLE IF NOT EXISTS `tolly_actress` (
  `actress_id` int(11) NOT NULL AUTO_INCREMENT,
  `actress_name` varchar(250) DEFAULT NULL,
  `actress_rate` double DEFAULT NULL,
  `actress_grade` varchar(50) DEFAULT NULL,
  `actress_pic` varchar(250) DEFAULT 'pic/u1.jpg',
  `actress_status` varchar(250) DEFAULT NULL,
  `actress_rating` double unsigned DEFAULT 0,
  PRIMARY KEY (`actress_id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COMMENT='actress Details';



-- Dumping structure for table hit.tolly_writer
DROP TABLE IF EXISTS `tolly_writer`;
CREATE TABLE IF NOT EXISTS `tolly_writer` (
  `writer_id` int(11) NOT NULL AUTO_INCREMENT,
  `writer_name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `writer_rate` double DEFAULT NULL,
  `writer_grade` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `writer_pic` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pic/u1.jpg',
  `writer_status` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `writer_rating` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`writer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

 
-- Dumping structure for table hit.tolly_music
DROP TABLE IF EXISTS `tolly_music`;
CREATE TABLE IF NOT EXISTS `tolly_music` (
  `music_id` int(11) NOT NULL AUTO_INCREMENT,
  `music_name` varchar(250) DEFAULT NULL,
  `music_rate` double DEFAULT NULL,
  `music_grade` varchar(50) DEFAULT NULL,
  `music_pic` varchar(50) NOT NULL DEFAULT 'pic/u1.jpg',
  `music_status` varchar(250) DEFAULT NULL,
  `music_rating` double DEFAULT 0,
  PRIMARY KEY (`music_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='music Details';
 

-- Dumping structure for table hit.tolly_cine
DROP TABLE IF EXISTS `tolly_cine`;
CREATE TABLE IF NOT EXISTS `tolly_cine` (
  `cine_id` int(11) NOT NULL AUTO_INCREMENT,
  `cine_name` varchar(250) DEFAULT NULL,
  `cine_rate` double DEFAULT NULL,
  `cine_grade` varchar(50) DEFAULT NULL,
  `cine_pic` varchar(50) NOT NULL DEFAULT 'pic/u1.jpg',
  `cine_status` varchar(250) DEFAULT NULL,
  `cine_rating` double unsigned DEFAULT 0,
  PRIMARY KEY (`cine_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='cine Details';




 

-- Dumping structure for table hit.tolly_editor
DROP TABLE IF EXISTS `tolly_editor`;
CREATE TABLE IF NOT EXISTS `tolly_editor` (
  `editor_id` int(11) NOT NULL AUTO_INCREMENT,
  `editor_name` varchar(250) DEFAULT NULL,
  `editor_rate` double DEFAULT NULL,
  `editor_grade` varchar(50) DEFAULT NULL,
  `editor_pic` varchar(50) NOT NULL DEFAULT 'pic/u1.jpg',
  `editor_status` varchar(250) DEFAULT NULL,
  `editor_rating` double unsigned DEFAULT 0,
  PRIMARY KEY (`editor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='editor Details';



-- Dumping structure for table hit.tolly_news
DROP TABLE IF EXISTS `tolly_news`;
CREATE TABLE IF NOT EXISTS `tolly_news` (
  `nid` int(11) NOT NULL AUTO_INCREMENT,
  `news` longtext DEFAULT NULL,
  `heading` mediumtext DEFAULT NULL,
  `pic` mediumtext DEFAULT NULL,
  PRIMARY KEY (`nid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table hit.tolly_news: 0 rows
/*!40000 ALTER TABLE `tolly_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `tolly_news` ENABLE KEYS */;

-- Dumping structure for table hit.tolly_ready_for_shoot
DROP TABLE IF EXISTS `tolly_ready_for_shoot`;
CREATE TABLE IF NOT EXISTS `tolly_ready_for_shoot` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL,
  `acid` int(11) DEFAULT NULL,
  `did` int(11) DEFAULT NULL,
  `wid` int(11) DEFAULT NULL,
  `mid` int(11) DEFAULT NULL,
  `eid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `budget` double DEFAULT NULL,
  `collection` double DEFAULT NULL,
  `profit` double DEFAULT NULL,
  `sofar` double DEFAULT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `pic` varchar(250) DEFAULT NULL,
  `dt` date NOT NULL,
  `notes` varchar(250) DEFAULT NULL,
  `dname` varchar(250) DEFAULT NULL,
  `aname` varchar(250) DEFAULT NULL,
  `acname` varchar(250) DEFAULT NULL,
  `s` varchar(250) NOT NULL DEFAULT 's1_a',
  `progress` int(10) unsigned DEFAULT NULL,
  `rating` double unsigned DEFAULT 0,
  `result` varchar(200) NOT NULL DEFAULT '0',
  `cinename` varchar(200) NOT NULL DEFAULT '0',
  `ediname` varchar(200) NOT NULL DEFAULT '0',
  `musname` varchar(200) NOT NULL DEFAULT '0',
  `wriname` varchar(200) DEFAULT '0',
  `a2` int(11) DEFAULT 0,
  `a2_name` varchar(50) DEFAULT '0',
  `a3` int(11) DEFAULT 0,
  `a3_name` varchar(50) DEFAULT '0',
  `ac2` int(11) DEFAULT 0,
  `ac2_name` varchar(50) DEFAULT '0',
  `ac3` int(11) DEFAULT 0,
  `ac3_name` varchar(50) DEFAULT '0',
  `d2` int(11) DEFAULT 0,
  `d2_name` varchar(50) DEFAULT '0',
  `d3` int(11) DEFAULT 0,
  `d3_name` varchar(50) DEFAULT '0',
  `w2` int(11) DEFAULT 0,
  `w2_name` varchar(50) DEFAULT '0',
  `w3` int(11) DEFAULT 0,
  `w3_name` varchar(50) DEFAULT '0',
  `m2` int(11) DEFAULT 0,
  `m2_name` varchar(50) DEFAULT '0',
  `m3` int(11) DEFAULT 0,
  `m3_name` varchar(50) DEFAULT '0',
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table hit.tolly_ready_for_shoot: 0 rows
/*!40000 ALTER TABLE `tolly_ready_for_shoot` DISABLE KEYS */;
/*!40000 ALTER TABLE `tolly_ready_for_shoot` ENABLE KEYS */;

-- Dumping structure for table hit.tolly_release
DROP TABLE IF EXISTS `tolly_release`;
CREATE TABLE IF NOT EXISTS `tolly_release` (
  `uid` int(11) NOT NULL DEFAULT 0,
  `rid` int(11) NOT NULL DEFAULT 0,
  `rel_cen` int(11) DEFAULT 0,
  `a1_cen` int(11) DEFAULT 0,
  `a2_cen` int(11) DEFAULT 0,
  `a3_cen` int(11) DEFAULT 0,
  `a4_cen` int(11) DEFAULT 0,
  `a5_cen` int(11) DEFAULT 0,
  `a1` double DEFAULT 0,
  `a2` double DEFAULT 0,
  `a3` double DEFAULT 0,
  `a4` double DEFAULT 0,
  `a5` double DEFAULT 0,
  `a6` double DEFAULT 0,
  `1w_coll` double DEFAULT 0,
  `2w_coll` double DEFAULT 0,
  `25d_coll` double DEFAULT 0,
  `50d_coll` double DEFAULT 0,
  `75d_coll` double DEFAULT 0,
  `100d_coll` double DEFAULT 0,
  `125d_coll` double DEFAULT 0,
  `150d_coll` double DEFAULT 0,
  `175d_coll` double DEFAULT 0,
  `total_coll` double DEFAULT 0,
  `1w_cen` int(11) DEFAULT 0,
  `2w_cen` int(11) DEFAULT 0,
  `25d_cen` int(11) DEFAULT 0,
  `50d_cen` int(11) DEFAULT 0,
  `75d_cen` int(11) DEFAULT 0,
  `100d_cen` int(11) DEFAULT 0,
  `125d_cen` int(11) DEFAULT 0,
  `150d_cen` int(11) DEFAULT 0,
  `175d_cen` int(11) DEFAULT 0,
  `200d_cen` int(11) DEFAULT 0,
  `250d_cen` int(11) DEFAULT 0,
  `300d_cen` int(11) DEFAULT 0,
  `350d_cen` int(11) DEFAULT 0,
  `400d_cen` int(11) DEFAULT 0,
  `max_days` int(11) DEFAULT 0,
  `max_cent` varchar(50) DEFAULT '0',
  `50cen` longtext DEFAULT NULL,
  `100cen` longtext DEFAULT NULL,
  `175cen` longtext DEFAULT NULL,
  `notes` longtext DEFAULT NULL,
  `rel_date` datetime DEFAULT NULL,
  `r1` double DEFAULT NULL,
  `r2` double DEFAULT NULL,
  `r3` double DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `poster` varchar(50) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table hit.tolly_release: 0 rows
/*!40000 ALTER TABLE `tolly_release` DISABLE KEYS */;
/*!40000 ALTER TABLE `tolly_release` ENABLE KEYS */;

-- Dumping structure for table hit.tolly_s1
DROP TABLE IF EXISTS `tolly_s1`;
CREATE TABLE IF NOT EXISTS `tolly_s1` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0,
  `s1_a_cost` double DEFAULT NULL,
  `s1_b_cost` double DEFAULT NULL,
  `s1_c_cost` double DEFAULT NULL,
  `s1_a_rate` double DEFAULT NULL,
  `s1_b_rate` double DEFAULT NULL,
  `s1_c_rate` double DEFAULT NULL,
  `s1_status` varchar(50) DEFAULT NULL,
  `s1_best` double DEFAULT NULL,
  KEY `rid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table hit.tolly_s1: 0 rows
/*!40000 ALTER TABLE `tolly_s1` DISABLE KEYS */;
/*!40000 ALTER TABLE `tolly_s1` ENABLE KEYS */;

-- Dumping structure for table hit.tolly_s2
DROP TABLE IF EXISTS `tolly_s2`;
CREATE TABLE IF NOT EXISTS `tolly_s2` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0,
  `s2_a_cost` double DEFAULT NULL,
  `s2_b_cost` double DEFAULT NULL,
  `s2_c_cost` double DEFAULT NULL,
  `s2_a_rate` double DEFAULT NULL,
  `s2_b_rate` double DEFAULT NULL,
  `s2_c_rate` double DEFAULT NULL,
  `s2_status` varchar(50) DEFAULT NULL,
  `s2_best` double DEFAULT NULL,
  KEY `rid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table hit.tolly_s2: 0 rows
/*!40000 ALTER TABLE `tolly_s2` DISABLE KEYS */;
/*!40000 ALTER TABLE `tolly_s2` ENABLE KEYS */;

-- Dumping structure for table hit.tolly_s3
DROP TABLE IF EXISTS `tolly_s3`;
CREATE TABLE IF NOT EXISTS `tolly_s3` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0,
  `s3_a_cost` double DEFAULT NULL,
  `s3_b_cost` double DEFAULT NULL,
  `s3_c_cost` double DEFAULT NULL,
  `s3_a_rate` double DEFAULT NULL,
  `s3_b_rate` double DEFAULT NULL,
  `s3_c_rate` double DEFAULT NULL,
  `s3_status` varchar(50) DEFAULT NULL,
  `s3_best` double DEFAULT NULL,
  KEY `rid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table hit.tolly_s3: 0 rows
/*!40000 ALTER TABLE `tolly_s3` DISABLE KEYS */;
/*!40000 ALTER TABLE `tolly_s3` ENABLE KEYS */;

-- Dumping structure for table hit.tolly_s4
DROP TABLE IF EXISTS `tolly_s4`;
CREATE TABLE IF NOT EXISTS `tolly_s4` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0,
  `s4_a_cost` double DEFAULT NULL,
  `s4_b_cost` double DEFAULT NULL,
  `s4_c_cost` double DEFAULT NULL,
  `s4_a_rate` double DEFAULT NULL,
  `s4_b_rate` double DEFAULT NULL,
  `s4_c_rate` double DEFAULT NULL,
  `s4_status` varchar(50) DEFAULT NULL,
  `s4_best` double DEFAULT NULL,
  KEY `rid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table hit.tolly_s4: 0 rows
/*!40000 ALTER TABLE `tolly_s4` DISABLE KEYS */;
/*!40000 ALTER TABLE `tolly_s4` ENABLE KEYS */;

-- Dumping structure for table hit.tolly_s5
DROP TABLE IF EXISTS `tolly_s5`;
CREATE TABLE IF NOT EXISTS `tolly_s5` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0,
  `s5_a_cost` double DEFAULT NULL,
  `s5_b_cost` double DEFAULT NULL,
  `s5_c_cost` double DEFAULT NULL,
  `s5_a_rate` double DEFAULT NULL,
  `s5_b_rate` double DEFAULT NULL,
  `s5_c_rate` double DEFAULT NULL,
  `s5_status` varchar(50) DEFAULT NULL,
  `s5_best` double DEFAULT NULL,
  KEY `rid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table hit.tolly_s5: 0 rows
/*!40000 ALTER TABLE `tolly_s5` DISABLE KEYS */;
/*!40000 ALTER TABLE `tolly_s5` ENABLE KEYS */;

-- Dumping structure for table hit.tolly_s6
DROP TABLE IF EXISTS `tolly_s6`;
CREATE TABLE IF NOT EXISTS `tolly_s6` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0,
  `s6_a_cost` double DEFAULT NULL,
  `s6_b_cost` double DEFAULT NULL,
  `s6_c_cost` double DEFAULT NULL,
  `s6_a_rate` double DEFAULT NULL,
  `s6_b_rate` double DEFAULT NULL,
  `s6_c_rate` double DEFAULT NULL,
  `s6_status` varchar(50) DEFAULT NULL,
  `s6_best` double DEFAULT NULL,
  KEY `rid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table hit.tolly_s6: 0 rows
/*!40000 ALTER TABLE `tolly_s6` DISABLE KEYS */;
/*!40000 ALTER TABLE `tolly_s6` ENABLE KEYS */;

-- Dumping structure for table hit.tolly_s7
DROP TABLE IF EXISTS `tolly_s7`;
CREATE TABLE IF NOT EXISTS `tolly_s7` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0,
  `s7_a_cost` double DEFAULT NULL,
  `s7_b_cost` double DEFAULT NULL,
  `s7_c_cost` double DEFAULT NULL,
  `s7_a_rate` double DEFAULT NULL,
  `s7_b_rate` double DEFAULT NULL,
  `s7_c_rate` double DEFAULT NULL,
  `s7_status` varchar(50) DEFAULT NULL,
  `s7_best` double DEFAULT NULL,
  KEY `rid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table hit.tolly_s7: 0 rows
/*!40000 ALTER TABLE `tolly_s7` DISABLE KEYS */;
/*!40000 ALTER TABLE `tolly_s7` ENABLE KEYS */;

-- Dumping structure for table hit.tolly_s8
DROP TABLE IF EXISTS `tolly_s8`;
CREATE TABLE IF NOT EXISTS `tolly_s8` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0,
  `s8_a_cost` double DEFAULT NULL,
  `s8_b_cost` double DEFAULT NULL,
  `s8_c_cost` double DEFAULT NULL,
  `s8_a_rate` double DEFAULT NULL,
  `s8_b_rate` double DEFAULT NULL,
  `s8_c_rate` double DEFAULT NULL,
  `s8_status` varchar(50) DEFAULT NULL,
  `s8_best` double DEFAULT NULL,
  KEY `rid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table hit.tolly_s8: 0 rows
/*!40000 ALTER TABLE `tolly_s8` DISABLE KEYS */;
/*!40000 ALTER TABLE `tolly_s8` ENABLE KEYS */;

-- Dumping structure for table hit.tolly_s9
DROP TABLE IF EXISTS `tolly_s9`;
CREATE TABLE IF NOT EXISTS `tolly_s9` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0,
  `s9_a_cost` double DEFAULT NULL,
  `s9_b_cost` double DEFAULT NULL,
  `s9_c_cost` double DEFAULT NULL,
  `s9_a_rate` double DEFAULT NULL,
  `s9_b_rate` double DEFAULT NULL,
  `s9_c_rate` double DEFAULT NULL,
  `s9_status` varchar(50) DEFAULT NULL,
  `s9_best` double DEFAULT NULL,
  KEY `rid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table hit.tolly_s9: 0 rows
/*!40000 ALTER TABLE `tolly_s9` DISABLE KEYS */;
/*!40000 ALTER TABLE `tolly_s9` ENABLE KEYS */;

-- Dumping structure for table hit.tolly_user
DROP TABLE IF EXISTS `tolly_user`;
CREATE TABLE IF NOT EXISTS `tolly_user` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `pic` varchar(50) NOT NULL DEFAULT 'pic/u1.jpg',
  `bal` double unsigned DEFAULT 50000000,
  `banner` varchar(250) DEFAULT NULL,
  `utype` varchar(50) DEFAULT 'user',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

-- Dumping data for table hit.tolly_user: 2 rows
/*!40000 ALTER TABLE `tolly_user` DISABLE KEYS */;
INSERT INTO `tolly_user` (`uid`, `username`, `password`, `email`, `status`, `pic`, `bal`, `banner`, `utype`) VALUES
	(93, 'admin', 'admin', 'admin', 'active', 'pic/u1.jpg', 996176585980, 'satya', 'admin'),
	(95, 'user', 'user', 'user', 'active', 'pic/u1.jpg', 2769910120, 'USER PRODUCTIONS', 'user');
/*!40000 ALTER TABLE `tolly_user` ENABLE KEYS */;

