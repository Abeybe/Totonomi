REATE TABLE `ttnm_rooms` (
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
);

CREATE TABLE `ttnm_users` (
  `USER_ID` char(12) NOT NULL,
  `SKYWAY_PEERID` char(16) DEFAULT NULL COMMENT 'SKYWAY接続後取得される16桁のID',
  `USER_NAME` varchar(256) DEFAULT NULL,
  `PASSWORD` varchar(256) DEFAULT NULL,
  `SAVE_FLAG` char(1) DEFAULT '0',
  `MAILADDRESS` varchar(256) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT current_timestamp(),
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`USER_ID`)
);
	
CREATE TABLE `ttnm_room_user` (
  `ROOM_ID` char(12) NOT NULL,
  `USER_ID` char(12) NOT NULL,
  `JOIN_FLAG` char(1) DEFAULT '0',
  `TABLE_ID` int(11) DEFAULT 0,
  `CREATED_AT` datetime DEFAULT current_timestamp(),
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`ROOM_ID`,`USER_ID`)
);

	
CREATE TABLE `ttnm_tables` (
  `ROOM_ID` char(12) CHARACTER SET latin1 NOT NULL,
  `TABLE_ID` int(11) NOT NULL,
  `TABLE_NAME` varchar(256) CHARACTER SET latin1 DEFAULT NULL,
  `TOPIC` varchar(256) CHARACTER SET latin1 DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT current_timestamp(),
  `UPDATED_AT` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`ROOM_ID`,`TABLE_ID`)
);

--データ全消去
DELETE FROM ttnm_rooms;
DELETE FROM ttnm_users;
DELETE FROM ttnm_room_user;
DELETE FROM ttnm_tables;