-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2020 at 09:00 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `topicste_main_db`
--
CREATE DATABASE IF NOT EXISTS `topicste_main_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `topicste_main_db`;

-- --------------------------------------------------------

--
-- Table structure for table `main_member`
--

CREATE TABLE `main_member` (
  `Status` varchar(50) NOT NULL,
  `Fullname` varchar(100) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `Mobile` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `UniqueId` varchar(100) DEFAULT NULL,
  `Position` varchar(200) NOT NULL,
  `UserUrl` varchar(100) NOT NULL,
  `ProfileUrl` varchar(150) NOT NULL,
  `Pincode` varchar(50) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(100) NOT NULL,
  `Country` varchar(100) NOT NULL,
  `Address` varchar(300) NOT NULL,
  `OtpData` text DEFAULT NULL,
  `Password` varchar(300) NOT NULL,
  `SecurityCode` varchar(300) NOT NULL,
  `AccountCreateAs` varchar(100) NOT NULL,
  `VerifyedAccount` text DEFAULT NULL,
  `SocialAccount` text DEFAULT NULL,
  `LastActiveTime` varchar(100) DEFAULT NULL,
  `LoginTime` varchar(100) NOT NULL,
  `LoginUniqueId` varchar(150) DEFAULT NULL,
  `LoginTokenData` text DEFAULT NULL,
  `CreateTime` varchar(100) NOT NULL,
  `PassChangeTime` varchar(100) NOT NULL,
  `LastUpdateBy` varchar(100) NOT NULL,
  `LastUpdatePosition` varchar(200) NOT NULL,
  `LastUpdateRank` varchar(100) NOT NULL,
  `LastUpdateTime` varchar(100) NOT NULL,
  `CreateBy` varchar(100) NOT NULL,
  `CreateByPosition` varchar(200) NOT NULL,
  `CreateByRank` varchar(100) NOT NULL,
  `LastChanges` text DEFAULT NULL,
  `StatusActionReason` varchar(200) DEFAULT NULL,
  `Signature` varchar(130) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `main_member`
--

INSERT INTO `main_member` (`Status`, `Fullname`, `Gender`, `Mobile`, `Email`, `UniqueId`, `Position`, `UserUrl`, `ProfileUrl`, `Pincode`, `City`, `State`, `Country`, `Address`, `OtpData`, `Password`, `SecurityCode`, `AccountCreateAs`, `VerifyedAccount`, `SocialAccount`, `LastActiveTime`, `LoginTime`, `LoginUniqueId`, `LoginTokenData`, `CreateTime`, `PassChangeTime`, `LastUpdateBy`, `LastUpdatePosition`, `LastUpdateRank`, `LastUpdateTime`, `CreateBy`, `CreateByPosition`, `CreateByRank`, `LastChanges`, `StatusActionReason`, `Signature`) VALUES
('H% ;ñ{ ÿ<Ú', 'éj€Á^dùÇÂE€¿ÛCD,', 'Ù\\7Ùg)¤Õ3žü\'w—d', 'UòáCˆ\\Â\r²vö+!', '{\\ÌÀVçJº”‚¬Ò ànÍëŠ†»K„ñ­›J[', 'q¶ÊÆç­‚>7Xñ°XL', 'HzÓmopBÐúÔÙ½í¥ò', '?\\^³;¢ªƒßPo?–6”ëS†Ã2go¨yƒ^‡æ', '?\\^³;¢ªƒßPo?–6”4\'Í@ˆís‚ŒklMrÿ¿>°n÷–¶µnûÝN‰¬>(', '§ã¡÷.¦ ;Yød0ðÛó', 'áiÏÌÎÒgÕâ!{', '‡Ï<àUÏÛ—3‘À¿âŽy', '\n6¬E‚^Ûž“‘Š', 'HíºñÈ?}ÅÇûF+0Ñ’3Ã¥$æ°êTßÕ×Ç0\"ã', NULL, '0°3’:œHƒ²œ—ÄŒšpPßÃ¥ôyºØ%¤ò„cš>î_ÔLK¬3º\n+D²°«9+/€2‡°uF—¤$wÄòP`zVìïKÚô(~ú¿­é', '*4°Ëžs-fKq¢¸[[e% \Z’gUcÇ\'ÎR>Ä¾Ü`‰ÀhßdYÎöæíyR¢šLàUÝpJ!Åq8Ú¼6Îv`zVìïKÚô(~ú¿­é', '‘õÎHôç¥™ÃïµE5', '¾«cÜ‡@ø×=ó³˜Ö˜›$&M‘y˜Q®hÃwá»F3t\\²Ç€˜šçÊH£7ÁÝx,òÃw~ðÝÐ*m}K', NULL, 'v=6±·¸ˆ+ê‚C©ÈXk', '´n¹*QäMM&ÿSJ\Z€‹£', 'º\0Ñ$Z·ö7qÄj«Jò}•Þ¨¨ÜvßŽàœ¬ƒÜ{ÊñlÐNœ*·õŸÔƒÌ·V', '¾§ÑEMÃ#Šâ”½ß¸\rm', '´n¹*QäMM&ÿSJ\Z€‹£', '´n¹*QäMM&ÿSJ\Z€‹£', '?\\^³;¢ªƒßPo?–6”ëS†Ã2go¨yƒ^‡æ', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '´n¹*QäMM&ÿSJ\Z€‹£', '?\\^³;¢ªƒßPo?–6”ëS†Ã2go¨yƒ^‡æ', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `main_member_setting`
--

CREATE TABLE `main_member_setting` (
  `CreateType` varchar(100) NOT NULL,
  `UpdateAble` varchar(100) NOT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `main_member_setting`
--

INSERT INTO `main_member_setting` (`CreateType`, `UpdateAble`, `SettingKeyUnique`, `SettingValueUnique`, `SettingKey`, `SettingValue`) VALUES
('0õh:—2ò¶Jèf{ã*°§¡• XïÄžÜÆ²Æ', 'hÕP^$æªóž¶ßûø¸~‚', '/³Fåg¨ð²jÛ˜w', NULL, NULL, 'x¥ÔI4Ã>y‰=‡\0¥ŒTEˆ0ßH#6KÄt3%‚›úY\\½	L[ž2J7');

-- --------------------------------------------------------

--
-- Table structure for table `main_user_accounts`
--

CREATE TABLE `main_user_accounts` (
  `Status` varchar(50) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `OrganizationType` varchar(100) NOT NULL,
  `OrganizationName` varchar(200) NOT NULL,
  `PostionRequest` varchar(80) NOT NULL,
  `Bio` varchar(300) NOT NULL,
  `UserUrl` varchar(100) NOT NULL,
  `SignupType` varchar(100) NOT NULL,
  `CreateTime` varchar(100) NOT NULL,
  `LastUpdateBy` varchar(100) NOT NULL,
  `LastUpdateTime` varchar(100) NOT NULL,
  `LastUpdatePosition` varchar(100) NOT NULL,
  `LastUpdateRank` varchar(100) NOT NULL,
  `Version` varchar(100) NOT NULL,
  `LastChanges` text DEFAULT NULL,
  `StatusReason` text DEFAULT NULL,
  `Signature` varchar(130) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `main_user_accounts`
--

INSERT INTO `main_user_accounts` (`Status`, `Username`, `OrganizationType`, `OrganizationName`, `PostionRequest`, `Bio`, `UserUrl`, `SignupType`, `CreateTime`, `LastUpdateBy`, `LastUpdateTime`, `LastUpdatePosition`, `LastUpdateRank`, `Version`, `LastChanges`, `StatusReason`, `Signature`) VALUES
('H% ;ñ{ ÿ<Ú', '«îUå–dsêÑâÒ', '‹§TË$\\¥\0…?º‡­FØ', 'oLêQýh¹»Yoÿ¼u', 'Ù\\7Ùg)¤Õ3žü\'w—d', 'qP äÓG(hØœ8ûô÷iäÅ$SÛîöÃðnl', 'n¥=%K\nsC\"O}ž÷?†°*\0²Â®a„FÍ\\Ô', 'Ù\\7Ùg)¤Õ3žü\'w—d', '\'×e}i^çïóèåa¼o', 'ÞD+J,*ì\\Ðw~¡ÏKoÕ', '\'×e}i^çïóèåa¼o', 'ÞD+J,*ì\\Ðw~¡ÏKoÕ', 'Ä8ŠŸùÉÄQŽÈ<6p', '©XùrŠÈKý6ßW§£1', NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', 'ÎöÁ+ø·ìÛe:‹ ', '‹§TË$\\¥\0…?º‡­FØ', '~ë×Ÿ`\\&M“s.àÀe¥', 'Ù\\7Ùg)¤Õ3žü\'w—d', 'qP äÓG(hØœ8ûô÷iäÅ$SÛîöÃðnl', '_ØjA¸ÜB¾2¦\Z|Ap¡+6[©ž7þPÐwLº«', 'Ù\\7Ùg)¤Õ3žü\'w—d', 'Âølë—Gjedñíý©', 'ÞD+J,*ì\\Ðw~¡ÏKoÕ', 'Âølë—Gjedñíý©', 'ÞD+J,*ì\\Ðw~¡ÏKoÕ', 'Ä8ŠŸùÉÄQŽÈ<6p', '©XùrŠÈKý6ßW§£1', NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', 'Õ‘‡ÛîÒ¨-\r\\²¼`zVìïKÚô(~ú¿­é', '‹§TË$\\¥\0…?º‡­FØ', '!A¾|q¿D\n$[Ý\0', 'Ù\\7Ùg)¤Õ3žü\'w—d', 'qP äÓG(hØœ8ûô÷iäÅ$SÛîöÃðnl', 'o‹³Ûk»ß\'L´6×ÿ«õô_›GßžY5Ç¼ËÄvÚJ', 'Ù\\7Ùg)¤Õ3žü\'w—d', '‹iô@¢˜#*Ë:A	h', 'ÞD+J,*ì\\Ðw~¡ÏKoÕ', '‹iô@¢˜#*Ë:A	h', 'ÞD+J,*ì\\Ðw~¡ÏKoÕ', 'Ä8ŠŸùÉÄQŽÈ<6p', '©XùrŠÈKý6ßW§£1', NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', 'q¶ÊÆç­‚>7Xñ°XL', '£ScavèÈ[„U…7]á', '£ScavèÈ[„U…7]á', 'ô!ž§k¨}±ü–Mûã¥R', '8‹#Áê1·^ôOî¬n)yõÏQÀBr¬ß»™9ò![:^Ÿ˜Ûó¹‘mJ', '?\\^³;¢ªƒßPo?–6”ëS†Ã2go¨yƒ^‡æ', '£ScavèÈ[„U…7]á', '´n¹*QäMM&ÿSJ\Z€‹£', 'ÞD+J,*ì\\Ðw~¡ÏKoÕ', '´n¹*QäMM&ÿSJ\Z€‹£', 'ÞD+J,*ì\\Ðw~¡ÏKoÕ', 'Ä8ŠŸùÉÄQŽÈ<6p', '©XùrŠÈKý6ßW§£1', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `main_member`
--
ALTER TABLE `main_member`
  ADD PRIMARY KEY (`UserUrl`) USING BTREE,
  ADD UNIQUE KEY `ProfileUrl` (`ProfileUrl`),
  ADD UNIQUE KEY `Mobile` (`Mobile`) USING BTREE,
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `UniqueId` (`UniqueId`),
  ADD UNIQUE KEY `LoginUniqueId` (`LoginUniqueId`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `main_member_setting`
--
ALTER TABLE `main_member_setting`
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`);

--
-- Indexes for table `main_user_accounts`
--
ALTER TABLE `main_user_accounts`
  ADD PRIMARY KEY (`Username`),
  ADD UNIQUE KEY `UserUrl` (`UserUrl`),
  ADD UNIQUE KEY `Signature` (`Signature`);
--
-- Database: `topicste_organization_user_account`
--
CREATE DATABASE IF NOT EXISTS `topicste_organization_user_account` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `topicste_organization_user_account`;

-- --------------------------------------------------------

--
-- Table structure for table `acxh6tfsld1586939542bdlbqt1k2q`
--

CREATE TABLE `acxh6tfsld1586939542bdlbqt1k2q` (
  `Status` varchar(50) NOT NULL,
  `Fullname` varchar(100) NOT NULL,
  `FatherFullname` varchar(100) DEFAULT NULL,
  `GuardianFullname` varchar(100) DEFAULT NULL,
  `Gender` varchar(50) NOT NULL,
  `GuardianGender` varchar(50) DEFAULT NULL,
  `Mobile` varchar(100) NOT NULL,
  `FatherMobile` varchar(100) DEFAULT NULL,
  `GuardianMobile` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `FatherEmail` varchar(100) DEFAULT NULL,
  `GuardianEmail` varchar(100) DEFAULT NULL,
  `UniqueId` varchar(100) DEFAULT NULL,
  `OpUniqueId` varchar(100) DEFAULT NULL,
  `SocialAccount` text DEFAULT NULL,
  `VerifyedAccount` text DEFAULT NULL,
  `FatherSocialAccount` text DEFAULT NULL,
  `FatherVerifyedAccount` text DEFAULT NULL,
  `GuardianSocialAccount` text DEFAULT NULL,
  `GuardianVerifyedAccount` text DEFAULT NULL,
  `Position` varchar(200) NOT NULL,
  `Department` varchar(300) DEFAULT NULL,
  `Semester` varchar(100) DEFAULT NULL,
  `StudyYear` varchar(100) DEFAULT NULL,
  `Branch` varchar(300) DEFAULT NULL,
  `UserUrl` varchar(100) NOT NULL,
  `ProfileUrl` varchar(150) NOT NULL,
  `PrimaryBatchId` varchar(100) DEFAULT NULL,
  `SecondaryBatchId` varchar(100) DEFAULT NULL,
  `OrgJoinTime` varchar(100) NOT NULL,
  `OrgStayDur` varchar(100) DEFAULT NULL,
  `OrgExitTime` varchar(100) DEFAULT NULL,
  `Pincode` varchar(50) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(100) NOT NULL,
  `Country` varchar(100) NOT NULL,
  `Address` varchar(300) NOT NULL,
  `OtpData` text DEFAULT NULL,
  `Password` varchar(300) NOT NULL,
  `SecurityCode` varchar(300) NOT NULL,
  `AccountCreateAs` varchar(100) NOT NULL,
  `LastActiveTime` varchar(100) DEFAULT NULL,
  `LoginTime` varchar(100) NOT NULL,
  `LoginUniqueId` varchar(150) DEFAULT NULL,
  `LoginTokenData` text DEFAULT NULL,
  `CreateTime` varchar(100) NOT NULL,
  `PassChangeTime` varchar(100) NOT NULL,
  `LastUpdateBy` varchar(100) NOT NULL,
  `LastUpdatePosition` varchar(200) NOT NULL,
  `LastUpdateRank` varchar(100) NOT NULL,
  `LastUpdateTime` varchar(100) NOT NULL,
  `CreateBy` varchar(100) NOT NULL,
  `CreateByPosition` varchar(200) NOT NULL,
  `CreateByRank` varchar(100) NOT NULL,
  `LastChanges` text DEFAULT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL,
  `StatusActionReason` varchar(200) DEFAULT NULL,
  `Signature` varchar(130) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acxh6tfsld1586939542bdlbqt1k2q`
--

INSERT INTO `acxh6tfsld1586939542bdlbqt1k2q` (`Status`, `Fullname`, `FatherFullname`, `GuardianFullname`, `Gender`, `GuardianGender`, `Mobile`, `FatherMobile`, `GuardianMobile`, `Email`, `FatherEmail`, `GuardianEmail`, `UniqueId`, `OpUniqueId`, `SocialAccount`, `VerifyedAccount`, `FatherSocialAccount`, `FatherVerifyedAccount`, `GuardianSocialAccount`, `GuardianVerifyedAccount`, `Position`, `Department`, `Semester`, `StudyYear`, `Branch`, `UserUrl`, `ProfileUrl`, `PrimaryBatchId`, `SecondaryBatchId`, `OrgJoinTime`, `OrgStayDur`, `OrgExitTime`, `Pincode`, `City`, `State`, `Country`, `Address`, `OtpData`, `Password`, `SecurityCode`, `AccountCreateAs`, `LastActiveTime`, `LoginTime`, `LoginUniqueId`, `LoginTokenData`, `CreateTime`, `PassChangeTime`, `LastUpdateBy`, `LastUpdatePosition`, `LastUpdateRank`, `LastUpdateTime`, `CreateBy`, `CreateByPosition`, `CreateByRank`, `LastChanges`, `SettingKeyUnique`, `SettingValueUnique`, `SettingKey`, `SettingValue`, `StatusActionReason`, `Signature`) VALUES
('H% ;ñ{ ÿ<Ú', 'Z´èÚ‚çShMúÎú‚c¥[KdIIŸµV³_8	¬T', 'ƒ—*ù·®LÎªã“4S/', 'Œˆà®\\}zï1|^÷ò', '¾Š  ÓÎ\0p?ÚX', '¾Š  ÓÎ\0p?ÚX', 'UòáCˆ\\Â\r²vö+!', '¾<9Þb¡7NšFQqç‚', 'ó‰Úÿqx<¥ÊiŽÌ', NULL, NULL, NULL, 'çwÍJrÄòúÇÊÄ_z?', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ï;).$A‚ÍÝ5BVª&', NULL, 'Ä8ŠŸùÉÄQŽÈ<6p', 'Ä8ŠŸùÉÄQŽÈ<6p', 'sç– Ë½…ïÁ°îYöß­', '7Ï,fÙ(®¥U+Ñý!³ážKPÿfM¬Ä´Â·I¹', '7Ï,fÙ(®¥U+Ñý!Oó‘dNý„J¡¬Õ‘µ>°n÷–¶µnûÝN‰¬>(', '³C8%`íÔ\re:( ÿN@Go¢šâ´.ÌrÿÆ', '³C8%`íÔ\re:( ÿ%¢6µ\rÎ®¨ˆ8+Ä', 'ÚÕÕÒ,h.ýe×qÐïˆD', NULL, NULL, 'gø6ET•‹î‚Š¯¨·3', 'áiÏÌÎÒgÕâ!{', '‡Ï<àUÏÛ—3‘À¿âŽy', '\n6¬E‚^Ûž“‘Š', 'ìO)\njÖBLdc¾Êj|ØùuƒÏ5\Z\'¿c%ŸJ¸', NULL, '¡LŒ=\n*ImòììÔÙu‰°ËW4ãV¸‚»Ñ¥&6ˆ*$¢{M7mW‡üøAPQ|I<;8pa[…àcmlÕ@U`zVìïKÚô(~ú¿­é', 'qu±cú¾Gj¶Â—yêÙÑSêøUý1!$¾	¯,Ñe\rvb?èóñÏ‡·©ú\r)”zÜp=ÿ‘¤kß`zVìïKÚô(~ú¿­é', '\0ó}t¨KÿcnË?²ƒZß(ƒ3\n½þªš¥_¨¿±À\0n', NULL, 'ŠZ/d\04þ Díò–Eg', NULL, NULL, 'ŠZ/d\04þ Díò–Eg', 'ŠZ/d\04þ Díò–Eg', 'o‹³Ûk»ß\'L´6×ÿ«õô_›GßžY5Ç¼ËÄvÚJ', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', 'ŠZ/d\04þ Díò–Eg', 'o‹³Ûk»ß\'L´6×ÿ«õô_›GßžY5Ç¼ËÄvÚJ', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', 'I}Û—)—TÁˆÓYé\nC', NULL, NULL, '¾Š  ÓÎ\0p?ÚX', NULL, '¾<9Þb¡7NšFQqç‚', NULL, NULL, 'ó°gKÊ\ZP#%Ê;±HànÍëŠ†»K„ñ­›J[', NULL, NULL, 'Õ‘‡ÛîÒ¨-\r\\²¼`zVìïKÚô(~ú¿­é', NULL, NULL, '¾«cÜ‡@ø×=ó³˜Ö˜›$&M‘y˜Q®hÃwá»F3t\\²Ç€˜šçÊH£7t!bR_S)¦ÆÜ•r Bî', NULL, NULL, NULL, NULL, 'HzÓmopBÐúÔÙ½í¥ò', NULL, NULL, NULL, NULL, 'o‹³Ûk»ß\'L´6×ÿ«õô_›GßžY5Ç¼ËÄvÚJ', 'o‹³Ûk»ß\'L´6×ÿ«õô:[¨‘\Z	Œš“f°1LŽÙnj°·6\"?¹À1Ð', NULL, NULL, '', NULL, NULL, '§ã¡÷.¦ ;Yød0ðÛó', 'áiÏÌÎÒgÕâ!{', '‡Ï<àUÏÛ—3‘À¿âŽy', '\n6¬E‚^Ûž“‘Š', 'HíºñÈ?}ÅÇûF+0Ñ’3Ã¥$æ°êTßÕ×Ç0\"ã', NULL, '0°3’:œHƒ²œ—ÄŒšpPßÃ¥ôyºØ%¤ò„cš>î_ÔLK¬3º\n+D²°«9+/€2‡°uF—¤$wÄòP`zVìïKÚô(~ú¿­é', '*4°Ëžs-fKq¢¸[[e% \Z’gUcÇ\'ÎR>Ä¾Ü`‰ÀhßdYÎöæíyR¢šLàUÝpJ!Åq8Ú¼6Îv`zVìïKÚô(~ú¿­é', '\0ó}t¨KÿcnË?²ƒZß(ƒ3\n½þªš¥_¨¿±À\0n', 'çÑ%\"D×k¿<¤®ýî', '‹iô@¢˜#*Ë:A	h', 'ê|TÂ.4pü+\r÷3ÏÂq„ç\rðYdÊ¢±‚Ú«H3KÊ/ˆN—#<qPÔ›', 'KœT–ˆã¥û1\Z<Æ¤½üƒ€ƒ×ªMoÈW‚Ã[¡jËŸ(1|„¤×ÛfcÈl }@¥I°µoœUpÓÄÆ&VZÍ¶”Gˆmâ™Î%±,‡ qoüî±7q\ZiA!ÃÓ^I?è¨;ÌŽ›¶ý´,ÎØ_¼+†	DºO@&îR P=@Ü{ÂÈAc\nG4nÅ#gõðÑŸ%õ¢¬èƒâîù	èö;žL¨Å‚2U•DŽ$oÁ{/ôPr`køªóirYDqò<\Z®Ù”v§*1¼›”Oïã¥Ï»ŒÇtÁ¼›·~zP³ý-þt|ˆµWWeª\'\'!àD’­˜Ò¦Ñ¡9j\r©{\'è”9ã)÷Ì_«ÿ««HŒXòSÛž|9¥Z{Ò/;î=¯`*îö…ˆ[cj‹ ·Ã›âÄ#¨!Y\"\\Y¹A‹ØGZ×Æ€ddÔ¿ŽReö™¾È~[rÐ	mï@Q§i/±•òu´¸GÖbDÝ€7±`Å(%`Y½ý0ä~3|NšU„}Ó0b,>ýÖ1:„ªûñÃ‘A}Â®AÝf…¢Î\"\Z±áf¸½Ð¿…ôrüŠþøN ¦Õh8cp[qºàí4%MôX`ž:¸jâ?‚Â’Ôþ@<@™)—¤Ø»íü«NNªkþÅ’u\"ÖÀa;ïŽQ¶_ë…Éçê[ŒÓ#Ó	àBèDRrlKÛ!–¼ühÑôÕ§õÖêä:\'¨s @LÙp:%Håñ>3¼wê W7Ù³²;‚*1|®™…R21\0®J±þ-^<Þ-Ì¦\ZtâƒÕo 8¸•HP[TÈËBQïeÊÓN\n\r2Ù¬H–!R½Ä5ò¯¨aÍH­®Ú4¾„\0ï%·ÀéGwØþÚÜ¬V³v%ÌÙpnSÔÅÈªÒ¯GŒV!OQ¨mq´›‘ÿh…/}¤ëÏm[†šM,Np²± 8@ÿË°é&™2³áûvVž ÒWVQl»¼ZT\r0bú:î\0€t»Ó]·Fqß×Ž¦ºâí2ZpG†Vý”Ìlãµ±%‚ÆWBÖ¾[m*[qÍƒç§D;œ 3Šï’pq»âö_ˆÐµ:‰xëL+¤ê|TÂ.4pü+\r÷3ÏÂq„ç\rðYdÊ¢±‚Ú«H3KØØžýe»ÏÀ˜^U‡,‹ä\'¥y4ùÔ`’‚ÕÍ»\0ÉÀÁKÓQR=À‘VÜžž£è\n¤´ŽÊô6L’«=³“ð;f™“µ4ñw~ª…ÝE\'ÅK', '‹iô@¢˜#*Ë:A	h', '‹iô@¢˜#*Ë:A	h', 'o‹³Ûk»ß\'L´6×ÿ«õô_›GßžY5Ç¼ËÄvÚJ', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '‹iô@¢˜#*Ë:A	h', 'o‹³Ûk»ß\'L´6×ÿ«õô_›GßžY5Ç¼ËÄvÚJ', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `apqhpp4dpd16065754516r6iwrdljb`
--

CREATE TABLE `apqhpp4dpd16065754516r6iwrdljb` (
  `Status` varchar(50) NOT NULL,
  `Fullname` varchar(100) NOT NULL,
  `FatherFullname` varchar(100) DEFAULT NULL,
  `GuardianFullname` varchar(100) DEFAULT NULL,
  `Gender` varchar(50) NOT NULL,
  `GuardianGender` varchar(50) DEFAULT NULL,
  `Mobile` varchar(100) NOT NULL,
  `FatherMobile` varchar(100) DEFAULT NULL,
  `GuardianMobile` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `FatherEmail` varchar(100) DEFAULT NULL,
  `GuardianEmail` varchar(100) DEFAULT NULL,
  `UniqueId` varchar(100) DEFAULT NULL,
  `OpUniqueId` varchar(100) DEFAULT NULL,
  `SocialAccount` text DEFAULT NULL,
  `VerifyedAccount` text DEFAULT NULL,
  `FatherSocialAccount` text DEFAULT NULL,
  `FatherVerifyedAccount` text DEFAULT NULL,
  `GuardianSocialAccount` text DEFAULT NULL,
  `GuardianVerifyedAccount` text DEFAULT NULL,
  `Position` varchar(200) NOT NULL,
  `Department` varchar(300) DEFAULT NULL,
  `Semester` varchar(100) DEFAULT NULL,
  `StudyYear` varchar(100) DEFAULT NULL,
  `Branch` varchar(300) DEFAULT NULL,
  `UserUrl` varchar(100) NOT NULL,
  `ProfileUrl` varchar(150) NOT NULL,
  `PrimaryBatchId` varchar(100) DEFAULT NULL,
  `SecondaryBatchId` varchar(100) DEFAULT NULL,
  `OrgJoinTime` varchar(100) NOT NULL,
  `OrgStayDur` varchar(100) DEFAULT NULL,
  `OrgExitTime` varchar(100) DEFAULT NULL,
  `Pincode` varchar(50) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(100) NOT NULL,
  `Country` varchar(100) NOT NULL,
  `Address` varchar(300) NOT NULL,
  `OtpData` text DEFAULT NULL,
  `Password` varchar(300) NOT NULL,
  `SecurityCode` varchar(300) NOT NULL,
  `AccountCreateAs` varchar(100) NOT NULL,
  `LastActiveTime` varchar(100) DEFAULT NULL,
  `LoginTime` varchar(100) NOT NULL,
  `LoginUniqueId` varchar(150) DEFAULT NULL,
  `LoginTokenData` text DEFAULT NULL,
  `CreateTime` varchar(100) NOT NULL,
  `PassChangeTime` varchar(100) NOT NULL,
  `LastUpdateBy` varchar(100) NOT NULL,
  `LastUpdatePosition` varchar(200) NOT NULL,
  `LastUpdateRank` varchar(100) NOT NULL,
  `LastUpdateTime` varchar(100) NOT NULL,
  `CreateBy` varchar(100) NOT NULL,
  `CreateByPosition` varchar(200) NOT NULL,
  `CreateByRank` varchar(100) NOT NULL,
  `LastChanges` text DEFAULT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(600) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL,
  `StatusActionReason` varchar(200) DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apqhpp4dpd16065754516r6iwrdljb`
--

INSERT INTO `apqhpp4dpd16065754516r6iwrdljb` (`Status`, `Fullname`, `FatherFullname`, `GuardianFullname`, `Gender`, `GuardianGender`, `Mobile`, `FatherMobile`, `GuardianMobile`, `Email`, `FatherEmail`, `GuardianEmail`, `UniqueId`, `OpUniqueId`, `SocialAccount`, `VerifyedAccount`, `FatherSocialAccount`, `FatherVerifyedAccount`, `GuardianSocialAccount`, `GuardianVerifyedAccount`, `Position`, `Department`, `Semester`, `StudyYear`, `Branch`, `UserUrl`, `ProfileUrl`, `PrimaryBatchId`, `SecondaryBatchId`, `OrgJoinTime`, `OrgStayDur`, `OrgExitTime`, `Pincode`, `City`, `State`, `Country`, `Address`, `OtpData`, `Password`, `SecurityCode`, `AccountCreateAs`, `LastActiveTime`, `LoginTime`, `LoginUniqueId`, `LoginTokenData`, `CreateTime`, `PassChangeTime`, `LastUpdateBy`, `LastUpdatePosition`, `LastUpdateRank`, `LastUpdateTime`, `CreateBy`, `CreateByPosition`, `CreateByRank`, `LastChanges`, `SettingKeyUnique`, `SettingValueUnique`, `SettingKey`, `SettingValue`, `StatusActionReason`, `Signature`) VALUES
('H% ;ñ{ ÿ<Ú', 'ij\\›‰îVí){5¬Ä­A', NULL, NULL, 'Ù\\7Ùg)¤Õ3žü\'w—d', NULL, '`Q$—êˆ•†+Sg', NULL, NULL, 'AÓÈòüa“®®@6\nÂ…PgÅaEqÑøÊÆWjÄ', NULL, NULL, '«îUå–dsêÑâÒ', NULL, NULL, '¾«cÜ‡@ø×=ó³˜Ö˜›$&M‘y˜Q®hÃwá»F3t\\²Ç€˜šçÊH£7v¹Ç+¦nm«·“(®‡g‚Å', NULL, NULL, NULL, NULL, 'HzÓmopBÐúÔÙ½í¥ò', NULL, NULL, NULL, NULL, 'n¥=%K\nsC\"O}ž÷?†°*\0²Â®a„FÍ\\Ô', 'n¥=%K\nsC\"O}ž÷hè«\"öi+UÇ€šÍxÆøÒBýá+YJÞ”‰MÕ’', NULL, NULL, '', NULL, NULL, '§ã¡÷.¦ ;Yød0ðÛó', 'áiÏÌÎÒgÕâ!{', '‡Ï<àUÏÛ—3‘À¿âŽy', '\n6¬E‚^Ûž“‘Š', 'HíºñÈ?}ÅÇûF+0Ñ’3Ã¥$æ°êTßÕ×Ç0\"ã', '7tŠ4¨²öäú=ÿÄÀfNÄÁôaIO\nª¿˜1î¯G<´ã0Ò€¶ÅYyôª@ºÿ)ÉÎxnööƒæ«ÊY$ëÎ>üõ¹N›Æ;ÁGÙ©ˆj»ïáãÔïÈ7Á;´\0EIUføÉÑÑ?N3Sr±×Ü<=Ñ9	¶q³ƒ‹q-ð1ýÏPp5¶Zj‘v9™\"ü”¸ç°%ék«øïUÛÅÜ²}éR¡ŠOÿIAªÁ‘ï¨\rê‹†œÀîN£', 'Ùn?¨ÝÃuq¼ñ\\åæöf·eHkêc¯íQ=,]çË½\\›<Z¢·Û‹éh±Õ§G?é8„¹åm”·ëE‡`zVìïKÚô(~ú¿­é', '*4°Ëžs-fKq¢¸[[e% \Z’gUcÇ\'ÎR>Ä¾Ü`‰ÀhßdYÎöæíyR¢šLàUÝpJ!Åq8Ú¼6Îv`zVìïKÚô(~ú¿­é', '\0ó}t¨KÿcnË?²ƒZß(ƒ3\n½þªš¥_¨¿±À\0n', 'µ³¼‰Ã¥ÞËd\rå8S¶€é', '\'×e}i^çïóèåa¼o', '£ Šjµ¨5íjW\Z»¸ª1ÚÔßW\"øÈ2Û»>9²ñ5V\0_Ú@9³Æv_áo,È', '¾§ÑEMÃ#Šâ”½ß¸\rm', '\'×e}i^çïóèåa¼o', 'jàI*r}!•ñ?jm‰', 'n¥=%K\nsC\"O}ž÷?†°*\0²Â®a„FÍ\\Ô', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '\'×e}i^çïóèåa¼o', 'n¥=%K\nsC\"O}ž÷?†°*\0²Â®a„FÍ\\Ô', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', 'ä…ñüÎ—Ñ^ó×fäˆn', NULL, NULL, '¾Š  ÓÎ\0p?ÚX', NULL, 'ó‰Úÿqx<¥ÊiŽÌ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'U(5É½þ(c{¸1•ößp›', NULL, NULL, NULL, NULL, 'YªõþìÔ)ìå{!à¥!oÁÞÜk¾p^ÇksD>ÅŒ', 'YªõþìÔ)ìå{!à¥!oÿ‹uÅ˜Yùö×‰ÂM;á1LŽÙnj°·6\"?¹À1Ð', NULL, NULL, 'ùZ¸Ä;$¿ßzJZ‘', NULL, NULL, '§ã¡÷.¦ ;Yød0ðÛó', 'áiÏÌÎÒgÕâ!{', '‡Ï<àUÏÛ—3‘À¿âŽy', '\n6¬E‚^Ûž“‘Š', 'Šg»€8¹SÑê.QjÁˆò`zVìïKÚô(~ú¿­é', NULL, '—\n×àNMDW;f\'@¼¢3Ôï”oŸHîPŽ|÷ídƒ³B\nU$*pšÝ™QÌ*+0•vºÇ#ªÎ€IÖþ(Yy©`zVìïKÚô(~ú¿­é', '†ƒ`Š¨³ð,z\rƒ¨«®Ÿº¯Ù–58„/9&jd‘2*è–Ç¥\0ÃAÀó©ú`\0\0ãy¢üöPº02Ä÷Ã`zVìïKÚô(~ú¿­é', '\0ó}t¨KÿcnË?²ƒZß(ƒ3\n½þªš¥_¨¿±À\0n', NULL, '¨CªÕxíYaµë ÀDxO', NULL, NULL, '•¹å¬%R^“', '•¹å¬%R^“', 'n¥=%K\nsC\"O}ž÷?†°*\0²Â®a„FÍ\\Ô', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '¨CªÕxíYaµë ÀDxO', 'n¥=%K\nsC\"O}ž÷?†°*\0²Â®a„FÍ\\Ô', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `axohbvrpyh1606576380lpy8dflaxw`
--

CREATE TABLE `axohbvrpyh1606576380lpy8dflaxw` (
  `Status` varchar(50) NOT NULL,
  `Fullname` varchar(100) NOT NULL,
  `FatherFullname` varchar(100) DEFAULT NULL,
  `GuardianFullname` varchar(100) DEFAULT NULL,
  `Gender` varchar(50) NOT NULL,
  `GuardianGender` varchar(50) DEFAULT NULL,
  `Mobile` varchar(100) NOT NULL,
  `FatherMobile` varchar(100) DEFAULT NULL,
  `GuardianMobile` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `FatherEmail` varchar(100) DEFAULT NULL,
  `GuardianEmail` varchar(100) DEFAULT NULL,
  `UniqueId` varchar(100) DEFAULT NULL,
  `OpUniqueId` varchar(100) DEFAULT NULL,
  `SocialAccount` text DEFAULT NULL,
  `VerifyedAccount` text DEFAULT NULL,
  `FatherSocialAccount` text DEFAULT NULL,
  `FatherVerifyedAccount` text DEFAULT NULL,
  `GuardianSocialAccount` text DEFAULT NULL,
  `GuardianVerifyedAccount` text DEFAULT NULL,
  `Position` varchar(200) NOT NULL,
  `Department` varchar(300) DEFAULT NULL,
  `Semester` varchar(100) DEFAULT NULL,
  `StudyYear` varchar(100) DEFAULT NULL,
  `Branch` varchar(300) DEFAULT NULL,
  `UserUrl` varchar(100) NOT NULL,
  `ProfileUrl` varchar(150) NOT NULL,
  `PrimaryBatchId` varchar(100) DEFAULT NULL,
  `SecondaryBatchId` varchar(100) DEFAULT NULL,
  `OrgJoinTime` varchar(100) NOT NULL,
  `OrgStayDur` varchar(100) DEFAULT NULL,
  `OrgExitTime` varchar(100) DEFAULT NULL,
  `Pincode` varchar(50) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(100) NOT NULL,
  `Country` varchar(100) NOT NULL,
  `Address` varchar(300) NOT NULL,
  `OtpData` text DEFAULT NULL,
  `Password` varchar(300) NOT NULL,
  `SecurityCode` varchar(300) NOT NULL,
  `AccountCreateAs` varchar(100) NOT NULL,
  `LastActiveTime` varchar(100) DEFAULT NULL,
  `LoginTime` varchar(100) NOT NULL,
  `LoginUniqueId` varchar(150) DEFAULT NULL,
  `LoginTokenData` text DEFAULT NULL,
  `CreateTime` varchar(100) NOT NULL,
  `PassChangeTime` varchar(100) NOT NULL,
  `LastUpdateBy` varchar(100) NOT NULL,
  `LastUpdatePosition` varchar(200) NOT NULL,
  `LastUpdateRank` varchar(100) NOT NULL,
  `LastUpdateTime` varchar(100) NOT NULL,
  `CreateBy` varchar(100) NOT NULL,
  `CreateByPosition` varchar(200) NOT NULL,
  `CreateByRank` varchar(100) NOT NULL,
  `LastChanges` text DEFAULT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(600) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL,
  `StatusActionReason` varchar(200) DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `axohbvrpyh1606576380lpy8dflaxw`
--

INSERT INTO `axohbvrpyh1606576380lpy8dflaxw` (`Status`, `Fullname`, `FatherFullname`, `GuardianFullname`, `Gender`, `GuardianGender`, `Mobile`, `FatherMobile`, `GuardianMobile`, `Email`, `FatherEmail`, `GuardianEmail`, `UniqueId`, `OpUniqueId`, `SocialAccount`, `VerifyedAccount`, `FatherSocialAccount`, `FatherVerifyedAccount`, `GuardianSocialAccount`, `GuardianVerifyedAccount`, `Position`, `Department`, `Semester`, `StudyYear`, `Branch`, `UserUrl`, `ProfileUrl`, `PrimaryBatchId`, `SecondaryBatchId`, `OrgJoinTime`, `OrgStayDur`, `OrgExitTime`, `Pincode`, `City`, `State`, `Country`, `Address`, `OtpData`, `Password`, `SecurityCode`, `AccountCreateAs`, `LastActiveTime`, `LoginTime`, `LoginUniqueId`, `LoginTokenData`, `CreateTime`, `PassChangeTime`, `LastUpdateBy`, `LastUpdatePosition`, `LastUpdateRank`, `LastUpdateTime`, `CreateBy`, `CreateByPosition`, `CreateByRank`, `LastChanges`, `SettingKeyUnique`, `SettingValueUnique`, `SettingKey`, `SettingValue`, `StatusActionReason`, `Signature`) VALUES
('H% ;ñ{ ÿ<Ú', 'ÈÈzrÛ~ŽÄ[ SŸ}\"', 'ÖàlÿÒ’JïàX›Æ	\Z', NULL, '¾Š  ÓÎ\0p?ÚX', NULL, 'h)+é0à«¬„o¥æ', 'wW	JöeSBÀ¡\Zão»Ô', NULL, 'Ö¶7g<2w¡Z\0“ “\\`zVìïKÚô(~ú¿­é', NULL, NULL, 'Œ¼ëkßýÖÝÖLŒúŽž°', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ï;).$A‚ÍÝ5BVª&', NULL, 'köHtiÏë¾Ó”«—Û°F', 'Ä8ŠŸùÉÄQŽÈ<6p', 'ýœ¤AAåØgrlsGK', 'ÊK¸µ¯`ÂöS@Ä×6–3júê\ZÕö\Z4ÜIŠ3[', 'ÊK¸µ¯`ÂöS@Ä×6–3½6ERv¸îÖ‘dqz\r1LŽÙnj°·6\"?¹À1Ð', 'ÊêöÎÇìyÙÆƒ˜Ìé', '‡¹‚¹/è…!\\rJ£8rk', 'òA¿Ìwˆ±«ka™', NULL, NULL, '§ã¡÷.¦ ;Yød0ðÛó', 'áiÏÌÎÒgÕâ!{', '‡Ï<àUÏÛ—3‘À¿âŽy', '\n6¬E‚^Ûž“‘Š', 'HíºñÈ?}ÅÇûF+0Ñ’3Ã¥$æ°êTßÕ×Ç0\"ã', NULL, 'Ä2ž˜ó¿QÓb‡ª¿* 10i¿ÿ0cæxáWF´#ãØ$Ô¯úÆjjFþN¸ å³Õ-Ìˆà÷Ãi§`zVìïKÚô(~ú¿­é', '÷¹´·Wâäd(ŒcNÅ=¾Ôò­3irz:ÃƒJø=ÿgŽËÌÂ ôÀÖ|-åˆ,¤æ_ Ãò§s2ðFþwïÇ`zVìïKÚô(~ú¿­é', '\0ó}t¨KÿcnË?²ƒZß(ƒ3\n½þªš¥_¨¿±À\0n', NULL, '›Ð¢€‡ÛÌ ‹1öÊ±=', NULL, NULL, '‚W@Í’B1.‰ËÍ4”Ï°Ò', '‚W@Í’B1.‰ËÍ4”Ï°Ò', '_ØjA¸ÜB¾2¦\Z|Ap¡+6[©ž7þPÐwLº«', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '›Ð¢€‡ÛÌ ‹1öÊ±=', '_ØjA¸ÜB¾2¦\Z|Ap¡+6[©ž7þPÐwLº«', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', 'ij\\›‰îVí){5¬Ä­A', NULL, NULL, '¾Š  ÓÎ\0p?ÚX', NULL, 'u¢~^ç—P“$lº°Ò@ž', NULL, NULL, '§üæ±ÛþéUE\\Ï÷ð°³Â|O‹=\"Å-bZj}šÙ', NULL, NULL, 'ÎöÁ+ø·ìÛe:‹ ', NULL, NULL, '¾«cÜ‡@ø×=ó³˜Ö˜›$&M‘y˜Q®hÃwá»F3t\\²Ç€˜šçÊH£7¦ÓŠö6Ð¤ë$Àå(°', NULL, NULL, NULL, NULL, 'HzÓmopBÐúÔÙ½í¥ò', NULL, NULL, NULL, NULL, '_ØjA¸ÜB¾2¦\Z|Ap¡+6[©ž7þPÐwLº«', '_ØjA¸ÜB¾2¦\Z|œ%qøµôÅ?Ö­±ºÝ•xÆøÒBýá+YJÞ”‰MÕ’', NULL, NULL, '', NULL, NULL, '§ã¡÷.¦ ;Yød0ðÛó', 'áiÏÌÎÒgÕâ!{', '‡Ï<àUÏÛ—3‘À¿âŽy', '\n6¬E‚^Ûž“‘Š', 'HíºñÈ?}ÅÇûF+0Ñ’3Ã¥$æ°êTßÕ×Ç0\"ã', NULL, '0°3’:œHƒ²œ—ÄŒšpPßÃ¥ôyºØ%¤ò„cš>î_ÔLK¬3º\n+D²°«9+/€2‡°uF—¤$wÄòP`zVìïKÚô(~ú¿­é', '*4°Ëžs-fKq¢¸[[e% \Z’gUcÇ\'ÎR>Ä¾Ü`‰ÀhßdYÎöæíyR¢šLàUÝpJ!Åq8Ú¼6Îv`zVìïKÚô(~ú¿­é', '\0ó}t¨KÿcnË?²ƒZß(ƒ3\n½þªš¥_¨¿±À\0n', 'ÌÆup: BR«ýYe\r–Y', 'Âølë—Gjedñíý©', '¤2L—¤§T…¼Ò¨Ñ:1ÓÐ„½7rä9¥äùÆí~¦BôˆþAÏp­ÛÞ¾/', 'KœT–ˆã¥û1\Z<Æ¤½üƒ€ƒ×ªMoÈW‚Ã[¡jËŸ(1|„¤×ÛfcÈl }@¥I°µoœUpÓÄÆ&VZÍ¶”Gˆmâ™Î%±,‡ qoKhó\0ÖÃ½h\0x%•F»Š|\\†/T;³u+ž…ìé™5ú˜Z®83–Í×û{ŽBÒZçýN€MVÉlmÐ5âžúODýfwÃCßl÷ðÔš]\n/ëˆ(o±°¢Û~¶¶ÆA Öéwû~A,\r02ˆõQa.¼z†Îó.°k³ÿwÊ-3ÝzP³ý-þt|ˆµWWeª©\0…óh:,<ù™Ãºi‰öÆƒÛ(F¡ÿ\\½[öV>]RNƒ·W…ŽMŽWI¼çQÇèÒÏnõT®Æa&\0º?jRö”X‚­Zbe»ó÷{D»±)U^ª\\¿ò©Pò=Ø¨+\'I\"\"ŒµÅFFûÑÙÌ8SÉ¤ßX½4þ€À7kÔú—•áÅ°ŒÌ¤Òù¾0ä~3|NšU„}Ó0b,>ýÖ1:„ªûñÃ‘A}Â®AÝf…¢Î\"\Z±áf¸½Ð¿…ôrüŠþøN ¦Õh8cp[qºàí4%MôX`ž:¸jâ?‚Â’Ôþ@<@™)—¤Ø»íü«NNªkþÅ’u\"ÖÀa;ïŽQ¶_ë…Éçê[ŒÓ#Ó	àBèD½ß¬sC†1–žŠaâdæŽõÖêä:\'¨s @LÙp:%Håñ>3¼wê W7Ù³²;‚*1|®™…R21\0®J±þ-^<Þ-Ì¦\ZtâƒÕo 8¸•HP[TÈËBQïeÊÓN\n\r2Ù¬H–!R½Ä5ò¯¨aÍH­®Ú4¾„\0ï%·ÀéGwØþÚÜ¬V³v%ÌÙpnSÔÅÈªÒ¯GŒV!OQ¨mq´›‘ÿh…/}¤ëÏm[†šM,Np²± 8@ÿË°é&™2³áûvVž ÒWVQl»¼ZT\rY•e4»ï6\0çàdÒ¦£Ž¦ºâí2ZpG†Vý”Ìlà)ìŽÁ—=ÎÅÃMšÀqÍƒç§D;œ 3Šï’pq»âö_ˆÐµ:‰xëL+¤¤2L—¤§T…¼Ò¨Ñ:1ÓÐ„½7rä9¥äùÆímVÐA!˜üíHÞ†fÛÊð\'.®Úç)°?uL™yïú‹kB÷“3)%Yš|?\r¬ÈsZ\n.a‰é‡* ·1ïË6äš´*ôGØíqR', 'Âølë—Gjedñíý©', 'Âølë—Gjedñíý©', '_ØjA¸ÜB¾2¦\Z|Ap¡+6[©ž7þPÐwLº«', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', 'Âølë—Gjedñíý©', '_ØjA¸ÜB¾2¦\Z|Ap¡+6[©ž7þPÐwLº«', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acxh6tfsld1586939542bdlbqt1k2q`
--
ALTER TABLE `acxh6tfsld1586939542bdlbqt1k2q`
  ADD PRIMARY KEY (`UserUrl`),
  ADD UNIQUE KEY `Mobile` (`Mobile`),
  ADD UNIQUE KEY `ProfileUrl` (`ProfileUrl`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `UniqueId` (`UniqueId`),
  ADD UNIQUE KEY `OpUniqueId` (`OpUniqueId`),
  ADD UNIQUE KEY `LoginUniqueId` (`LoginUniqueId`),
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `apqhpp4dpd16065754516r6iwrdljb`
--
ALTER TABLE `apqhpp4dpd16065754516r6iwrdljb`
  ADD PRIMARY KEY (`UserUrl`),
  ADD UNIQUE KEY `Mobile` (`Mobile`),
  ADD UNIQUE KEY `ProfileUrl` (`ProfileUrl`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `UniqueId` (`UniqueId`),
  ADD UNIQUE KEY `OpUniqueId` (`OpUniqueId`),
  ADD UNIQUE KEY `LoginUniqueId` (`LoginUniqueId`),
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `axohbvrpyh1606576380lpy8dflaxw`
--
ALTER TABLE `axohbvrpyh1606576380lpy8dflaxw`
  ADD PRIMARY KEY (`UserUrl`),
  ADD UNIQUE KEY `Mobile` (`Mobile`),
  ADD UNIQUE KEY `ProfileUrl` (`ProfileUrl`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `UniqueId` (`UniqueId`),
  ADD UNIQUE KEY `OpUniqueId` (`OpUniqueId`),
  ADD UNIQUE KEY `LoginUniqueId` (`LoginUniqueId`),
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`),
  ADD UNIQUE KEY `Signature` (`Signature`);
--
-- Database: `topicste_organization_user_setting`
--
CREATE DATABASE IF NOT EXISTS `topicste_organization_user_setting` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `topicste_organization_user_setting`;

-- --------------------------------------------------------

--
-- Table structure for table `acxh6tfsld1586939542bdlbqt1k2q`
--

CREATE TABLE `acxh6tfsld1586939542bdlbqt1k2q` (
  `CreateType` varchar(100) NOT NULL,
  `UpdateAble` varchar(100) NOT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acxh6tfsld1586939542bdlbqt1k2q`
--

INSERT INTO `acxh6tfsld1586939542bdlbqt1k2q` (`CreateType`, `UpdateAble`, `SettingKeyUnique`, `SettingValueUnique`, `SettingKey`, `SettingValue`) VALUES
('0õh:—2ò¶Jèf{ã*°§¡• XïÄžÜÆ²Æ', 'hÕP^$æªóž¶ßûø¸~‚', '/³Fåg¨ð²jÛ˜w', NULL, NULL, 'x¥ÔI4Ã>y‰=‡\0¥ŒTEˆ0ßH#6KÄt3ížì;1aâì¦¨xÄ:ïZ^ÃmgªÙ·În©ö6€H„£¶¶¨µl3\\ê¥ÄFÁZlgÎº,0>\Z¸›`ÜˆÞÕ»Aº Ïªí4îà6‘³vZ˜»¸ïCb#b\n‹åëÔ38ôÈÝøÜP¤\\—S’äÿjiBë=ÇÐUû]Ð'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '×7_L¾zÏ8ÂeA¼š#æ ,T¬2õ_÷)Ýª³®{Nœse‘Í÷‰Ò¼Ra„QÔÃ·_', NULL, NULL, '¶Sq „§oó‰‚N\ns¾§	a…—%ƒ|L¬“<Þ#?Å’,‰þÙqÚ5Ã”ñw§	a…—%ƒ|L¬“<Þ#ådÎ]¥]Ôkè•¼,T¬2õ_÷)Ýª³®{Nœs³x~#ÁÁ à»ˆ$Rõ/?Ù.×8ü-Ë6Å¤}WÕßã$–8O‚—ÜÆÓ-.Z\\ø/>ºÝ%v:ÿé7DöùÒ’÷:ÄœÐ?ø˜E“gr®lyÊîÉ'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '6ùùäSŒÀÄ“u–ÝyÍ', NULL, NULL, 'ø/TB¿Ì—>r98¼å`zVìïKÚô(~ú¿­é'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '\rºb=\"‚Æ÷\Zü¿d&ôÃÎ', NULL, NULL, 'ø/TB¿Ì—>r98¼å`zVìïKÚô(~ú¿­é'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '*œô*Õ‰\rC7Œù‚sòm¥', NULL, NULL, 'b¯DÕÉ!/*±íD—D'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', 'xÁýñCIÅ ‘Ž%+L[', NULL, NULL, '³C8%`íÔ\re:( ÿN@Go¢šâ´.ÌrÿÆ'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '9¹&IÒ>	Ër@0m¾nÔ`zVìïKÚô(~ú¿­é', NULL, NULL, '³C8%`íÔ\re:( ÿ%¢6µ\rÎ®¨ˆ8+Ä'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', 'Ýï,qÙ‰Í‚\ræ4š‘˜zk', NULL, NULL, 'ÄÿNN íæ”¹ÜáTv');

-- --------------------------------------------------------

--
-- Table structure for table `apqhpp4dpd16065754516r6iwrdljb`
--

CREATE TABLE `apqhpp4dpd16065754516r6iwrdljb` (
  `CreateType` varchar(100) NOT NULL,
  `UpdateAble` varchar(100) NOT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(600) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apqhpp4dpd16065754516r6iwrdljb`
--

INSERT INTO `apqhpp4dpd16065754516r6iwrdljb` (`CreateType`, `UpdateAble`, `SettingKeyUnique`, `SettingValueUnique`, `SettingKey`, `SettingValue`) VALUES
('0õh:—2ò¶Jèf{ã*°§¡• XïÄžÜÆ²Æ', 'hÕP^$æªóž¶ßûø¸~‚', '/³Fåg¨ð²jÛ˜w', NULL, NULL, 'x¥ÔI4Ã>y‰=‡\0¥ŒTEˆ0ßH#6KÄt3ížì;1aâì¦¨xÄ:ïZ^ÃmgªÙ·În©ö6€H„£¶¶¨µl3\\ê¥ÄFÁZlgÎº,0>\Z¸›`ÜˆÞÕ»Aº Ïªí4î+Ó\':€KÊ¦ÈÛ]\0Ú“ç•P¥¡ë‘ón#S’äÿjiBë=ÇÐUû]Ð'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '×7_L¾zÏ8ÂeA¼š#æ ,T¬2õ_÷)Ýª³®{Nœse‘Í÷‰Ò¼Ra„QÔÃ·_', NULL, NULL, '¶Sq „§oó‰‚N\ns¾§	a…—%ƒ|L¬“<Þ#?Å’,‰þÙqÚ5Ã”ñw§	a…—%ƒ|L¬“<Þ#ådÎ]¥]Ôkè•¼,T¬2õ_÷)Ýª³®{Nœs³x~#ÁÁ à»ˆ$Rõ/?Ù.×8ü-Ë6Å¤}WÕßã$–8O‚—ÜÆÓ-.Z\\ø/>ºÝ%v:ÿé7DöùÒ’÷:ÄœÐ?ø˜E“gr®lyÊîÉ'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '6ùùäSŒÀÄ“u–ÝyÍ', NULL, NULL, '’\r>fÝ°®2ô&(ÊÞg`zVìïKÚô(~ú¿­é'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '\rºb=\"‚Æ÷\Zü¿d&ôÃÎ', NULL, NULL, '’\r>fÝ°®2ô&(ÊÞg`zVìïKÚô(~ú¿­é'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '*œô*Õ‰\rC7Œù‚sòm¥', NULL, NULL, 'b¯DÕÉ!/*±íD—D'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', 'xÁýñCIÅ ‘Ž%+L[', NULL, NULL, 'ç³;£{NêtðÁó‘KÇ	)±æn=N4¼¿Ø¬Èg'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '9¹&IÒ>	Ër@0m¾nÔ`zVìïKÚô(~ú¿­é', NULL, NULL, 'ï1Dð–ƒ ~æ%\\I\r\"IIä[ì/¾†Ð¥Ñ%ìE„'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', 'Ýï,qÙ‰Í‚\ræ4š‘˜zk', NULL, NULL, 'b¯DÕÉ!/*±íD—D');

-- --------------------------------------------------------

--
-- Table structure for table `axohbvrpyh1606576380lpy8dflaxw`
--

CREATE TABLE `axohbvrpyh1606576380lpy8dflaxw` (
  `CreateType` varchar(100) NOT NULL,
  `UpdateAble` varchar(100) NOT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(600) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `axohbvrpyh1606576380lpy8dflaxw`
--

INSERT INTO `axohbvrpyh1606576380lpy8dflaxw` (`CreateType`, `UpdateAble`, `SettingKeyUnique`, `SettingValueUnique`, `SettingKey`, `SettingValue`) VALUES
('0õh:—2ò¶Jèf{ã*°§¡• XïÄžÜÆ²Æ', 'hÕP^$æªóž¶ßûø¸~‚', '/³Fåg¨ð²jÛ˜w', NULL, NULL, 'x¥ÔI4Ã>y‰=‡\0¥ŒTEˆ0ßH#6KÄt3ížì;1aâì¦¨xÄ:ïZ^ÃmgªÙ·În©ö6€H„£¶¶¨µl3\\ê¥ÄFÁZlgÎº,0>\Z¸›`ÜˆÞÕ»Aº Ïªí4î+Ó\':€KÊ¦ÈÛ]\0Ú\n‹åëÔ38ôÈÝøÜP¤\\—S’äÿjiBë=ÇÐUû]Ð'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '×7_L¾zÏ8ÂeA¼š#æ ,T¬2õ_÷)Ýª³®{Nœse‘Í÷‰Ò¼Ra„QÔÃ·_', NULL, NULL, '¶Sq „§oó‰‚N\ns¾§	a…—%ƒ|L¬“<Þ#?Å’,‰þÙqÚ5Ã”ñw§	a…—%ƒ|L¬“<Þ#ådÎ]¥]Ôkè•¼,T¬2õ_÷)Ýª³®{Nœs³x~#ÁÁ à»ˆ$Rõ/?Ù.×8ü-Ë6Å¤}WÕßã$–8O‚—ÜÆÓ-.Z\\ Nª†NåA×H»jŽWYEùÒ’÷:ÄœÐ?ø˜E“gr®lyÊîÉ'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '6ùùäSŒÀÄ“u–ÝyÍ', NULL, NULL, '’\r>fÝ°®2ô&(ÊÞg‚ýWÔÝay£XìC7.'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '\rºb=\"‚Æ÷\Zü¿d&ôÃÎ', NULL, NULL, '’\r>fÝ°®2ô&(ÊÞg‚ýWÔÝay£XìC7.'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '*œô*Õ‰\rC7Œù‚sòm¥', NULL, NULL, '9ü\0pPt–clé=£;l'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', 'xÁýñCIÅ ‘Ž%+L[', NULL, NULL, 'K³\'\"*«Æ8®Uúo’z,îtÒê\"É&I¯¼)f`s›ùÈ'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '9¹&IÒ>	Ër@0m¾nÔ`zVìïKÚô(~ú¿­é', NULL, NULL, 'q–ƒ_ÂÖÞe„¼(©‘s…]Zà™Ça­j\'×³_Çšº‚ìl\'t	ÿ<¼%,œÎrq¨.›­µ²‡|Š}Ø'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', 'Ýï,qÙ‰Í‚\ræ4š‘˜zk', NULL, NULL, 'b¯DÕÉ!/*±íD—D');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acxh6tfsld1586939542bdlbqt1k2q`
--
ALTER TABLE `acxh6tfsld1586939542bdlbqt1k2q`
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`);

--
-- Indexes for table `apqhpp4dpd16065754516r6iwrdljb`
--
ALTER TABLE `apqhpp4dpd16065754516r6iwrdljb`
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`);

--
-- Indexes for table `axohbvrpyh1606576380lpy8dflaxw`
--
ALTER TABLE `axohbvrpyh1606576380lpy8dflaxw`
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`);
--
-- Database: `topicste_service_create_a3cnvkaihl1580334506d13zswes11`
--
CREATE DATABASE IF NOT EXISTS `topicste_service_create_a3cnvkaihl1580334506d13zswes11` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `topicste_service_create_a3cnvkaihl1580334506d13zswes11`;

-- --------------------------------------------------------

--
-- Table structure for table `acxh6tfsld1586939542bdlbqt1k2q_member`
--

CREATE TABLE `acxh6tfsld1586939542bdlbqt1k2q_member` (
  `Status` varchar(100) NOT NULL,
  `UserUrl` varchar(100) NOT NULL,
  `Position` varchar(100) NOT NULL,
  `GroupId` varchar(100) NOT NULL,
  `GroupType` varchar(100) NOT NULL,
  `GuardianPemission` varchar(100) DEFAULT NULL,
  `WardenPemission` varchar(100) DEFAULT NULL,
  `MemberOfGroup` text DEFAULT NULL,
  `ActiveSchedule` text DEFAULT NULL,
  `CreateTime` varchar(100) NOT NULL,
  `CreateBy` varchar(100) NOT NULL,
  `CreatePosition` varchar(100) NOT NULL,
  `CreateRank` varchar(100) NOT NULL,
  `LastUpdateTime` varchar(100) NOT NULL,
  `LastUpdateBy` varchar(100) NOT NULL,
  `LastUpdatePosition` varchar(100) NOT NULL,
  `LastUpdateRank` varchar(100) NOT NULL,
  `LastChanges` text DEFAULT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL,
  `StatusReason` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `acxh6tfsld1586939542bdlbqt1k2q_request_store`
--

CREATE TABLE `acxh6tfsld1586939542bdlbqt1k2q_request_store` (
  `Status` varchar(100) NOT NULL,
  `RequestId` varchar(100) NOT NULL,
  `GroupId` varchar(100) NOT NULL,
  `GroupType` varchar(100) NOT NULL,
  `GuardianPermission` varchar(50) DEFAULT NULL,
  `GuardianPermissionTime` varchar(100) DEFAULT NULL,
  `WardenPermission` varchar(50) NOT NULL,
  `WardenPermissionTime` varchar(100) DEFAULT NULL,
  `WardenUrl` varchar(100) DEFAULT NULL,
  `WardenRank` varchar(100) DEFAULT NULL,
  `SeenBy` text DEFAULT NULL,
  `RequestFrom` varchar(100) NOT NULL,
  `RequestTime` varchar(100) NOT NULL,
  `Venue` varchar(150) NOT NULL,
  `RequestReason` text DEFAULT NULL,
  `RequestOutGoingTime` varchar(100) NOT NULL,
  `ExactOutGoingTime` varchar(100) DEFAULT NULL,
  `OutGoingStatus` varchar(100) NOT NULL,
  `RequestInComingTime` varchar(100) DEFAULT NULL,
  `ExactInComingTime` varchar(100) DEFAULT NULL,
  `InComingStatus` varchar(100) NOT NULL,
  `OutAndInComingDiff` varchar(100) DEFAULT NULL,
  `GuardianPermissionReceiveUrlKey` varchar(300) DEFAULT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL,
  `LastChanges` text DEFAULT NULL,
  `StatusReason` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `acxh6tfsld1586939542bdlbqt1k2q_setting`
--

CREATE TABLE `acxh6tfsld1586939542bdlbqt1k2q_setting` (
  `CreateType` varchar(100) NOT NULL,
  `UpdateAble` varchar(100) NOT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acxh6tfsld1586939542bdlbqt1k2q_setting`
--

INSERT INTO `acxh6tfsld1586939542bdlbqt1k2q_setting` (`CreateType`, `UpdateAble`, `SettingKeyUnique`, `SettingValueUnique`, `SettingKey`, `SettingValue`) VALUES
('£ScavèÈ[„U…7]á', 'Ä‹Ü”aSŠ¯û+Mži', 'Æàã¤x<ÇàÚ°s\Z¯»f', NULL, NULL, '©XùrŠÈKý6ßW§£1'),
('£ScavèÈ[„U…7]á', 'Ä‹Ü”aSŠ¯û+Mži', '/³Fåg¨ð²jÛ˜w', NULL, NULL, '`n¤ïðœ°²rÁo*[ ZMÖ)výBøc¼±vù‘Ê¼3él•IåË‚~“´](R£y'),
('£ScavèÈ[„U…7]á', ']°YkÌ\'ä~å@$Nˆ¦', '¤Ì…ç.Œ‚´Û0D¶û', NULL, NULL, 'Ÿ¤ÉEÍ­+˜Ÿ`\nšíZçýô«ÂE¬Õn6è\0ð­­?Û¸…óþ–ÖŠõ'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '°ÿæ™õéãßU2ýt÷ž>s´ÌµT®,Ç=T%', NULL, NULL, 'zJ¬åÓ÷Š¿½2¿$\Zª—'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '6$b×NoS!P•]×?°§¡• XïÄžÜÆ²Æ', NULL, NULL, '¶~«Ð+¯BAÎü\ZÈó\ZfL¸JèÄ*°bçÂé×Ž¥Z­Êú¿úû£¯jIß¾}0Š0,ºc±1„3©U†“¼™0ãš˜@\ZŽIw]Ñz[Ê~÷äãneF#²âkËu@TE'),
('Ù\\7Ùg)¤Õ3žü\'w—d', 'hÕP^$æªóž¶ßûø¸~‚', 'j…™{ÙSWÏÒ4™+àŸïÜ', NULL, NULL, 'àÉ\"¼ÈL{wþê@Ö\"v_kƒ¡l.—ï”É)br˜Ë7ÑÎƒi+¦ayè•|ÝÞI	6pÙ·~0òˆlÛ+6P9WL¹ÙSªU®1k‘ÖûÒãJ‰~N¦ç\rƒ³Âlƒl@wöÖfHÐËÆí¤[~)¾*4“åàçOÜòPðwqÿ{1ðNÏIëí{KY5‹Z²ª¬ï³aÖeëo·–ó§Õ¼K)áEk­È[ÿÖË?÷ÍÕ:Qü¹s˜ºÐ¢³½:E£»ñ¢…Ü—4ü·ª¤-y‚Úà\\%u(’€ ]žéçBsHBâ!³øŒ‡¿Þf\\Z9{RÉ$>w:´“º¶aÐÛTuåut†?€tô“´WÊ‰æj!Šä~Ú2;|ð™ëÅû1Œ\'ñÒèÁ=¬Â90[~>üv,mR{{ŸZØ·m´É¢1›\"©c8½ŠUõ[›Q;{¢Ç/Û§máû¯WD4ÏË‚ðŠr^Cû‚%Û&WWù&íœ\rÓ\\#¶:eä`HTµUO9=Ëß¤Ya_mó{L–•û“O(¿BCtu\Z5ìo¿\'ë¨ùäï^åÎÑÇ«r®…ò(;èL½¯¡h¼jÜ\Z3EÑé\\1{ájŒƒ„T)Ìè+ûAu\'q-ÏÊÁ“žGI-é¥_	4,!;ûù÷ˆë\\ÊéÌ6Ö¾Oog2çBéFùZg\0\0›õd;›¬¥G‡Aõ	U2ýå}ù\'õe§­œ-fä¥ËÝíD¼-ƒÓ a‰áþ…P¯‰´í‰_Ø=W×Ö<´(ÃSrJ«µøm3S„¿²Ò¢šG4oÿ‘âJ‚Õ!?Žñå+wãE}l>ß#ï«PúÕ5iúÊsgÓ¦	éDÅÚó^ÿ07´n?käYdóœ	›°oeRÓ°‰\Z@6Ë=Êë˜—†O8?uáRlœN»|}ì½n·»¢Œ¹\n|	 >¹ˆ¦kY3Ò·¥ÊIzù%1¹\'èZo=œîÒÝugçÆù9Š¬Íó 8·Ûõ\"ñ× žÕ\nÁ°Qw½éòX4Åšo*Öh.†r^Cû‚%Û&WWù&íœr7æ\\K$qLçüˆ|_æw9Œü/À1oŸÝ70-›@•`g³©!aºé¼:y^~ç	U[2hÙHÎƒ<^D;.ßûÿ05mzÛú†?ÏÊŸ€Ê|M˜>öÍ7Ì\"§fo·oiôÃ¾úÄƒ¸ìÿÉÌ‚å?žƒþ×Î]ÑÇÐë+˜¬ì>¸Z\rAƒSîü,©-žO‚^áã\nz¤Úiñ¢QíUÏt÷³(Éj…¶oïsY<Ê°i:1x>ÒâË¥Ö[Æq(?»þ/Á¥ÄÒ )ÑEj\0†ÝÐ Œ#]-^ðjæL‘5šÛlÒëN«\0');

-- --------------------------------------------------------

--
-- Table structure for table `apqhpp4dpd16065754516r6iwrdljb_member`
--

CREATE TABLE `apqhpp4dpd16065754516r6iwrdljb_member` (
  `Status` varchar(100) NOT NULL,
  `UserUrl` varchar(100) NOT NULL,
  `Position` varchar(100) NOT NULL,
  `GroupId` varchar(100) NOT NULL,
  `GroupType` varchar(100) NOT NULL,
  `GuardianPemission` varchar(100) DEFAULT NULL,
  `WardenPemission` varchar(100) DEFAULT NULL,
  `MemberOfGroup` text DEFAULT NULL,
  `ActiveSchedule` text DEFAULT NULL,
  `CreateTime` varchar(100) NOT NULL,
  `CreateBy` varchar(100) NOT NULL,
  `CreatePosition` varchar(100) NOT NULL,
  `CreateRank` varchar(100) NOT NULL,
  `LastUpdateTime` varchar(100) NOT NULL,
  `LastUpdateBy` varchar(100) NOT NULL,
  `LastUpdatePosition` varchar(100) NOT NULL,
  `LastUpdateRank` varchar(100) NOT NULL,
  `LastChanges` text DEFAULT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL,
  `StatusReason` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apqhpp4dpd16065754516r6iwrdljb_member`
--

INSERT INTO `apqhpp4dpd16065754516r6iwrdljb_member` (`Status`, `UserUrl`, `Position`, `GroupId`, `GroupType`, `GuardianPemission`, `WardenPemission`, `MemberOfGroup`, `ActiveSchedule`, `CreateTime`, `CreateBy`, `CreatePosition`, `CreateRank`, `LastUpdateTime`, `LastUpdateBy`, `LastUpdatePosition`, `LastUpdateRank`, `LastChanges`, `SettingKeyUnique`, `SettingValueUnique`, `SettingKey`, `SettingValue`, `StatusReason`, `Signature`) VALUES
('H% ;ñ{ ÿ<Ú', 'YªõþìÔ)ìå{!à¥!oÁÞÜk¾p^ÇksD>ÅŒ', 'N[¾œ8 ƒ.†4PW', '3 Ùî´Á¦ÞiŸeÈÎ¾', '²Ç/\'Ø®]ßPvŸ™ì­', NULL, NULL, '.nÝ•*Ì3øàfÑ\\', NULL, 'mì ]Ôÿ‹÷\ng0”älÏ', 'n¥=%K\nsC\"O}ž÷?†°*\0²Â®a„FÍ\\Ô', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', 'mì ]Ôÿ‹÷\ng0”älÏ', 'n¥=%K\nsC\"O}ž÷?†°*\0²Â®a„FÍ\\Ô', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `apqhpp4dpd16065754516r6iwrdljb_request_store`
--

CREATE TABLE `apqhpp4dpd16065754516r6iwrdljb_request_store` (
  `Status` varchar(100) NOT NULL,
  `RequestId` varchar(100) NOT NULL,
  `GroupId` varchar(100) NOT NULL,
  `GroupType` varchar(100) NOT NULL,
  `GuardianPermission` varchar(50) DEFAULT NULL,
  `GuardianPermissionTime` varchar(100) DEFAULT NULL,
  `WardenPermission` varchar(50) NOT NULL,
  `WardenPermissionTime` varchar(100) DEFAULT NULL,
  `WardenUrl` varchar(100) DEFAULT NULL,
  `WardenRank` varchar(100) DEFAULT NULL,
  `SeenBy` text DEFAULT NULL,
  `RequestFrom` varchar(100) NOT NULL,
  `RequestTime` varchar(100) NOT NULL,
  `Venue` varchar(150) NOT NULL,
  `RequestReason` text DEFAULT NULL,
  `RequestOutGoingTime` varchar(100) NOT NULL,
  `ExactOutGoingTime` varchar(100) DEFAULT NULL,
  `OutGoingStatus` varchar(100) NOT NULL,
  `RequestInComingTime` varchar(100) DEFAULT NULL,
  `ExactInComingTime` varchar(100) DEFAULT NULL,
  `InComingStatus` varchar(100) NOT NULL,
  `OutAndInComingDiff` varchar(100) DEFAULT NULL,
  `GuardianPermissionReceiveUrlKey` varchar(300) DEFAULT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL,
  `LastChanges` text DEFAULT NULL,
  `StatusReason` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `apqhpp4dpd16065754516r6iwrdljb_setting`
--

CREATE TABLE `apqhpp4dpd16065754516r6iwrdljb_setting` (
  `CreateType` varchar(100) NOT NULL,
  `UpdateAble` varchar(100) NOT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apqhpp4dpd16065754516r6iwrdljb_setting`
--

INSERT INTO `apqhpp4dpd16065754516r6iwrdljb_setting` (`CreateType`, `UpdateAble`, `SettingKeyUnique`, `SettingValueUnique`, `SettingKey`, `SettingValue`) VALUES
('£ScavèÈ[„U…7]á', 'Ä‹Ü”aSŠ¯û+Mži', 'Æàã¤x<ÇàÚ°s\Z¯»f', NULL, NULL, '©XùrŠÈKý6ßW§£1'),
('£ScavèÈ[„U…7]á', 'Ä‹Ü”aSŠ¯û+Mži', '/³Fåg¨ð²jÛ˜w', NULL, NULL, '`n¤ïðœ°²rÁo*[ ZMÖ)výBøc¼±vù‘Ê¼3él•IåË‚~“´](R£y'),
('£ScavèÈ[„U…7]á', ']°YkÌ\'ä~å@$Nˆ¦', '¤Ì…ç.Œ‚´Û0D¶û', NULL, NULL, 'Ÿ¤ÉEÍ­+˜Ÿ`\nšíZçýô«ÂE¬Õn6è\0ð­­?Û¸…óþ–ÖŠõ'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '°ÿæ™õéãßU2ýt÷ž>s´ÌµT®,Ç=T%', NULL, NULL, 'zJ¬åÓ÷Š¿½2¿$\Zª—'),
('Ù\\7Ùg)¤Õ3žü\'w—d', ']°YkÌ\'ä~å@$Nˆ¦', '6$b×NoS!P•]×?°§¡• XïÄžÜÆ²Æ', NULL, NULL, '¶~«Ð+¯BAÎü\ZÈó\ZfL¸JèÄ*°bçÂé×Ž¥Z­Êú¿úû£¯jIß¾}0Š0,ºc±1„3©U†“¼™0ãš˜@\ZŽIw]Ñz[Ê~÷äãneF#²âkËu@TE'),
('Ù\\7Ùg)¤Õ3žü\'w—d', 'hÕP^$æªóž¶ßûø¸~‚', 'j…™{ÙSWÏÒ4™+àŸïÜ', NULL, NULL, 'àÉ\"¼ÈL{wþê@Ö\"v_kƒ¡l.—ï”É)br˜Ë7ÑÎƒi+¦ayè•|ÝÞI	6pÙ·~0òˆlÛ+6P9WL¹ÙSªU®1k‘ÖûÒãJ‰~N¦ç\rƒ³Âlƒl@wöÖfHÐËÆí¤[~)¾*4“åàçOÜòPðwqÿ{1ðNÏIëí{KY5‹Z²ª¬ï³aÖeëo·–ó§Õ¼K)áEk­È[ÿÖË?÷ÍÕ:Qü¹s˜ºÐ¢³½:E£»ñ¢…Ü—4ü·ª¤-y‚Úà\\%u(’€ ]žéçBsHBâ!³øŒ‡¿Þf\\Z9{RÉ$>w:´“º¶aÐÛTuåut†?€tô“´WÊ‰æj!Šä~Ú2;|ð™ëÅû1Œ\'ñÒèÁ=¬Â90[~>üv,mR{{ŸZØ·m´É¢1›\"©c8½ŠUõ[›Q;{¢Ç/Û§máû¯WD4ÏË‚ðŠr^Cû‚%Û&WWù&íœ\rÓ\\#¶:eä`HTµUO9=Ëß¤Ya_mó{L–•û“O(¿BCtu\Z5ìo¿\'ë¨ùäï^åÎÑÇ«r®…ò(;èL½¯¡h¼jÜ\Z3EÑé\\1{ájŒƒ„T)Ìè+ûAu\'q-ÏÊÁ“žGI-é¥_	4,!;ûù÷ˆë\\ÊéÌ6Ö¾Oog2çBéFùZg\0\0›õd;›¬¥G‡Aõ	U2ýå}ù\'õe§­œ-fä¥ËÝíD¼-ƒÓ a‰áþ…P¯‰´í‰_Ø=W×Ö<´(ÃSrJ«µøm3S„¿²Ò¢šG4oÿ‘âJ‚Õ!?Žñå+wãE}l>ß#ï«PúÕ5iúÊsgÓ¦	éDÅÚó^ÿ07´n?käYdóœ	›°oeRÓ°‰\Z@6Ë=Êë˜—†O8?uáRlœN»|}ì½n·»¢Œ¹\n|	 >¹ˆ¦kY3Ò·¥ÊIzù%1¹\'èZo=œîÒÝugçÆù9Š¬Íó 8·Ûõ\"ñ× žÕ\nÁ°Qw½éòX4Åšo*Öh.†r^Cû‚%Û&WWù&íœr7æ\\K$qLçüˆ|_æw9Œü/À1oŸÝ70-›@•`g³©!aºé¼:y^~ç	U[2hÙHÎƒ<^D;.ßûÿ05mzÛú†?ÏÊŸ€Ê|M˜>öÍ7Ì\"§fo·oiôÃ¾úÄƒ¸ìÿÉÌ‚å?žƒþ×Î]ÑÇÐë+˜¬ì>¸Z\rAƒSîü,©-žO‚^áã\nz¤Úiñ¢QíUÏt÷³(Éj…¶oïsY<Ê°i:1x>ÒâË¥Ö[Æq(?»þ/Á¥ÄÒ )ÑEj\0†ÝÐ Œ#]-^ðjæL‘5šÛlÒëN«\0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acxh6tfsld1586939542bdlbqt1k2q_member`
--
ALTER TABLE `acxh6tfsld1586939542bdlbqt1k2q_member`
  ADD PRIMARY KEY (`UserUrl`),
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `acxh6tfsld1586939542bdlbqt1k2q_request_store`
--
ALTER TABLE `acxh6tfsld1586939542bdlbqt1k2q_request_store`
  ADD PRIMARY KEY (`RequestId`),
  ADD UNIQUE KEY `GuardianPermissionReceiveUrlKey` (`GuardianPermissionReceiveUrlKey`),
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `acxh6tfsld1586939542bdlbqt1k2q_setting`
--
ALTER TABLE `acxh6tfsld1586939542bdlbqt1k2q_setting`
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`);

--
-- Indexes for table `apqhpp4dpd16065754516r6iwrdljb_member`
--
ALTER TABLE `apqhpp4dpd16065754516r6iwrdljb_member`
  ADD PRIMARY KEY (`UserUrl`),
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `apqhpp4dpd16065754516r6iwrdljb_request_store`
--
ALTER TABLE `apqhpp4dpd16065754516r6iwrdljb_request_store`
  ADD PRIMARY KEY (`RequestId`),
  ADD UNIQUE KEY `GuardianPermissionReceiveUrlKey` (`GuardianPermissionReceiveUrlKey`),
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `apqhpp4dpd16065754516r6iwrdljb_setting`
--
ALTER TABLE `apqhpp4dpd16065754516r6iwrdljb_setting`
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`);
--
-- Database: `topicste_service_create_axtxbyl4qn1583926727nb91ipl6rj`
--
CREATE DATABASE IF NOT EXISTS `topicste_service_create_axtxbyl4qn1583926727nb91ipl6rj` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `topicste_service_create_axtxbyl4qn1583926727nb91ipl6rj`;

-- --------------------------------------------------------

--
-- Table structure for table `apqhpp4dpd16065754516r6iwrdljb_member`
--

CREATE TABLE `apqhpp4dpd16065754516r6iwrdljb_member` (
  `Status` varchar(100) NOT NULL,
  `UserUrl` varchar(100) NOT NULL,
  `Position` varchar(100) NOT NULL,
  `CreateTime` varchar(100) NOT NULL,
  `CreateBy` varchar(100) NOT NULL,
  `CreatePosition` varchar(100) NOT NULL,
  `CreateRank` varchar(100) NOT NULL,
  `LastUpdateTime` varchar(100) NOT NULL,
  `LastUpdateBy` varchar(100) NOT NULL,
  `LastUpdatePosition` varchar(100) NOT NULL,
  `LastUpdateRank` varchar(100) NOT NULL,
  `LastChanges` text DEFAULT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL,
  `StatusReason` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `apqhpp4dpd16065754516r6iwrdljb_report`
--

CREATE TABLE `apqhpp4dpd16065754516r6iwrdljb_report` (
  `Status` varchar(100) NOT NULL,
  `MsgId` varchar(300) NOT NULL,
  `SendTime` varchar(100) NOT NULL,
  `MsgLength` varchar(100) NOT NULL,
  `MsgCount` varchar(100) NOT NULL,
  `SendTo` text NOT NULL,
  `MsgBody` text NOT NULL,
  `SendBy` varchar(300) NOT NULL,
  `MsgType` varchar(200) NOT NULL,
  `MsgLable` varchar(200) NOT NULL,
  `MsgSendByService` varchar(200) NOT NULL,
  `MsgServiceId` varchar(200) DEFAULT NULL,
  `MsgDetail` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apqhpp4dpd16065754516r6iwrdljb_report`
--

INSERT INTO `apqhpp4dpd16065754516r6iwrdljb_report` (`Status`, `MsgId`, `SendTime`, `MsgLength`, `MsgCount`, `SendTo`, `MsgBody`, `SendBy`, `MsgType`, `MsgLable`, `MsgSendByService`, `MsgServiceId`, `MsgDetail`, `Signature`) VALUES
('œ\0X~$úÙ<uRÆP‡', 'ÕÀ­2çßýAÏî®pÚ=4@I´õ!ê\nfªpÈ¡ì', '´)o1÷$~gAÑj£q*', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', '`Q$—êˆ•†+Sg', '/9XŒh¨3Ì“tÏD-!€vpcôUÿ;Y¾âCë', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', 'ÆÄdK³\\Œ™sx«Da~ŠYß	®¹j5Våþõ', 'Æ06õˆÏß•}†ÊŠ.', '\ZDø´;•úN\" t4ÎEJÌýýU]‘\rí\0Õ«·œU§', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `apqhpp4dpd16065754516r6iwrdljb_setting`
--

CREATE TABLE `apqhpp4dpd16065754516r6iwrdljb_setting` (
  `CreateType` varchar(100) NOT NULL,
  `UpdateAble` varchar(100) NOT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apqhpp4dpd16065754516r6iwrdljb_setting`
--

INSERT INTO `apqhpp4dpd16065754516r6iwrdljb_setting` (`CreateType`, `UpdateAble`, `SettingKeyUnique`, `SettingValueUnique`, `SettingKey`, `SettingValue`) VALUES
('£ScavèÈ[„U…7]á', 'Ä‹Ü”aSŠ¯û+Mži', 'Æàã¤x<ÇàÚ°s\Z¯»f', NULL, NULL, '©XùrŠÈKý6ßW§£1'),
('£ScavèÈ[„U…7]á', 'Ä‹Ü”aSŠ¯û+Mži', '/³Fåg¨ð²jÛ˜w', NULL, NULL, 'ðSžs½¿pK¤<;ÕçsÏ'),
('Ù\\7Ùg)¤Õ3žü\'w—d', 'hÕP^$æªóž¶ßûø¸~‚', 'j…™{ÙSWÏÒ4™+àŸïÜ', NULL, NULL, 'Û	­	[C\0Œþ’/ÁÖ”.F§A\"ª/Ñ„•	\0\'ãÔÝÌµÖB!	\\u}¤\'gÜÌ:õE\nt4.^šK');

-- --------------------------------------------------------

--
-- Table structure for table `axohbvrpyh1606576380lpy8dflaxw_member`
--

CREATE TABLE `axohbvrpyh1606576380lpy8dflaxw_member` (
  `Status` varchar(100) NOT NULL,
  `UserUrl` varchar(100) NOT NULL,
  `Position` varchar(100) NOT NULL,
  `CreateTime` varchar(100) NOT NULL,
  `CreateBy` varchar(100) NOT NULL,
  `CreatePosition` varchar(100) NOT NULL,
  `CreateRank` varchar(100) NOT NULL,
  `LastUpdateTime` varchar(100) NOT NULL,
  `LastUpdateBy` varchar(100) NOT NULL,
  `LastUpdatePosition` varchar(100) NOT NULL,
  `LastUpdateRank` varchar(100) NOT NULL,
  `LastChanges` text DEFAULT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL,
  `StatusReason` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `axohbvrpyh1606576380lpy8dflaxw_report`
--

CREATE TABLE `axohbvrpyh1606576380lpy8dflaxw_report` (
  `Status` varchar(100) NOT NULL,
  `MsgId` varchar(300) NOT NULL,
  `SendTime` varchar(100) NOT NULL,
  `MsgLength` varchar(100) NOT NULL,
  `MsgCount` varchar(100) NOT NULL,
  `SendTo` text NOT NULL,
  `MsgBody` text NOT NULL,
  `SendBy` varchar(300) NOT NULL,
  `MsgType` varchar(200) NOT NULL,
  `MsgLable` varchar(200) NOT NULL,
  `MsgSendByService` varchar(200) NOT NULL,
  `MsgServiceId` varchar(200) DEFAULT NULL,
  `MsgDetail` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `axohbvrpyh1606576380lpy8dflaxw_setting`
--

CREATE TABLE `axohbvrpyh1606576380lpy8dflaxw_setting` (
  `CreateType` varchar(100) NOT NULL,
  `UpdateAble` varchar(100) NOT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `axohbvrpyh1606576380lpy8dflaxw_setting`
--

INSERT INTO `axohbvrpyh1606576380lpy8dflaxw_setting` (`CreateType`, `UpdateAble`, `SettingKeyUnique`, `SettingValueUnique`, `SettingKey`, `SettingValue`) VALUES
('£ScavèÈ[„U…7]á', 'Ä‹Ü”aSŠ¯û+Mži', 'Æàã¤x<ÇàÚ°s\Z¯»f', NULL, NULL, '©XùrŠÈKý6ßW§£1'),
('£ScavèÈ[„U…7]á', 'Ä‹Ü”aSŠ¯û+Mži', '/³Fåg¨ð²jÛ˜w', NULL, NULL, 'ðSžs½¿pK¤<;ÕçsÏ'),
('Ù\\7Ùg)¤Õ3žü\'w—d', 'hÕP^$æªóž¶ßûø¸~‚', 'j…™{ÙSWÏÒ4™+àŸïÜ', NULL, NULL, 'Û	­	[C\0Œþ’/ÁÖ”.F§A\"ª/Ñ„•	\0\'ãÔÝÌµÖB!	\\u}¤\'gÜÌ:õE\nt4.^šK');

-- --------------------------------------------------------

--
-- Table structure for table `main_member`
--

CREATE TABLE `main_member` (
  `Status` varchar(100) NOT NULL,
  `UserUrl` varchar(100) NOT NULL,
  `Position` varchar(100) NOT NULL,
  `CreateTime` varchar(100) NOT NULL,
  `CreateBy` varchar(100) NOT NULL,
  `CreatePosition` varchar(100) NOT NULL,
  `CreateRank` varchar(100) NOT NULL,
  `LastUpdateTime` varchar(100) NOT NULL,
  `LastUpdateBy` varchar(100) NOT NULL,
  `LastUpdatePosition` varchar(100) NOT NULL,
  `LastUpdateRank` varchar(100) NOT NULL,
  `LastChanges` text DEFAULT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL,
  `StatusReason` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `main_report`
--

CREATE TABLE `main_report` (
  `Status` varchar(100) NOT NULL,
  `MsgId` varchar(300) NOT NULL,
  `SendTime` varchar(100) NOT NULL,
  `MsgLength` varchar(100) NOT NULL,
  `MsgCount` varchar(100) NOT NULL,
  `SendTo` text NOT NULL,
  `MsgBody` text NOT NULL,
  `SendBy` varchar(300) NOT NULL,
  `MsgType` varchar(200) NOT NULL,
  `MsgLable` varchar(200) NOT NULL,
  `MsgSendByService` varchar(200) NOT NULL,
  `MsgServiceId` varchar(200) DEFAULT NULL,
  `MsgDetail` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `main_report`
--

INSERT INTO `main_report` (`Status`, `MsgId`, `SendTime`, `MsgLength`, `MsgCount`, `SendTo`, `MsgBody`, `SendBy`, `MsgType`, `MsgLable`, `MsgSendByService`, `MsgServiceId`, `MsgDetail`, `Signature`) VALUES
('œ\0X~$úÙ<uRÆP‡', '\r0Z[!zëî†CÉ5W¼mÆó“ïS+‘ÉQª4ÓJ', '9­”£òwòŽÍUsƒü•', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', '¾<9Þb¡7NšFQqç‚', '/9XŒh¨3Ì“tÏD-!Ô&§ÐÞÔ\r^›Ùš§ø…', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', '!¦Ñü¼ÀØ>–{#ˆý–$q=÷k5G&É™Ì', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', '˜þÚ#€køÅµåx£Ô¯¥»¾¡ZÀíªÌ7P]/+', ',Ã0ÊíÁüÆ×ˆåË`øv', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', 'UòáCˆ\\Â\r²vö+!', '/9XŒh¨3Ì“tÏD-!‹LÍ Šˆ“ ZêãzpË\Z', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', 'ÆÄdK³\\Œ™sx«Da~ŠYß	®¹j5Våþõ', 'Æ06õˆÏß•}†ÊŠ.', 'µ‡öG]Î¥‚ÑR	AƒÚ®|Û{wåëR§ÌuD0', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', '¹|}5~/±[CßaI½´‡I†lÉ\nZxñkïâi', '7Ò«‚$§$+Jï~ÞdøŸ&', ',Ô¢3qý\'T©õCc7¿º', 'Ä8ŠŸùÉÄQŽÈ<6p', 'UòáCˆ\\Â\r²vö+!', '/9XŒh¨3Ì“tÏD-!:5Y†¾yah2\0d§\0¼ß‘', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', '&r¢°J•†³±mlØÍ€SÓ#z^w,hì›]™;é‰!', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', 'BÜÔ7o\nîàMºÓö”5¤ÍƒƒeÜ×3 æoòö5Ã', '†o÷…º½ðV˜€!ÒêT', ',Ô¢3qý\'T©õCc7¿º', 'Ä8ŠŸùÉÄQŽÈ<6p', 'UòáCˆ\\Â\r²vö+!', '/9XŒh¨3Ì“tÏD-!:5Y†¾yah2\0d§\0¼ß‘', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', 'ybµ°ºfô7L¿O\nÞŒu¿,~~L¥Îf‚™î¤~', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', 'ðÓÖ—Ì÷Ú6#a’è¾¶W\'æè9(UÌÙò×èK', '8Mt3O6¬@Œñ!·.|', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', '¾<9Þb¡7NšFQqç‚', '/9XŒh¨3Ì“tÏD-!·ÚSKñWÈ·´¬:ÆhiJ*', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', 'o™µ˜{ÞóßIœ&Ë¥\0·¹oqoê×\0¸œ€\"Ã', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', 'D:o“Ì\'Ç+ Îì(çÓL*bAí-î@wýYÈi™', 'C‡‰4ƒ,wP[ÉË¼·l', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', 'u¢~^ç—P“$lº°Ò@ž', '/9XŒh¨3Ì“tÏD-!Ø\\NÄ®Z¡iÀ6E°‡ÅC', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', 'OE!³\n-fÿü×w1nÅÅ•Î\Z“…', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', 'ItñO›V\rR¼ÔÆ¢}ò\'‚ÀØ*¯šýç¹G~õ', 'Mþq¥\\·Zªaô´\nO¬iy', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', 'UòáCˆ\\Â\r²vö+!', '/9XŒh¨3Ì“tÏD-!aÒ©o©ê¥´;ó‡„\0éÉ', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', '€\0›%ª3IC5Ëf…³M]‘AÕDnÑ}eGIÏ»*', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', 'ï~›\"Ï,ùxiGªË;@Èã¢ÃI†ú-¹†ŽgÛñòn', 'ÒÝè\"Üó‹ ~Æ;ÖÝ´‡', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', '¾<9Þb¡7NšFQqç‚', '/9XŒh¨3Ì“tÏD-!P|áß	GƒÑ\"ê1¨ôä', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', 'F¡š-ëV\0?ÄÂ,\r¹·Œ$ø××–¾ÂgÍ3öÈC6‘s', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', 'oN:—f`C¦#z|Ÿ•pä õóÆÙª)ð–ƒ®EEG', 'Ëáw«5Ü‘mÜuî', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', 'UòáCˆ\\Â\r²vö+!', '/9XŒh¨3Ì“tÏD-!HM ŽVTJàý®)4ì4í', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', 'h	þÉA‰± OÁn—²ECÜ4ðûÍ$šý>3ýüI', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', 'ô­·î™ùš«`)s_î×[èÖ\'\\ü¤Q¨HÖ3mT', 'HfH6¸ïß‡”³ÖäUÀË', ',Ô¢3qý\'T©õCc7¿º', 'Ä8ŠŸùÉÄQŽÈ<6p', '¾<9Þb¡7NšFQqç‚', '/9XŒh¨3Ì“tÏD-!:5Y†¾yah2\0d§\0¼ß‘', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', 'mE4ç5æD£>f\\+ÝUô4Â>œ¸iÊs]×N', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', 's(f“ŽB½+oÖ—´Á.À¹Áª“>‡¾¸\'\\)+~', 'ž\\™§äi­ibóô”‹ƒ÷', ',Ô¢3qý\'T©õCc7¿º', 'Ä8ŠŸùÉÄQŽÈ<6p', '¾<9Þb¡7NšFQqç‚', '/9XŒh¨3Ì“tÏD-!:5Y†¾yah2\0d§\0¼ß‘', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', 'úŽ\nc~ƒ¢<MQÛ\0œñ7È®3\\¡®Ì´þ¢®†', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', 'Xßºš\rZRÌÐG{Æžö¿²«8¡Zþ¡ÛÞ*ÐB‚ç)', 'Ácf¾¬Ü’ý²‚.#”c', ',Ô¢3qý\'T©õCc7¿º', 'Ä8ŠŸùÉÄQŽÈ<6p', '¾<9Þb¡7NšFQqç‚', '/9XŒh¨3Ì“tÏD-!:5Y†¾yah2\0d§\0¼ß‘', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', 'I\ržÂä÷]Úñüò* )a¡„§«·Zõ^ÖÔ”ÈÂ', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', 'ZÆ,êÌ¶LÎ¢Ì®A–â}ÿÅ{òò±J(ˆÛGù«', 'À®k°>33*ô:l¡Ö', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', 'ôÂT¨Å<J°ñ¡|5Ì', '/9XŒh¨3Ì“tÏD-!_ªH7%ØñlâpRÿýD¸N', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', '› AÀŠÐˆZ¹°n;\"0]üq\0àoË`Éê-¢×', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', '_ ºg¤Ø~fœ‚d‰9çõ?þç“w™knKlQ3MÖ—', '¤–JìVí§ÀvóþB©', ',Ô¢3qý\'T©õCc7¿º', 'Ä8ŠŸùÉÄQŽÈ<6p', 'UòáCˆ\\Â\r²vö+!', '/9XŒh¨3Ì“tÏD-!:5Y†¾yah2\0d§\0¼ß‘', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', 'ˆÎß1\r\\oa²ìeZ­–¯Œ~¶º;fß_»\\', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', '‚ßõ4ì§ßå‚,B‚¢1Ù½N¥i°òdŠãÖrÉÚè— ', '#sÀÐ¬žÙì¶ýRh\r”ö™', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', '¾<9Þb¡7NšFQqç‚', '/9XŒh¨3Ì“tÏD-!×ÓN²žÕJA8¬¾w3]7', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', 'Û¢46+ÀÇÿÇ„#á`å®òÎ£8­ö%´Ç•oû–', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', '†û€#Ôsô…¥Úb./\ZFôí³\nà¹Ÿ•a¶ˆž', 'Ãèœy·è5£ÃºuŒÌ1', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', 'UòáCˆ\\Â\r²vö+!', '/9XŒh¨3Ì“tÏD-!6ÉTÒQØÊCÒåv%m', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', 'ÆÄdK³\\Œ™sx«Da~ŠYß	®¹j5Våþõ', 'Æ06õˆÏß•}†ÊŠ.', 'ômšUÕáxU—º¨×\0juíIá5-VÅ÷—sF', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', '–x\\±ß 8’ÐË–CàkèøZ3‘yràS%äÁd]', '9‹‘IV@<Ü& \'»µ', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', 'NÜ#ÄDpH¬]’žl}ù<', '/9XŒh¨3Ì“tÏD-!Í¦š^Ä€bq\05O©‡Æ', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', 'hü}Æ½ÇUý}ÌiÿÌÇ1Ò}¯ÿr—¶ˆ5', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', '—/–mãèÉGÓB—3®Så4¿üK¤’6êd·ËÆë', 'ã¸ÿ\Zò—²p×¡ÜË¤&h', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', 'ôÂT¨Å<J°ñ¡|5Ì', '/9XŒh¨3Ì“tÏD-!>¨_öN;DæN‚XŽ:Ä', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', 'õe0˜hqa*Èª³é×q!E˜e©éD;aíš«ïŸ	9î', NULL, NULL),
('œ\0X~$úÙ<uRÆP‡', 'Ÿæ5dÁý¹¯:Eš²}‘R>+dz!’ƒb ·~o', '\'Ï€Z^âÎUWlù¶Û‰‰', 'š¥yÜ/HÒ,Q\0S’î ', 'Ä8ŠŸùÉÄQŽÈ<6p', 'UòáCˆ\\Â\r²vö+!', '/9XŒh¨3Ì“tÏD-!1¾Ý[Y\n”û}·Y2', '4¸ÿ2è8øzÝkÍÈ¹Ž', '&¡|mš©¬¬GÕ?ki›gÒŸÂ¢2\"?k?ëœ³', '/\'Ç?ÜñÊŸÆ½C]x{M', 'Æ06õˆÏß•}†ÊŠ.', 'ê,!:\"{.\"’~`àhÄ‰Ìi•Ñ9\rp´‹•ò', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `main_setting`
--

CREATE TABLE `main_setting` (
  `CreateType` varchar(100) NOT NULL,
  `UpdateAble` varchar(100) NOT NULL,
  `SettingKeyUnique` varchar(400) DEFAULT NULL,
  `SettingValueUnique` varchar(400) DEFAULT NULL,
  `SettingKey` text DEFAULT NULL,
  `SettingValue` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `main_setting`
--

INSERT INTO `main_setting` (`CreateType`, `UpdateAble`, `SettingKeyUnique`, `SettingValueUnique`, `SettingKey`, `SettingValue`) VALUES
('£ScavèÈ[„U…7]á', 'Ä‹Ü”aSŠ¯û+Mži', 'Æàã¤x<ÇàÚ°s\Z¯»f', NULL, NULL, '©XùrŠÈKý6ßW§£1'),
('£ScavèÈ[„U…7]á', 'Ä‹Ü”aSŠ¯û+Mži', '/³Fåg¨ð²jÛ˜w', NULL, NULL, 'ðSžs½¿pK¤<;ÕçsÏ'),
('Ù\\7Ùg)¤Õ3žü\'w—d', 'hÕP^$æªóž¶ßûø¸~‚', 'j…™{ÙSWÏÒ4™+àŸïÜ', NULL, NULL, 'Û	­	[C\0Œþ’/ÁÖ”.F§A\"ª/Ñ„•	\0\'ãÔÝÌµÖB!	\\u}¤\'gÜÌ:õE\nt4.^šK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apqhpp4dpd16065754516r6iwrdljb_member`
--
ALTER TABLE `apqhpp4dpd16065754516r6iwrdljb_member`
  ADD PRIMARY KEY (`UserUrl`),
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `apqhpp4dpd16065754516r6iwrdljb_report`
--
ALTER TABLE `apqhpp4dpd16065754516r6iwrdljb_report`
  ADD PRIMARY KEY (`MsgId`),
  ADD UNIQUE KEY `MsgServiceId` (`MsgServiceId`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `apqhpp4dpd16065754516r6iwrdljb_setting`
--
ALTER TABLE `apqhpp4dpd16065754516r6iwrdljb_setting`
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`);

--
-- Indexes for table `axohbvrpyh1606576380lpy8dflaxw_member`
--
ALTER TABLE `axohbvrpyh1606576380lpy8dflaxw_member`
  ADD PRIMARY KEY (`UserUrl`),
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `axohbvrpyh1606576380lpy8dflaxw_report`
--
ALTER TABLE `axohbvrpyh1606576380lpy8dflaxw_report`
  ADD PRIMARY KEY (`MsgId`),
  ADD UNIQUE KEY `MsgServiceId` (`MsgServiceId`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `axohbvrpyh1606576380lpy8dflaxw_setting`
--
ALTER TABLE `axohbvrpyh1606576380lpy8dflaxw_setting`
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`);

--
-- Indexes for table `main_member`
--
ALTER TABLE `main_member`
  ADD PRIMARY KEY (`UserUrl`),
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `main_report`
--
ALTER TABLE `main_report`
  ADD PRIMARY KEY (`MsgId`),
  ADD UNIQUE KEY `MsgServiceId` (`MsgServiceId`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `main_setting`
--
ALTER TABLE `main_setting`
  ADD UNIQUE KEY `SettingKeyUnique` (`SettingKeyUnique`),
  ADD UNIQUE KEY `SettingValueUnique` (`SettingValueUnique`);
--
-- Database: `topicste_service_manage`
--
CREATE DATABASE IF NOT EXISTS `topicste_service_manage` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `topicste_service_manage`;

-- --------------------------------------------------------

--
-- Table structure for table `service_buy_for_feature_record`
--

CREATE TABLE `service_buy_for_feature_record` (
  `Status` varchar(100) NOT NULL,
  `TransferStatus` varchar(100) NOT NULL,
  `PaymentStatus` varchar(100) NOT NULL,
  `BuyId` varchar(100) NOT NULL,
  `Priority` varchar(100) DEFAULT NULL,
  `VldPlnReqNo` varchar(100) NOT NULL,
  `VldPlnValidity` varchar(100) NOT NULL,
  `NVldPlnReqNo` varchar(100) NOT NULL,
  `ServiceMember` varchar(100) NOT NULL,
  `ServiceCode` varchar(100) NOT NULL,
  `Organization` varchar(100) NOT NULL,
  `ServiceAndOrganization` varchar(200) NOT NULL,
  `StartTime` varchar(100) DEFAULT NULL,
  `ExpTime` varchar(100) DEFAULT NULL,
  `LastChanges` text DEFAULT NULL,
  `StatusReason` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_buy_for_feature_record`
--

INSERT INTO `service_buy_for_feature_record` (`Status`, `TransferStatus`, `PaymentStatus`, `BuyId`, `Priority`, `VldPlnReqNo`, `VldPlnValidity`, `NVldPlnReqNo`, `ServiceMember`, `ServiceCode`, `Organization`, `ServiceAndOrganization`, `StartTime`, `ExpTime`, `LastChanges`, `StatusReason`, `Signature`) VALUES
('H% ;ñ{ ÿ<Ú', 'ù\'oŠ¢óÎk½påÞr…y', '‚Œ)3Ù¢ç˜g\r¢×òû°', '1ã<½DkÜÊ{µçh¹\ZåÜ+s~ n=K`Q', 'Ä8ŠŸùÉÄQŽÈ<6p', 'çé¦Ä¢JyÏ&üì6¥{<9', 'çé¦Ä¢JyÏ&üì6¥{<9', 'â‹WC3nL‹$T€¶Ø', ']°YkÌ\'ä~å@$Nˆ¦', 'ª¦å´…Žq(Æyã2Lï¥ò(.½PƒLÖ]hû^tCåE', '_ØjA¸ÜB¾2¦\Z|Ap¡+6[©ž7þPÐwLº«', 'ª¦å´…Žq(Æyã2Lï¥A0GhÃm}+ÀÍ¹ñŠZv,QÉÊí¨lºäìÉdÔk9N·w^9$«¯ €', 'çé¦Ä¢JyÏ&üì6¥{<9', 'çé¦Ä¢JyÏ&üì6¥{<9', NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', 'ù\'oŠ¢óÎk½påÞr…y', '‚Œ)3Ù¢ç˜g\r¢×òû°', 'eŠ<’ÇÅ„ (ÇfPÜ§(z÷Àb9§ž—ˆ', 'Ä8ŠŸùÉÄQŽÈ<6p', 'a!ÖõÚú\n¢–6î~}J', 'Axß0¿âÏ»ùè5ªHæ§»', 'çé¦Ä¢JyÏ&üì6¥{<9', ']°YkÌ\'ä~å@$Nˆ¦', '´a	©%žƒ¯fDMþ·w™9œ!qR6æÆÿ2îÅ€', 'n¥=%K\nsC\"O}ž÷?†°*\0²Â®a„FÍ\\Ô', '´a	©%žƒ¯fDMþ·wÄC9bÏ”ø&âÃ?¾¨ˆy9V5\0‰êB\rÿ”ä*Gõeq™ˆ!“Ûkeð', 'çé¦Ä¢JyÏ&üì6¥{<9', 'çé¦Ä¢JyÏ&üì6¥{<9', NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', 'ù\'oŠ¢óÎk½påÞr…y', '‚Œ)3Ù¢ç˜g\r¢×òû°', '\\+¦ÙØÖä½áX[C¨SHÇŒÍ„#§\nëôö(Rü€ó', 'Ä8ŠŸùÉÄQŽÈ<6p', 'a!ÖõÚú\n¢–6î~}J', 'Axß0¿âÏ»ùè5ªHæ§»', 'çé¦Ä¢JyÏ&üì6¥{<9', ']°YkÌ\'ä~å@$Nˆ¦', '´a	©%žƒ¯fDMþ·w™9œ!qR6æÆÿ2îÅ€', 'o‹³Ûk»ß\'L´6×ÿ«õô_›GßžY5Ç¼ËÄvÚJ', '´a	©%žƒ¯fDMþ·wÄC9bÏ”ø&âÃ?¾¨ˆÜÇÈ”\Zèv?œGŠ?Ä[Cÿd{J±…É‘9	à~l\ZÀ', 'çé¦Ä¢JyÏ&üì6¥{<9', 'çé¦Ä¢JyÏ&üì6¥{<9', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_buy_history`
--

CREATE TABLE `service_buy_history` (
  `BuyId` varchar(100) NOT NULL,
  `CSPCode` varchar(300) NOT NULL,
  `PlanCode` varchar(100) NOT NULL,
  `ServiceCode` varchar(100) NOT NULL,
  `Organization` varchar(100) NOT NULL,
  `BuyTime` varchar(100) NOT NULL,
  `PlanDtls` text NOT NULL,
  `BuyByDtls` text NOT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_buy_history`
--

INSERT INTO `service_buy_history` (`BuyId`, `CSPCode`, `PlanCode`, `ServiceCode`, `Organization`, `BuyTime`, `PlanDtls`, `BuyByDtls`, `Signature`) VALUES
('1ã<½DkÜÊ{µçh¹\ZåÜ+s~ n=K`Q', '8;±ÆÈpØbô€¦….çé¦Ä¢JyÏ&üì6¥{<9', 'Õ~u*LiX£‚,ßjkN¨Š Œš¨›w8QŸU', 'ª¦å´…Žq(Æyã2Lï¥ò(.½PƒLÖ]hû^tCåE', '_ØjA¸ÜB¾2¦\Z|Ap¡+6[©ž7þPÐwLº«', '®ÎšñÜ7“\\·\\Æòj>í', 'º.`XÖü~h2Þ=DÉ@Î1ðñPãhêEv¹Ü1š½y¾9è+.`‚fDýKÐdZì~4?5}pn7îÕŒ‡|%ià…	‰~', '«íÆ÷b¾Sï¼®À{ùÄaž‘!ç7Lå¸IB.A|xëøRZÉ6?ã!#ËYeƒ\ZÁ4¤^hèžºEÕ?d“®Ûz\"XªXRÝ¶kñßþ¤úî¶IDíwÏÊè§ØmŒhòJ1zÞgMª', NULL),
('eŠ<’ÇÅ„ (ÇfPÜ§(z÷Àb9§ž—ˆ', 'ÑÔ¢õÂ]»Mšô‘9å”­`É‘°Ûª:Áê§Ð˜Ø', ' K]ñ‡¤wÂÐ\'c¤å.yå[‚_ËÝ\0ÕÊ -ÈOtL£', '´a	©%žƒ¯fDMþ·w™9œ!qR6æÆÿ2îÅ€', 'n¥=%K\nsC\"O}ž÷?†°*\0²Â®a„FÍ\\Ô', 'WL“½1ÞÔÈ\'®„HZé', 'º.`XÖü~h2Þ=DÉ@Î1ðñPãhêEv¹Ü1š½y¾9è+.`‚fDýKÐdZì~4?5}pn7îÕŒ‡|%ià…	‰~', '«íÆ÷b¾Sï¼®À{ùÄw—G‘X·1_\reºÕ°\0–K@A¹g:‰¢äj\"5Ææm>ÜÎ%¶¼U‚¶î±8d“®Ûz\"XªXRÝ¶kñßþ¤úî¶IDíwÏÊè§ØmŒhòJ1zÞgMª', NULL),
('n\"t†Ì->Ò9?VA#$˜¬\'3n§•†Ì¶RÄ²0', '8;±ÆÈpØbô€¦….çé¦Ä¢JyÏ&üì6¥{<9', 'Õ~u*LiX£‚,ßjkN¨Š Œš¨›w8QŸU', 'ª¦å´…Žq(Æyã2Lï¥ò(.½PƒLÖ]hû^tCåE', 'n¥=%K\nsC\"O}ž÷?†°*\0²Â®a„FÍ\\Ô', 'ÐYàm!1ÞpT¯Þ<ÓB', 'º.`XÖü~h2Þ=DÉ@Î1ðñPãhêEv¹Ü1š½y¾9è+.`‚fDýKÐdZì~4?5}pn7îÕŒ‡|%ià…	‰~', '«íÆ÷b¾Sï¼®À{ùÄw—G‘X·1_\reºÕ°\0–K@A¹g:‰¢äj\"5Ææm>ÜÎ%¶¼U‚¶î±8d“®Ûz\"XªXRÝ¶kñßþ¤úî¶IDíwÏÊè§ØmŒhòJ1zÞgMª', NULL),
('\\+¦ÙØÖä½áX[C¨SHÇŒÍ„#§\nëôö(Rü€ó', 'ÑÔ¢õÂ]»Mšô‘9å”­`É‘°Ûª:Áê§Ð˜Ø', ' K]ñ‡¤wÂÐ\'c¤å.yå[‚_ËÝ\0ÕÊ -ÈOtL£', '´a	©%žƒ¯fDMþ·w™9œ!qR6æÆÿ2îÅ€', 'o‹³Ûk»ß\'L´6×ÿ«õô_›GßžY5Ç¼ËÄvÚJ', '—XàmsZUÆ(°Éb˜', 'º.`XÖü~h2Þ=DÉ@Î1ðñPãhêEv¹Ü1š½y¾9è+.`‚fDýKÐdZì~4?5}pn7îÕŒ‡|%ià…	‰~', '«íÆ÷b¾Sï¼®À{ùÄ	úÅã{»ô6}MasŠúäÞ\"@U~˜!Î²È°¬\ZÜ©~íh%ðj`4DmÇ\rd“®Ûz\"XªXRÝ¶kñßþ¤úî¶IDíwÏÊè§ØmŒhòJ1zÞgMª', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_buy_record`
--

CREATE TABLE `service_buy_record` (
  `Status` varchar(50) NOT NULL,
  `SetupStatus` varchar(50) NOT NULL,
  `ServiceMember` varchar(50) NOT NULL,
  `BuyId` varchar(100) NOT NULL,
  `VldPlnReqNo` varchar(100) NOT NULL,
  `VldPlnValidity` varchar(100) NOT NULL,
  `NVldPlnReqNo` varchar(100) NOT NULL,
  `TotalRequest` varchar(100) NOT NULL,
  `PlanUpdateDate` varchar(100) NOT NULL,
  `ServiceCode` varchar(100) NOT NULL,
  `Organization` varchar(100) NOT NULL,
  `ServiceAndOrganization` varchar(200) NOT NULL,
  `StartTime` varchar(100) DEFAULT NULL,
  `ExpTime` varchar(100) DEFAULT NULL,
  `ServiceVersion` varchar(100) NOT NULL,
  `LastChanges` text DEFAULT NULL,
  `StatusReason` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_buy_record`
--

INSERT INTO `service_buy_record` (`Status`, `SetupStatus`, `ServiceMember`, `BuyId`, `VldPlnReqNo`, `VldPlnValidity`, `NVldPlnReqNo`, `TotalRequest`, `PlanUpdateDate`, `ServiceCode`, `Organization`, `ServiceAndOrganization`, `StartTime`, `ExpTime`, `ServiceVersion`, `LastChanges`, `StatusReason`, `Signature`) VALUES
('H% ;ñ{ ÿ<Ú', 'H% ;ñ{ ÿ<Ú', ']°YkÌ\'ä~å@$Nˆ¦', 'aAýv)•RFXç8ü–š\ZàÉœÖÓÌåL˜mm}', 'çé¦Ä¢JyÏ&üì6¥{<9', '®ÎšñÜ7“\\·\\Æòj>í', 'çé¦Ä¢JyÏ&üì6¥{<9', 'çé¦Ä¢JyÏ&üì6¥{<9', '®ÎšñÜ7“\\·\\Æòj>í', 'ª¦å´…Žq(Æyã2Lï¥ò(.½PƒLÖ]hû^tCåE', '_ØjA¸ÜB¾2¦\Z|Ap¡+6[©ž7þPÐwLº«', 'ª¦å´…Žq(Æyã2Lï¥A0GhÃm}+ÀÍ¹ñŠZv,QÉÊí¨lºäìÉdÔk9N·w^9$«¯ €', 'çé¦Ä¢JyÏ&üì6¥{<9', 'çé¦Ä¢JyÏ&üì6¥{<9', '©XùrŠÈKý6ßW§£1', NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', 'H% ;ñ{ ÿ<Ú', ']°YkÌ\'ä~å@$Nˆ¦', 'n\"t†Ì->Ò9?VA#$˜¬\'3n§•†Ì¶RÄ²0', 'çé¦Ä¢JyÏ&üì6¥{<9', 'çé¦Ä¢JyÏ&üì6¥{<9', '¶Ó“¼mS}s‰ÏÀ0', 'Ä8ŠŸùÉÄQŽÈ<6p', '´)o1÷$~gAÑj£q*', 'ª¦å´…Žq(Æyã2Lï¥ò(.½PƒLÖ]hû^tCåE', 'n¥=%K\nsC\"O}ž÷?†°*\0²Â®a„FÍ\\Ô', 'ª¦å´…Žq(Æyã2Lï¥A0GhÃm}+ÀÍ¹ñŠZvy9V5\0‰êB\rÿ”ä*Gõeq™ˆ!“Ûkeð', 'çé¦Ä¢JyÏ&üì6¥{<9', 'çé¦Ä¢JyÏ&üì6¥{<9', '©XùrŠÈKý6ßW§£1', NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', 'H% ;ñ{ ÿ<Ú', ']°YkÌ\'ä~å@$Nˆ¦', 'OýÚ¢ÒaT}ŠïÓ°:37VµÙ\0D•7S^Ñè¿Õ', 'çé¦Ä¢JyÏ&üì6¥{<9', 'WL“½1ÞÔÈ\'®„HZé', 'çé¦Ä¢JyÏ&üì6¥{<9', 'çé¦Ä¢JyÏ&üì6¥{<9', 'WL“½1ÞÔÈ\'®„HZé', '´a	©%žƒ¯fDMþ·w™9œ!qR6æÆÿ2îÅ€', 'n¥=%K\nsC\"O}ž÷?†°*\0²Â®a„FÍ\\Ô', '´a	©%žƒ¯fDMþ·wÄC9bÏ”ø&âÃ?¾¨ˆy9V5\0‰êB\rÿ”ä*Gõeq™ˆ!“Ûkeð', 'çé¦Ä¢JyÏ&üì6¥{<9', 'çé¦Ä¢JyÏ&üì6¥{<9', '©XùrŠÈKý6ßW§£1', NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', 'H% ;ñ{ ÿ<Ú', ']°YkÌ\'ä~å@$Nˆ¦', 'ŒTi(K\"½ÈÄà’Ÿý.Ð‚=Î€wÍÏ_)ç÷–¼:', 'çé¦Ä¢JyÏ&üì6¥{<9', '—XàmsZUÆ(°Éb˜', 'çé¦Ä¢JyÏ&üì6¥{<9', 'çé¦Ä¢JyÏ&üì6¥{<9', '—XàmsZUÆ(°Éb˜', '´a	©%žƒ¯fDMþ·w™9œ!qR6æÆÿ2îÅ€', 'o‹³Ûk»ß\'L´6×ÿ«õô_›GßžY5Ç¼ËÄvÚJ', '´a	©%žƒ¯fDMþ·wÄC9bÏ”ø&âÃ?¾¨ˆÜÇÈ”\Zèv?œGŠ?Ä[Cÿd{J±…É‘9	à~l\ZÀ', 'çé¦Ä¢JyÏ&üì6¥{<9', 'çé¦Ä¢JyÏ&üì6¥{<9', '©XùrŠÈKý6ßW§£1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_list`
--

CREATE TABLE `service_list` (
  `Status` varchar(50) NOT NULL,
  `ServiceMember` varchar(50) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `NameSearch` varchar(150) NOT NULL,
  `ShortDescription` varchar(300) NOT NULL,
  `Description` text NOT NULL,
  `Code` varchar(100) NOT NULL,
  `ServiceFor` text NOT NULL,
  `StartTime` varchar(100) DEFAULT NULL,
  `ExpTime` varchar(100) DEFAULT NULL,
  `StartTimeType` varchar(50) NOT NULL,
  `ExpTimeType` varchar(50) NOT NULL,
  `CreateBy` varchar(100) NOT NULL,
  `CreateTime` varchar(100) NOT NULL,
  `CreatePosition` varchar(100) NOT NULL,
  `CreateRank` varchar(100) NOT NULL,
  `LastUpdateBy` varchar(100) NOT NULL,
  `LastUpdateTime` varchar(100) NOT NULL,
  `LastUpdatePosition` varchar(100) NOT NULL,
  `LastUpdateRank` varchar(100) NOT NULL,
  `AllOffersPermission` varchar(50) NOT NULL,
  `SpecialOffersPermission` varchar(50) NOT NULL,
  `PrivateOffersPermission` varchar(50) NOT NULL,
  `AllMaxOfferDiscount` varchar(100) DEFAULT NULL,
  `SpecialMaxOfferDiscount` varchar(100) DEFAULT NULL,
  `PrivateMaxOfferDiscount` varchar(100) DEFAULT NULL,
  `TablesAndColumns` text NOT NULL,
  `TablesAndColumnsDefaultValues` text NOT NULL,
  `TotalSelledPack` varchar(100) NOT NULL,
  `MaxSellLimit` varchar(100) NOT NULL,
  `Version` varchar(100) NOT NULL,
  `LastChanges` text DEFAULT NULL,
  `StatusReason` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_list`
--

INSERT INTO `service_list` (`Status`, `ServiceMember`, `Name`, `NameSearch`, `ShortDescription`, `Description`, `Code`, `ServiceFor`, `StartTime`, `ExpTime`, `StartTimeType`, `ExpTimeType`, `CreateBy`, `CreateTime`, `CreatePosition`, `CreateRank`, `LastUpdateBy`, `LastUpdateTime`, `LastUpdatePosition`, `LastUpdateRank`, `AllOffersPermission`, `SpecialOffersPermission`, `PrivateOffersPermission`, `AllMaxOfferDiscount`, `SpecialMaxOfferDiscount`, `PrivateMaxOfferDiscount`, `TablesAndColumns`, `TablesAndColumnsDefaultValues`, `TotalSelledPack`, `MaxSellLimit`, `Version`, `LastChanges`, `StatusReason`, `Signature`) VALUES
('H% ;ñ{ ÿ<Ú', ']°YkÌ\'ä~å@$Nˆ¦', 'Þ0›ÇpØ»ð¯.m(QÉË', 'Á`4ýÖ<íõ:§g‡\'9', '÷¸7û0åéˆ\Z6Ýv‹óŸ6:t&±\'”y¿ö9\\KMé3[nÇ5°îö ×—nX™…¬dÈJYƒ…šN', '\nú;KíÎæ‘¦P(ú“C~HJ;D¿\ZÒ×›ï×†(ÌvµÂë«n>IáÓN¬ÙÍíˆ¨¢úT––C	Dâ&;z–e¼Y¥¬ï`v2²í¦Âüº²Ñö,¿ClôŸÈ$ß˜:ê¬½FKðÒ³5Ój‰Å4ÐüJUø¡j}:8ˆ|¨ìÅìŒm	Î/¹^¼qè,5¬éƒ‚ÃW‚æÂ¿«“Ÿö£ð2Ho(úà¸ïÂ`L•£òŽÉ[Åmf.P„û¾É\'=‡EV¥³ý’Óv•%^8ÝMÅÀ,ŠjÈ<+¾´Óœæ|¼tË€äVÿeq\n1kÂô´°(lgp(\rÓ5Lr›uØàIõ$[œ’.BúøA¥(­ƒ~<+ízÍì$×yÞŠåµ¢x¶ì’­;AMÈÙ±Ã¶GëQ˜»G«Tÿôf—jÒèøCE¢~² jÛ+Ú\rß¥y‚Å/ñ ±Àn=WS?²²ú{P×œ‡-mUä‡ã\nÖõóáF„UO¨6ªø', '´a	©%žƒ¯fDMþ·w™9œ!qR6æÆÿ2îÅ€', 'ššIQ­“»éd; õ_', 'g=–2UBŠk\'?KQ`‰ßE', 'ÁîF-cuÀ‘%Ü9>´X¨', 'ô}U#ßV?\'ÛhAŽÙ¯', 'óF^†ßÏñ„¸a¨ž“(!', '¢R9@±>î^Œ0;É›­œÿ¬´£Ž(FéÊŸƒÙpg', '?óŒ\'O®•#Ñ¶žµj', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '?\\^³;¢ªƒßPo?–6”ëS†Ã2go¨yƒ^‡æ', 'Ž\ZðòžLâÎ®ûE¿–ÓBí', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '1šJà…? ÜíõÔ¾r¯¾', '1šJà…? ÜíõÔ¾r¯¾', '1šJà…? ÜíõÔ¾r¯¾', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', '&A4cîûM>£}rÍ=\"ïàú¯¹”™®æÆ%¦º©þà7>†3æÝ£\0¯ñâC_)yMÇ=ž64ò9¨×±3Äé\r{ò)Âi(ôÇ&\'„:?-¨#$ªÕLÂøÒ“ÙšØf{Ø§\"²Ge¤#‘ë^.Šb|v]Ùx±úc>e \n4xI«¶<n¶€ú9õfÏ¦F«cïàÍJ³§w!ÐâèÀ3üÎß!íß·œgf	{c²läB‘gU%ŸÂÔýu¶cÛo*´·5¯ã<º­RÚÁÙ²·e’¤Ú§”šÖg¯5\'›uâ£€çùÝ¨ÙU…6—dIT²UÓ’à4¼öÆ¨;žW´½©årógsÃÀùÊå2ý”òŸÕ|ü9€1¾>£ÍÓ:ïÌ¤ÈÉg$K1ˆ8PcG—¦bXBô‡ÓQ¹¯˜\nºqXšÔÆŸëü¥Q½_b,bþ”Â	aO™ÖÄéº¶*5,¾wk^µÑoö*OOqÈMÆXÛ3•ÄI×yx¤Üÿ~K½Ï¬\Z-\0ff\Z/¨Ž±Ä Ä”g-×Ø ¬¡	ü;5³ÈÖ‰jt*Êïö®…Ð“»Ìäœ£`øÑë¾{3sn¬ëbÃÍ!À²|6ËÎÍn)µÄw¥‘@ÚIýÚ/—>üãA¯`ñØnœÅY³TX84œÃ,ht0{Ëz›”ÆýdHyíg}øøA¾]xvÅÍ©»©Ã%ÀVJHfÖDÿíï¸Ú4µ4>\røb—Ék€;Jjl7¡ìè~o5§,õ§ áR¤Q…×Q:v´rœá!‚¾¢µ=âÊºJ^?	Phð»´ëß%­o#âøÆ¢œfÞè÷Ôù0U²ËàgÅcËÖVüh†¢lqf“ÚÅ\\nšâÁÃ¹|“R ·»’¨Œ¡eß“\"ÐÆ:çóùûå•E\"ÛÆ·xë¦ëî³.²5®‡a‚[&!çùÝ¨ÙU…6—dIT²UÓ’à4¼öÆ¨;žW´½©årógsÃÀùÊå2ýî5´C±ÁÇ{#Ö@>°ÜR^íª¬BÏ¿Æ´lõ4w‡ÜóOU1TV\"C¤cùÙ™öà…´h‡/ðû¢P{ÖøÞp5faûÏÏdéÒé`cóö-•vàíž.Í@\0*›þ¦•bÝBŠíå4†ÀeÉ²\0KmÍ¦ÿot!o#ú%$  ûRóýÛ;1A¸‘OÖÞ¬`Àqé×”#/÷üÒN´Oü€çùÝ¨ÙU…6—dIT²UÓ’à4¼öÆ¨;žW´½©årógsÃÀùÊå2ý+ýÔá#p‹ZÈ}zÁ£²ËàgÅcËÖVüh†¢lqf“ÚÅ\\nšâÁÃ¹|“R ·»’¨Œ¡eß“\"ÐÆXÌ¡¡­à!î§tòiÉu,gbR®cÚ;1\\tDÇ²ËàgÅcËÖVüh†¢lqf“ÚÅ\\nšâÁÃ¹|“R ·»’¨Œ¡eß“\"ÐÆXÌ¡¡­à!î§tòiÉ\r#œƒç7E;bÃÖ¡YñÐ*OOqÈMÆXÛ3•ÄI×yx¤Üÿ~K½Ï¬\Z-\0ff&Óm\'%B-·ù„ˆ)èûøKÜ&#9g_(áS˜·F·ÇØVöçvùê²fðdU®×ë1«µ\'n¯ÈÜT¿kG·‚ˆU¦…„›þÌézˆ’Ê3Y>ÜMùÆB,½œð]fa´ÀæGâ‹c/T@Á¯3üÎß!íß·œgf.«X\r×‚3]n5ŸqñJbQvÅÍ©»©Ã%ÀVJN¨(+í.¿Œ‹Ð[÷6¢_“#°Ù“{`4¢ZêVØ=Á{V“lÎ©ø¥À4áö›j:Ø*ñ‚ô7lÝ-í^«ø­f¿hô\'ÒÖøcÍÛùD%ÊÜï„ÑÏ^AÅÇÐH²‘\0Õpa{{‚ŠˆÉ\"ËÑ4c9íL¡ÛÝ¿QdÅ=!ÚN)ËN6½q‡£fçSãRd/zI—bƒ†d·¸‘½HŒÂœv‚ö¿ãÅ\rL;Ê(\"÷e²ãv´ŽÜ˜4ëôz4vË µÕôYý4ñeÔŠ3¬i¢×%ÇÆoÞ˜Jø [f1¼PHë¿X ;š‡ùsÆ™Væz«íÞ¯wp¿WÚÿ@è¥§p^‚Ý¿QdÅ=!ÚN)ËN6½q‡£fçSãRd/zI—bƒ†%¿¬ðmQü/VeS¡h‘px>Då\n$\\\'pºvó‡ñ%\0`OÑRÊ{¶Ÿï²|6ËÎÍn)µÄw¥‘c[CçQ!^ox¾Ï¯Ì§ÂâÊüClÆ·–gåzÉÃÖ’Td/HêËÔ5âÍÓ:ïÌ¤ÈÉg$K1ˆ8PcG—¦bXBô‡ÓQ¹¯˜\nºqXšÔÆŸëü¥Q½_b^`¦ì<´»!ŠèOÌ•Šä¿5ß¬¹Ù—!ùÿƒœB÷çøºÊE=Aƒ«ŸŸ6Àdg‹&ŽéeÛŠ<Ê¦rC}h-ýO[ÍqÄùõø+Ÿè?’ª61JL8wÒWö»äÎÑ•tåÏœÊ•iÆñºâä ·óèE,¬­~~+TíÚÔÁ³±˜©ê<¶¥/;/ð¤C}ûuTÂãHïß¾œ»àAiy•7gš|–­pŠ\"\\:¶=<óKBÖnÉwÒ¹{¨ o¸ø&úÄ2á ^ld²|6ËÎÍn)µÄw¥‘c[CçQ!^ox¾Ï¯Ì\"(ÅJ’?_ŒÜ4\\DÊèÊÈHf–h¿~x5•ëë1«µ\'n¯ÈÜT¿kG·‚ˆU¦…„›þÌézˆ’Ê3Y>ÜMùÆB,½œð›.Ä>\"­¢f†â™Ác7”Ôæe‚ý¶ÿkõÕ}¥`öyx¤Üÿ~K½Ï¬\Z-\0ff\Z/¨Ž±Ä Ä”g-×ØìÃ‚µ{Ç°”m”¤=XÈé!j$7p·7tþe°4ñˆž¢íÍÓ:ïÌ¤ÈÉg$K1ˆ8PcG—¦bXBô‡ÓQ¹¯˜\nºqXšÔÆŸëü¥Q½_b)y×l-QàFÔkMG–¢gû‹‡‘¤±dè7š„ò£#{Ø§\"²Ge¤#‘ë^.Šb|v]Ùx±úc>e \n4xI«¶<n¶€ú9õfÏ¦F}t›ßŠ¨ªbYÁèò#lÈ²ËàgÅcËÖVüh†¢lqf“ÚÅ\\nšâÁÃ¹|“R ·»’¨Œ¡eß“\"ÐÆc¤xdÅƒe½úÏ¯6Áé\ZÊš‹”MôOú»Î*pöÃû\Z´çŒÕ» bÚaŒÊ”zH\r¶æÕ˜ó¹Æ}üá—Øo@ÚIýÚ/—>üãA\Z‚°mô_½*i}ÃIÄœÏZó ˜Hs	¿‡Y´~Øa‚÷*6A[‰úô,¼í^«ø­f¿hô\'ÒÖøcÍ}h-ýO[ÍqÄùõø+Ÿ³¿Ô—ŒýÐ©÷\Z0¸æï‡|›ÎO\rËÛ~£w05a(rü§‘,¾—wÆ|§^´rœá!‚¾¢µ=âÊºJ^?	Phð»´ëß%­o#âæ²“Ð\\¯WMŽŒ(#üEO–.#—T¶,(Ç‘ù¶È£K×FûàùŒ:ÀOdg‹&ŽéeÛŠ<Ê¦rC}h-ýO[ÍqÄùõø+Ÿ’cÐûåCÕ?û\Z?e`G3o¼“lÏè£\r`Y¶pkèÏÃû\Z´çŒÕ» bÚaŒÊ”_n%g¶3Ârºç5¿ÞU™©årógsÃÀùÊå2ýD°’ƒTÙÚ–Åè:\ncyÍÓ:ïÌ¤ÈÉg$K1ˆ8PcG—¦bXBô‡ÓQ¹¯˜ÕZÌ2Ô¾Ò{£1Gtl˜7(íáØî¤\nGV÷|ÞbÅ©\0Ì	†¹WbÖæ¥¥à{Ø§\"²Ge¤#‘ë^‚ˆU¦…„›þÌézˆ’Ê3Y>ÜMùÆB,½œðö*ËR•(³oWþ…À=Ý†„»Xðäjfj‘a¶ôlâæ—b—^‚Q\'Ô	@v‹ÿÁXJ1JJùÖÝ\\Aä?òqÈ›Øk/´S [QV~ÍÓ:ïÌ¤ÈÉg$K1ˆ8PcG—¦bXBô‡ÓQ¹¯˜\nºqXšÔÆŸëü¥Q½_b)y×l-QàFÔkMG–¢é×”#/÷üÒN´Oü€çùÝ¨ÙU…6—dIT²UÓ’à4¼öÆ¨;žW´½©årógsÃÀùÊå2ýUlcÄïû%T`P¾•„Æw]­ãÂ¦ tkŠ.Ôš’¸ÅÅqãÕÁXù²uœû…¤ª c¤	¦®ÍˆÚ“@ÍôÝ®îok½Ê£W¢$>Ë•1ù« Û\'È;$Oü“@Î²™)ùKõºmÈvÅÍ©»©Ã%ÀVJ’¶_Š£{0ß,–øEÊ\rÊÖËÔD…¡«ÇyB»yýè3üÎß!íß·œgf	{c²läB‘gU%ŸÂÔýu¶cÛo*´·5¯ã<ÓK4€û½Æ“l.Ð“9×3©Z	kC_!š6ù¶,²ËàgÅcËÖVüh†¢lqf“ÚÅ\\nšâÁÃ¹|“R rYH;=ên¬¬FR1RmÜE¦<eçtÊ4¸„ç\\âõ«÷bÁÒd•B³ˆoV*‚ü“o$TàñÎlƒZ©i†ä¶ììþÂÅ9åè§;TÚëç•Úà¸òõ‹ÚýÕ­¡`CÍ‹4ÒÐÏð­I5•Íï«\r‰ª¦qíQÕ**OOqÈMÆXÛ3•ÄI×yx¤Üÿ~K½Ï¬\Z-\0ff\Z/¨Ž±Ä Ä”g-×ØFÈE‚p•_cœ‹\rT;tÀéÑ<æ¬6&+.Í@\0*›þ¦•bÝBŠíå4ñeÔŠ3¬i¢×%ÇÆoÞ˜Jø [f1¼PHë¿X _†I52e%AMéð?íÇ–œt$ú\0uW›G0úœ(yçøºÊE=Aƒ«ŸŸ6Àdg‹&ŽéeÛŠ<Ê¦rC}h-ýO[ÍqÄùõø+Ÿ©à’¸ySŒº×`bØìã©Žûú{\r*fv‰bž”,çøºÊE=Aƒ«ŸŸ6À—b—^‚Q\'Ô	@v‹ÿÁXJ1JJùÖÝ\\Aä?òqÝ9ÄDæ‰P‰—÷`ù%£Š6¸*èÞx\0øÏ$O¤3üÎß!íß·œgf÷ÉÞË³Xûÿ×lºvÅÍ©»©Ã%ÀVJN¨(+í.¿Œ‹Ð[÷6ö@h\\=‚ðìcÕ	—#*rÆpƒ{Š§NZ¬ˆÙ—¯¸tÉw,¾À0Ìx‚šŠ5K‚ˆU¦…„›þÌézˆ’ã	Ð¢lVü›•Š²p Åxéßœgy®Øër„[iÛA1°¨éWÏ‹\'5–UŸ\\úŠ§:êÕÇGG}«’´rœá!‚¾¢µ=âÊºJ^?üD\rÏ·DÛÛ±îD-\n÷\r>;“•‡Ì‰Rã­–ˆöò£ÍÆì J\rÃ‡ã>Ptùñú(ÛÏÐÒÊÉ‹³ðo—b—^‚Q\'Ô	@v‹ÿÁXJ1JJùÖÝ\\Aä?òq¦˜óåõÇ¯!Éod^Úh$Û8P[fiÆnŠÔâ$Ê8uQù”-œªœ±¹!ÕZÌ2Ô¾Ò{£1Gtl˜Ü&#9g_(áS˜·F·ÇØVöçvùê²fðdU®×ë1«µ\'n¯ÈÜT¿kG·‚ˆU¦…„›þÌézˆ’Ê3Y>ÜMùÆB,½œð5ufýrÞPÄÙˆÑ¯õuã²_ç‡¾ï^_>G;P4ñeÔŠ3¬i¢×%ÇÆoÞ˜Jø [f1¼PHë¿X (iÿ!#ýpH*YO#›ö²ËàgÅcËÖVüh†¢lq[¡5ÂY…à0âÃºÖîrYH;=ên¬¬FR1RxóÄ]=-\0vûòÍnØ`zVìïKÚô(~ú¿­é', 'ÔËŒß¢ñÇGAâG·…HuƒÚQQÒøäœu#X8Ä<!ÙHð„Å\\p‰?·4–3m{ŠTM´Ä¯ùVz/´=%b„ã€>È á1¬î)¡Ë»±º8Œº|µõ%ß›=)ågE¥H¹¦ý’\"‰öú•(¦’qù ¬‹NÑØ<E‹ëãžþ(ðYÇ ¤q§AÛÆ¬2úÈV¾e9uŸÏßwx°÷ÉÎe¬CØ¬ãiÒî©ñNáÊÔV0Þ¦IÐ8~Z2øûÿ^EM¼	‰¶qrÃ¤ˆa¨ŒÚŸ]~èdüì\0íÆ{¤ÜØs,æûÿpâ¿#VæX„Š˜*zÃ5èÚ%c/ÊœIw€d+/ÓOÇ˜p2›£)9)¬/ypˆtÝúGßÛðW`AùÒ¢€/ÖÁ{øþ³Æ·9ÃÄwK¬`3<¥,˜•oq\0CHy®Ó‹	Y(\0÷Ùrùu5ç©>i¿Þ³R²ÛØfs;¹A\\^ƒ]D¾–<ÂN[·œÒÒ}±c¼b N5À|]]\r²êævñÔhîk=7\"õ@õ|?Ë¯nµ\\@6¹ÙNœB q‘sŽ<îëfæñ¥®BH‘¬µ£šÓR!¶ÕT¡zÆ­»êRS\"ØYY†¬uó|>Çu8ð>Lyt\'{<ÓÄåSÚ\'È:¬&àšL¹h#ÆZGmˆE­jLH½\\%\Zs¯éƒ›Ç’çù#à]ÃökëÃ4Öb6‘PÑ÷êO0\Zü\"”^¸Ð(\0ô9Q¡ûØ­à5ÒÖÎôÑ6Ÿ3»ËØ)0ÈTcÃ*ÏVPÀÞÑwëwûÅ»!¦œ.*K†Ä¤žzL@øÄJÞ“V:˜?«ó-l€¿Å;\r³\'†4äô•aŒ!IB\'#¸£û·B3§\n6h¨W?ç®+Rd¨bòoÕØ <È†•³F<gx7ú‘W÷ÐMfÈáe±ÓÂ_TSK­×ÿ,µ™Þk©–”FÈœ†p\nºåÏ_NœˆvOÐrº#áäÄBŒ/ezdzÒvIL(d#jW)S¤f\rF”Ãá,«¹‰fZã\rSß®Í{Ž34¼œr€•Õ!’X“À^4¤Š?ðAlR­YßÏ<rg@~hñØç|ÆwžÈñ°D–L²Ð©)yñ¼€ÿø°jUJ{	ëÇÒ{DÑ¶½\'F&];t‡_Ä™±r_žŽ›LhKy“v*ªˆ‡3éÝÉÜü±rÌ_Wþ¡÷5zºj@*·Œ={=©„ŠLë¾·‚P©…Q²ôL¿Itº½6ýÂsir•?þÜiÇ2[)+ÓW4’E\0ˆ•Ê5Ç}šˆÝ\0@üJaOÓ¢és·¸–	–‚Ž1h8e¨_å@U·ÖaZŒßBA`ZŸ¾ü\"ül-jŽsûz&œÛ(m$8‘¬µ~(›¤³5\0KL(¹[ 0ô¼ºZ;†½[íîNx¾¾eæšzRAòƒYèdBt0dd7I?ÝÖì¥Êð…Á”“äÍŸOŸ$òWÅP_œ“¥ceTKj&À?ôm¼)gT‡á¡æFjN±(b©,Ø“@ôÜLUnÞøÒ|¥	`òÊ†ý½Ôp­Pkª\"úV’€ôI\00[î‡›Ûv$/¼M›!\'Ðˆ{/DŸFzXŠpnšôv#€´RÁ¢\'½ŸÎÅ¬˜z]]>uÏ«ãíê?Y÷{InúgtS·ÛãÀýÇIRˆV¬›4ñ£ÖÆJàë1}+Š½1®¯Éä*Æì:°üaÚS¸&aõüŠ%•üž\0ðù;ÐØX…\'µDÛyÑM•2äÅQT4©íå†ŸjîÇøÀ\rÿÈ§ŽGf†Ì˜‹Jaµ@[ITïr?{hàYwrÓû¿Õa 0½í\r_¾ZQ˜Ñ–Ì:ëXÀõQzÃhU;–b´aèÞèw!ècuþ‡›Ûv$/¼M›!\'Ðˆ{/D§D7™[ÓÐË©5´évçÇAhÚ\Z–­Ÿ šZô‹!Ä¬1±û‡î\'î{Zi`D¾yB¡ÿÕ›v¡í.Nzûd\rÙ\0¤i5Ú• :ãŒ•Û~“Z÷»lLb5$o¨{Ç•[Á‹—·ðUÛJåîIÑó`Ò(\ryåÉ=Þ\\ßû(ïÁ\r®š”Ÿ fn‚Tõzš>_ã0W¡b¹ò*o¥Ôýú}‰Ž‰Î­ÛÍàxR‰ïm¸‰°Ä—Q1‰/1We:ÀvbÐE©m‘åÐH~~}6ëC\'y¬Lwqs–]Øœd]BM\n§ÜÊÐ›\\/Ò×.lÁ±*H÷Çr€nhTFsõŒåÀ›õcçÉ9hÂÿI ¨ûèúŒÇH\'·,´|Ù¦ÛžûFúaª¾Ž\"÷èæÛ] p°eMîL¦U“¹¼Çâ[–²²ï¯\ZÃ¹Z6jám³´›ò\0eØ ‘þyVPŒJ”Y&´ÐñîãäL)DBw\0Qî|¿­~0(kÀZÆv#óÉð€ÛPÍtöö 1g2¯sªÖ¯¼·tHžéÚªV-­.z\0Æ¥‰‰êžÁ^,ûÈýDE^uxmú|Ô;¿à\\çµÒÞvØ\\UnÓè(øÊ¼†—AßõÐ\0‹\"·\Zÿ¾´æBsŠjósh\0¥e<ã)‹ñbYŽK«Ñm\"œiF?òÅ=SFáõNwÏh^ÃR.hvbÐE©m‘åÐH~~}6‡›Ûv$/¼M›!\'Ðˆ{/D&‰¹n¯ÒÀHôR6Vm(pã_„wÎÿŒÌ…;=KÝ\'Òß|ŸQÍ”Q!Ç5~gÉþh‡·ÆYíxcš=_œ“¥ceTKj&À?ô¿Õ\rª—ÄÔ}ÚÚOsœP4™ôV#é¼É”6L=›Õïå¡}‹Ä}Ò$ÿ‹W\'ÊÓ²óBçc$uÜ«á¶©‡÷1ƒé†lß³\0’ŽÓHê{qnE‰wõÐ\0‹\"·\Zÿ¾´æBs½#·>lŒÎÅÁ{ÃòföŸ—5ŸØŠGJ±c–×†<-ÅuêÚu´$Z@L<´Šê{Í¢È=Ö…@í-CŽ69\rU\0Œº;û†H¹Q„\Z³Wè®a[úÕ6p²÷n&ùÝÖûŸÁÑ>­V^¼6†õ', 'çé¦Ä¢JyÏ&üì6¥{<9', 'ùZ¸Ä;$¿ßzJZ‘', '©XùrŠÈKý6ßW§£1', NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', ']°YkÌ\'ä~å@$Nˆ¦', 'qM°äŠØ.ÚœOQ¿Ò€É', 'Ø]ƒ-|mæZ0ª!®–K', 'a:ÖßÅ1i4Œ¥BóN*4„ifñ¶Á–ß?Í~ôäOJ,\"žõ‡0O„\\¸$·7Gþ¬fÏ¾‰c7€_)x1ûFÄ', 'a:ÖßÅ1i4Œ¥BóN*4„ifñ¶Á–ß?Í~ôäOJ,\"žõ‡0O„\\¸$·7G_o9u°Ëò“îäÕ¤Zâ\0×§\0?—„JÅ“[rÊªBH˜Á‘°*Êí\'®Žl/Õ¡LV\Z	&…þHÜR†SSx}ÿœñrbJvŒépƒ’‰Ú8ÕBÐ¸,ØÕ‹-G\n5rÐx‰¸éV,­‘þôz©BVjÒŽW3Š÷Óþ\"“n', 'ª¦å´…Žq(Æyã2Lï¥ò(.½PƒLÖ]hû^tCåE', 'U\0p’ƒŠ‰âJßRõ5&', 'çé¦Ä¢JyÏ&üì6¥{<9', 'ùZ¸Ä;$¿ßzJZ‘', 'ô}U#ßV?\'ÛhAŽÙ¯', 'óF^†ßÏñ„¸a¨ž“(!', 'PÕQö§­¼Ea‹\n±Áýïò£oñJ‘3øÒE«œ¨¨', 'æßâ‘Ê\'Íµ#ZF\rûš', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '©€»ºÔN W\r©},80<‹ò’åk¯²ýþºØÿ', 'r• ÚÓón‹ ¤2<êÂ‰­', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '1šJà…? ÜíõÔ¾r¯¾', '1šJà…? ÜíõÔ¾r¯¾', '1šJà…? ÜíõÔ¾r¯¾', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', '&A4cîûM>£}rÍ=\"ïàú¯¹”™®æÆ%¦º©þà7>†3æÝ£\0¯ñâC_)yMÇ=ž64ò9¨×±3Äé\r{ò)Âi(ôÇ&\'„:?-¨#$ªÕLÂøÒ“ÙšØf{Ø§\"²Ge¤#‘ë^.Šb|v]Ùx±úc>e \n4xI«¶<n¶€ú9õfÏ¦F«cïàÍJ³§w!ÐâèÀ3üÎß!íß·œgf	{c²läB‘gU%ŸÂÔýu¶cÛo*´·5¯ã<Ì¥°àSÕ7èìP«œ\0—ùÑÖŽà„•yÛ|a(rü§‘,¾—wÆ|§^š’¸ÅÅqãÕÁXù²uœû…¤ª c¤	¦®ÍˆÚ“n›¨Jª…Þ˜o&?+PÏàú¯¹”™®æÆ%¦º©þà7>†3æÝ£\0¯ñâC_)yMÇ=ž64ò9¨×±3Äé–#J¡5ƒ”,óàø™üvÙMÔZxa}Ó‹ÉMšˆoV*‚ü“o$TàñÎlƒZ©i†ä¶ììþÂÅ9åè§;TÚëç•Úà¸òõ‹Úòk\r¡IiÖLfoüqR¡×´-íi„\\+}ÍOŠw&CyR }äEf:|}øUVe\\d…Ú\'Û¹¹Õm…IÄÇ=\\~Úh,CY\rý¼üæ·Ý¡g—÷‚ûü2UÉx2›àú¯¹”™®æÆ%¦º©þà7>†3æÝ£\0¯ñâC_)yMÇ=ž64ò9¨×±3ÄéeÁù¯+ö&HÓ‘˜aÉT¨~Ù7ØïÃÓ?_ìÇã±a(rü§‘,¾—wÆ|§^š’¸ÅÅqãÕÁXù²uœû…¤ª c¤	¦®ÍˆÚ“›J;x`F´vh³^}D×åUb¢Võ¦ßA]Ôâa(rü§‘,¾—wÆ|§^š’¸ÅÅqãÕÁXù²uœû…¤ª c¤	¦®ÍˆÚ“\0Å=(N¼¦­_r$<¸KÞ*V«œycÈœoYÑyçøºÊE=Aƒ«ŸŸ6Àdg‹&ŽéeÛŠ<Ê¦rC}h-ýO[ÍqÄùõø+Ÿ©ÄCtã(9øx\"#çÚ$Û8P[fiÆnŠÔâ$Ê8uQù”-œªœ±¹!ÕZÌ2Ô¾Ò{£1Gtl˜ÏÃ˜ª²yÆ\\´ª‡¶ä5Ê	Ä\'¸<§˜rlÂ$åVj®ìšg˜7ÙÞI÷#Á›¾(4ñeÔŠ3¬i¢×%ÇÆo ~\ZvJŠ~•/òÀ¦žz·¥Bñ,¶ë0J†Þ>­NÀ®Ãƒœ2¥Dèàú¯¹”™®æÆ%¦º©þ\"½ÔXËð´ãÉœˆÖ<½;´Óì¿ù`•¥I†XÎ’hH¡ T‡ü»wÜI73jlÎ†Ñ£ÓõYNÝƒs“ØŸ\'ÍØ¶œ®ÂUTñ;´lƒZ©i†ä¶ììþÂÅ9å>|™Èpõ§2ÿXARÉ€â­|½Kî“—>ÀÑëÑK¤cí:ìîÉënˆ\n~i\ZnZÏBÐÌày¥(žœ~U¸ÚÔÁ³±˜©ê<¶¥/;/ðo“°@þ­ùO¡aÑWx$wüâõÌ	DØ°\nçV†\\–Ÿ\'ÍØ¶œ®ÂUTñ;´lƒZ©i†ä¶ììþÂÅ9å>|™Èpõ§2ÿXARÉ¾z¨¤¦@T¹zóvRXÄ“3üÎß!íß·œgf÷ÉÞË³Xûÿ×lºvÅÍ©»©Ã%ÀVJN¨(+í.¿Œ‹Ð[÷6íÿküËzdÅ*	åÅãÆ¡1cïn‡XÆóU1ÿ®žGÙçùÝ¨ÙU…6—dIT²UÓ’à4¼öÆ¨;žW´½©årógsÃÀùÊå2ýÃ\n\ZEd:¶¢Û¥(t)ö¸ú´þ\0{Sò¨…ÐV\r­ç7Ü›òÕø=‚?g\Z~,Ñ¥ý¡[^LCŒDo%º\0F\r>;“•‡Ì‰Rã­–ˆö$»&ì–ãžŽ©jz®6e€Sþ.OoÄéfü´·±ˆ‹yx¤Üÿ~K½Ï¬\Z-\0ffð€=]œ»ú$¸ ‡š›©Üv)­£Ôr¡†ƒ{s˜ NÃ.4€Vî<EG•IKå3üÎß!íß·œgf.«X\r×‚3]n5ŸqñJbQvÅÍ©»©Ã%ÀVJN¨(+í.¿Œ‹Ð[÷6NûŒ8Y3ÊÕ´2Áª—$Û8P[fiÆnŠÔâ$Ê8uQù”-œªœ±¹!ÕZÌ2Ô¾Ò{£1Gtl˜mž.sÐ!1i†£¨n¼YU–£Íp3¸äO	ßAYŠ}Ïùñú(ÛÏÐÒÊÉ‹³ðo—b—^‚Q\'Ô	@v‹ÿÁÜuð#^\"‚m7A{u¹’P‰°®nu}]1Hè”â%Î§óàú¯¹”™®æÆ%¦º©þà7>†3æÝ£\0¯ñâC_)yMÇ=ž64ò9¨×±3Äé]VªêS¯Â|å!8¬âáökR^íª¬BÏ¿Æ´lõ4ŒôG‘¨{Ç¢çÃhæY\\ùÙ™öà…´h‡/ðû¢NèlÖ¯û‡™fÝû]^A9Ö9NhËQt-Ù-àú¯¹”™®æÆ%¦º©þà7>†3æÝ£\0¯ñâC_)yMÇ=ž64ò9¨×±3Äé÷ªkkûá—µÙïÝg©¹ÉÇ‹io±ŸœÂ vÐË…× çùÝ¨ÙU…6—dIT²UÓ’à4¼öÆ¨;žW´½©årógsÃÀùÊå2ý«öû¥gèÿm¼Ñ3Û5*OOqÈMÆXÛ3•ÄI×yx¤Üÿ~K½Ï¬\Z-\0ff&Óm\'%B-·ù„ˆ)èûøK†…†ÏVNÜò¢Ôžw‚¼hndZBßÍ<\rpXÚU”³ìoë<õNùÂ&‘ïàêyMÇ=ž64ò9¨×±3Äé£ KIî³\"Äå¥=Å}.Å»3?¥åì]©&ó\'ŒnZÏBÐÌày¥(žœ~U¸d…Ú\'Û¹¹Õm…IÄÊ3Y>ÜMùÆB,½œðð-ZÏðÅá”2óbºÈá·¢ÙHž¸P´ˆŠŸÕ2õzH\r¶æÕ˜ó¹Æ}üá—Øo@ÚIýÚ/—>üãA¤²eïÑÚFTL2fà,+9[öe\" G@òÞLuyx¤Üÿ~K½Ï¬\Z-\0ff&Óm\'%B-·ù„ˆ)èûøKZÅhI€°ÉT: ÿÓ%dR^íª¬BÏ¿Æ´lõ4O1Ä>Poß÷îó8ÏLêùÙ™öà…´h‡/ðû¢Læ5ñx¥ß	úÞ`›v*¬’Ýalê¹”öW@ð”ê²ËàgÅcËÖVüh†¢lq³Îgš÷SU#ÄäPy!ƒˆ“·»’¨Œ¡eß“\"ÐÆRÔv±`0Èv~Eª°ÒÁ¾Üxb	ýÜG¢þŽ~Êkì‰Ø1ç&TFß4Ä]Ï4ñeÔŠ3¬i¢×%ÇÆo ~\ZvJŠ~•/òÀ¦ƒ&î\nŽ\0öaqgîñÚGÌÀaØ“È*QÇáèBµMg¢ùñú(ÛÏÐÒÊÉ‹³ðo—b—^‚Q\'Ô	@v‹ÿÁXJ1JJùÖÝ\\Aä?òqÊx¿å,—€%õà­¼ÂÒ‹²¿f•ûø}®ÅN³ylƒZ©i†ä¶ììþÂÅ9å¹8³òý%\rñA»y\0Ø`ŠöÛULvS&3.J', 'ÔËŒß¢ñÇGAâG·…HuƒÚQQÒøäœu#X8Ä<!ÙHð„Å\\p‰?·4–3m{ŠTM´Ä¯ùVz/´=%b„ã€>È á1¬î)¡Ë»±º8Œº|µõ%ß›=)ågE¥H¹¦ý’\"‰öú•(¦’qù ¬‹NÑØ<E‹ëãžþ(ðYÇ ¤q§AÛÆ¬2úÈV¾e9uŸÏßwx°÷ÉÎe¬CØ¬ãiÒî©ñNáÊÔV0Þ¦IÐ8~Z2øûÿ^EM¼	‰¶qrÃ¤ˆa¨ŒÚŸ]~èdüì\0íÆ{¤ÜØì]älS:žc–½^œq˜	ÑwëwûÅ»!¦œ.*K†Ä¤žzL@øÄJÞ“V:˜?-MÒN\ZÙNm<S	w)\Z¿TÓÙ!)_>Ý37xSoPlÇ€c–à…NÖðOã!ÑAFñ<ðôßõ™nóÚ¬°Lo5°!FIyŠàû´->\':e…Éic3Rô»°¤ áX÷ÔûT½À°/ƒßC 2\Zø_c\\(ê>–š‡OÝIøXvØ•Œ…¯~ˆLþ#½œT\rp_ä»töñ²Ã\'ÝÎü%º\'Î½U	9', 'çé¦Ä¢JyÏ&üì6¥{<9', 'ùZ¸Ä;$¿ßzJZ‘', '©XùrŠÈKý6ßW§£1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_payment_history`
--

CREATE TABLE `service_payment_history` (
  `PmtId` varchar(100) NOT NULL,
  `RefundStatus` varchar(100) DEFAULT NULL,
  `RefundGeneratedRequest` varchar(100) DEFAULT NULL,
  `RefundGeneratedResponse` varchar(100) DEFAULT NULL,
  `RefundGeneratedRequestTime` varchar(100) DEFAULT NULL,
  `RefundGenretedResponseTime` varchar(100) DEFAULT NULL,
  `RefundAmountINR` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `service_plans`
--

CREATE TABLE `service_plans` (
  `Status` varchar(50) NOT NULL,
  `PlanCode` varchar(100) NOT NULL,
  `PlanFor` varchar(100) NOT NULL,
  `Price` varchar(100) NOT NULL,
  `Validity` varchar(100) NOT NULL,
  `MaxRequestLimit` varchar(100) NOT NULL,
  `SameOrgCanBuyMaxTimeByPlaneCode` varchar(100) NOT NULL,
  `CSPCode` varchar(300) NOT NULL,
  `SameOrgCanBuyMaxTimeByCSP` varchar(100) NOT NULL,
  `StartTime` varchar(100) NOT NULL,
  `ExpTime` varchar(100) NOT NULL,
  `TotalSelledPack` varchar(100) NOT NULL,
  `MaxSellLimit` varchar(100) NOT NULL,
  `CreateBy` varchar(100) NOT NULL,
  `CreateTime` varchar(100) NOT NULL,
  `CreatePosition` varchar(100) NOT NULL,
  `CreateRank` varchar(100) NOT NULL,
  `LastUpdateBy` varchar(100) NOT NULL,
  `LastUpdateTime` varchar(100) NOT NULL,
  `LastUpdatePosition` varchar(100) NOT NULL,
  `LastUpdateRank` varchar(100) NOT NULL,
  `AllOffersPermission` varchar(50) NOT NULL,
  `SpecialOffersPermission` varchar(50) NOT NULL,
  `PrivateOffersPermission` varchar(50) NOT NULL,
  `AllMaxOfferDiscount` varchar(100) NOT NULL,
  `SpecialMaxOfferDiscount` varchar(100) NOT NULL,
  `PrivateMaxOfferDiscount` varchar(100) NOT NULL,
  `LastChanges` text DEFAULT NULL,
  `StatusActionReason` text DEFAULT NULL,
  `Signature` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_plans`
--

INSERT INTO `service_plans` (`Status`, `PlanCode`, `PlanFor`, `Price`, `Validity`, `MaxRequestLimit`, `SameOrgCanBuyMaxTimeByPlaneCode`, `CSPCode`, `SameOrgCanBuyMaxTimeByCSP`, `StartTime`, `ExpTime`, `TotalSelledPack`, `MaxSellLimit`, `CreateBy`, `CreateTime`, `CreatePosition`, `CreateRank`, `LastUpdateBy`, `LastUpdateTime`, `LastUpdatePosition`, `LastUpdateRank`, `AllOffersPermission`, `SpecialOffersPermission`, `PrivateOffersPermission`, `AllMaxOfferDiscount`, `SpecialMaxOfferDiscount`, `PrivateMaxOfferDiscount`, `LastChanges`, `StatusActionReason`, `Signature`) VALUES
('H% ;ñ{ ÿ<Ú', 'Õ~u*LiX£‚,ßjkN¨Š Œš¨›w8QŸU', 'ª¦å´…Žq(Æyã2Lï¥ò(.½PƒLÖ]hû^tCåE', 'çé¦Ä¢JyÏ&üì6¥{<9', 'ùZ¸Ä;$¿ßzJZ‘', 'â‹WC3nL‹$T€¶Ø', 'ùZ¸Ä;$¿ßzJZ‘', '8;±ÆÈpØbô€¦….çé¦Ä¢JyÏ&üì6¥{<9', 'köHtiÏë¾Ó”«—Û°F', 'º;&×¨äªs-ÉØø=„Z', 'ùZ¸Ä;$¿ßzJZ‘', 'çé¦Ä¢JyÏ&üì6¥{<9', 'ùZ¸Ä;$¿ßzJZ‘', 'PÕQö§­¼Ea‹\n±Áýïò£oñJ‘3øÒE«œ¨¨', 'º;&×¨äªs-ÉØø=„Z', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '?\\^³;¢ªƒßPo?–6”ëS†Ã2go¨yƒ^‡æ', '¨/B¤¼!:À¨AH‚¨yf', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '1šJà…? ÜíõÔ¾r¯¾', '1šJà…? ÜíõÔ¾r¯¾', '1šJà…? ÜíõÔ¾r¯¾', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', 'ô£–{rî9ÎöÜhÀâaÁÂÑBµ‹e\"\"ú{%&§', '´a	©%žƒ¯fDMþ·w™9œ!qR6æÆÿ2îÅ€', 'Oü2	\'{/cAœkÙ¼iÌ', 'ùZ¸Ä;$¿ßzJZ‘', 'Qg\']Žc‹—fÁzˆ[b', 'ùZ¸Ä;$¿ßzJZ‘', 'åäÑi4ä9M@pa\'úÇ', 'ùZ¸Ä;$¿ßzJZ‘', 'Î$·È¤2v%²e¢4q¬ü', 'ùZ¸Ä;$¿ßzJZ‘', 'çé¦Ä¢JyÏ&üì6¥{<9', 'ùZ¸Ä;$¿ßzJZ‘', 'PÕQö§­¼Ea‹\n±Áýïò£oñJ‘3øÒE«œ¨¨', '0ÒÿlâxñÖ~ëC‡1', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', 'PÕQö§­¼Ea‹\n±Áýïò£oñJ‘3øÒE«œ¨¨', '0ÒÿlâxñÖ~ëC‡1', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '1šJà…? ÜíõÔ¾r¯¾', '1šJà…? ÜíõÔ¾r¯¾', '1šJà…? ÜíõÔ¾r¯¾', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', '‡(aÃ–9àÌ1;DAg6ì‹Â›ƒòŠi¨–Œëè)é', '´a	©%žƒ¯fDMþ·w™9œ!qR6æÆÿ2îÅ€', 'çé¦Ä¢JyÏ&üì6¥{<9', '½yƒJ¿(€q´yÉ‰¯[ún', 'a!ÖõÚú\n¢–6î~}J', 'ùZ¸Ä;$¿ßzJZ‘', 'ÑÔ¢õÂ]»Mšô‘9å”;Pá‘c,}Ü½^…ŽL9:', 'Ä8ŠŸùÉÄQŽÈ<6p', 'åƒJÌÝì‚}^å†-¯ô', '’DÉ‡‚9òœÇs,š`', 'çé¦Ä¢JyÏ&üì6¥{<9', 'ùZ¸Ä;$¿ßzJZ‘', 'PÕQö§­¼Ea‹\n±Áýïò£oñJ‘3øÒE«œ¨¨', 'î=K—;¸B|O\\Ÿ', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '-®#Y­²†ÿ™dLjQ[Øu¬IŠM`1;HÅ	_†¸®£', ']ï½	ëáØƒ¡Îz½œ;s', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '1šJà…? ÜíõÔ¾r¯¾', '1šJà…? ÜíõÔ¾r¯¾', '1šJà…? ÜíõÔ¾r¯¾', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', NULL, NULL, NULL),
('H% ;ñ{ ÿ<Ú', ' K]ñ‡¤wÂÐ\'c¤å.yå[‚_ËÝ\0ÕÊ -ÈOtL£', '´a	©%žƒ¯fDMþ·w™9œ!qR6æÆÿ2îÅ€', 'çé¦Ä¢JyÏ&üì6¥{<9', 'Axß0¿âÏ»ùè5ªHæ§»', 'a!ÖõÚú\n¢–6î~}J', 'ùZ¸Ä;$¿ßzJZ‘', 'ÑÔ¢õÂ]»Mšô‘9å”­`É‘°Ûª:Áê§Ð˜Ø', 'ùZ¸Ä;$¿ßzJZ‘', 'çé¦Ä¢JyÏ&üì6¥{<9', 'C=\\f¾\r}¥TƒVEr', 'çé¦Ä¢JyÏ&üì6¥{<9', 'ùZ¸Ä;$¿ßzJZ‘', 'PÕQö§­¼Ea‹\n±Áýïò£oñJ‘3øÒE«œ¨¨', '\rl“*…>ìÎVbQE›³', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '-®#Y­²†ÿ™dLjQ[Øu¬IŠM`1;HÅ	_†¸®£', 'Ëëf?T÷BgD¯cù®ð>k', 'HzÓmopBÐúÔÙ½í¥ò', 'Ä8ŠŸùÉÄQŽÈ<6p', '1šJà…? ÜíõÔ¾r¯¾', '1šJà…? ÜíõÔ¾r¯¾', '1šJà…? ÜíõÔ¾r¯¾', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', 'mŽ—ãùÒ*2‰ÕÆ»Êp[ÏFE¯$X„ö¼|‘õžš¯¢WYfD±4jþ', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `service_buy_for_feature_record`
--
ALTER TABLE `service_buy_for_feature_record`
  ADD PRIMARY KEY (`BuyId`),
  ADD UNIQUE KEY `UniquePriorityForServiceAndOrg` (`ServiceCode`,`Priority`,`Organization`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `service_buy_history`
--
ALTER TABLE `service_buy_history`
  ADD PRIMARY KEY (`BuyId`),
  ADD UNIQUE KEY `Signature` (`Signature`);

--
-- Indexes for table `service_buy_record`
--
ALTER TABLE `service_buy_record`
  ADD PRIMARY KEY (`BuyId`),
  ADD UNIQUE KEY `ServiceAndOrganization` (`ServiceAndOrganization`),
  ADD UNIQUE KEY `Signature` (`StatusReason`(300));

--
-- Indexes for table `service_list`
--
ALTER TABLE `service_list`
  ADD PRIMARY KEY (`Code`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD UNIQUE KEY `NameSearch` (`NameSearch`),
  ADD UNIQUE KEY `signature` (`Signature`);

--
-- Indexes for table `service_payment_history`
--
ALTER TABLE `service_payment_history`
  ADD PRIMARY KEY (`PmtId`);

--
-- Indexes for table `service_plans`
--
ALTER TABLE `service_plans`
  ADD PRIMARY KEY (`PlanCode`),
  ADD UNIQUE KEY `Signature` (`Signature`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
