CREATE TABLE `TTNM_ROOMS` (
  `ROOM_ID` char(12) NOT NULL,
  `ROOM_NAME` varchar(256) DEFAULT NULL,
  `PASSWORD` varchar(256) DEFAULT NULL,
  `HOST_USER_ID` char(12) DEFAULT NULL,
  `MEMBER_NUM` int(11) DEFAULT NULL,
  `TABLE_NUM` int(11) DEFAULT NULL,
  `PUBLIC_FLAG` char(1) DEFAULT '0',
  `CREATED_AT` datetime DEFAULT current_timestamp(),
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`ROOM_ID`)
)ENGINE = InnoDB
DEFAULT CHARACTER SET 'utf8';

CREATE TABLE `TTNM_USERS` (
  `USER_ID` char(12) NOT NULL,
  `SKYWAY_PEERID` char(16) DEFAULT NULL COMMENT 'SKYWAY接続後取得される16桁のID',
  `USER_NAME` varchar(256) DEFAULT NULL,
  `PASSWORD` varchar(256) DEFAULT NULL,
  `SAVE_FLAG` char(1) DEFAULT '0',
  `MAILADDRESS` varchar(256) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT current_timestamp(),
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`USER_ID`)
)ENGINE = InnoDB
DEFAULT CHARACTER SET 'utf8';
	
CREATE TABLE `TTNM_ROOM_USER` (
  `ROOM_ID` char(12) NOT NULL,
  `USER_ID` char(12) NOT NULL,
  `JOIN_FLAG` char(1) DEFAULT '0',
  `TABLE_ID` int(11) DEFAULT 1,
  `CREATED_AT` datetime DEFAULT current_timestamp(),
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`ROOM_ID`,`USER_ID`),
  KEY `TTNM_ROOM_USER_IDFK_1` (`USER_ID`),
  CONSTRAINT `TTNM_ROOM_USER_IDFK_1` FOREIGN KEY (`USER_ID`) REFERENCES `TTNM_USERS` (`USER_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `TTNM_ROOM_USER_IDFK_2` FOREIGN KEY (`ROOM_ID`) REFERENCES `TTNM_ROOMS` (`ROOM_ID`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE = InnoDB
DEFAULT CHARACTER SET 'utf8';
	
CREATE TABLE `TTNM_TABLES` (
  `ROOM_ID` char(12) NOT NULL,
  `TABLE_ID` int(11) NOT NULL,
  `TABLE_NAME` varchar(256) DEFAULT NULL,
  `TOPIC` varchar(256) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT current_timestamp(),
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`ROOM_ID`,`TABLE_ID`),
  CONSTRAINT `TTNM_TABLES_IDFK_1` FOREIGN KEY (`ROOM_ID`) REFERENCES `TTNM_ROOMS` (`ROOM_ID`) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE = InnoDB
DEFAULT CHARACTER SET 'utf8';

--データ全消去

--会場削除でテーブル(ttnm_table)と会場-ユーザ情報(TTNM_ROOM_USER)を削除
DELETE FROM ttnm_rooms;
--ユーザ削除で会場-ユーザ情報(TTNM_ROOM_USER)を削除
DELETE FROM ttnm_users;