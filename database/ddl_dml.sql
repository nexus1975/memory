--2016.11.27
ALTER TABLE `users` CHANGE `activation_token` `activation_token` VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;

--2016.12.04
CREATE TABLE IF NOT EXISTS `geolocs` (
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
`clientdata` varchar( 1000 ) COLLATE utf8_unicode_ci NOT NULL ,
`serverdata` varchar( 1000 ) COLLATE utf8_unicode_ci NOT NULL ,
`longitude` varchar( 20 ) COLLATE utf8_unicode_ci NOT NULL ,
`latitude` varchar( 20 ) COLLATE utf8_unicode_ci NOT NULL ,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY ( `id` )
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT=1;

ALTER TABLE `geolocs` 
ADD `imei` VARCHAR(20) NOT NULL AFTER `latitude`, 
ADD `altitude` FLOAT NOT NULL AFTER `imei`, 
ADD `accuracy` FLOAT NOT NULL AFTER `altitude`, 
ADD `speed` FLOAT NOT NULL AFTER `accuracy`, 
ADD `bearing` FLOAT NOT NULL AFTER `speed`;

--2017.02.04
CREATE TABLE `devices` (
  `id` int(10) UNSIGNED NOT NULL,
  `imei` varchar(15) NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp,
  `status` varchar(20) DEFAULT 'NEW'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `devices` (`imei`);
ALTER TABLE `devices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

  
  CREATE TABLE `userdevices` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` int(10) UNSIGNED NOT NULL,
  `imei` varchar(15) NOT NULL,  
  `name` varchar(100) COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp,
  `status` varchar(20) DEFAULT 'NEW'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `userdevices`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `userdevices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `geolocs` ADD `deviceid` INT(10) NOT NULL AFTER `imei`;

--2017-02-11
ALTER TABLE `userdevices`
  ADD `defaultdevice` int(1) UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE `geolocs`
  ADD `devicetime` timestamp;

--2017-02-19
CREATE TABLE `savedroutes` (
  `id` int(10) UNSIGNED NOT NULL,
  `imei` varchar(15) NOT NULL,  
  `name` varchar(200) COLLATE utf8_unicode_ci,
  `datefrom` timestamp NOT NULL,
  `dateto` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `savedroutes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `savedroutes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `savedroutes` ADD `pausetime` FLOAT;

ALTER TABLE `savedroutes` ADD `distance` DOUBLE;

ALTER TABLE `savedroutes` ADD `distance2` DOUBLE;

--2017-05-30
ALTER TABLE `geolocs` 
ADD `name` VARCHAR(200) NULL AFTER `bearing`, 

--2017-06-10
CREATE TABLE IF NOT EXISTS `places` (
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
`imei` VARCHAR(20) NOT NULL,
`userid` int(10) UNSIGNED NOT NULL,
`longitude` FLOAT NOT NULL ,
`latitude` FLOAT NOT NULL ,
`altitude` FLOAT NOT NULL,
`name` VARCHAR(200) NOT NULL,
`created_at` timestamp,
`updated_at` timestamp,
PRIMARY KEY ( `id` )
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT=1;





--temp
delete from geolocs g where 
exists (select 1 from savedroutes s 
         where upper(s.name) like '%TEST%' 
           and  g.devicetime between s.datefrom and dateto
       and g.imei = s.imei)
order by 1;