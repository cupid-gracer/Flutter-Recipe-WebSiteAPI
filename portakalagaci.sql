/*
 Navicat Premium Data Transfer

 Source Server         : A
 Source Server Type    : MySQL
 Source Server Version : 100408
 Source Host           : localhost:3306
 Source Schema         : portakalagaci

 Target Server Type    : MySQL
 Target Server Version : 100408
 File Encoding         : 65001

 Date: 24/11/2020 15:23:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_bookmark
-- ----------------------------
DROP TABLE IF EXISTS `tbl_bookmark`;
CREATE TABLE `tbl_bookmark`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_on` datetime(0) NULL DEFAULT NULL,
  `updated_on` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tbl_bookmark_recipe_id`(`recipe_id`) USING BTREE,
  INDEX `tbl_bookmark_user_id`(`user_id`) USING BTREE,
  CONSTRAINT `tbl_bookmark_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `tbl_recipes` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_bookmark_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 175 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_bookmark
-- ----------------------------
INSERT INTO `tbl_bookmark` VALUES (1, 42, 14, '2020-10-22 11:26:53', NULL);
INSERT INTO `tbl_bookmark` VALUES (2, 41, 14, '2020-10-23 08:57:12', NULL);
INSERT INTO `tbl_bookmark` VALUES (3, 12, 13, '2020-10-23 16:48:11', NULL);
INSERT INTO `tbl_bookmark` VALUES (4, 10, 13, '2020-10-23 16:49:43', NULL);
INSERT INTO `tbl_bookmark` VALUES (149, 38, 16, '2020-11-19 09:57:04', NULL);
INSERT INTO `tbl_bookmark` VALUES (156, 12, 16, '2020-11-19 09:57:32', NULL);
INSERT INTO `tbl_bookmark` VALUES (157, 5, 16, '2020-11-19 09:57:37', NULL);
INSERT INTO `tbl_bookmark` VALUES (158, 3, 16, '2020-11-19 09:57:43', NULL);
INSERT INTO `tbl_bookmark` VALUES (170, 40, 18, '2020-11-21 11:58:24', NULL);
INSERT INTO `tbl_bookmark` VALUES (173, 42, 16, '2020-11-24 11:14:58', NULL);
INSERT INTO `tbl_bookmark` VALUES (174, 40, 16, '2020-11-24 11:15:16', NULL);

-- ----------------------------
-- Table structure for tbl_carousel
-- ----------------------------
DROP TABLE IF EXISTS `tbl_carousel`;
CREATE TABLE `tbl_carousel`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sub_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` enum('A','I') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'A' COMMENT '\"A=active,I=inactive\"',
  `created_on` datetime(0) NULL DEFAULT NULL,
  `updated_on` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tbl_category
-- ----------------------------
DROP TABLE IF EXISTS `tbl_category`;
CREATE TABLE `tbl_category`  (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `category_image` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` enum('A','I') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'A' COMMENT '\"A=active ,I=inactive\"',
  `created_on` datetime(0) NULL DEFAULT NULL,
  `updated_on` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`cid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_category
-- ----------------------------
INSERT INTO `tbl_category` VALUES (4, 'Ana Yemekler', '', 'A', '2020-06-16 20:11:17', NULL);
INSERT INTO `tbl_category` VALUES (5, 'Çorbalar', '5ef6b7d3d1007.png', 'A', '2020-06-27 08:36:59', NULL);
INSERT INTO `tbl_category` VALUES (6, 'Hamur İşleri', '5ef6eddfca9cc.jpg', 'A', '2020-06-27 12:27:35', NULL);
INSERT INTO `tbl_category` VALUES (7, 'Ekmekler', '', 'A', '2020-06-28 07:26:14', NULL);

-- ----------------------------
-- Table structure for tbl_comment
-- ----------------------------
DROP TABLE IF EXISTS `tbl_comment`;
CREATE TABLE `tbl_comment`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('A','I') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'A' COMMENT '\"A=active ,I=inactive\"',
  `comment` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `comment_type` enum('C','R') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'C' COMMENT '\"C=comment,R=reply comment\"',
  `comment_reply_id` int(11) NOT NULL,
  `created_on` datetime(0) NULL DEFAULT NULL,
  `updated_on` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tbl_comment_user_id`(`user_id`) USING BTREE,
  INDEX `tbl_comment_recipe_id`(`recipe_id`) USING BTREE,
  CONSTRAINT `tbl_comment_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `tbl_recipes` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 87 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_comment
-- ----------------------------
INSERT INTO `tbl_comment` VALUES (1, 12, 14, 'A', 'Tesekkurler', 'C', 0, '2020-10-22 14:14:10', NULL);
INSERT INTO `tbl_comment` VALUES (2, 33, 16, 'A', '987', 'C', 0, '2020-11-10 22:01:50', NULL);
INSERT INTO `tbl_comment` VALUES (3, 41, 16, 'A', '3', 'C', 0, '2020-11-10 22:02:46', NULL);
INSERT INTO `tbl_comment` VALUES (4, 41, 16, 'A', '6', 'R', 3, '2020-11-10 22:02:51', NULL);
INSERT INTO `tbl_comment` VALUES (5, 41, 16, 'A', '9', 'R', 3, '2020-11-10 22:02:56', NULL);
INSERT INTO `tbl_comment` VALUES (6, 41, 16, 'A', '9', 'R', 3, '2020-11-10 22:03:02', NULL);
INSERT INTO `tbl_comment` VALUES (7, 3, 16, 'A', 'wefwef', 'C', 0, '2020-11-19 19:54:38', NULL);
INSERT INTO `tbl_comment` VALUES (8, 3, 16, 'A', 'wefef', 'R', 7, '2020-11-19 19:54:45', NULL);
INSERT INTO `tbl_comment` VALUES (9, 3, 16, 'A', 'efef', 'R', 7, '2020-11-19 19:54:51', NULL);
INSERT INTO `tbl_comment` VALUES (68, 42, 18, 'A', '\"this is test comment654654654654\"', 'R', 0, '2020-11-24 12:29:31', NULL);
INSERT INTO `tbl_comment` VALUES (69, 42, 18, 'A', '\"this is test comment654654654654\"', 'R', 0, '2020-11-24 12:29:35', NULL);
INSERT INTO `tbl_comment` VALUES (70, 42, 18, 'A', '\"this is test comment654654654654\"', 'R', 0, '2020-11-24 12:29:39', NULL);
INSERT INTO `tbl_comment` VALUES (71, 42, 18, 'A', '\"this is test comment654654654654\"', 'R', 0, '2020-11-24 12:29:50', NULL);
INSERT INTO `tbl_comment` VALUES (72, 42, 18, 'A', '\"this is test comment654654654654\"', 'R', 0, '2020-11-24 12:29:54', NULL);
INSERT INTO `tbl_comment` VALUES (73, 42, 18, 'A', '\"this is test comment654654654654\"', 'R', 0, '2020-11-24 12:31:40', NULL);
INSERT INTO `tbl_comment` VALUES (74, 42, 18, 'A', 'wefwefwefef', 'R', 0, '2020-11-24 12:32:25', NULL);
INSERT INTO `tbl_comment` VALUES (75, 42, 18, 'A', 'wefwefwefef', 'R', 0, '2020-11-24 12:35:58', NULL);
INSERT INTO `tbl_comment` VALUES (76, 42, 18, 'A', 'wefwefwefef', 'R', 0, '2020-11-24 12:36:29', NULL);
INSERT INTO `tbl_comment` VALUES (77, 42, 18, 'A', 'wefwefwefef', 'R', 0, '2020-11-24 12:37:05', NULL);
INSERT INTO `tbl_comment` VALUES (78, 12, 16, 'A', 'wow fieisooc Odie DD email fjdiso Rosie ', 'R', 0, '2020-11-24 12:37:10', NULL);
INSERT INTO `tbl_comment` VALUES (79, 12, 16, 'A', 'wow fieisooc Odie DD email fjdiso Rosie ', 'R', 0, '2020-11-24 12:39:05', NULL);
INSERT INTO `tbl_comment` VALUES (80, 12, 16, 'A', 'wow fieisooc Odie DD email fjdiso Rosie ', 'R', 0, '2020-11-24 12:39:31', NULL);
INSERT INTO `tbl_comment` VALUES (81, 12, 16, 'A', 'tfbhff wv v veg exf xejf jex edgf email fhehfh e', 'R', 0, '2020-11-24 12:49:28', NULL);
INSERT INTO `tbl_comment` VALUES (82, 33, 16, 'A', '16', 'R', 0, '2020-11-24 12:55:57', NULL);
INSERT INTO `tbl_comment` VALUES (83, 42, 18, 'A', 'wefwefwefef', 'R', 0, '2020-11-24 10:55:01', NULL);
INSERT INTO `tbl_comment` VALUES (84, 42, 18, 'A', 'wefwefwefef', 'R', 0, '2020-11-24 10:55:39', NULL);
INSERT INTO `tbl_comment` VALUES (85, 42, 18, 'A', 'wefwefwefef', 'R', 0, '2020-11-24 10:55:43', NULL);
INSERT INTO `tbl_comment` VALUES (86, 4, 16, 'A', '65465 654 64 64 654 65 454 ', 'R', 0, '2020-11-24 03:29:21', NULL);

-- ----------------------------
-- Table structure for tbl_contact
-- ----------------------------
DROP TABLE IF EXISTS `tbl_contact`;
CREATE TABLE `tbl_contact`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `website` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_on` datetime(0) NULL DEFAULT NULL,
  `updated_on` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tbl_email_setting
-- ----------------------------
DROP TABLE IF EXISTS `tbl_email_setting`;
CREATE TABLE `tbl_email_setting`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `smtp_username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `smtp_password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `smtp_host` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `smtp_port` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `smtp_secure` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email_from_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `updated_on` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_email_setting
-- ----------------------------
INSERT INTO `tbl_email_setting` VALUES (1, 'admin.portakalagaci@greytomato.net', 'Ryc89R0qBdn_552pR', 'mail.your-server.de', '587', 'tls', 'Portakalagaci Admin', '2020-07-30 10:09:09');

-- ----------------------------
-- Table structure for tbl_ingredients
-- ----------------------------
DROP TABLE IF EXISTS `tbl_ingredients`;
CREATE TABLE `tbl_ingredients`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) NOT NULL,
  `ingredient_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `qty` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `weight` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_on` datetime(0) NULL DEFAULT NULL,
  `updated_on` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tbl_ingredients_recipe_id`(`rid`) USING BTREE,
  CONSTRAINT `tbl_ingredients_recipe_id` FOREIGN KEY (`rid`) REFERENCES `tbl_recipes` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 769 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_ingredients
-- ----------------------------
INSERT INTO `tbl_ingredients` VALUES (37, 2, 'Yumurta', '3', 'Adet', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (38, 2, 'Toz şeker', '1', 'Su bardağı', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (39, 2, 'Süt', '1', 'Su bardağı', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (40, 2, 'Ayçicek yağı', '1', 'Su bardağı', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (41, 2, 'Kakao', '2', 'Yemek kaşığı', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (42, 2, 'Vanilya', '1', 'Paket', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (43, 2, 'Un', '1', 'Su bardağı', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (44, 2, 'Un', '2', 'Yemek kaşığı', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (45, 2, 'Kabartma tozu', '1', 'Paket', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (46, 2, 'Tereyağı, kek kalıbını yağlamak için', '1', 'Yemek kaşığı', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (47, 2, 'Süt', '1', 'Su bardağı', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (48, 2, 'Kakao', '1.5', 'Yemek kaşığı', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (49, 2, 'Toz şeker', '0.5', 'Su bardağı', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (50, 2, 'Sıvı yağ', '2', 'Yemek kaşığı', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (51, 2, 'Tuz', '1', 'Tutam', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_ingredients` VALUES (239, 10, 'süt', '1', 'su bardağı', NULL, '2020-06-27 13:51:34');
INSERT INTO `tbl_ingredients` VALUES (240, 10, 'sıvıyağ', '1', 'çay bardağı', NULL, '2020-06-27 13:51:34');
INSERT INTO `tbl_ingredients` VALUES (241, 10, 'yumurta (akı içine, sarısı üstüne)', '1', 'adet', NULL, '2020-06-27 13:51:34');
INSERT INTO `tbl_ingredients` VALUES (242, 10, 'yaşmaya (veya 1 yemek kaşığı kurumaya)', '20', 'gr', NULL, '2020-06-27 13:51:34');
INSERT INTO `tbl_ingredients` VALUES (243, 10, 'tuz', '2', 'çay kaşığı', NULL, '2020-06-27 13:51:34');
INSERT INTO `tbl_ingredients` VALUES (244, 10, 'tozşeker', '2', 'çay kaşığı', NULL, '2020-06-27 13:51:34');
INSERT INTO `tbl_ingredients` VALUES (245, 10, '(veya aldığı kadar) un', '3', 'su bardağı', NULL, '2020-06-27 13:51:34');
INSERT INTO `tbl_ingredients` VALUES (248, 3, 'patates', '5', 'adet', NULL, '2020-06-27 18:59:49');
INSERT INTO `tbl_ingredients` VALUES (249, 3, 'zeytinyağı', '1', 'çay bardağı', NULL, '2020-06-27 18:59:49');
INSERT INTO `tbl_ingredients` VALUES (250, 3, 'tuz', '1', 'miktar', NULL, '2020-06-27 18:59:49');
INSERT INTO `tbl_ingredients` VALUES (251, 3, 'eski kaşar rendesi', '250', 'gr', NULL, '2020-06-27 18:59:49');
INSERT INTO `tbl_ingredients` VALUES (252, 3, 'buz küpleri', '2', 'su bardağı', NULL, '2020-06-27 18:59:49');
INSERT INTO `tbl_ingredients` VALUES (253, 3, 'baharatlar', '1', 'miktar', NULL, '2020-06-27 18:59:49');
INSERT INTO `tbl_ingredients` VALUES (254, 4, 'Kuzu gerdan', '6', 'adet', NULL, '2020-06-27 19:02:22');
INSERT INTO `tbl_ingredients` VALUES (255, 4, 'Patlıcan', '2', 'adet', NULL, '2020-06-27 19:02:22');
INSERT INTO `tbl_ingredients` VALUES (256, 4, 'Dolmalık biber', '3', 'adet', NULL, '2020-06-27 19:02:22');
INSERT INTO `tbl_ingredients` VALUES (257, 4, 'Patates', '3', 'adet', NULL, '2020-06-27 19:02:22');
INSERT INTO `tbl_ingredients` VALUES (258, 4, 'Domates', '6', 'adet', NULL, '2020-06-27 19:02:22');
INSERT INTO `tbl_ingredients` VALUES (259, 4, 'Salça', '1', 'yemek kaşığı', NULL, '2020-06-27 19:02:22');
INSERT INTO `tbl_ingredients` VALUES (260, 4, 'Zeytinyağı', '1', 'çay bardağı', NULL, '2020-06-27 19:02:22');
INSERT INTO `tbl_ingredients` VALUES (261, 4, 'Tuz', '1', 'tutam', NULL, '2020-06-27 19:02:22');
INSERT INTO `tbl_ingredients` VALUES (262, 5, 'kuru soğan', '1', 'adet', NULL, '2020-06-27 19:06:33');
INSERT INTO `tbl_ingredients` VALUES (263, 5, 'beyaz lahana', '5', 'yaprak', NULL, '2020-06-27 19:06:33');
INSERT INTO `tbl_ingredients` VALUES (264, 5, 'yeşil mercimek', 'Yarım', 'su bardağı', NULL, '2020-06-27 19:06:33');
INSERT INTO `tbl_ingredients` VALUES (265, 5, 'pilavlık bulgur', 'Yarım', 'su bardağı', NULL, '2020-06-27 19:06:33');
INSERT INTO `tbl_ingredients` VALUES (266, 5, 'domates salçası', 'Yarım', 'yemek kaşığı', NULL, '2020-06-27 19:06:33');
INSERT INTO `tbl_ingredients` VALUES (267, 5, 'sıvı yağ', '1', 'miktar', NULL, '2020-06-27 19:06:33');
INSERT INTO `tbl_ingredients` VALUES (268, 6, 'yemeklik doğranmış kurusoğan', '1', 'adet', NULL, '2020-06-27 19:11:03');
INSERT INTO `tbl_ingredients` VALUES (269, 6, 'tereyağı', '1', 'yemek kaşığı', NULL, '2020-06-27 19:11:03');
INSERT INTO `tbl_ingredients` VALUES (270, 6, 'domates salçası', '1', 'yemek kaşığı', NULL, '2020-06-27 19:11:03');
INSERT INTO `tbl_ingredients` VALUES (271, 6, 'nohut (Geceden ıslatılmış olmalı)', '1', 'su bardağı', NULL, '2020-06-27 19:11:03');
INSERT INTO `tbl_ingredients` VALUES (272, 6, 'yeşil mercimek', 'Yarım', 'su bardağı', NULL, '2020-06-27 19:11:03');
INSERT INTO `tbl_ingredients` VALUES (273, 6, 'erişte', 'Yarım', 'su bardağı', NULL, '2020-06-27 19:11:03');
INSERT INTO `tbl_ingredients` VALUES (274, 6, 'un', '1', 'yemek kaşığı', NULL, '2020-06-27 19:11:03');
INSERT INTO `tbl_ingredients` VALUES (275, 6, 'tuz', '1', 'tutam', NULL, '2020-06-27 19:11:03');
INSERT INTO `tbl_ingredients` VALUES (276, 6, 'kuru nane', '1', 'tatlı kaşığı', NULL, '2020-06-27 19:11:03');
INSERT INTO `tbl_ingredients` VALUES (277, 6, 'karabiber', '1', 'tutam', NULL, '2020-06-27 19:11:03');
INSERT INTO `tbl_ingredients` VALUES (288, 7, 'yerelması (toplam yaklaşık 750gr)', '1', 'paket', NULL, '2020-06-27 19:17:01');
INSERT INTO `tbl_ingredients` VALUES (289, 7, 'tereyağı', '1', 'yemek kaşığı', NULL, '2020-06-27 19:17:01');
INSERT INTO `tbl_ingredients` VALUES (290, 7, 'sıcak su', '3', 'su bardağı', NULL, '2020-06-27 19:17:01');
INSERT INTO `tbl_ingredients` VALUES (291, 7, 'köri', 'Yarım', 'çay kaşığı', NULL, '2020-06-27 19:17:01');
INSERT INTO `tbl_ingredients` VALUES (292, 7, 'ndan üç parmak eksik soğuk sütün üzerini ayrıca eritilmiş tereyağıyla tamamlayıp karıştırın', '1', 'su bardağı', NULL, '2020-06-27 19:17:01');
INSERT INTO `tbl_ingredients` VALUES (293, 7, 'muskat', '1', 'tutam', NULL, '2020-06-27 19:17:01');
INSERT INTO `tbl_ingredients` VALUES (294, 7, 'deniz tuzu', '1', 'miktar', NULL, '2020-06-27 19:17:01');
INSERT INTO `tbl_ingredients` VALUES (295, 7, 'karabiber', '1', 'miktar', NULL, '2020-06-27 19:17:01');
INSERT INTO `tbl_ingredients` VALUES (296, 7, 'maydanoz', '1', 'tutam', NULL, '2020-06-27 19:17:01');
INSERT INTO `tbl_ingredients` VALUES (297, 7, 'üzeri için arzuya göre küp kesilmiş tost ekmekleri', '1', 'miktar', NULL, '2020-06-27 19:17:01');
INSERT INTO `tbl_ingredients` VALUES (298, 8, 'nohut, bir gece önceden ıslatılmış', '1', 'su bardağı', NULL, '2020-06-27 19:19:15');
INSERT INTO `tbl_ingredients` VALUES (299, 8, 'kırmızı mercimek', '1', 'su bardağı', NULL, '2020-06-27 19:19:15');
INSERT INTO `tbl_ingredients` VALUES (300, 8, 'pirinç', 'Yarım', 'su bardağı', NULL, '2020-06-27 19:19:15');
INSERT INTO `tbl_ingredients` VALUES (301, 8, 'tereyağı', '1', 'yemek kaşığı', NULL, '2020-06-27 19:19:15');
INSERT INTO `tbl_ingredients` VALUES (302, 8, 'soğan, yemeklik doğranmış', '2', 'adet', NULL, '2020-06-27 19:19:15');
INSERT INTO `tbl_ingredients` VALUES (303, 8, 'kuşbaşı et, çok küçük doğranmış veya kıyma', '350', 'gr', NULL, '2020-06-27 19:19:15');
INSERT INTO `tbl_ingredients` VALUES (304, 8, 'un', '2', 'yemek kaşığı', NULL, '2020-06-27 19:19:15');
INSERT INTO `tbl_ingredients` VALUES (305, 8, 'kaynamış et suyu veya su', '1', 'miktar', NULL, '2020-06-27 19:19:15');
INSERT INTO `tbl_ingredients` VALUES (306, 8, 'tuz, nane, pul biber', '1', 'miktar', NULL, '2020-06-27 19:19:15');
INSERT INTO `tbl_ingredients` VALUES (307, 9, 'semizotu', '250', 'gr', NULL, '2020-06-27 19:21:41');
INSERT INTO `tbl_ingredients` VALUES (308, 9, 'haşlanmış nohut', '200', 'gr', NULL, '2020-06-27 19:21:41');
INSERT INTO `tbl_ingredients` VALUES (309, 9, 'haşlanmış kurufasulye', '200', 'gr', NULL, '2020-06-27 19:21:41');
INSERT INTO `tbl_ingredients` VALUES (310, 9, 'haşlanmış aşurelik buğday', '200', 'gr', NULL, '2020-06-27 19:21:41');
INSERT INTO `tbl_ingredients` VALUES (311, 9, 'su / et suyu', '3', 'litre', NULL, '2020-06-27 19:21:41');
INSERT INTO `tbl_ingredients` VALUES (312, 9, 'un', '1', 'su bardağı', NULL, '2020-06-27 19:21:41');
INSERT INTO `tbl_ingredients` VALUES (313, 9, 'yoğurt', '250', 'gr', NULL, '2020-06-27 19:21:41');
INSERT INTO `tbl_ingredients` VALUES (314, 9, 'limonun suyu', '1', 'adet', NULL, '2020-06-27 19:21:41');
INSERT INTO `tbl_ingredients` VALUES (315, 9, 'tereyağı', '100', 'gr', NULL, '2020-06-27 19:21:41');
INSERT INTO `tbl_ingredients` VALUES (316, 9, 'tuz', '1', 'miktar', NULL, '2020-06-27 19:21:41');
INSERT INTO `tbl_ingredients` VALUES (317, 9, 'kırmızıbiber', 'Yarım', 'çay kaşığı', NULL, '2020-06-27 19:21:41');
INSERT INTO `tbl_ingredients` VALUES (324, 13, 'yerelması', '750', 'gr', '2020-06-27 19:37:26', NULL);
INSERT INTO `tbl_ingredients` VALUES (325, 13, 'kuru soğan', '1', 'adet', '2020-06-27 19:37:26', NULL);
INSERT INTO `tbl_ingredients` VALUES (326, 13, 'zeytinyağı', '2', 'yemek kaşığı', '2020-06-27 19:37:26', NULL);
INSERT INTO `tbl_ingredients` VALUES (327, 13, 'havuç, küp küp doğranmış', '2', 'adet', '2020-06-27 19:37:26', NULL);
INSERT INTO `tbl_ingredients` VALUES (328, 13, 'ndan biraz az kırmızı mercimek', 'Yarım', 'su bardağı', '2020-06-27 19:37:26', NULL);
INSERT INTO `tbl_ingredients` VALUES (329, 13, 'kaynamış su', '1,5', 'litre', '2020-06-27 19:37:26', NULL);
INSERT INTO `tbl_ingredients` VALUES (330, 13, 'tuz', '1', 'miktar', '2020-06-27 19:37:26', NULL);
INSERT INTO `tbl_ingredients` VALUES (331, 13, 'limon', '1', 'adet', '2020-06-27 19:37:26', NULL);
INSERT INTO `tbl_ingredients` VALUES (332, 12, 'ılık su', '1', 'su bardağı', NULL, '2020-06-28 07:26:28');
INSERT INTO `tbl_ingredients` VALUES (333, 12, 'instant kuru maya', '1', 'yemek kaşığı', NULL, '2020-06-28 07:26:28');
INSERT INTO `tbl_ingredients` VALUES (334, 12, 'tuz', '1', 'tatlı kaşığı', NULL, '2020-06-28 07:26:28');
INSERT INTO `tbl_ingredients` VALUES (335, 12, '+ 1 tatlı kaşığı sıvıyağ', '1', 'yemek kaşığı', NULL, '2020-06-28 07:26:28');
INSERT INTO `tbl_ingredients` VALUES (336, 12, '+ 2 tatlı kaşığı toz şeker', '2', 'yemek kaşığı', NULL, '2020-06-28 07:26:28');
INSERT INTO `tbl_ingredients` VALUES (337, 12, 'un', '4', 'su bardağı', NULL, '2020-06-28 07:26:28');
INSERT INTO `tbl_ingredients` VALUES (346, 14, 'büyük boy karnabahar (ya da 2 küçük boy)', '1', 'adet', NULL, '2020-06-28 07:41:08');
INSERT INTO `tbl_ingredients` VALUES (347, 14, 'kuru soğan, soyulmuş ve irice doğranmış', '2', 'adet', NULL, '2020-06-28 07:41:08');
INSERT INTO `tbl_ingredients` VALUES (348, 14, 'sarımsak, soyulmuş', '3', 'diş', NULL, '2020-06-28 07:41:08');
INSERT INTO `tbl_ingredients` VALUES (349, 14, 'zeytinyağı', '4', 'yemek kaşığı', NULL, '2020-06-28 07:41:08');
INSERT INTO `tbl_ingredients` VALUES (350, 14, 'tavuk suyu', '5', 'su bardağı', NULL, '2020-06-28 07:41:08');
INSERT INTO `tbl_ingredients` VALUES (351, 14, 'defne yaprağı', '1', 'adet', NULL, '2020-06-28 07:41:08');
INSERT INTO `tbl_ingredients` VALUES (352, 14, 'süt (tercihen yağsız)', '3', 'su bardağı', NULL, '2020-06-28 07:41:08');
INSERT INTO `tbl_ingredients` VALUES (353, 14, 'tuz', '1', 'miktar', NULL, '2020-06-28 07:41:08');
INSERT INTO `tbl_ingredients` VALUES (361, 15, 'orta boy domates, yıkanmış, ikiye veya dörde bölünmüş', '14', 'adet', NULL, '2020-06-28 07:49:31');
INSERT INTO `tbl_ingredients` VALUES (362, 15, 'soğan', '1', 'adet', NULL, '2020-06-28 07:49:31');
INSERT INTO `tbl_ingredients` VALUES (363, 15, 'sarımsak', '1', 'baş', NULL, '2020-06-28 07:49:31');
INSERT INTO `tbl_ingredients` VALUES (364, 15, 'kaynamış su', '1', 'litre', NULL, '2020-06-28 07:49:31');
INSERT INTO `tbl_ingredients` VALUES (365, 15, 'tuz', '1', 'miktar', NULL, '2020-06-28 07:49:31');
INSERT INTO `tbl_ingredients` VALUES (366, 15, 'karabiber', '1', 'miktar', NULL, '2020-06-28 07:49:31');
INSERT INTO `tbl_ingredients` VALUES (367, 15, 'arzuya göre taze nane, fesleğen veya rendelenmiş kaşar peyniri', '1', 'miktar', NULL, '2020-06-28 07:49:31');
INSERT INTO `tbl_ingredients` VALUES (373, 16, 'yeşil mercimek', '1', 'su bardağı', NULL, '2020-06-28 08:36:16');
INSERT INTO `tbl_ingredients` VALUES (374, 16, 'erişte', '1', 'avuç', NULL, '2020-06-28 08:36:16');
INSERT INTO `tbl_ingredients` VALUES (375, 16, 'yoğurt', '2', 'su bardağı', NULL, '2020-06-28 08:36:16');
INSERT INTO `tbl_ingredients` VALUES (376, 16, 'tuz', '1', 'miktar', NULL, '2020-06-28 08:36:16');
INSERT INTO `tbl_ingredients` VALUES (377, 16, 'arzuya göre tereyağı, kırmızı toz biber, nane', '1', 'miktar', NULL, '2020-06-28 08:36:16');
INSERT INTO `tbl_ingredients` VALUES (407, 18, 'orta boy soğan', '1', 'adet', NULL, '2020-06-28 09:10:19');
INSERT INTO `tbl_ingredients` VALUES (408, 18, 'sarımsak', '2', 'diş', NULL, '2020-06-28 09:10:19');
INSERT INTO `tbl_ingredients` VALUES (409, 18, 'orta boy kabak', '6-7', 'adet', NULL, '2020-06-28 09:10:19');
INSERT INTO `tbl_ingredients` VALUES (410, 18, 'yoğurt', '1', 'su bardağı', NULL, '2020-06-28 09:10:19');
INSERT INTO `tbl_ingredients` VALUES (411, 18, 'süt', '2', 'su bardağı', NULL, '2020-06-28 09:10:19');
INSERT INTO `tbl_ingredients` VALUES (412, 18, 'tereyağı', '2', 'yemek kaşığı', NULL, '2020-06-28 09:10:19');
INSERT INTO `tbl_ingredients` VALUES (413, 18, 'limon suyu', '1', 'yemek kaşığı', NULL, '2020-06-28 09:10:19');
INSERT INTO `tbl_ingredients` VALUES (414, 18, 'taze nane', '1', 'demet', NULL, '2020-06-28 09:10:19');
INSERT INTO `tbl_ingredients` VALUES (415, 18, 'karabiber', '1', 'miktar', NULL, '2020-06-28 09:10:19');
INSERT INTO `tbl_ingredients` VALUES (416, 18, 'tuz', '1', 'miktar', NULL, '2020-06-28 09:10:19');
INSERT INTO `tbl_ingredients` VALUES (424, 19, 'ıspanak başı (ince kıyılacak)', '2', 'deste', NULL, '2020-06-28 09:29:12');
INSERT INTO `tbl_ingredients` VALUES (425, 19, 'nohut (pişmiş)', '1', 'su bardağı', NULL, '2020-06-28 09:29:12');
INSERT INTO `tbl_ingredients` VALUES (426, 19, 'yeşil mercimek (yıkanacak)', '1', 'kase', NULL, '2020-06-28 09:29:12');
INSERT INTO `tbl_ingredients` VALUES (427, 19, 'sarımsak', '5 - 6', 'diş', NULL, '2020-06-28 09:29:12');
INSERT INTO `tbl_ingredients` VALUES (428, 19, 'limon suyu, tuz, karabiber', '1', 'miktar', NULL, '2020-06-28 09:29:12');
INSERT INTO `tbl_ingredients` VALUES (429, 19, 'biber salçası', '1', 'tatlı kaşığı', NULL, '2020-06-28 09:29:12');
INSERT INTO `tbl_ingredients` VALUES (430, 19, 'zeytinyağı', '1', 'miktar', NULL, '2020-06-28 09:29:12');
INSERT INTO `tbl_ingredients` VALUES (431, 20, 'kırmızı mercimek', '1', 'su bardağı', '2020-06-28 09:40:17', NULL);
INSERT INTO `tbl_ingredients` VALUES (432, 20, 'ndan biraz fazla pirinç', 'Yarım', 'çay bardağı', '2020-06-28 09:40:17', NULL);
INSERT INTO `tbl_ingredients` VALUES (433, 20, 'un', '1', 'yemek kaşığı', '2020-06-28 09:40:17', NULL);
INSERT INTO `tbl_ingredients` VALUES (434, 20, 'domates salçası', '1', 'yemek kaşığı', '2020-06-28 09:40:17', NULL);
INSERT INTO `tbl_ingredients` VALUES (435, 20, 'zeytinyağı', 'Yarım', 'çay bardağı', '2020-06-28 09:40:17', NULL);
INSERT INTO `tbl_ingredients` VALUES (436, 20, 'kuru soğan yemeklik doğranmış', '1', 'baş', '2020-06-28 09:40:17', NULL);
INSERT INTO `tbl_ingredients` VALUES (437, 20, 'ndan biraz fazla haşlanmış, pişirilmiş ve kabuğu soyulmuş nohut', '1', 'su bardağı', '2020-06-28 09:40:17', NULL);
INSERT INTO `tbl_ingredients` VALUES (438, 20, 'tuz', '1,5', 'tatlı kaşığı', '2020-06-28 09:40:17', NULL);
INSERT INTO `tbl_ingredients` VALUES (439, 20, 'kuru nane', '1', 'tatlı kaşığı', '2020-06-28 09:40:17', NULL);
INSERT INTO `tbl_ingredients` VALUES (452, 21, 'zeytinyağı', '1', 'yemek kaşığı', NULL, '2020-06-28 09:51:40');
INSERT INTO `tbl_ingredients` VALUES (453, 21, 'margarin (ben tereyağı kullandım)', '30', 'gr', NULL, '2020-06-28 09:51:40');
INSERT INTO `tbl_ingredients` VALUES (454, 21, 'pastırma, çemensiz, doğranmış', '4', 'dilim', NULL, '2020-06-28 09:51:40');
INSERT INTO `tbl_ingredients` VALUES (455, 21, 'pırasanın beyaz kısımları, doğranmış', '1', 'adet', NULL, '2020-06-28 09:51:40');
INSERT INTO `tbl_ingredients` VALUES (456, 21, 'kuru soğan, yemeklik doğranmış', '1', 'adet', NULL, '2020-06-28 09:51:40');
INSERT INTO `tbl_ingredients` VALUES (457, 21, 'un', '2', 'yemek kaşığı', NULL, '2020-06-28 09:51:40');
INSERT INTO `tbl_ingredients` VALUES (458, 21, '(4 su bardağı) tavuk suyu', '1', 'litre', NULL, '2020-06-28 09:51:40');
INSERT INTO `tbl_ingredients` VALUES (459, 21, 'taze patates, soyulup küp küp doğranmış', '8 -10', 'adet', NULL, '2020-06-28 09:51:40');
INSERT INTO `tbl_ingredients` VALUES (460, 21, 'konserve mısır', '200', 'gr', NULL, '2020-06-28 09:51:40');
INSERT INTO `tbl_ingredients` VALUES (461, 21, 'yumurta sarısı', '2', 'adet', NULL, '2020-06-28 09:51:40');
INSERT INTO `tbl_ingredients` VALUES (462, 21, 'yoğurt (ben ayran kullandım)', '1', 'su bardağı', NULL, '2020-06-28 09:51:40');
INSERT INTO `tbl_ingredients` VALUES (463, 21, 'maydanoz', '1', 'demet', NULL, '2020-06-28 09:51:40');
INSERT INTO `tbl_ingredients` VALUES (464, 22, 'kuru soğan, doğranmış', '2', 'adet', '2020-06-29 19:03:23', NULL);
INSERT INTO `tbl_ingredients` VALUES (465, 22, 'zeytinyağı', '2', 'yemek kaşığı', '2020-06-29 19:03:23', NULL);
INSERT INTO `tbl_ingredients` VALUES (466, 22, 'tavuk suyu', '1,75', 'litre', '2020-06-29 19:03:23', NULL);
INSERT INTO `tbl_ingredients` VALUES (467, 22, 'kırmızı mercimek, ayıklanmış ve yıkanmış', '200', 'gr', '2020-06-29 19:03:23', NULL);
INSERT INTO `tbl_ingredients` VALUES (468, 22, 'pirinç, ayıklanmış ve yıkanmış', '100', 'gr', '2020-06-29 19:03:23', NULL);
INSERT INTO `tbl_ingredients` VALUES (469, 22, 'karabiber', '1', 'tutam', '2020-06-29 19:03:23', NULL);
INSERT INTO `tbl_ingredients` VALUES (470, 22, 'toz kişniş', '2', 'tatlı kaşığı', '2020-06-29 19:03:23', NULL);
INSERT INTO `tbl_ingredients` VALUES (471, 22, 'tuz', '1', 'tutam', '2020-06-29 19:03:23', NULL);
INSERT INTO `tbl_ingredients` VALUES (472, 22, 'kimyon', '1', 'tatlı kaşığı', '2020-06-29 19:03:23', NULL);
INSERT INTO `tbl_ingredients` VALUES (473, 22, 'limon', '2', 'adet', '2020-06-29 19:03:23', NULL);
INSERT INTO `tbl_ingredients` VALUES (474, 23, 'sıvıyağ', '2', 'yemek kaşığı', '2020-06-29 19:10:37', NULL);
INSERT INTO `tbl_ingredients` VALUES (475, 23, 'un', '2', 'yemek kaşığı', '2020-06-29 19:10:37', NULL);
INSERT INTO `tbl_ingredients` VALUES (476, 23, 'salça', '1', 'yemek kaşığı', '2020-06-29 19:10:37', NULL);
INSERT INTO `tbl_ingredients` VALUES (477, 23, 'rendelenmiş domates', '5', 'adet', '2020-06-29 19:10:37', NULL);
INSERT INTO `tbl_ingredients` VALUES (478, 23, 'su', '5', 'su bardağı', '2020-06-29 19:10:37', NULL);
INSERT INTO `tbl_ingredients` VALUES (479, 23, 'süt', '2', 'yemek kaşığı', '2020-06-29 19:10:37', NULL);
INSERT INTO `tbl_ingredients` VALUES (480, 23, 'tuz', '1', 'tutam', '2020-06-29 19:10:37', NULL);
INSERT INTO `tbl_ingredients` VALUES (481, 24, 'kuru soğan, yemeklik doğranmış', '1', 'baş', '2020-06-29 19:15:58', NULL);
INSERT INTO `tbl_ingredients` VALUES (482, 24, 'zeytinyağı', 'Yarım', 'çay bardağı', '2020-06-29 19:15:58', NULL);
INSERT INTO `tbl_ingredients` VALUES (483, 24, 'un', '1', 'yemek kaşığı', '2020-06-29 19:15:58', NULL);
INSERT INTO `tbl_ingredients` VALUES (484, 24, 'pırasa', '1', 'adet', '2020-06-29 19:15:58', NULL);
INSERT INTO `tbl_ingredients` VALUES (485, 24, 'havuç, soyulmuş', '1', 'adet', '2020-06-29 19:15:58', NULL);
INSERT INTO `tbl_ingredients` VALUES (486, 24, 'kereviz, soyulmuş', '1', 'adet', '2020-06-29 19:15:58', NULL);
INSERT INTO `tbl_ingredients` VALUES (487, 24, 'patates', '1', 'adet', '2020-06-29 19:15:58', NULL);
INSERT INTO `tbl_ingredients` VALUES (488, 24, 'kaynamış su', '1,5', 'litre', '2020-06-29 19:15:58', NULL);
INSERT INTO `tbl_ingredients` VALUES (489, 24, 'limonun suyu', '1', 'adet', '2020-06-29 19:15:58', NULL);
INSERT INTO `tbl_ingredients` VALUES (490, 24, 'yumurtanın sarısı, beyazından tamamen ayrılmış', '1', 'adet', '2020-06-29 19:15:58', NULL);
INSERT INTO `tbl_ingredients` VALUES (491, 25, 'zeytinyağı', 'Yarım', 'çay bardağı', '2020-06-29 19:21:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (492, 25, 'kuru soğan', '1', 'baş', '2020-06-29 19:21:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (493, 25, 'sivribiber', '3-4', 'adet', '2020-06-29 19:21:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (494, 25, 'domates', '3-4', 'adet', '2020-06-29 19:21:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (495, 25, 'kırmızı mercimek', '1', 'su bardağı', '2020-06-29 19:21:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (496, 25, 'tuz', '1', 'tatlı kaşığı', '2020-06-29 19:21:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (497, 25, 'nane', '1', 'tatlı kaşığı', '2020-06-29 19:21:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (498, 25, 'arpa şehriye', '1', 'avuç', '2020-06-29 19:21:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (499, 25, 'su', '2,5', 'litre', '2020-06-29 19:21:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (500, 26, 'zeytinyağı', '2', 'yemek kaşığı', '2020-06-29 19:41:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (501, 26, 'soğan, yemeklik doğranmış', '1', 'adet', '2020-06-29 19:41:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (502, 26, 'patates, küp küp doğranmış', '2', 'adet', '2020-06-29 19:41:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (503, 26, 'su', '1,5', 'litre', '2020-06-29 19:41:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (504, 26, 'kabak, soyulup küp küp doğranmış', '2', 'adet', '2020-06-29 19:41:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (505, 26, 'dolusu doğranmış maydanoz', '1-2', 'avuç', '2020-06-29 19:41:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (506, 26, 'tuz', '1', 'tutam', '2020-06-29 19:41:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (507, 26, 'zeytinyağı', '4', 'yemek kaşığı', '2020-06-29 19:41:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (508, 26, 'taze soğan, doğranmış', '4', 'yemek kaşığı', '2020-06-29 19:41:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (509, 27, 'süzülmüş yoğurt', '2', 'kase', '2020-06-29 19:46:52', NULL);
INSERT INTO `tbl_ingredients` VALUES (510, 27, 'yumurta', '1', 'adet', '2020-06-29 19:46:52', NULL);
INSERT INTO `tbl_ingredients` VALUES (511, 27, 'un', '2', 'yemek kaşığı', '2020-06-29 19:46:52', NULL);
INSERT INTO `tbl_ingredients` VALUES (512, 27, 'su', '1', 'çay bardağı', '2020-06-29 19:46:52', NULL);
INSERT INTO `tbl_ingredients` VALUES (513, 27, 'yumruk büyüklüğünde kıyma', '1', 'adet', '2020-06-29 19:46:52', NULL);
INSERT INTO `tbl_ingredients` VALUES (514, 27, 'tuz', '1', 'tutam', '2020-06-29 19:46:52', NULL);
INSERT INTO `tbl_ingredients` VALUES (515, 27, 'karabiber', '1', 'tutam', '2020-06-29 19:46:52', NULL);
INSERT INTO `tbl_ingredients` VALUES (516, 27, 'su', '1,5-2', 'litre', '2020-06-29 19:46:52', NULL);
INSERT INTO `tbl_ingredients` VALUES (517, 27, 'pirinç / şehriye', '1,5', 'çay bardağı', '2020-06-29 19:46:52', NULL);
INSERT INTO `tbl_ingredients` VALUES (518, 28, 'tereyağı', 'Yarım', 'yemek kaşığı', '2020-06-29 19:52:34', NULL);
INSERT INTO `tbl_ingredients` VALUES (519, 28, 'soğan', '1', 'adet', '2020-06-29 19:52:34', NULL);
INSERT INTO `tbl_ingredients` VALUES (520, 28, 'su', '5', 'su bardağı', '2020-06-29 19:52:34', NULL);
INSERT INTO `tbl_ingredients` VALUES (521, 28, 'kızılcıklı tarhana', '5', 'yemek kaşığı', '2020-06-29 19:52:34', NULL);
INSERT INTO `tbl_ingredients` VALUES (522, 28, 'tuz', '1', 'tutam', '2020-06-29 19:52:34', NULL);
INSERT INTO `tbl_ingredients` VALUES (523, 28, 'tereyağı', '1', 'miktar', '2020-06-29 19:52:34', NULL);
INSERT INTO `tbl_ingredients` VALUES (524, 28, 'nane', '1', 'tatlı kaşığı', '2020-06-29 19:52:34', NULL);
INSERT INTO `tbl_ingredients` VALUES (525, 28, 'pul biber', '1', 'tatlı kaşığı', '2020-06-29 19:52:34', NULL);
INSERT INTO `tbl_ingredients` VALUES (526, 28, 'sirke', '1', 'miktar', '2020-06-29 19:52:34', NULL);
INSERT INTO `tbl_ingredients` VALUES (527, 28, 'sarımsak', '2', 'diş', '2020-06-29 19:52:34', NULL);
INSERT INTO `tbl_ingredients` VALUES (528, 29, 'kültür mantarı', '500', 'gr', '2020-06-29 19:56:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (529, 29, 'tereyağı', '2', 'yemek kaşığı', '2020-06-29 19:56:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (530, 29, 'un', '4', 'yemek kaşığı', '2020-06-29 19:56:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (531, 29, 'soğuk su', '1', 'litre', '2020-06-29 19:56:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (532, 29, 'tuz', '1', 'tutam', '2020-06-29 19:56:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (533, 29, 'süt', '1,5', 'su bardağı', '2020-06-29 19:56:01', NULL);
INSERT INTO `tbl_ingredients` VALUES (534, 30, 'zeytinyağı', '2', 'yemek kaşığı', '2020-06-29 20:05:47', NULL);
INSERT INTO `tbl_ingredients` VALUES (535, 30, 'tereyağı', 'Yarım', 'yemek kaşığı', '2020-06-29 20:05:47', NULL);
INSERT INTO `tbl_ingredients` VALUES (536, 30, 'soğan, yemeklik doğranmış', '1', 'adet', '2020-06-29 20:05:47', NULL);
INSERT INTO `tbl_ingredients` VALUES (537, 30, 'yeşil biber', '2-3', 'adet', '2020-06-29 20:05:47', NULL);
INSERT INTO `tbl_ingredients` VALUES (538, 30, 'domates', '2', 'adet', '2020-06-29 20:05:47', NULL);
INSERT INTO `tbl_ingredients` VALUES (539, 30, 'domates salçası', '1', 'yemek kaşığı', '2020-06-29 20:05:47', NULL);
INSERT INTO `tbl_ingredients` VALUES (540, 30, 'bulgur', '1', 'çay bardağı', '2020-06-29 20:05:47', NULL);
INSERT INTO `tbl_ingredients` VALUES (541, 30, 'sıcak su', '5', 'su bardağı', '2020-06-29 20:05:47', NULL);
INSERT INTO `tbl_ingredients` VALUES (542, 30, 'taze fasulye, verev kesilmiş', '250', 'gr', '2020-06-29 20:05:47', NULL);
INSERT INTO `tbl_ingredients` VALUES (543, 30, 'beyaz peynir, ufalanmış', '150', 'gr', '2020-06-29 20:05:47', NULL);
INSERT INTO `tbl_ingredients` VALUES (544, 30, 'tuz', '1', 'tutam', '2020-06-29 20:05:47', NULL);
INSERT INTO `tbl_ingredients` VALUES (545, 30, 'karabiber', '1', 'miktar', '2020-06-29 20:05:47', NULL);
INSERT INTO `tbl_ingredients` VALUES (546, 31, 'tavuk göğsü', '1', 'adet', '2020-06-29 20:10:53', NULL);
INSERT INTO `tbl_ingredients` VALUES (547, 31, 'tavuk but', '1', 'adet', '2020-06-29 20:10:53', NULL);
INSERT INTO `tbl_ingredients` VALUES (548, 31, 'kuru soğan', '2', 'baş', '2020-06-29 20:10:53', NULL);
INSERT INTO `tbl_ingredients` VALUES (549, 31, 'un', '2', 'yemek kaşığı', '2020-06-29 20:10:53', NULL);
INSERT INTO `tbl_ingredients` VALUES (550, 31, 'sarımsak', '3', 'diş', '2020-06-29 20:10:53', NULL);
INSERT INTO `tbl_ingredients` VALUES (551, 31, 'tereyağı', '2', 'yemek kaşığı', '2020-06-29 20:10:53', NULL);
INSERT INTO `tbl_ingredients` VALUES (552, 31, 'tuz', '1', 'tutam', '2020-06-29 20:10:53', NULL);
INSERT INTO `tbl_ingredients` VALUES (553, 31, 'karabiber', '1', 'tutam', '2020-06-29 20:10:53', NULL);
INSERT INTO `tbl_ingredients` VALUES (601, 34, 'orta boy soğan, yemeklik soğandan daha ince doğranmış', '1', 'adet', '2020-06-29 20:36:14', NULL);
INSERT INTO `tbl_ingredients` VALUES (602, 34, 'zeytinyağı', 'Yarım', 'çay bardağı', '2020-06-29 20:36:14', NULL);
INSERT INTO `tbl_ingredients` VALUES (603, 34, 'orta boy patates, ince ince küçük kareler şeklinde kesilmiş', '1', 'adet', '2020-06-29 20:36:14', NULL);
INSERT INTO `tbl_ingredients` VALUES (604, 34, 'domates salçası', '1', 'yemek kaşığı', '2020-06-29 20:36:14', NULL);
INSERT INTO `tbl_ingredients` VALUES (605, 34, 'kaynar su', '7-8', 'su bardağı', '2020-06-29 20:36:14', NULL);
INSERT INTO `tbl_ingredients` VALUES (606, 34, 'erişte, ufak ufak kırılmış (kırıldıktan sonraki ölçü)', '1', 'su bardağı', '2020-06-29 20:36:14', NULL);
INSERT INTO `tbl_ingredients` VALUES (607, 34, 'tuz', '1', 'tatlı kaşığı', '2020-06-29 20:36:14', NULL);
INSERT INTO `tbl_ingredients` VALUES (608, 34, 'nane', '1', 'tatlı kaşığı', '2020-06-29 20:36:14', NULL);
INSERT INTO `tbl_ingredients` VALUES (609, 35, 'soğan', '1', 'adet', '2020-06-29 20:40:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (610, 35, 'patates', '4', 'adet', '2020-06-29 20:40:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (611, 35, 'lahana', '2', 'yaprak', '2020-06-29 20:40:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (612, 35, 'havuç', '3', 'adet', '2020-06-29 20:40:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (613, 35, 'pırasa', '2', 'adet', '2020-06-29 20:40:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (614, 35, 'yağ', '3', 'yemek kaşığı', '2020-06-29 20:40:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (615, 35, 'su', '1,5-2', 'litre', '2020-06-29 20:40:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (616, 35, 'un', '1', 'yemek kaşığı', '2020-06-29 20:40:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (617, 35, 'tuz', '1', 'yemek kaşığı', '2020-06-29 20:40:35', NULL);
INSERT INTO `tbl_ingredients` VALUES (618, 36, 'patates', '2', 'adet', '2020-06-29 20:45:12', NULL);
INSERT INTO `tbl_ingredients` VALUES (619, 36, 'havuç', '2', 'adet', '2020-06-29 20:45:12', NULL);
INSERT INTO `tbl_ingredients` VALUES (620, 36, 'balkabağı', 'Yarım', 'kg', '2020-06-29 20:45:12', NULL);
INSERT INTO `tbl_ingredients` VALUES (621, 36, 'tuz', '1', 'tutam', '2020-06-29 20:45:12', NULL);
INSERT INTO `tbl_ingredients` VALUES (622, 36, 'karabiber', '1', 'tutam', '2020-06-29 20:45:12', NULL);
INSERT INTO `tbl_ingredients` VALUES (623, 36, 'defne yaprağı', '1', 'tutam', '2020-06-29 20:45:12', NULL);
INSERT INTO `tbl_ingredients` VALUES (624, 37, 'tereyağı', '2', 'yemek kaşığı', '2020-06-29 20:54:08', NULL);
INSERT INTO `tbl_ingredients` VALUES (625, 37, 'orta boy soğan', '2', 'adet', '2020-06-29 20:54:08', NULL);
INSERT INTO `tbl_ingredients` VALUES (626, 37, 'un', '2', 'yemek kaşığı', '2020-06-29 20:54:08', NULL);
INSERT INTO `tbl_ingredients` VALUES (627, 37, 'domates salçası', '1', 'yemek kaşığı', '2020-06-29 20:54:08', NULL);
INSERT INTO `tbl_ingredients` VALUES (628, 37, 'biber salçası', '1', 'yemek kaşığı', '2020-06-29 20:54:08', NULL);
INSERT INTO `tbl_ingredients` VALUES (629, 37, 'patates', '2', 'adet', '2020-06-29 20:54:08', NULL);
INSERT INTO `tbl_ingredients` VALUES (630, 37, 'kabak', '2', 'adet', '2020-06-29 20:54:08', NULL);
INSERT INTO `tbl_ingredients` VALUES (631, 37, 'havuç', '2', 'adet', '2020-06-29 20:54:08', NULL);
INSERT INTO `tbl_ingredients` VALUES (632, 37, 'bezelye', '1', 'çay bardağı', '2020-06-29 20:54:08', NULL);
INSERT INTO `tbl_ingredients` VALUES (633, 37, 'kaynamış su', '1-1,5', 'litre', '2020-06-29 20:54:08', NULL);
INSERT INTO `tbl_ingredients` VALUES (634, 37, 'tuz', '1', 'tutam', '2020-06-29 20:54:08', NULL);
INSERT INTO `tbl_ingredients` VALUES (635, 37, 'süt', '1', 'su bardağı', '2020-06-29 20:54:08', NULL);
INSERT INTO `tbl_ingredients` VALUES (636, 37, 'yumurtanın sarısı', '2', 'adet', '2020-06-29 20:54:08', NULL);
INSERT INTO `tbl_ingredients` VALUES (645, 38, '1 + 3/4 su bardağı ılık su', '420', 'ml', NULL, '2020-06-29 21:05:31');
INSERT INTO `tbl_ingredients` VALUES (646, 38, '5 + 1/4 su bardağı un', '600', 'gr', NULL, '2020-06-29 21:05:31');
INSERT INTO `tbl_ingredients` VALUES (647, 38, '3/4 su bardağı tam buğday unu (ben kepekli un kullandım)', '75', 'gr', NULL, '2020-06-29 21:05:31');
INSERT INTO `tbl_ingredients` VALUES (648, 38, '2 yemek kaşığı süt tozu', '30', 'ml', NULL, '2020-06-29 21:05:31');
INSERT INTO `tbl_ingredients` VALUES (649, 38, '2 çay kaşığı tuz', '10', 'ml', NULL, '2020-06-29 21:05:31');
INSERT INTO `tbl_ingredients` VALUES (650, 38, '2 çay kaşığı toz şeker', '10', 'ml', NULL, '2020-06-29 21:05:31');
INSERT INTO `tbl_ingredients` VALUES (651, 38, '2 yemek kaşığı tereyağı', '25', 'gr', NULL, '2020-06-29 21:05:31');
INSERT INTO `tbl_ingredients` VALUES (652, 38, '1+ 1/2 çay kaşığı instant maya', '7,5', 'ml', NULL, '2020-06-29 21:05:31');
INSERT INTO `tbl_ingredients` VALUES (663, 33, '1', '1', 'adet', NULL, '2020-06-30 08:11:55');
INSERT INTO `tbl_ingredients` VALUES (664, 33, '2', '2', 'adet', NULL, '2020-06-30 08:11:55');
INSERT INTO `tbl_ingredients` VALUES (665, 33, '3', '3', 'adet', NULL, '2020-06-30 08:11:55');
INSERT INTO `tbl_ingredients` VALUES (666, 33, '4', '4', 'adet', NULL, '2020-06-30 08:11:55');
INSERT INTO `tbl_ingredients` VALUES (667, 33, '5', '5', 'adet', NULL, '2020-06-30 08:11:55');
INSERT INTO `tbl_ingredients` VALUES (684, 32, 'buğday', 'Yarım', 'kg', NULL, '2020-06-30 11:22:57');
INSERT INTO `tbl_ingredients` VALUES (685, 32, 'nohut', '1', 'su bardağı', NULL, '2020-06-30 11:22:57');
INSERT INTO `tbl_ingredients` VALUES (686, 32, 'kurufasulye', '1', 'su bardağı', NULL, '2020-06-30 11:22:57');
INSERT INTO `tbl_ingredients` VALUES (687, 32, 'pirinç', '1', 'çay bardağı', NULL, '2020-06-30 11:22:57');
INSERT INTO `tbl_ingredients` VALUES (688, 32, 'kuru kayısı, yıkanmış ve ufak ufak doğranmış', '100', 'gr', NULL, '2020-06-30 11:22:57');
INSERT INTO `tbl_ingredients` VALUES (689, 32, 'kuş üzümü', '50', 'gr', NULL, '2020-06-30 11:22:57');
INSERT INTO `tbl_ingredients` VALUES (690, 32, 'çekirdeksiz kuru üzüm', '100', 'gr', NULL, '2020-06-30 11:22:57');
INSERT INTO `tbl_ingredients` VALUES (691, 32, 'toz şeker', '1', 'kg', NULL, '2020-06-30 11:22:57');
INSERT INTO `tbl_ingredients` VALUES (692, 39, 'kuşbaşı doğranmış kereviz', '1', 'adet', '2020-06-30 12:14:46', NULL);
INSERT INTO `tbl_ingredients` VALUES (693, 39, 'kuşbaşı doğranmış havuç', '1', 'adet', '2020-06-30 12:14:46', NULL);
INSERT INTO `tbl_ingredients` VALUES (694, 39, 'kuşbaşı doğranmış patates', '1', 'adet', '2020-06-30 12:14:46', NULL);
INSERT INTO `tbl_ingredients` VALUES (695, 39, 'zeytinyağı', '3', 'yemek kaşığı', '2020-06-30 12:14:46', NULL);
INSERT INTO `tbl_ingredients` VALUES (696, 39, 'su', '3', 'su bardağı', '2020-06-30 12:14:46', NULL);
INSERT INTO `tbl_ingredients` VALUES (697, 39, 'süt', '1', 'su bardağı', '2020-06-30 12:14:46', NULL);
INSERT INTO `tbl_ingredients` VALUES (698, 39, 'un', '1,5', 'yemek kaşığı', '2020-06-30 12:14:46', NULL);
INSERT INTO `tbl_ingredients` VALUES (699, 39, 'limon suyu', '1', 'yemek kaşığı', '2020-06-30 12:14:46', NULL);
INSERT INTO `tbl_ingredients` VALUES (700, 39, 'hindistan cevizi rendesi', '1', 'tutam', '2020-06-30 12:14:46', NULL);
INSERT INTO `tbl_ingredients` VALUES (701, 39, 'tuz', '1', 'tutam', '2020-06-30 12:14:46', NULL);
INSERT INTO `tbl_ingredients` VALUES (702, 39, 'karabiber', '1', 'tutam', '2020-06-30 12:14:46', NULL);
INSERT INTO `tbl_ingredients` VALUES (703, 39, 'su', '1', 'litre', '2020-06-30 12:14:46', NULL);
INSERT INTO `tbl_ingredients` VALUES (729, 41, 'kırmızı mercimek', '1', 'su bardağı', NULL, '2020-07-14 17:55:06');
INSERT INTO `tbl_ingredients` VALUES (730, 41, 'soğan', '1', 'baş', NULL, '2020-07-14 17:55:06');
INSERT INTO `tbl_ingredients` VALUES (731, 41, 'havuç', '1', 'adet', NULL, '2020-07-14 17:55:06');
INSERT INTO `tbl_ingredients` VALUES (732, 41, 'zeytinyağı', '2', 'yemek kaşığı', NULL, '2020-07-14 17:55:06');
INSERT INTO `tbl_ingredients` VALUES (733, 41, 'su', '1,5', 'litre', NULL, '2020-07-14 17:55:06');
INSERT INTO `tbl_ingredients` VALUES (734, 41, 'un', '1', 'yemek kaşığı', NULL, '2020-07-14 17:55:06');
INSERT INTO `tbl_ingredients` VALUES (735, 41, 'et suyu tableti (tablet yoksa kullanmaya da bilirsiniz)', '2', 'adet', NULL, '2020-07-14 17:55:06');
INSERT INTO `tbl_ingredients` VALUES (746, 40, 'sucuk veya birkaç dilim patırma', 'Yarım', 'parmak', NULL, '2020-07-17 22:54:35');
INSERT INTO `tbl_ingredients` VALUES (747, 40, 'tereyağı', '25', 'gr', NULL, '2020-07-17 22:54:35');
INSERT INTO `tbl_ingredients` VALUES (748, 40, 'soğan, doğranmış', '1', 'adet', NULL, '2020-07-17 22:54:35');
INSERT INTO `tbl_ingredients` VALUES (749, 40, 'pırasa (yaklaşık 3 adet), ince ince doğranmış', '500', 'gr', NULL, '2020-07-17 22:54:35');
INSERT INTO `tbl_ingredients` VALUES (750, 40, 'patates (yaklaşık 3 adet), soyulmuş ve 2cm\'lik küplere bölünmüş', '500', 'gr', NULL, '2020-07-17 22:54:35');
INSERT INTO `tbl_ingredients` VALUES (751, 40, 'sıcak su', '5', 'litre', NULL, '2020-07-17 22:54:35');
INSERT INTO `tbl_ingredients` VALUES (752, 40, '(bir kutu) çiğ krema', '200', 'ml', NULL, '2020-07-17 22:54:35');
INSERT INTO `tbl_ingredients` VALUES (753, 40, 'tuz', '1', 'tutam', NULL, '2020-07-17 22:54:35');
INSERT INTO `tbl_ingredients` VALUES (764, 42, 'domates', '3', 'adet', NULL, '2020-11-19 19:56:39');
INSERT INTO `tbl_ingredients` VALUES (765, 42, 'test', '10', 'yemek kaşığı', NULL, '2020-11-19 19:56:39');
INSERT INTO `tbl_ingredients` VALUES (766, 42, 'şehriye', '1', 'miktar', NULL, '2020-11-19 19:56:39');
INSERT INTO `tbl_ingredients` VALUES (767, 42, 'nane', '1', 'tutam', NULL, '2020-11-19 19:56:39');
INSERT INTO `tbl_ingredients` VALUES (768, 42, 'tuz', '1', 'tutam', NULL, '2020-11-19 19:56:39');

-- ----------------------------
-- Table structure for tbl_measurement
-- ----------------------------
DROP TABLE IF EXISTS `tbl_measurement`;
CREATE TABLE `tbl_measurement`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `measurement_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('A','I') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'A' COMMENT '\"A=active ,I=inactive\"',
  `created_on` datetime(0) NULL DEFAULT NULL,
  `updated_on` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_measurement
-- ----------------------------
INSERT INTO `tbl_measurement` VALUES (3, 'gr', 'A', '2020-06-23 14:29:33', '2020-06-25 20:27:55');
INSERT INTO `tbl_measurement` VALUES (9, 'su bardağı', 'A', '2020-06-25 20:21:30', '2020-06-27 12:10:32');
INSERT INTO `tbl_measurement` VALUES (10, 'çay bardağı', 'A', '2020-06-25 20:26:28', '2020-06-27 12:10:22');
INSERT INTO `tbl_measurement` VALUES (11, 'çay kaşığı', 'A', '2020-06-25 20:27:23', '2020-06-27 12:09:50');
INSERT INTO `tbl_measurement` VALUES (12, 'paket', 'A', '2020-06-25 20:28:54', '2020-06-27 12:09:35');
INSERT INTO `tbl_measurement` VALUES (13, 'yemek kaşığı', 'A', '2020-06-25 20:29:40', '2020-06-27 12:09:25');
INSERT INTO `tbl_measurement` VALUES (14, 'tutam', 'A', '2020-06-25 20:30:53', '2020-06-27 12:09:17');
INSERT INTO `tbl_measurement` VALUES (15, 'adet', 'A', '2020-06-25 20:31:10', '2020-06-27 12:09:11');
INSERT INTO `tbl_measurement` VALUES (16, 'kg', 'A', '2020-06-26 18:51:35', '2020-06-27 12:09:04');
INSERT INTO `tbl_measurement` VALUES (17, 'miktar', 'A', '2020-06-26 19:07:51', '2020-06-27 12:08:57');
INSERT INTO `tbl_measurement` VALUES (18, 'yaprak', 'A', '2020-06-26 19:58:43', '2020-06-27 12:08:50');
INSERT INTO `tbl_measurement` VALUES (19, 'tatlı kaşığı', 'A', '2020-06-27 08:43:48', NULL);
INSERT INTO `tbl_measurement` VALUES (20, 'litre', 'A', '2020-06-27 12:05:00', NULL);
INSERT INTO `tbl_measurement` VALUES (21, 'diş', 'A', '2020-06-28 07:34:52', NULL);
INSERT INTO `tbl_measurement` VALUES (22, 'baş', 'A', '2020-06-28 07:47:22', NULL);
INSERT INTO `tbl_measurement` VALUES (23, 'avuç', 'A', '2020-06-28 08:32:41', NULL);
INSERT INTO `tbl_measurement` VALUES (24, 'demet', 'A', '2020-06-28 09:08:02', NULL);
INSERT INTO `tbl_measurement` VALUES (25, 'deste', 'A', '2020-06-28 09:20:51', NULL);
INSERT INTO `tbl_measurement` VALUES (26, 'kase', 'A', '2020-06-28 09:24:54', NULL);
INSERT INTO `tbl_measurement` VALUES (27, 'dilim', 'A', '2020-06-28 09:47:57', NULL);
INSERT INTO `tbl_measurement` VALUES (28, 'ml', 'A', '2020-06-29 21:04:52', NULL);
INSERT INTO `tbl_measurement` VALUES (29, 'parmak', 'A', '2020-06-30 15:52:22', NULL);

-- ----------------------------
-- Table structure for tbl_rating
-- ----------------------------
DROP TABLE IF EXISTS `tbl_rating`;
CREATE TABLE `tbl_rating`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` float NOT NULL,
  `created_on` datetime(0) NULL DEFAULT NULL,
  `updated_on` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tbl_rating_recipe_id`(`recipe_id`) USING BTREE,
  INDEX `tbl_rating_user_id`(`user_id`) USING BTREE,
  CONSTRAINT `tbl_rating_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `tbl_recipes` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_rating_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_rating
-- ----------------------------
INSERT INTO `tbl_rating` VALUES (1, 42, 14, 5, '2020-10-22 14:12:49', NULL);
INSERT INTO `tbl_rating` VALUES (2, 38, 13, 5, '2020-10-23 15:55:50', NULL);
INSERT INTO `tbl_rating` VALUES (3, 12, 13, 4, '2020-10-23 16:50:21', NULL);
INSERT INTO `tbl_rating` VALUES (4, 33, 16, 5, '2020-11-10 22:01:41', '2020-11-24 00:55:51');
INSERT INTO `tbl_rating` VALUES (5, 41, 16, 1, '2020-11-10 22:02:25', NULL);
INSERT INTO `tbl_rating` VALUES (6, 2, 16, 4, '2020-11-18 21:36:41', '2020-11-18 21:36:48');
INSERT INTO `tbl_rating` VALUES (7, 3, 16, 3, '2020-11-19 19:27:41', '2020-11-19 19:29:21');
INSERT INTO `tbl_rating` VALUES (8, 42, 16, 4, '2020-11-23 21:57:24', '2020-11-24 11:16:49');
INSERT INTO `tbl_rating` VALUES (9, 42, 18, 4, '2020-11-23 22:05:30', '2020-11-24 10:53:37');
INSERT INTO `tbl_rating` VALUES (10, 12, 16, 3, '2020-11-23 23:41:16', '2020-11-24 00:49:20');
INSERT INTO `tbl_rating` VALUES (11, 38, 16, 5, '2020-11-23 23:41:58', NULL);
INSERT INTO `tbl_rating` VALUES (12, 40, 16, 5, '2020-11-24 01:11:12', NULL);
INSERT INTO `tbl_rating` VALUES (13, 4, 16, 4.5, '2020-11-24 15:29:13', '2020-11-24 15:29:23');

-- ----------------------------
-- Table structure for tbl_recipes
-- ----------------------------
DROP TABLE IF EXISTS `tbl_recipes`;
CREATE TABLE `tbl_recipes`  (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `recipes_heading` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `today_recipe` int(1) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` enum('A','I') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'A' COMMENT '\"A=active ,I=inactive\"',
  `recipes_time` int(11) NOT NULL,
  `recipes_image` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `serving_person` int(11) NOT NULL,
  `calories` float NOT NULL,
  `direction` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `summary` text CHARACTER SET utf16 COLLATE utf16_general_ci NOT NULL,
  `youtube_link` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_on` datetime(0) NULL DEFAULT NULL,
  `updated_on` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`rid`) USING BTREE,
  INDEX `tbl_recipes_cat_id`(`cat_id`) USING BTREE,
  CONSTRAINT `tbl_recipes_cat_id` FOREIGN KEY (`cat_id`) REFERENCES `tbl_category` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_recipes
-- ----------------------------
INSERT INTO `tbl_recipes` VALUES (2, 'Islak Kek', 0, 4, 5, 'A', 60, '[\"5ef4c1d5edb95.jpg\"]', 6, 0, '[\"Derin bir kasede yumurta ve \\u015fekeri aktar\\u0131n\",\"\\u015eeker eriyip, kar\\u0131\\u015f\\u0131m krema k\\u0131vam\\u0131na gelene kadar \\u00e7\\u0131rp\\u0131n\",\"Ard\\u0131ndan i\\u00e7erisine s\\u00fct\\u00fc, s\\u0131v\\u0131 ya\\u011f\\u0131 ilave edin\",\"Vanilini de ekleyip tekrar kar\\u0131\\u015ft\\u0131r\\u0131n\",\"Topak kalmamas\\u0131 i\\u00e7in kakao, kabartma tozu ve unu s\\u00fczge\\u00e7ten ge\\u00e7irip kar\\u0131\\u015f\\u0131ma ekleyin\",\"Son bir kez daha g\\u00fczelce \\u00e7\\u0131rp\\u0131n\",\"Ya\\u011flanm\\u0131\\u015f, \\u0131s\\u0131ya dayan\\u0131kl\\u0131 bir kab\\u0131n i\\u00e7erisine kar\\u0131\\u015f\\u0131m\\u0131 d\\u00f6kd\\u00fckten sonra \\u00f6nceden \\u0131s\\u0131t\\u0131lm\\u0131\\u015f 180 derece f\\u0131r\\u0131nda yakla\\u015f\\u0131k 30 dakika pi\\u015firin\",\"Keki \\u0131slatmak i\\u00e7in bir sos tenceresinde s\\u00fct, toz \\u015fekeri aktar\\u0131n\",\"S\\u0131v\\u0131 ya\\u011f\\u0131 da ilave edin\",\"Kakao ve bir tutam tuzu kar\\u0131\\u015ft\\u0131r\\u0131p bir ta\\u015f\\u0131m kaynat\\u0131n\",\"Kaynay\\u0131nca ocaktan al\\u0131n\",\"F\\u0131r\\u0131ndan \\u00e7\\u0131kan kekin \\u00fczerine ocakta haz\\u0131rlad\\u0131\\u011f\\u0131m\\u0131z sosu d\\u00f6k\\u00fcn ve \\u00e7ekmesini bekleyin ve servis yap\\u0131n\"]', 'Bugün #portakalagacistudyosu nda genclik gunuydu???? Efendim Portakal Agaci blogu hep yetişkin tarifleri ile doluymus, onlar biraz da genclerin yapmak isteyeceği tarifler ekleyeceklermis???? Bugun ıslak kek ve misto kurabiye yapildi. Anneannecigimin tabagi ile fotograflandi. Islak kek ile baslayalim????', '', '2020-06-25 20:55:09', NULL);
INSERT INTO `tbl_recipes` VALUES (3, 'Fırında Patates Dilimleri', 0, 4, 5, 'A', 40, '[\"5ef5fa48be2d0.jpg\"]', 6, 0, '[\"Patatesleri y\\u0131kay\\u0131p dilimleyin\",\"Derin bir kasede buz k\\u00fcpleri ile kar\\u0131\\u015ft\\u0131r\\u0131p yar\\u0131m saat bekletin\",\"\\u0130yice kurulay\\u0131p ya\\u011f ve baharatlarla kar\\u0131\\u015ft\\u0131r\\u0131n\",\"Ya\\u011fl\\u0131 ka\\u011f\\u0131t serili tepsiye tek s\\u0131ra yay\\u0131n\",\"200C\'de 35 dk pi\\u015firin\",\"\\u00c7\\u0131k\\u0131nca eski kasar rendesi ile kar\\u0131\\u015ft\\u0131r\\u0131n\"]', 'Fırında Patates Dilimleri', 'https://www.youtube.com/embed/PbtPbE_NOAY', '2020-06-26 19:08:16', '2020-06-27 18:59:49');
INSERT INTO `tbl_recipes` VALUES (4, 'Fırında Kuzu Gerdan', 1, 4, 5, 'A', 60, '[\"5ef60181bff77.jpg\"]', 6, 0, '[\"Kuzu gerdanlar\\u0131 tavada \\u00f6nl\\u00fc arkal\\u0131 m\\u00fch\\u00fcrleyin\",\"Sebzeleri do\\u011fray\\u0131p zeytinya\\u011f\\u0131nda soteleyip taba\\u011fa al\\u0131n\",\"Ayn\\u0131 ya\\u011fda sal\\u00e7ay\\u0131 kavurun\",\"Do\\u011franm\\u0131\\u015f domatesleri ekleyin\",\"Etleri yava\\u015f\\u00e7a domates sosuna al\\u0131p bir saate yak\\u0131n pi\\u015firin\",\"Pi\\u015fince etleri f\\u0131r\\u0131n kab\\u0131na al\\u0131n, sebzeleri ve sosu \\u00fczerlerine d\\u00f6k\\u00fcp tuz serpin\",\"Kab\\u0131n \\u00fczerini ya\\u011fl\\u0131 ka\\u011f\\u0131tla kapat\\u0131p 200C f\\u0131r\\u0131nda pi\\u015firin\"]', 'Fırında Kuzu Gerdan', 'https://youtu.be/qjWcbiIzW1g', '2020-06-26 19:39:05', '2020-06-27 19:02:22');
INSERT INTO `tbl_recipes` VALUES (5, 'Lahana Çorbası', 0, 5, 5, 'A', 60, '[\"5ef607cb3dbf8.jpg\"]', 6, 0, '[\"So\\u011fanlar\\u0131 k\\u00fcp k\\u00fcp do\\u011fray\\u0131n\",\"Tencereye \\u00e7ok az s\\u0131v\\u0131ya\\u011f ekleyip k\\u0131zd\\u0131r\\u0131n\",\"So\\u011fanlar\\u0131 ekleyip kavurun. Sal\\u00e7as\\u0131n\\u0131 ilave edip kavurmaya devam edin\",\"1 litre kaynar suyu tencereye ekleyin. Mercime\\u011fi biraz ha\\u015flay\\u0131p s\\u00fcz\\u00fcn\",\"Tencereye bulgur, mercime\\u011fi ekleyin\",\"Lahanay\\u0131 ince ince do\\u011fray\\u0131p tencereye ekleyin. Orta dereceli ate\\u015fte bulgurlar yumu\\u015fayana kadar pi\\u015firin\"]', 'Bu tarifin bana göre komik bir hikayesi var. Geçen haftalarda yöresel yemekler yapmayı kafaya takınca elimizdeki malzemelere göre yöresel tarifler aramaya başladık internette. Bir sitede karşımıza bu tarif çıktı. Deneyip ne kadar lezzetli olduğunu düşünürken, tarifin asıl kaynağını paylaştığımızdan emin olmak için biraz daha araştırmaya karar verdim. Ararken aslında diyet sayfalarında -hatta yüzlerce sayfada- yazıldığını gördüm. Diyet yemekleri lezzetsiz olur diye düşünüyordum ama bu tarif fikrimi değiştirdim. Bir hafta boyunca lahana çorbası içmeyi asla tavsiye etmiyorum ama arada bir yapmak için lezzetli bir çorba.', '', '2020-06-26 20:05:55', '2020-06-27 19:06:33');
INSERT INTO `tbl_recipes` VALUES (6, 'Hanımağa Çorbası', 0, 5, 5, 'A', 60, '[\"5ef6ba6bac97a.png\"]', 6, 0, '[\"Tencereye so\\u011fan ve tereya\\u011f\\u0131n\\u0131 al\\u0131p sotelemeye ba\\u015flay\\u0131n\",\"So\\u011fanlar solunca sal\\u00e7ay\\u0131 ilave edin\",\"kokusu \\u00e7\\u0131k\\u0131nca \\u00fczerini \\u00f6rtecek kadar s\\u0131cak su ekleyin\",\"Nohutlar\\u0131 ilave edip pi\\u015fmeye b\\u0131rak\\u0131n\",\"Nohutlar\\u0131n pi\\u015fmesine yak\\u0131n ye\\u015fil mercimek ve eri\\u015fteyi ilave edin\",\"Unu ayr\\u0131 bir yerde suland\\u0131r\\u0131p baharatlarla \\u00e7orbaya ekleyin ve tuzunu ayarlay\\u0131n\",\"Eri\\u015fte ve mercimekler yumu\\u015fay\\u0131ncaya kadar pi\\u015firin\"]', 'Buzlukta haşlanmış nohut varsa bu akşama bu çorbayı yapmanızı mutlaka mutlaka tavsiye ederim! Ben yine iftar misafirlerimize yaptım ilk olarak, çok çok lezzetli oldu. Tarif @Lokma Dergisi Ocak 2016 “Türkiye’nin Çorbaları” sayısından. Ben siyez unu ve siyez eriştesiyle yaptım. Nohutlarım da önceden pismiş olduğu için mercimeklerle beraber ekledim', '', '2020-06-27 08:48:03', '2020-06-27 19:11:03');
INSERT INTO `tbl_recipes` VALUES (7, 'Kremalı Yer Elması Çorbası', 0, 5, 5, 'A', 60, '[\"5ef6bdc16d95f.png\"]', 4, 0, '[\"Yer elmalar\\u0131n\\u0131n kabuklar\\u0131n\\u0131 soyup temizleyin. Kararmamalar\\u0131 i\\u00e7in soyduklar\\u0131n\\u0131z\\u0131 su dolu bir kab\\u0131n i\\u00e7erisine at\\u0131n. Hepsi temizlendikten sonra tekrar y\\u0131kay\\u0131p iri olanlar\\u0131n\\u0131 birka\\u00e7 par\\u00e7aya kesin\",\"1 yemek kasigi tereya\\u011f\\u0131ndan az bir miktar ay\\u0131rarak kalan\\u0131n\\u0131 tencerede eritin, yerelmalar\\u0131n\\u0131 ekleyin. \\u00dcstlerine k\\u00f6riyi serpip birka\\u00e7 dakika kar\\u0131\\u015ft\\u0131rarak soteleyin\",\"S\\u0131cak suyu tencereye ekleyin, kaynamas\\u0131n\\u0131 bekledikten sonra alt\\u0131n\\u0131 k\\u0131sarak yakla\\u015f\\u0131k 20 dk pi\\u015firin\",\"Yerelmalar\\u0131 iyice p\\u00fcre yap\\u0131lacak k\\u0131vama geldi\\u011finde blenderdan ge\\u00e7irin. Kremay\\u0131, muskat, tuz ve karabiberi ekleyin. K\\u0131vam\\u0131na g\\u00f6re su ilave edebilirsiniz\",\"Isterseniz ay\\u0131rd\\u0131\\u011f\\u0131n\\u0131z tereya\\u011f\\u0131yla k\\u00fcp ekmekleri k\\u0131t\\u0131rla\\u015ft\\u0131r\\u0131n. \\u00c7orban\\u0131z\\u0131 kaselere ald\\u0131ktan sonra \\u00fcstlerine maydanoz ve k\\u0131t\\u0131r ekmek, dilerseniz biraz daha muskat serperek servis yap\\u0131n\"]', 'Yer elmasını en son ne zaman yapmışım diye arşivi taradığımda 2,5 sene önce yaptığımı fark ettim. Benim aklımda hala o yazıda yazdığım gibi çok uzun zaman önce yaptığım yemek kalmış ama. Son yapışımda olduğu gibi bu sefer de bu minik sebzeler gene başkalarının sayesinde girdiler dolaba. Twitter\'da fikir sorduğumda Asuman, kremalı çorbasını yapmamı önerdi. Karşıma sevgili Sibel\'in tarifi çıkınca, bir de nasıl lezzetli olduğunu okuyunca hemen denemeye koyuldum. Ben sadece çiğ krema yerine internette bulduğum muadilini ekledim. Sonuçta ilk tadımdan sonra \"çok lezzetli, nedir bu?\" yorumunu aldı çorbamız :) Artık yer elması 2 seneye kalmadan tekrar tekrar girecek mutfağıma. Tarifi ve bize bu sebzeyi sevdirdiği için sevgili Sibel\'e kocaman bir teşekkür!', '', '2020-06-27 09:02:17', '2020-06-27 19:17:01');
INSERT INTO `tbl_recipes` VALUES (8, 'Tennuri Çorbası', 0, 5, 5, 'A', 60, '[\"5ef6e7817e554.jpg\"]', 8, 0, '[\"Ak\\u015famdan \\u0131slatt\\u0131\\u011f\\u0131n\\u0131z nohutu y\\u0131kay\\u0131p yar\\u0131 diri kalacak \\u015fekilde ha\\u015flay\\u0131n. Ha\\u015flan\\u0131nca mercimek ve pirinci ilave edip pi\\u015firmeye devam edin\",\"Ayr\\u0131 bir tencerede tereya\\u011f\\u0131n\\u0131 eritip so\\u011fan\\u0131 kavurun. So\\u011fanlar hafif pembele\\u015fince etleri ilave edin. Etler b\\u0131rakt\\u0131\\u011f\\u0131 suyu \\u00e7ekince unu ilave edip 1-2 dakika \\u00e7evirin. Nohut, mercimek ve pirin\\u00e7 kar\\u0131\\u015f\\u0131m\\u0131n\\u0131 et tenceresine ekleyin. Birka\\u00e7 kez kar\\u0131\\u015ft\\u0131r\\u0131p \\u00fczerlerini 3 parmak ge\\u00e7ecek kadar su ilave edin\",\"Etler iyice yumu\\u015fayana kadar pi\\u015firip tuzunu ve baharatlar\\u0131n\\u0131 ekleyin\"]', 'Antep\'e özgü bu çorbayı hazır çorbalar reyonunda keşfettim. Ama hazırını kullanmak yerine ben evde yaptım. Aslında kıyma kullanılıyormuş ama bana kalırsa minik kuşbaşı et ile daha güzel oldu. Bundan sonra kesinlikle favori çorbalarım listesinde en üstlerde bu çorba.', '', '2020-06-27 12:00:25', '2020-06-27 19:19:15');
INSERT INTO `tbl_recipes` VALUES (9, 'Yörük Çorbası', 0, 5, 5, 'A', 60, '[\"5ef6e93cd8a1a.jpg\"]', 8, 0, '[\"Suyu, nohut, kurufasulye ve bu\\u011fday\\u0131 b\\u00fcy\\u00fck bir tencereye al\\u0131p kaynat\\u0131n. Yo\\u011furt, un ve limon suyunu ba\\u015fka bir kapta \\u00e7\\u0131rp\\u0131n. Kaynayan sudan bir kep\\u00e7e dolusu al\\u0131p yo\\u011furtlu kar\\u0131\\u015f\\u0131ma azar azar ve s\\u00fcrekli kar\\u0131\\u015ft\\u0131rarak ekleyin. Bu kar\\u0131\\u015f\\u0131m\\u0131 kaynayan suya ilave edip tuzla tatland\\u0131r\\u0131n. 15 dakika pi\\u015firin.\",\"Semizotlar\\u0131n\\u0131 temizleyin. Semizotlar\\u0131n\\u0131 iri par\\u00e7alar halinde do\\u011fray\\u0131n (sadece yaprak olarak da atabilirsiniz). Kaynamakta olan \\u00e7orbaya tereya\\u011f\\u0131n\\u0131 ekleyin. 10 dakika pi\\u015firin. \\u00c7orbay\\u0131 ocaktan indirmeye 5 dakika kala semizotunu ilave edin. Tuzunu ve biberi serpin. S\\u0131cak servis yap\\u0131n.\"]', 'Ben Lezzet & Sofra\'nın tariflerini birleştirdim.', '', '2020-06-27 12:07:48', '2020-06-27 19:21:41');
INSERT INTO `tbl_recipes` VALUES (10, 'Katmer Poğaça', 0, 6, 1, 'A', 60, '[\"5ef6ed59dfa2e.jpg\"]', 6, 200, '[\"Mayay\\u0131 \\u00e7ok az \\u0131l\\u0131k suyla eritin\",\"Il\\u0131k s\\u00fct, s\\u0131v\\u0131ya\\u011f, tuz, \\u015feker, yumurta ak\\u0131 ve un ile ele yap\\u0131\\u015fmayacak yumu\\u015fakl\\u0131kta hamur yap\\u0131n\",\"Mayalanmas\\u0131n\\u0131 beklemeden 8 par\\u00e7aya ay\\u0131r\\u0131n\",\"Her par\\u00e7ay\\u0131 tabak b\\u00fcy\\u00fckl\\u00fc\\u011f\\u00fcnde a\\u00e7\\u0131p, \\u00fczerine yumu\\u015fak tereya\\u011f\\u0131ndan ince bir tabaka halinde s\\u00fcr\\u00fcn\",\"Hamurlar\\u0131 \\u00fcst\\u00fcste dizerek, her par\\u00e7ada bu i\\u015flemi tekrarlay\\u0131n. En \\u00fcsttekine ya\\u011f s\\u00fcrmeyin\",\"\\u00dcst\\u00fcste dizilmi\\u015f hamurlar\\u0131 fazla ezmeden yava\\u015f yava\\u015f 60-70 cm \\u00e7ap\\u0131na gelinceye kadar b\\u00fcy\\u00fct\\u00fcn\",\"Sigara b\\u00f6re\\u011fi sarar gibi kesip, aras\\u0131na peynir koyarak sar\\u0131n\",\"30-40 dakika mayaland\\u0131r\\u0131p, \\u00fczerine yumurta sar\\u0131s\\u0131 s\\u00fcr\\u00fcn\",\"180 derecede \\u00fczerleri k\\u0131zarana kadar pi\\u015firin\"]', 'Bu tarifi yıllar önce mutfakguncesi.blogspot.com’dan almistim, hala cok severek yapiyorum.', '', '2020-06-27 12:25:21', '2020-06-27 13:51:34');
INSERT INTO `tbl_recipes` VALUES (12, 'Anneanne Ekmeği', 0, 7, 5, 'A', 30, '[\"5ef75142436b2.jpg\"]', 4, 0, '[\"F\\u0131r\\u0131n\\u0131 200C\'ye \\u0131s\\u0131t\\u0131p kapat\\u0131n. Geni\\u015f bir kab\\u0131n i\\u00e7inde \\u0131l\\u0131k su, maya, tuz, ya\\u011f, \\u015feker ve 2 su barda\\u011f\\u0131 unu kar\\u0131\\u015ft\\u0131r\\u0131n. Kab\\u0131n\\u0131z\\u0131n \\u00fczerini stre\\u00e7leyip f\\u0131r\\u0131nda kar\\u0131\\u015f\\u0131m 2 kat\\u0131 olana kadar bekletin\",\"\\u0130ki kat\\u0131na \\u00e7\\u0131k\\u0131nca azar azar 2 su barda\\u011f\\u0131 unu ekleyip iyice yo\\u011furun. Hamuru ya\\u011flanm\\u0131\\u015f bir kaseye al\\u0131p \\u00e7evire \\u00e7evire her yan\\u0131n\\u0131n ya\\u011flanmas\\u0131n\\u0131 sa\\u011flay\\u0131n. \\u00dczerini \\u00f6rt\\u00fcp tekrar f\\u0131r\\u0131na al\\u0131p iki kat\\u0131 kabart\\u0131n\",\"Hamuru hafif\\u00e7e yo\\u011furup ekmek \\u015fekli verin ve dikd\\u00f6rtgen kek kal\\u0131b\\u0131n\\u0131za yerle\\u015ftirip kapal\\u0131 f\\u0131r\\u0131n\\u0131n\\u0131zda kabart\\u0131n. 175C\'de 35-45 dakika pi\\u015firin. Kal\\u0131ptan \\u00e7\\u0131kard\\u0131ktan sonra bir beze sararak \\u0131l\\u0131t\\u0131n\"]', 'Pazartesi günü ekmek yapmak için 3 saatten az zamanım kaldığını fark\r\nedince all recipes\'ten bu tarifi buldum. Tarifteki bekleme sürelerini,\r\nhamuru önceden 200C\'ye ısıtıp kapattığım fırında bekleterek kısalttım.\r\nBöylece bekleme süreleri yaklaşık15şer dakikaya indi. Fırından ilk\r\nçıktığında kızıma ekmeği bıraktırıp yemeğe geçirmekte epeyce zorlandım.', '', '2020-06-27 19:31:38', '2020-06-28 07:26:28');
INSERT INTO `tbl_recipes` VALUES (13, 'Yerelması Çorbası', 0, 5, 5, 'A', 60, '[\"5ef7529e52fad.jpg\"]', 6, 0, '[\"Yerelmalar\\u0131n\\u0131 soyup limonlu suda bekletin. Kuru so\\u011fan\\u0131 yemeklik do\\u011fray\\u0131p zeytinya\\u011f\\u0131nda havu\\u00e7larla beraber kavurun.\",\"So\\u011fan \\u015feffafla\\u015fmaya ba\\u015flay\\u0131nca yerelmalar\\u0131n\\u0131 k\\u00fcp k\\u00fcp do\\u011fray\\u0131p tencereye ekleyin. Mercime\\u011fi y\\u0131kay\\u0131p tencere ilave edin ve birka\\u00e7 kez daha kar\\u0131\\u015ft\\u0131r\\u0131n.\",\"Kaynam\\u0131\\u015f suyu ekleyip mercimekler ezilene kadar pi\\u015firin. Pi\\u015fince blend\\u0131rdan ge\\u00e7irin, k\\u0131vam\\u0131 koyu gelirse su ilave edin. Tuzunu ekleyip limon suyula servis yap\\u0131n.\"]', 'Tarif sebzeli mercimek çorbasının neredeyse aynısı, ben yerelması yerine normalde kereviz koyuyorum, bu tarifte baştan eklemedim ama siz patates de ilave edebilirsiniz.', '', '2020-06-27 19:37:26', NULL);
INSERT INTO `tbl_recipes` VALUES (14, 'Fırınlanmış Karnabahar Çorbası', 0, 5, 5, 'A', 60, '[\"5ef7fc2b46307.jpg\"]', 4, 0, '[\"F\\u0131r\\u0131n\\u0131 190C\'ye getirin. Karnabahar\\u0131 2-3cmlik par\\u00e7alara b\\u00f6l\\u00fcn. B\\u00fcy\\u00fck\\u00e7e bir f\\u0131r\\u0131n tepsisine karnabaharlar\\u0131, so\\u011fan ve sar\\u0131msaklar\\u0131 koyun. \\u00dczerlerine zeytinya\\u011f\\u0131n\\u0131 gezdirip hepsinin ya\\u011flanmas\\u0131n\\u0131 sa\\u011flayacak \\u015fekilde kar\\u0131\\u015ft\\u0131r\\u0131n.\",\"F\\u0131r\\u0131nda yar\\u0131m saat, karnabaharlar k\\u0131zarana kadar, pi\\u015firin. \\u00dcstlerinin rengi de\\u011fi\\u015ftik\\u00e7e 10-15 dakikada bir alt\\u00fcst edin.\",\"Pi\\u015ftiklerinde tepsideki t\\u00fcm malzemeyi tencereye al\\u0131n. \\u00dczerine tavuk suyunu ekleyin. Bir de defne yapra\\u011f\\u0131 koyun. Karnabaharlar g\\u00fczelce yumu\\u015fayana kadar pi\\u015firin.\",\"Defne yapra\\u011f\\u0131n\\u0131 \\u00e7\\u0131kart\\u0131p \\u00e7orbay\\u0131 blend\\u0131rdan ge\\u00e7irin. Tekrar oca\\u011fa al\\u0131p istedi\\u011finiz yumu\\u015fakl\\u0131\\u011fa gelene kadar s\\u00fct ekleyin. 10 dakika daha pi\\u015firip tuzunu ekleyin.\"]', 'Az kişi olduğumuz için küçük bir karnabahar kullandım, tavuk suyunu da içme suyu ile karıştırdım.', '', '2020-06-28 07:40:51', '2020-06-28 07:41:08');
INSERT INTO `tbl_recipes` VALUES (15, 'Közlenmiş Domates Çorbası', 0, 5, 5, 'A', 60, '[\"5ef7fe2678401.jpg\"]', 4, 0, '[\"Domatesleri, so\\u011fan\\u0131 ve sar\\u0131msa\\u011f\\u0131 160C \\u0131s\\u0131daki f\\u0131r\\u0131na koyup 45 dakika k\\u00f6zleyin. Hepsi iyice yumu\\u015fay\\u0131nca f\\u0131r\\u0131ndan al\\u0131n.\",\"So\\u011fan ve sar\\u0131msaklar\\u0131 soyun. So\\u011fanlar\\u0131 do\\u011fray\\u0131n. Az zeytinya\\u011f\\u0131 eklenmi\\u015f tencerede sar\\u0131msaklarla beraber 2-3 dakika \\u00e7evirin.\",\"Domatesleri ve kaynam\\u0131\\u015f suyun yar\\u0131s\\u0131n\\u0131 tencereye ekleyip blend\\u0131r ile p\\u00fcre haline getirin. Bir ta\\u015f\\u0131m kaynat\\u0131p suyun kalan yar\\u0131s\\u0131n\\u0131 ekleyin.\",\"Tuzunu ve karabiberini ekleyin. \\u0130ste\\u011finize g\\u00f6re taze otlar veya peynir ile s\\u00fcsleyip servis yap\\u0131n.\"]', 'Közlemenin domateslere verdiği tat kadar soğan ve sarımsağa kattığı aroma da çok hoş', '', '2020-06-28 07:49:18', '2020-06-28 07:49:31');
INSERT INTO `tbl_recipes` VALUES (16, 'Tutmaç Çorbası', 0, 5, 5, 'A', 60, '[\"5ef8091e0cc54.jpg\"]', 4, 0, '[\"Ye\\u015fil mercime\\u011fi tencereye al\\u0131p \\u00fczerine su ekleyin. Mercimekler pi\\u015fmek \\u00fczere iken eri\\u015fteleri ilave edin.\",\"Eri\\u015fteler pi\\u015fince 2 su barda\\u011f\\u0131 yo\\u011furdu bir kapta kar\\u0131\\u015ft\\u0131r\\u0131n. \\u00c7orban\\u0131n suyundan yo\\u011furda ekleyip \\u0131l\\u0131t\\u0131n. Yo\\u011furdu \\u00e7orba tenceresine ilave edin.\",\"Tuzunu ayarlay\\u0131n. Bir tavada ya\\u011f\\u0131 eritip biberi k\\u0131zd\\u0131r\\u0131n. En son \\u00fczerine bolca nane serpin.\"]', 'Tutmaç Çorbası:', '', '2020-06-28 08:36:06', '2020-06-28 08:36:16');
INSERT INTO `tbl_recipes` VALUES (18, 'Kabak Çorbası:', 0, 5, 5, 'A', 40, '[\"5ef810ec8983e.jpg\"]', 4, 0, '[\"Kal\\u0131n tabanl\\u0131 bir tencerede, orta ate\\u015fte ya\\u011f\\u0131 eritip, \\u00e7entilmi\\u015f so\\u011fan ve sar\\u0131msaklar\\u0131 8-10 dakika \\u00e7evirin. Temizleyip ince do\\u011frad\\u0131\\u011f\\u0131n\\u0131z kabaklar\\u0131, s\\u0131cak s\\u00fct\\u00fc, tuzu ve istedi\\u011finiz kadar karabiberi tencereye ilave edip, bir ta\\u015f\\u0131m kaynatt\\u0131ktan sonra, hafif ate\\u015fte yar\\u0131m saat pi\\u015firin.\",\"Tencereyi ate\\u015ften al\\u0131p, \\u00e7orbay\\u0131 el blend\\u0131r\\u0131 ile ya da robotta iyice kar\\u0131\\u015ft\\u0131r\\u0131n, sonra yine tencereye bo\\u015falt\\u0131p \\u00f6nceden iyice \\u00e7\\u0131rpt\\u0131\\u011f\\u0131n\\u0131z yo\\u011furdu ve limon suyunu  yine \\u00e7\\u0131rparak ekleyin ve 3-4 dakika daha pi\\u015firin.\",\"Servis yaparken \\u00fczerine taze nane serpi\\u015ftirin.\"]', 'Kabak Çorbası:', '', '2020-06-28 09:09:24', '2020-06-28 09:10:19');
INSERT INTO `tbl_recipes` VALUES (19, 'Ispanak Köklü Yeşil Mercimek Çorbası', 0, 5, 5, 'A', 45, '[\"5ef8155a29b93.jpg\"]', 4, 0, '[\"Tencereye 5 su barda\\u011f\\u0131 suyu koyup ,mercime\\u011fi ekleyin. K\\u0131s\\u0131k ate\\u015fte pi\\u015firip, nohutu ilave edin.\",\"Bir tavada ya\\u011fla \\u0131spana\\u011f\\u0131 kavurun , sal\\u00e7ay\\u0131 ezin, \\u00e7orbaya kat\\u0131p tuz, biber, limon suyu ilavesiyle biraz kaynat\\u0131p servis yap\\u0131n.\"]', 'Ispanak Köklü Yeşil Mercimek Çorbası (Ispanak Başı)', '', '2020-06-28 09:28:18', '2020-06-28 09:29:12');
INSERT INTO `tbl_recipes` VALUES (20, 'Nohutlu Mercimek Çorbası', 0, 5, 5, 'A', 60, '[\"5ef81829a61f8.jpg\"]', 4, 0, '[\"1 ba\\u015f kuru so\\u011fan\\u0131 yemeklik do\\u011franm\\u0131\\u015f olarak zeytinya\\u011f\\u0131yla beraber tencereye al\\u0131n.\",\"Renkleri pembele\\u015fene kadar kavurma i\\u015flemi uygulay\\u0131n.\",\"Sal\\u00e7ay\\u0131 ilave edip bir miktar daha kar\\u0131\\u015ft\\u0131r\\u0131n.\",\"Ard\\u0131ndan y\\u0131kanm\\u0131\\u015f, suyu s\\u00fcz\\u00fclm\\u00fc\\u015f k\\u0131rm\\u0131z\\u0131 mercimek ile pirinci, arkas\\u0131ndan da bir yk. unu ekleyin.\",\"1-2 kez \\u00e7evirdikten sonra 1,5 litre kaynam\\u0131\\u015f suyu \\u00fczerine ilave edin.\",\"Mercimek ve pirin\\u00e7ler ezilinceye kadar pi\\u015firin.\",\"Bu arada \\u00e7orban\\u0131n k\\u0131vam\\u0131n\\u0131 ara s\\u0131ra kontrol ederek kaynam\\u0131\\u015f su ilave edebilirsiniz.\",\"\\u00c7orba pi\\u015fmi\\u015ftir dedi\\u011finiz zaman blend\\u0131rdan ge\\u00e7irin.\",\"Tencereyi tekrar ate\\u015fe al\\u0131p nohutlar\\u0131 ilave ederek 10 dakika kadar kaynama i\\u015flemini devam ettirin.\",\"Bu s\\u00fcrenin sonunda tuzunu ve nanesini ekleyip kaselerin yan\\u0131na limon dilimi koyarak servise haz\\u0131rlayabilirsiniz.\"]', 'Nohutlu mercimek çorbası', '', '2020-06-28 09:40:17', NULL);
INSERT INTO `tbl_recipes` VALUES (21, 'Patates ve Mısır Çorbası', 0, 5, 5, 'A', 40, '[\"5ef81abe9c9d0.jpg\"]', 6, 0, '[\"Ya\\u011flar\\u0131 bir tencerede eritin. Past\\u0131rma kullan\\u0131yorsan\\u0131z tencereye ekleyip 1-2 kez kar\\u0131\\u015ft\\u0131r\\u0131n. Ate\\u015fi azalt\\u0131p p\\u0131rasa ve so\\u011fan\\u0131 ekleyin. 5 dakika kavurup unu ilave edin. Unu 1-2 dakika kavurup tavuk suyunu ekleyin.\",\"Tavuk suyu kaynay\\u0131nca patatesleri ilave edin. Patatesler yumu\\u015fay\\u0131nca m\\u0131s\\u0131rlar\\u0131 ekleyin.\",\"Yumurta sar\\u0131lar\\u0131n\\u0131 yo\\u011furt ile kar\\u0131\\u015ft\\u0131r\\u0131n. \\u00c7orban\\u0131n suyundan biraz al\\u0131p yo\\u011furda ekleyin. (B\\u00f6ylece yo\\u011furt \\u0131l\\u0131ns\\u0131n, aksi taktirde \\u00e7orban\\u0131z kesilir.) Yo\\u011furdu azar azar \\u00e7orbaya ilave edin.\",\"E\\u011fer \\u00e7orban\\u0131z \\u00e7ok koyu ise biraz kaynam\\u0131\\u015f su ekleyerek kar\\u0131\\u015ft\\u0131r\\u0131n. Tuzunu ve karabiberini ekleyin. Tabaklara payla\\u015ft\\u0131r\\u0131p \\u00fczerine maydanoz serperek servis yap\\u0131n.\"]', 'Pazar akşamı evde tek başıma kalınca denenmek üzere bekleyen tariflerden ikisini yaptım. Birincisi Delicious, Temmuz 2005 sayısından patates ve mısır çorbası, diğeri de geçen hafta başında bahsettiğim Living dergisinden Vişneli ve Bademli Biscotti. Çorbanın malzemeleri ve ölçülerinde birkaç değişiklik yaptım. Asıl tarifte pastırma kullanılıyordu ama ben eklemedim.  Annem de çorbayı ertesi gün yağda kızdırılmış nane ile servis yaptı, eğer siz de bu lezzetli çorbaya pastırma eklemeyecekseniz yağda kızdırılmış nane veya pul biber ile sunabilirsiniz.', '', '2020-06-28 09:51:18', '2020-06-28 09:51:40');
INSERT INTO `tbl_recipes` VALUES (22, 'Mahluta Çorbası', 0, 5, 5, 'A', 45, '[\"5ef9eda364d3b.jpg\"]', 4, 0, '[\"So\\u011fanlar\\u0131 ya\\u011fda kavurun. Tavan\\u0131n kapa\\u011f\\u0131n\\u0131 kapat\\u0131p ara s\\u0131ra kar\\u0131\\u015ft\\u0131rarak so\\u011fanlar\\u0131n yumu\\u015famas\\u0131n\\u0131 sa\\u011flay\\u0131n. Daha sonra ate\\u015fin alt\\u0131n\\u0131 a\\u00e7\\u0131p s\\u0131k s\\u0131k kar\\u0131\\u015ft\\u0131rarak karamelize olmalar\\u0131n\\u0131 sa\\u011flay\\u0131n. So\\u011fanlar\\u0131 ka\\u011f\\u0131t havlu \\u00fczerine koyup bir kenara al\\u0131n.\",\"Suyu kaynat\\u0131p i\\u00e7ine mercime\\u011fi ve pirin\\u00e7leri at\\u0131n. Karabiber ve ki\\u015fni\\u015fi ekleyip mercimekler iyice ezilene kadar -35 veya 45 dakika- pi\\u015firin.\",\"\\u00c7orban\\u0131n tad\\u0131n\\u0131 kontrol ederek tuzunu ilave edin. (tavuk suyundan dolay\\u0131 daha az tuz kullanacaks\\u0131n\\u0131z)\",\"Koyulu\\u011funu ayarlamak i\\u00e7in gerekirse bir miktar daha kaynar su ekleyin.\",\"Kaselere al\\u0131p \\u00fczerine kimyon serperek so\\u011fan ve limon dilimleri e\\u015fli\\u011finde servis yap\\u0131n.\"]', 'Claudia Roden; Arabesque kitabından alınmıştır. \r\n\r\n*yazar 2 tavuk bulyon kullanarak yapmayı önermiş, dilerseniz kendi yaptığınız tavuk suyunu bir miktar su ile karıştırarak da kullanabilirsiniz.', '', '2020-06-29 19:03:23', NULL);
INSERT INTO `tbl_recipes` VALUES (23, 'Domates Çorbası', 0, 5, 5, 'A', 45, '[\"5ef9ef5529747.jpg\"]', 6, 0, '[\"2 yemek ka\\u015f\\u0131\\u011f\\u0131 s\\u0131v\\u0131ya\\u011f ile 2 yemek ka\\u015f\\u0131\\u011f\\u0131 unu biraz kavurun.\",\"1 yemek ka\\u015f\\u0131\\u011f\\u0131 sal\\u00e7a ile 5 adet rendelenmi\\u015f domates ekleyin. Topaklan\\u0131rsa bu a\\u015famada el blend\\u0131r\\u0131 ile kar\\u0131\\u015ft\\u0131r\\u0131n.\",\"Daha sonra 5 su barda\\u011f\\u0131 su ekleyin.Koyula\\u015fana kadar kar\\u0131\\u015ft\\u0131rarak pi\\u015firin.\",\"Servis yaparken tencereye s\\u00fct\\u00fc ve tuzu ilave edin.\",\"\\u0130ste\\u011fe g\\u00f6re \\u00fczerine ka\\u015far rendesi serpin.\"]', 'portakalagaci.com sitemizde; Merih isimli üyemizin paylaştığı tarifdir.', '', '2020-06-29 19:10:37', NULL);
INSERT INTO `tbl_recipes` VALUES (24, 'Taneli Sebze Çorbası', 0, 5, 5, 'A', 45, '[\"5ef9f0963c6ae.jpg\"]', 6, 0, '[\"so\\u011fan\\u0131 yemeklik  do\\u011fray\\u0131n. zeytinya\\u011f\\u0131 ile tencere al\\u0131p kavurun. 1 yemek ka\\u015f\\u0131\\u011f\\u0131 unu ekleyip 1-2 kez kar\\u0131\\u015ft\\u0131r\\u0131n.\",\"mutfak robotundan ge\\u00e7irilmi\\u015f p\\u0131rasay\\u0131, havucu ve kerevizi ekleyin. birka\\u00e7 dakika daha kar\\u0131\\u015ft\\u0131r\\u0131p 1,5 lt kaynam\\u0131\\u015f suyu ilave edin. sebzeler hafif pi\\u015fince robottan ge\\u00e7irilmi\\u015f patatesi ekleyip pi\\u015fmeye b\\u0131rak\\u0131n.\",\"bu arada \\u00e7orban\\u0131n terbiyesini haz\\u0131rlay\\u0131n. 1yumurtan\\u0131n sar\\u0131s\\u0131n\\u0131 1 limon suyu ile iyice \\u00e7\\u0131rp\\u0131n. \\u00e7orban\\u0131n suyundan ka\\u015f\\u0131kla azar azar al\\u0131p terbiyeyi \\u0131l\\u0131t\\u0131n. daha sonra terbiyeyi yava\\u015f yava\\u015f pi\\u015fmi\\u015f olan \\u00e7orbaya ekleyin. tuzunu kontrol ederek ilave edin. kereviz yapraklar\\u0131 ile s\\u00fcsleyin.\"]', 'Diğer çorbalardaki gibi blendırdan geçirmek yerine hepsini mutfak robotunda ince ince kıyıp öyle pişiriyorsunuz', '', '2020-06-29 19:15:58', NULL);
INSERT INTO `tbl_recipes` VALUES (25, 'Şehriyeli Mercimek Çorbası', 0, 5, 5, 'A', 45, '[\"5ef9f1e7bab55.jpg\"]', 4, 0, '[\"so\\u011fan\\u0131 ince ince yemeklik do\\u011fray\\u0131n. sivri biberleri de do\\u011fray\\u0131n. tencereye ya\\u011f\\u0131 koyun. so\\u011fan\\u0131 ve biberleri ekleyip so\\u011fanlar \\u00f6lene kadar kavurun.\",\"domatesleri soyup f\\u0131nd\\u0131k b\\u00fcy\\u00fckl\\u00fc\\u011f\\u00fcnde do\\u011fray\\u0131p tencereye ekleyin. bir iki dakika kar\\u0131\\u015ft\\u0131r\\u0131n.\",\"mercimekleri y\\u0131kay\\u0131p ekleyin, bir iki kez kar\\u0131\\u015ft\\u0131r\\u0131n. en son kaynar suyu ekleyip pi\\u015fmeye b\\u0131rak\\u0131n. mercimekler iyice ezilene kadar pi\\u015firin. pi\\u015ftikten sonra tuzunu ekleyin. servis yapmadan 15 dakika \\u00f6nce arpa \\u015fehriyeyi ekleyip \\u015fehriyeler uzayana kadar pi\\u015firin. \\u00fczerine nane serpip servis yap\\u0131n.\"]', 'Şehriyeli Mercimek Çorbası', '', '2020-06-29 19:21:35', NULL);
INSERT INTO `tbl_recipes` VALUES (26, 'Kabak ve Patates Çorbası', 0, 5, 5, 'A', 45, '[\"5ef9f6756b62b.jpg\"]', 4, 0, '[\"2 yemek ka\\u015f\\u0131\\u011f\\u0131 zeytinya\\u011f\\u0131nda so\\u011fan\\u0131 ve patatesleri 2-3 dakika kavurun. suyu tencereye ekleyin. kaynay\\u0131nca kabaklar\\u0131 ilave edin. k\\u0131s\\u0131k ate\\u015fte 8-10 dakika kaynat\\u0131n.\",\"bu arada 4 yemek ka\\u015f\\u0131\\u011f\\u0131 zeytinya\\u011f\\u0131n\\u0131 do\\u011franm\\u0131\\u015f taze so\\u011fanlarla rondodan veya blend\\u0131rdan ge\\u00e7irip bir kenara al\\u0131n.\",\"patatesler yumu\\u015fay\\u0131nca do\\u011franm\\u0131\\u015f maydanozlar\\u0131 ve tuzu ekleyin. \\u00e7orbay\\u0131 blend\\u0131rdan ge\\u00e7irin. tabaklara ald\\u0131\\u011f\\u0131n\\u0131z \\u00e7orban\\u0131n \\u00fczerine so\\u011fanl\\u0131 ya\\u011fdan damlatarak servis yap\\u0131n.\"]', 'Kabak ve Patates Çorbası', '', '2020-06-29 19:41:01', NULL);
INSERT INTO `tbl_recipes` VALUES (27, 'Köfteli Yoğurt Çorbası', 0, 5, 5, 'A', 45, '[\"5ef9f7d42aa4f.jpg\"]', 4, 0, '[\"k\\u0131yma, tuz ve karabiber ile k\\u00f6fte harc\\u0131 yap\\u0131n. bu har\\u00e7tan nohuttan k\\u00fc\\u00e7\\u00fck k\\u00f6fteler yap\\u0131n.\",\"1,5-2 litre suyu kaynat\\u0131n. k\\u00f6fteleri at\\u0131p 5 dakika kaynat\\u0131n. ard\\u0131ndan \\u015fehriyeleri ekleyin. \\u00e7orban\\u0131n alt\\u0131n\\u0131 kapat\\u0131p \\u0131l\\u0131t\\u0131n.\",\"2 kase yo\\u011furt, 1 yumurta, 2 ka\\u015f\\u0131k un ve 1 \\u00e7ay barda\\u011f\\u0131 suyu \\u00e7\\u0131rp\\u0131n. \\u00e7orbadan kep\\u00e7eyle azar azar ald\\u0131\\u011f\\u0131n\\u0131z suyla yo\\u011furtlu harc\\u0131 \\u0131l\\u0131t\\u0131n.\",\"\\u0131l\\u0131nan harc\\u0131 kar\\u0131\\u015ft\\u0131ra kar\\u0131\\u015ft\\u0131ra tencereye ekleyin. kar\\u0131\\u015ft\\u0131rarak kaynat\\u0131n. kaynay\\u0131nca alt\\u0131n\\u0131 kapat\\u0131n. \\u00fczerine zeytinya\\u011f\\u0131nda k\\u0131zd\\u0131r\\u0131lm\\u0131\\u015f nane gezdirerek servis yap\\u0131n.\"]', 'Köfteli Yoğurt Çorbası', '', '2020-06-29 19:46:52', NULL);
INSERT INTO `tbl_recipes` VALUES (28, 'Kızılcıklı Tarhana Çorbası', 0, 5, 5, 'A', 45, '[\"5ef9f92a27a5a.jpg\"]', 4, 0, '[\"so\\u011fan\\u0131 rendeleyin. yar\\u0131m yemek ka\\u015f\\u0131\\u011f\\u0131 tereya\\u011f\\u0131 ile kavurun. 5 su barda\\u011f\\u0131 so\\u011fuk suda 5 yemek ka\\u015f\\u0131\\u011f\\u0131 tarhanay\\u0131 ezin ve so\\u011fanlara ilave edin. devaml\\u0131 kar\\u0131\\u015ft\\u0131rarak kaynayana kadar pi\\u015firin. kaynay\\u0131nca tuzu ekleyin.\",\"sosu i\\u00e7in tereya\\u011f\\u0131n\\u0131 eritin. \\u00f6nce naneyi ekleyip 1-2 kez \\u00e7evirin. ard\\u0131ndan pul biberi ekleyip kar\\u0131\\u015ft\\u0131r\\u0131n. tabaklara ald\\u0131\\u011f\\u0131n\\u0131z \\u00e7orbalara tereya\\u011fl\\u0131 sos, sar\\u0131msak ve sirke ekleyerek servis yap\\u0131n.\"]', 'Kızılcıklı Tarhana Çorbası', '', '2020-06-29 19:52:34', NULL);
INSERT INTO `tbl_recipes` VALUES (29, 'Mantar Çorbası', 0, 5, 5, 'A', 45, '[\"5ef9f9f990180.jpg\"]', 4, 0, '[\"mantarlar\\u0131 y\\u0131kay\\u0131p k\\u00fc\\u00e7\\u00fcklerini ikiye, b\\u00fcy\\u00fcklerini d\\u00f6rde b\\u00f6l\\u00fcn. hepsini ince ince do\\u011fray\\u0131n.\",\"orta boy bir tencerede ya\\u011f\\u0131 ve unu kavurun. kavrulunca tencereye suyu ekleyin ve blend\\u0131r yard\\u0131m\\u0131yla kar\\u0131\\u015ft\\u0131r\\u0131n. su kaynay\\u0131nca mantarlar\\u0131 ve tuzu ilave edip yakla\\u015f\\u0131k 20 dakika pi\\u015firin.\",\"pi\\u015ftikten sonra s\\u00fct\\u00fc ekleyin. 1 ta\\u015f\\u0131m kaynat\\u0131p alt\\u0131n\\u0131 kapat\\u0131n. taze \\u00e7ekilmi\\u015f karabiber ile servis yap\\u0131n.\"]', 'Mantar Çorbası', '', '2020-06-29 19:56:01', NULL);
INSERT INTO `tbl_recipes` VALUES (30, 'Cıvırla (Fasulye Çorbası)', 0, 5, 5, 'A', 45, '[\"5ef9fc43d4dc4.jpg\"]', 6, 0, '[\"so\\u011fan\\u0131 zeytinya\\u011f\\u0131 ve tereya\\u011f\\u0131nda kavurun. (ben tereya\\u011f\\u0131n\\u0131 eklemedim) pembele\\u015fince do\\u011frad\\u0131\\u011f\\u0131n\\u0131z biberleri, soyup do\\u011frad\\u0131\\u011f\\u0131n\\u0131z domatesleri, sal\\u00e7ay\\u0131 ve bulguru ekleyin. bir s\\u00fcre daha kavurun.\",\"kavrulunca 5 su barda\\u011f\\u0131 suyu ekleyip tencerenin a\\u011fz\\u0131 kapal\\u0131 olarak 10 dakika pi\\u015firin. pi\\u015firdikten sonra fasulyeleri ekleyin. tencerenin a\\u011fz\\u0131n\\u0131 tekrar kapat\\u0131p fasulyeler yumu\\u015fayana kadar pi\\u015firin.\",\"fasulyeler pi\\u015fince peyniri, tuzu (peynir tuzlu oldu\\u011fu i\\u00e7in az) ve karabiberi ilave edin. bir ta\\u015f\\u0131m kaynat\\u0131p alt\\u0131n\\u0131 kapat\\u0131n.\"]', 'Cıvırla (Fasulye Çorbası)', '', '2020-06-29 20:05:47', NULL);
INSERT INTO `tbl_recipes` VALUES (31, 'Tavuk Suyu Çorba', 0, 5, 5, 'A', 45, '[\"5ef9fd759e763.jpg\"]', 8, 0, '[\"tavuk butu derisinden ay\\u0131r\\u0131p g\\u00f6\\u011f\\u00fcs ve 2 ba\\u015f kuru so\\u011fan ile birlikte ha\\u015flay\\u0131n. ha\\u015flanm\\u0131\\u015f etleri suyun i\\u00e7inden al\\u0131p minik minik do\\u011fray\\u0131n.\",\"2 yemek ka\\u015f\\u0131\\u011f\\u0131 unu 2 yemek ka\\u015f\\u0131\\u011f\\u0131 tereya\\u011f\\u0131 ile ayr\\u0131 bir \\u00e7orba tenceresine al\\u0131n. unun kokusu gidene kadar (yakla\\u015f\\u0131k 3-4 dakika) kavurun.\",\"tavu\\u011fu ha\\u015flad\\u0131\\u011f\\u0131n\\u0131z et suyuna bir miktar kaynam\\u0131\\u015f su ilave edin. (toplam 2 litre olacak kadar). bu suyu unun \\u00fczerine azar azar ekleyin.\",\"sar\\u0131msaklar\\u0131 d\\u00f6v\\u00fcn ve do\\u011franm\\u0131\\u015f tavuklarla birlikte tencereye ilave edin. \\u00e7orban\\u0131n suyun kontrol ederek tuzunu ayarlay\\u0131n. (kontrol etmenizin nedeni tavuk suyunun tuzlu olmas\\u0131). 10 dakika pi\\u015firin. bu arada tencerenin a\\u011fz\\u0131n\\u0131 a\\u00e7\\u0131k tutmaya \\u00f6zen g\\u00f6sterin.\",\"en son servis yaparken \\u00fczerine \\u00e7ekilmi\\u015f karabiber serpin.\"]', 'Çorbanın tadı işkembe çorbasına yakın oluyor.', '', '2020-06-29 20:10:53', NULL);
INSERT INTO `tbl_recipes` VALUES (32, 'Aşure ve Aşure Çorbası', 0, 5, 5, 'A', 240, '[\"5efa00bbe17f4.jpg\",\"5efa001605931.jpg\"]', 20, 0, '[\"a\\u015fureyi pi\\u015firmeye ba\\u015flamadan 8-9 saat \\u00f6nce bu\\u011fday\\u0131 b\\u00fcy\\u00fck\\u00e7e bir tencereye al\\u0131p \\u00fczerini 4-5 parmak ge\\u00e7ecek kadar kire\\u00e7siz su ile doldurun ve bir ta\\u015f\\u0131m kaynat\\u0131n.\",\"a\\u015fure yaparken kuru yemi\\u015fleri eklemeden (6. ad\\u0131m) \\u00f6nce pi\\u015fmi\\u015f baklagillerden \\u00e7orba tenceresine 6-7 kep\\u00e7e ay\\u0131r\\u0131n.\",\"tencereye 1,5 lt. so\\u011fuk s\\u00fct ekleyin. 1-2 defa kar\\u0131\\u015ft\\u0131r\\u0131p kaynamas\\u0131n\\u0131 bekleyin. kaynay\\u0131nca tuz ilave edin.\",\"bu arada 2 yemek ka\\u015f\\u0131\\u011f\\u0131 tereya\\u011f\\u0131, ince ince do\\u011franm\\u0131\\u015f 1 k\\u00fc\\u00e7\\u00fck so\\u011fan ve pul biberi tavada k\\u0131zd\\u0131r\\u0131p sos haz\\u0131rlay\\u0131n.\",\"\\u00e7orba pi\\u015fince kaselere al\\u0131p nane ve sos ile servis yap\\u0131n.\",\"\\u00e7orba pi\\u015fince kaselere al\\u0131p nane ve sos ile servis yap\\u0131n.\",\"a\\u015furenin k\\u0131vam\\u0131n\\u0131 kaynar su ekleyerek diledi\\u011finiz gibi ayarlayabilirsiniz.\",\"a\\u015fure so\\u011fuduktan sonra kaselere payla\\u015ft\\u0131r\\u0131p tar\\u00e7\\u0131n\\/ceviz\\/f\\u0131nd\\u0131k\\/nar ile s\\u00fcsleyin. not: pi\\u015ftikten sonra a\\u015furenin bir k\\u0131sm\\u0131na veya tamam\\u0131na bir portakal kabu\\u011fu rendesi eklerseniz \\u00e7ok g\\u00fczel bir tat yakalam\\u0131\\u015f olursunuz.\",\"A\\u015fure \\u00c7orbas\\u0131 Haz\\u0131rlamak \\u0130\\u00e7in:\",\"a\\u015fure yaparken kuru yemi\\u015fleri eklemeden (6. ad\\u0131m) \\u00f6nce pi\\u015fmi\\u015f baklagillerden \\u00e7orba tenceresine 6-7 kep\\u00e7e ay\\u0131r\\u0131n.\",\"tencereye 1,5 lt. so\\u011fuk s\\u00fct ekleyin. 1-2 defa kar\\u0131\\u015ft\\u0131r\\u0131p kaynamas\\u0131n\\u0131 bekleyin. kaynay\\u0131nca tuz ilave edin.\",\"bu arada 2 yemek ka\\u015f\\u0131\\u011f\\u0131 tereya\\u011f\\u0131, ince ince do\\u011franm\\u0131\\u015f 1 k\\u00fc\\u00e7\\u00fck so\\u011fan ve pul biberi tavada k\\u0131zd\\u0131r\\u0131p sos haz\\u0131rlay\\u0131n.\",\"\\u00e7orba pi\\u015fince kaselere al\\u0131p nane ve sos ile servis yap\\u0131n.\"]', 'Dilerseniz ufak ufak doğranmış kuru incir (incir aşurenin rengini koyulaştırdığı için biz pek kullanmıyoruz)', '', '2020-06-29 20:22:06', '2020-06-30 11:22:57');
INSERT INTO `tbl_recipes` VALUES (33, 'Lius', 0, 4, 1, 'A', 45, '[\"5efa01781bbc1.jpg\"]', 4, 0, '[\"1\",\"lius 1\",\"lius 2\",\"12\",\"5\",\"6\",\"7\",\"8\",\"9\",\"lius 3\",\"lius 4\"]', 'qwerty', '', '2020-06-29 20:28:00', '2020-06-30 08:11:55');
INSERT INTO `tbl_recipes` VALUES (34, 'Patatesli Erişte Çorbası', 0, 5, 5, 'A', 45, '[\"5efa0366548cc.jpg\"]', 6, 0, '[\"So\\u011fanlar\\u0131 zeytinya\\u011f\\u0131yla birlikte derin bir tencere koyun. Normal ate\\u015fte kavurun.\",\"Patatesi ve sal\\u00e7ay\\u0131 so\\u011fanlara ekleyin. Patatesler tencereye yap\\u0131\\u015fmaya ba\\u015flay\\u0131ncaya kadar kavurun.\",\"Kaynam\\u0131\\u015f suyu ekleyin. Patatesleri 10 dakika kadar pi\\u015firin. (patatesler ge\\u00e7 pi\\u015fti\\u011fi i\\u00e7in onlar\\u0131 \\u00f6nceden pi\\u015firmek gerekiyor\",\"Eri\\u015fteleri ve tuzu ekleyin. Kar\\u0131\\u015ft\\u0131r\\u0131p pi\\u015fmeye b\\u0131rak\\u0131n.\",\"Eri\\u015fteler pi\\u015fince \\u2013yakla\\u015f\\u0131k 10 dakika sonra- tencerenin alt\\u0131n\\u0131 kapat\\u0131p \\u00fczerine nane serperek servis yap\\u0131n.\",\"\\u00c7orban\\u0131n k\\u0131vam\\u0131 koyu olmu\\u015fsa biraz kaynam\\u0131\\u015f su ekleyin.\"]', 'İsterseniz bu çorbaya bir miktar kıyma veya 1 su bardağı et suyu da ekleyebilirsiniz.', '', '2020-06-29 20:36:14', NULL);
INSERT INTO `tbl_recipes` VALUES (35, 'Kış Sebzeleri Çorbası', 0, 5, 5, 'A', 45, '[\"5efa046bcf8c0.jpg\"]', 6, 0, '[\"\\u00f6nce t\\u00fcm sebzeleri y\\u0131kay\\u0131p k\\u00fc\\u00e7\\u00fck k\\u00fcpler halinde do\\u011fruyorsunuz.\",\"so\\u011fan\\u0131 ya\\u011fla hafif\\u00e7e kavurup unu ekliyorsunuz. bir iki kez kar\\u0131\\u015ft\\u0131r\\u0131p patates d\\u0131\\u015f\\u0131ndaki sebzeleri kat\\u0131yorsunuz.\",\"sebzeler hafif \\u00f6l\\u00fcnce kaynam\\u0131\\u015f suyu ilave ediyorsunuz. biraz yumu\\u015fad\\u0131klar\\u0131 zaman patatesi ve tuzu ekliyorsunuz. kaynay\\u0131nca el blend\\u0131r\\u0131ndan ge\\u00e7irip nane ile servis yap\\u0131yorsunuz\"]', 'Fotoğrafta mercimek çorbası gibi gözüken bu çorbanın içinde aslında kış sebzeleri çorbası için; lahana, pırasa, havuç ve patates var.', '', '2020-06-29 20:40:35', NULL);
INSERT INTO `tbl_recipes` VALUES (36, 'Patatesli Balkabağı Çorbası', 0, 5, 5, 'A', 45, '[\"5efa05801e7d5.jpeg\"]', 6, 0, '[\"\\u00f6nce sebzeleri k\\u00fcp k\\u00fcp do\\u011fray\\u0131p hepsi yumu\\u015fay\\u0131ncaya kadar ha\\u015fl\\u0131yorsunuz\",\"ha\\u015flan\\u0131nca blend\\u0131rla eziyor, bir defne yapra\\u011f\\u0131n\\u0131 ufalay\\u0131p i\\u00e7ine kat\\u0131yorsunuz\",\"\\u00e7orban\\u0131n bana g\\u00f6re s\\u0131rr\\u0131 tuzu ve karabiberinde. bildi\\u011finiz \\u00e7orbalardan daha tatl\\u0131 olaca\\u011f\\u0131 i\\u00e7in biraz daha fazla tuz eklemeniz, karabiberi de m\\u00fcmk\\u00fcnse taze olarak \\u00f6\\u011f\\u00fct\\u00fcp bolca koyman\\u0131z gerekiyor\"]', 'Patatesli Balkabağı Çorbası', '', '2020-06-29 20:45:12', NULL);
INSERT INTO `tbl_recipes` VALUES (37, 'Terbiyeli Sebze Çorbası', 0, 5, 5, 'A', 45, '[\"5efa0797ef616.jpg\"]', 6, 0, '[\"So\\u011fan\\u0131 ve sebzeleri soyun, y\\u0131kay\\u0131p do\\u011fray\\u0131n.\",\"Tereya\\u011f\\u0131n\\u0131 eritin. So\\u011fan\\u0131 ya\\u011fda pembele\\u015ftirin. Pembele\\u015fince sal\\u00e7alar\\u0131 ekleyip 1-2 kez kar\\u0131\\u015ft\\u0131r\\u0131n. Sebzeleri ilave edin, 3-4 dakika sonra unu ekleyin. Un ile bir s\\u00fcre kavurduktan sonra suyu ve tuzu ekleyin.\",\"Hafif ate\\u015fte sebzeler yumu\\u015fayana kadar pi\\u015firin.  Pi\\u015fince \\u00e7orbay\\u0131 blend\\u0131rdan ge\\u00e7irin.\",\"S\\u00fct\\u00fc ve yumurta sar\\u0131lar\\u0131n\\u0131 bir kapta \\u00e7\\u0131rp\\u0131n. \\u00c7orbadan bir kep\\u00e7e al\\u0131p devaml\\u0131 kar\\u0131\\u015ft\\u0131rarak s\\u00fcte ilave edin. Bu kar\\u0131\\u015f\\u0131m\\u0131 yava\\u015f yava\\u015f -kar\\u0131\\u015ft\\u0131rmaya devam ederek- \\u00e7orbaya ekleyin. E\\u011fer \\u00e7orban\\u0131n k\\u0131vam\\u0131 yo\\u011funsa azar azar kaynam\\u0131\\u015f su ekleyin.\"]', 'Tarifin aslı Yelda Sönmez\'in \"Anneannemin Mutfağı\" kitabına ait, ben bazı sebzeleri çıkartıp bazılarına da arttırdım, domates yerine de salça kullandım.', '', '2020-06-29 20:54:07', NULL);
INSERT INTO `tbl_recipes` VALUES (38, 'Çiftlik Evi Ekmeği', 0, 7, 5, 'A', 44, '[\"5efa0a0c55755.jpg\"]', 6, 0, '[\"Il\\u0131k suyu ekmek makinesinin haznesine d\\u00f6k\\u00fcn. Unlar\\u0131 suyun \\u00fczerini tamamen kapatacak \\u015fekilde serpin. S\\u00fct tozu ekleyin. Tuz, \\u015feker ve ya\\u011f\\u0131 kab\\u0131n farkl\\u0131 kenarlar\\u0131na yerle\\u015ftirin. Unun ortas\\u0131n\\u0131 hafif\\u00e7e a\\u00e7arak (suya ula\\u015fmayacak kadar) mayay\\u0131 d\\u00f6k\\u00fcn.\",\"Makineyi 1 numaral\\u0131 ayarda 3 saat pi\\u015fecek \\u015fekilde ayarlay\\u0131n. Pi\\u015fme s\\u00fcresinin ba\\u015flamas\\u0131na 10 dakika kala (toplam s\\u00fcrenin bitimine 1 saat + 10 dakika kala) makinenin kapa\\u011f\\u0131n\\u0131 a\\u00e7\\u0131n. Ekme\\u011fin \\u00fczerine f\\u0131r\\u00e7ayla su s\\u00fcr\\u00fcp biraz un serpin. Keskin bir b\\u0131\\u00e7akla diklemesine ekme\\u011fe bast\\u0131r\\u0131n.\",\"Program bitince kab\\u0131 makineden \\u00e7\\u0131kart\\u0131n. 10 dakika sonra ekme\\u011fi kaptan \\u00e7\\u0131kar\\u0131p telin \\u00fczerinde so\\u011futun.\"]', 'Ölçüler ekmek makinesinin su bardağı, yemek kaşığı ve çay kaşığına göredir.', '', '2020-06-29 21:04:36', '2020-06-29 21:05:31');
INSERT INTO `tbl_recipes` VALUES (39, 'Kereviz Çorbası', 0, 5, 5, 'A', 45, '[\"5efadf5e3bea6.jpg\"]', 6, 0, '[\"tencereye 3 su barda\\u011f\\u0131 suyu, patates, kereviz ve havucu koyup, kapa\\u011f\\u0131 kapal\\u0131 olarak kaynat\\u0131n.\",\"kaynad\\u0131ktan sonra ate\\u015fi hafifletin ve sebzeler iyici yumu\\u015fayana kadar pi\\u015firin. biraz so\\u011fuyunca blend\\u0131rdan ge\\u00e7irin, bir kenara koyun.\",\"ayr\\u0131 bir tavada ya\\u011f\\u0131 \\u0131s\\u0131t\\u0131n. unu ekleyin ve \\u00e7ok hafif pembele\\u015fince s\\u00fct\\u00fc azar azar kat\\u0131n.\",\"bu arada p\\u00fcre haline gelen sebzelere 1 litre kaynar suyu ekleyip biraz kaynat\\u0131n. kaynay\\u0131nca \\u00e7orbadan birka\\u00e7 ka\\u015f\\u0131k al\\u0131p un-s\\u00fct kar\\u0131\\u015f\\u0131m\\u0131na ekleyin.\",\"kar\\u0131\\u015f\\u0131m\\u0131 \\u00e7\\u0131rpma teli ile kar\\u0131\\u015ft\\u0131rar p\\u00fcr\\u00fczs\\u00fcz bir hal almas\\u0131n\\u0131 sa\\u011flay\\u0131n. kar\\u0131\\u015f\\u0131m\\u0131 kaynayan \\u00e7orban\\u0131n i\\u00e7ine h\\u0131zla kar\\u0131\\u015ft\\u0131rarak d\\u00f6k\\u00fcn. tuz, karabiber ve hindistan cevizini de ilave edip 4-5 dk. daha kaynat\\u0131n.\"]', 'kaynak; mevsimlerle gelen lezzetler, tijen inaltong', '', '2020-06-30 12:14:46', NULL);
INSERT INTO `tbl_recipes` VALUES (40, 'Kremalı Sebze Çorbası', 0, 5, 5, 'A', 45, '[\"5f11ded3d1110.jpg\",\"5efb148ebe958.jpg\"]', 6, 350, '[\"sucuklar\\u0131 k\\u00fc\\u00e7\\u00fck k\\u00fcplere b\\u00f6l\\u00fcn ve derin bir tencerede hafif renk de\\u011fi\\u015ftirene kadar k\\u0131zart\\u0131n. (2-3 dakika) tereya\\u011f\\u0131n\\u0131 ekleyip kar\\u0131\\u015ft\\u0131r\\u0131n. so\\u011fan\\u0131 ekleyin ve tencerenin kapa\\u011f\\u0131n\\u0131 kapat\\u0131p so\\u011fanlar yumu\\u015fayana kadar (3-4 dakika) bekleyin.\",\"p\\u0131rasalar\\u0131 ve patatesleri ekleyin. hepsini iyice kar\\u0131\\u015ft\\u0131r\\u0131p kapa\\u011f\\u0131 tekrar kapat\\u0131n. orta \\u0131s\\u0131da arada kar\\u0131\\u015ft\\u0131rarak yakla\\u015f\\u0131k 10 dakika pi\\u015firin.\",\"kaynar suyu tencereye ilave edin. bir iki ta\\u015f\\u0131m kaynat\\u0131p tuzu ekleyin. tencerenni kapa\\u011f\\u0131 kapal\\u0131 olarak d\\u00fc\\u015f\\u00fck \\u0131s\\u0131da yakla\\u015f\\u0131k 15-20 dakika (sebzeler yumu\\u015fayana kadar) pi\\u015firin.\",\"ate\\u015fi s\\u00f6nd\\u00fcr\\u00fcp 1-2 dakika bekleyin. \\u00e7orbay\\u0131 el blend\\u0131r\\u0131ndan ge\\u00e7irin. tekrar oca\\u011fa al\\u0131p 1-2 ta\\u015f\\u0131m kaynat\\u0131n ve kremay\\u0131 ilave edin. iyice kar\\u0131\\u015ft\\u0131r\\u0131p karabiber ekleyin. \\u00e7orbalar\\u0131 tabaklara al\\u0131p past\\u0131rma dilimleri ile servis yap\\u0131n.\"]', 'Tarif Pırasa ve Patates Çorbası olarak da bilinir.', '', '2020-06-30 16:01:42', '2020-07-17 22:54:35');
INSERT INTO `tbl_recipes` VALUES (41, 'Mercimek Çorbası', 0, 5, 5, 'A', 45, '[\"5f0da422788bc.jpeg\",\"5efb19c383c24.jpg\"]', 6, 600, '[\"1.\\tTencereye so\\u011fan\\u0131 ve ya\\u011f\\u0131 koyup kavurun. So\\u011fan pembele\\u015fince 1 ka\\u015f\\u0131k unu koyup birka\\u00e7 kere kar\\u0131\\u015ft\\u0131r\\u0131n.\",\"2.\\tSonra mercime\\u011fi ve soyup ku\\u015fba\\u015f\\u0131 do\\u011frad\\u0131\\u011f\\u0131n\\u0131z havucu ekleyip gene kar\\u0131\\u015ft\\u0131r\\u0131n. Tabletleri de ekledikten sonra suyu ilave edip havu\\u00e7 ve mercimekler iyice ezilene kadar pi\\u015firin.\",\"3.\\tPi\\u015fince tuzunu ekleyin ve \\u00e7orbay\\u0131 blend\\u0131rdan ge\\u00e7irin. Limonla birlikte \\u00e7ok lezzetli oluyor.\"]', 'Mercimek Çorbası', '', '2020-06-30 16:23:55', '2020-07-14 17:55:06');
INSERT INTO `tbl_recipes` VALUES (42, 'Naneli Şehriye Çorbası', 0, 5, 17, 'A', 45, '[\"5f06b434221dd.jpg\",\"5efb1d171469a.jpg\"]', 6, 3.3, '[\"\\u00e7orba i\\u00e7in \\u00f6nce 3 domatesi k\\u00fcp k\\u00fcp do\\u011fruyorsunuz.\",\"domatesleri tencereye koyup, 1,5 yemek ka\\u015f\\u0131\\u011f\\u0131 tereya\\u011f\\u0131 ekliyor ve domatesler iyice ezilene kadar pi\\u015firiyorsunuz. (domateslerin tamamen ezilmesi i\\u00e7in ezme aletini kullanabilirsiniz.)\",\"daha sonra 1 litre kaynam\\u0131\\u015f su ilave ediyor, 1-2 ta\\u015f\\u0131m da tencerede kaynat\\u0131p tencereye 1\\/2 nescafe fincan\\u0131 \\u015fehriyeyi ekliyorsunuz.\",\"\\u015fehriyeler pi\\u015fince tuzunu ilave ediyor ve servis yaparken kaselere nane serpiyorsunuz. ben 2-3 ekme\\u011fi k\\u0131zart\\u0131p servis yaparken \\u00e7orbalar\\u0131n yanlar\\u0131 koydum.\"]', 'Naneli Şehriye Çorbası', 'https://youtu.be/qjWcbiIzW1g', '2020-06-30 16:38:07', '2020-11-19 19:56:39');

-- ----------------------------
-- Table structure for tbl_site_config
-- ----------------------------
DROP TABLE IF EXISTS `tbl_site_config`;
CREATE TABLE `tbl_site_config`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `site_logo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `site_favicon` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `site_phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `site_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time_zone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `head_script` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `header_color` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `facebook_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `google_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `twitter_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `instagram_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `is_facebook_login` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N' COMMENT 'Y=Yes, N=No',
  `is_google_login` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N' COMMENT 'Y=Yes, N=No',
  `apikey` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `authdomain` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `databaseurl` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `storagebucket` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_site_config
-- ----------------------------
INSERT INTO `tbl_site_config` VALUES (1, 'portakalagaci', '5ee83eda30cc0_thumb.png', '5fb65c26a90b1.png', '0213456789', 'portakalagaci@greytomato.net', 'Asia/Kolkata', '', '#680303', '', '', '', '', 'Y', 'Y', 'AIzaSyDtb4BG4Ae4mKCFu1DJDf3LlyKXhOIyJFU', 'portakal-agaci.firebaseapp.com', 'https://portakal-agaci.firebaseio.com', 'portakal-agaci.appspot.com');

-- ----------------------------
-- Table structure for tbl_user
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` enum('A','C') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'C' COMMENT '\"A =admin,C=customer\"',
  `register_type` enum('GENERAL','SSO') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'GENERAL' COMMENT '\"GENERAL = General,SSO=single-sign-on\"',
  `firstname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lastname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` enum('A','I','EP') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'A' COMMENT '\"A=active ,I=inactive,EP=email pending\"',
  `profile_image` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `forgot_password_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `forgot_password_time` datetime(0) NULL DEFAULT NULL,
  `created_on` datetime(0) NULL DEFAULT NULL,
  `updated_on` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES (1, 'A', 'GENERAL', 'Lius', 'Lipindi', 'A', NULL, NULL, '0192023a7bbd73250516f069df18b500', 'lius@karyadigital.co.id', NULL, NULL, NULL, NULL);
INSERT INTO `tbl_user` VALUES (2, 'A', 'GENERAL', 'Goksal', 'Sahin', 'A', NULL, NULL, '0192023a7bbd73250516f069df18b500', 'goksal@karyadigital.co.id', NULL, NULL, NULL, NULL);
INSERT INTO `tbl_user` VALUES (3, 'A', 'GENERAL', 'Admin', 'Portakalagaci', 'A', NULL, NULL, '0192023a7bbd73250516f069df18b500', 'admin-portakalagaci@karyadigital.co.id', NULL, NULL, NULL, NULL);
INSERT INTO `tbl_user` VALUES (4, 'A', 'GENERAL', 'Zaenal', 'Zaenal', 'A', NULL, NULL, '0192023a7bbd73250516f069df18b500', 'zaenal@karyadigital.co.id', NULL, NULL, NULL, NULL);
INSERT INTO `tbl_user` VALUES (5, 'A', 'GENERAL', 'Ahmet', 'Morgul', 'A', NULL, NULL, '0192023a7bbd73250516f069df18b500', 'ahmet@karyadigital.co.id', NULL, NULL, NULL, NULL);
INSERT INTO `tbl_user` VALUES (6, 'C', 'SSO', 'Lius Lipindi', '', 'A', 'https://lh3.googleusercontent.com/a-/AOh14GigvKkQu2QMTHF6qP-tpy9GoJKJc-rW56t4Upsmgw', NULL, '', 'my3mail.lius@gmail.com', NULL, NULL, '2020-07-09 14:18:37', NULL);
INSERT INTO `tbl_user` VALUES (8, 'C', 'SSO', 'Lius LIus Lius', '', 'A', 'https://graph.facebook.com/3452700818086943/picture', NULL, '', 'my3mail_lius@ymail.com', NULL, NULL, '2020-07-21 11:14:32', NULL);
INSERT INTO `tbl_user` VALUES (12, 'C', 'GENERAL', 'Lius Lipindi', '', 'A', '', '', '2019e5a0b9701f69e2641b5f8a923caa', 'lius@greytomato.com', NULL, NULL, '2020-07-21 16:17:00', NULL);
INSERT INTO `tbl_user` VALUES (13, 'C', 'GENERAL', 'violet	', '', 'A', '', '', 'eb2465b0ead821c74f1504a64afdb068', 'violetfocus0618@gmail.com', NULL, NULL, '2020-10-22 11:13:37', NULL);
INSERT INTO `tbl_user` VALUES (14, 'C', 'SSO', 'Goksal', 'Sahin', 'A', '', '', '', 'goksal@gmail.com', NULL, NULL, '2020-10-22 11:25:35', '2020-10-22 14:13:07');
INSERT INTO `tbl_user` VALUES (16, 'C', 'SSO', 'cupidFirstname', 'gracer', 'A', NULL, '0123456789', 'f5bb0c8de146c67b44babbf4e6584cc0', 'cupidgracer@gmail.com', NULL, NULL, '2020-11-10 17:40:53', '2020-11-24 01:04:23');
INSERT INTO `tbl_user` VALUES (17, 'A', 'GENERAL', 'cupid', 'gracer', 'A', NULL, '01234567891', 'f5bb0c8de146c67b44babbf4e6584cc0', 'cupidadmin@gmail.com', NULL, NULL, '2020-11-10 17:40:57', '2020-11-17 01:15:59');
INSERT INTO `tbl_user` VALUES (18, 'C', 'GENERAL', 'cupid', 'c', 'I', NULL, 'N/A', 'f5bb0c8de146c67b44babbf4e6584cc0', 'cupid@gmail.com', NULL, NULL, '2020-11-19 21:32:30', '2020-11-23 09:32:08');

SET FOREIGN_KEY_CHECKS = 1;
