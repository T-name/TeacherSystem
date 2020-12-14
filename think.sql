/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : think

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 14/12/2020 20:02:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sy_class
-- ----------------------------
DROP TABLE IF EXISTS `sy_class`;
CREATE TABLE `sy_class`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `i_classid` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级id   后改char',
  `v_classname` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级名字',
  `i_headmasterid` char(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班主任id  后改char',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` int(11) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `i_classid`(`i_classid`) USING BTREE,
  UNIQUE INDEX `v_classname`(`v_classname`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '超级管理员带领班级' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sy_class
-- ----------------------------
INSERT INTO `sy_class` VALUES (1, '181260', '18计算机1班', '181260325', 1607836215, 1607836215);
INSERT INTO `sy_class` VALUES (2, '181261', '18计算机2班', '181260326', 1607836215, 1607836215);
INSERT INTO `sy_class` VALUES (3, '181262', '18计算机3班', '181260327', 1607836215, 1607836215);
INSERT INTO `sy_class` VALUES (4, '181263', '18计算机4班', '181260328', 1607836215, 1607836215);
INSERT INTO `sy_class` VALUES (5, '181264', '18计算机5班', '181260325', 1607836215, 1607836215);
INSERT INTO `sy_class` VALUES (6, '181265', '18计算机6班', '181260326', 1607836215, 1607836215);
INSERT INTO `sy_class` VALUES (7, '181266', '18计算机7班', '181260327', 1607836215, 1607836215);
INSERT INTO `sy_class` VALUES (8, '181267', '18计算机8班', '181260328', 1607836215, 1607836215);
INSERT INTO `sy_class` VALUES (9, '181268', '18计算机9班', '181260326', 1607836215, 1607836215);
INSERT INTO `sy_class` VALUES (10, '181269', '18计算机10班', '181260327', 1607836215, 1607836215);
INSERT INTO `sy_class` VALUES (11, '181270', '18计算机11班', '181260328', 1607836215, 1607836215);

-- ----------------------------
-- Table structure for sy_collect
-- ----------------------------
DROP TABLE IF EXISTS `sy_collect`;
CREATE TABLE `sy_collect`  (
  `id` int(24) UNSIGNED NOT NULL AUTO_INCREMENT,
  `v_number` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '编号',
  `v_teacer_id` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发起人id',
  `v_title` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '题目',
  `v_title_info` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '题目描述',
  `i_modify` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '是否允许修改 1 ：不允许 2：允许  后改char',
  `i_doc` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容 1:不允许文档，2：只允许文档 3：都允许 后改char',
  `v_classid` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '班级id 用于班级限制',
  `end_time` int(24) NOT NULL COMMENT '截止时间',
  `create_time` int(24) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `v_number`(`v_number`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sy_collect_work
-- ----------------------------
DROP TABLE IF EXISTS `sy_collect_work`;
CREATE TABLE `sy_collect_work`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `v_number` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '编号',
  `v_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名 改',
  `i_sid` char(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学号  后改char ',
  `v_note` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `v_content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容 json数据 0是文字 1是文件 ；原来是varchar类型，后来改text类型。',
  `create_time` int(24) NOT NULL COMMENT '添加时间',
  `update_time` int(24) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sy_curriculums
-- ----------------------------
DROP TABLE IF EXISTS `sy_curriculums`;
CREATE TABLE `sy_curriculums`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `teacher_id` char(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '任课老师ID',
  `curriculums` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '课表 json',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `teacher_id`(`teacher_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sy_group
-- ----------------------------
DROP TABLE IF EXISTS `sy_group`;
CREATE TABLE `sy_group`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `i_classid` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级id 后改char',
  `i_teacherid` char(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '老师id  后改char',
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `i_classid`(`i_classid`, `i_teacherid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '普通管理员带领班级' ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of sy_group
-- ----------------------------
INSERT INTO `sy_group` VALUES (1, '181260', '181260321', 1607836230, 1607836230);
INSERT INTO `sy_group` VALUES (2, '181261', '181260322', 1607836230, 1607836230);
INSERT INTO `sy_group` VALUES (3, '181262', '181260323', 1607836230, 1607836230);
INSERT INTO `sy_group` VALUES (4, '181263', '181260324', 1607836230, 1607836230);
INSERT INTO `sy_group` VALUES (5, '181264', '181260321', 1607836230, 1607836230);
INSERT INTO `sy_group` VALUES (6, '181265', '181260322', 1607836230, 1607836230);
INSERT INTO `sy_group` VALUES (7, '181266', '181260323', 1607836230, 1607836230);
INSERT INTO `sy_group` VALUES (8, '181267', '181260324', 1607836230, 1607836230);
INSERT INTO `sy_group` VALUES (9, '181268', '181260321', 1607836230, 1607836230);
INSERT INTO `sy_group` VALUES (10, '181269', '181260322', 1607836230, 1607836230);
INSERT INTO `sy_group` VALUES (11, '181270', '181260323', 1607836230, 1607836230);

-- ----------------------------
-- Table structure for sy_note
-- ----------------------------
DROP TABLE IF EXISTS `sy_note`;
CREATE TABLE `sy_note`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `v_order_number` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注单号',
  `i_sid` char(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学号 后改char',
  `v_note_info` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注信息',
  `create_time` int(11) UNSIGNED NOT NULL COMMENT '添备注加时间',
  `end_time` int(11) UNSIGNED NULL DEFAULT NULL COMMENT '备注信息有效结束时间',
  `i_create_id` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员添加账号  后改char',
  `delete_time` int(11) NULL DEFAULT NULL COMMENT '软删除',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `v_order_number`(`v_order_number`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sy_status
-- ----------------------------
DROP TABLE IF EXISTS `sy_status`;
CREATE TABLE `sy_status`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `i_sid` char(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学号 后改char',
  `c_status` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '状态',
  `c_checkid` char(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '签到人/签到教师',
  `c_note` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '签到备注',
  `create_time` int(11) NOT NULL COMMENT '签到时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sy_student
-- ----------------------------
DROP TABLE IF EXISTS `sy_student`;
CREATE TABLE `sy_student`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '索引id',
  `i_sid` char(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学号  后面改为char类型',
  `c_studentname` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `i_classid` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级id 后改char',
  `i_phone_number` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '手机号 后改char',
  `v_home_address` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '家庭地址',
  `i_parent_phone` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '父母联系方式 后改char',
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `i_sid`(`i_sid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 551 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sy_student
-- ----------------------------
INSERT INTO `sy_student` VALUES (1, '18126011', '胖虎1', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (2, '18126012', '胖虎2', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (3, '18126013', '胖虎3', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (4, '18126014', '胖虎4', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (5, '18126015', '胖虎5', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (6, '18126016', '胖虎6', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (7, '18126017', '胖虎7', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (8, '18126018', '胖虎8', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (9, '18126019', '胖虎9', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (10, '181260110', '胖虎10', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (11, '181260111', '胖虎11', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (12, '181260112', '胖虎12', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (13, '181260113', '胖虎13', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (14, '181260114', '胖虎14', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (15, '181260115', '胖虎15', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (16, '181260116', '胖虎16', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (17, '181260117', '胖虎17', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (18, '181260118', '胖虎18', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (19, '181260119', '胖虎19', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (20, '181260120', '胖虎20', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (21, '181260121', '胖虎21', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (22, '181260122', '胖虎22', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (23, '181260123', '胖虎23', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (24, '181260124', '胖虎24', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (25, '181260125', '胖虎25', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (26, '181260126', '胖虎26', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (27, '181260127', '胖虎27', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (28, '181260128', '胖虎28', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (29, '181260129', '胖虎29', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (30, '181260130', '胖虎30', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (31, '181260131', '胖虎31', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (32, '181260132', '胖虎32', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (33, '181260133', '胖虎33', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (34, '181260134', '胖虎34', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (35, '181260135', '胖虎35', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (36, '181260136', '胖虎36', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (37, '181260137', '胖虎37', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (38, '181260138', '胖虎38', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (39, '181260139', '胖虎39', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (40, '181260140', '胖虎40', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (41, '181260141', '胖虎41', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (42, '181260142', '胖虎42', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (43, '181260143', '胖虎43', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (44, '181260144', '胖虎44', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (45, '181260145', '胖虎45', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (46, '181260146', '胖虎46', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (47, '181260147', '胖虎47', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (48, '181260148', '胖虎48', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (49, '181260149', '胖虎49', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (50, '181260150', '胖虎50', '181260', '', '江西省', '', 1607836835, 1607836835);
INSERT INTO `sy_student` VALUES (51, '18126021', '彭于晏1', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (52, '18126022', '彭于晏2', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (53, '18126023', '彭于晏3', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (54, '18126024', '彭于晏4', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (55, '18126025', '彭于晏5', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (56, '18126026', '彭于晏6', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (57, '18126027', '彭于晏7', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (58, '18126028', '彭于晏8', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (59, '18126029', '彭于晏9', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (60, '181260210', '彭于晏10', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (61, '181260211', '彭于晏11', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (62, '181260212', '彭于晏12', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (63, '181260213', '彭于晏13', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (64, '181260214', '彭于晏14', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (65, '181260215', '彭于晏15', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (66, '181260216', '彭于晏16', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (67, '181260217', '彭于晏17', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (68, '181260218', '彭于晏18', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (69, '181260219', '彭于晏19', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (70, '181260220', '彭于晏20', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (71, '181260221', '彭于晏21', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (72, '181260222', '彭于晏22', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (73, '181260223', '彭于晏23', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (74, '181260224', '彭于晏24', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (75, '181260225', '彭于晏25', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (76, '181260226', '彭于晏26', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (77, '181260227', '彭于晏27', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (78, '181260228', '彭于晏28', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (79, '181260229', '彭于晏29', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (80, '181260230', '彭于晏30', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (81, '181260231', '彭于晏31', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (82, '181260232', '彭于晏32', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (83, '181260233', '彭于晏33', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (84, '181260234', '彭于晏34', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (85, '181260235', '彭于晏35', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (86, '181260236', '彭于晏36', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (87, '181260237', '彭于晏37', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (88, '181260238', '彭于晏38', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (89, '181260239', '彭于晏39', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (90, '181260240', '彭于晏40', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (91, '181260241', '彭于晏41', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (92, '181260242', '彭于晏42', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (93, '181260243', '彭于晏43', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (94, '181260244', '彭于晏44', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (95, '181260245', '彭于晏45', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (96, '181260246', '彭于晏46', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (97, '181260247', '彭于晏47', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (98, '181260248', '彭于晏48', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (99, '181260249', '彭于晏49', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (100, '181260250', '彭于晏50', '181261', '', '江西省', '', 1607836871, 1607836871);
INSERT INTO `sy_student` VALUES (101, '18126031', '吴彦祖1', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (102, '18126032', '吴彦祖2', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (103, '18126033', '吴彦祖3', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (104, '18126034', '吴彦祖4', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (105, '18126035', '吴彦祖5', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (106, '18126036', '吴彦祖6', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (107, '18126037', '吴彦祖7', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (108, '18126038', '吴彦祖8', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (109, '18126039', '吴彦祖9', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (110, '181260310', '吴彦祖10', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (111, '181260311', '吴彦祖11', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (112, '181260312', '吴彦祖12', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (113, '181260313', '吴彦祖13', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (114, '181260314', '吴彦祖14', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (115, '181260315', '吴彦祖15', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (116, '181260316', '吴彦祖16', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (117, '181260317', '吴彦祖17', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (118, '181260318', '吴彦祖18', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (119, '181260319', '吴彦祖19', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (120, '181260320', '吴彦祖20', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (121, '181260321', '吴彦祖21', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (122, '181260322', '吴彦祖22', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (123, '181260323', '吴彦祖23', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (124, '181260324', '吴彦祖24', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (125, '181260325', '吴彦祖25', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (126, '181260326', '吴彦祖26', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (127, '181260327', '吴彦祖27', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (128, '181260328', '吴彦祖28', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (129, '181260329', '吴彦祖29', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (130, '181260330', '吴彦祖30', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (131, '181260331', '吴彦祖31', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (132, '181260332', '吴彦祖32', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (133, '181260333', '吴彦祖33', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (134, '181260334', '吴彦祖34', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (135, '181260335', '吴彦祖35', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (136, '181260336', '吴彦祖36', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (137, '181260337', '吴彦祖37', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (138, '181260338', '吴彦祖38', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (139, '181260339', '吴彦祖39', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (140, '181260340', '吴彦祖40', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (141, '181260341', '吴彦祖41', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (142, '181260342', '吴彦祖42', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (143, '181260343', '吴彦祖43', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (144, '181260344', '吴彦祖44', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (145, '181260345', '吴彦祖45', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (146, '181260346', '吴彦祖46', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (147, '181260347', '吴彦祖47', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (148, '181260348', '吴彦祖48', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (149, '181260349', '吴彦祖49', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (150, '181260350', '吴彦祖50', '181262', '', '江西省', '', 1607836891, 1607836891);
INSERT INTO `sy_student` VALUES (151, '18126041', '迪迦1', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (152, '18126042', '迪迦2', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (153, '18126043', '迪迦3', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (154, '18126044', '迪迦4', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (155, '18126045', '迪迦5', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (156, '18126046', '迪迦6', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (157, '18126047', '迪迦7', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (158, '18126048', '迪迦8', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (159, '18126049', '迪迦9', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (160, '181260410', '迪迦10', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (161, '181260411', '迪迦11', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (162, '181260412', '迪迦12', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (163, '181260413', '迪迦13', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (164, '181260414', '迪迦14', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (165, '181260415', '迪迦15', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (166, '181260416', '迪迦16', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (167, '181260417', '迪迦17', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (168, '181260418', '迪迦18', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (169, '181260419', '迪迦19', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (170, '181260420', '迪迦20', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (171, '181260421', '迪迦21', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (172, '181260422', '迪迦22', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (173, '181260423', '迪迦23', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (174, '181260424', '迪迦24', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (175, '181260425', '迪迦25', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (176, '181260426', '迪迦26', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (177, '181260427', '迪迦27', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (178, '181260428', '迪迦28', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (179, '181260429', '迪迦29', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (180, '181260430', '迪迦30', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (181, '181260431', '迪迦31', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (182, '181260432', '迪迦32', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (183, '181260433', '迪迦33', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (184, '181260434', '迪迦34', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (185, '181260435', '迪迦35', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (186, '181260436', '迪迦36', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (187, '181260437', '迪迦37', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (188, '181260438', '迪迦38', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (189, '181260439', '迪迦39', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (190, '181260440', '迪迦40', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (191, '181260441', '迪迦41', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (192, '181260442', '迪迦42', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (193, '181260443', '迪迦43', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (194, '181260444', '迪迦44', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (195, '181260445', '迪迦45', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (196, '181260446', '迪迦46', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (197, '181260447', '迪迦47', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (198, '181260448', '迪迦48', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (199, '181260449', '迪迦49', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (200, '181260450', '迪迦50', '181263', '', '江西省', '', 1607836925, 1607836925);
INSERT INTO `sy_student` VALUES (201, '18126051', '金角大王1', '181264', '', '江西省', '', 1607837030, 1607837030);
INSERT INTO `sy_student` VALUES (202, '18126052', '金角大王2', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (203, '18126053', '金角大王3', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (204, '18126054', '金角大王4', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (205, '18126055', '金角大王5', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (206, '18126056', '金角大王6', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (207, '18126057', '金角大王7', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (208, '18126058', '金角大王8', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (209, '18126059', '金角大王9', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (210, '181260510', '金角大王10', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (211, '181260511', '金角大王11', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (212, '181260512', '金角大王12', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (213, '181260513', '金角大王13', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (214, '181260514', '金角大王14', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (215, '181260515', '金角大王15', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (216, '181260516', '金角大王16', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (217, '181260517', '金角大王17', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (218, '181260518', '金角大王18', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (219, '181260519', '金角大王19', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (220, '181260520', '金角大王20', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (221, '181260521', '金角大王21', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (222, '181260522', '金角大王22', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (223, '181260523', '金角大王23', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (224, '181260524', '金角大王24', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (225, '181260525', '金角大王25', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (226, '181260526', '金角大王26', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (227, '181260527', '金角大王27', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (228, '181260528', '金角大王28', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (229, '181260529', '金角大王29', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (230, '181260530', '金角大王30', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (231, '181260531', '金角大王31', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (232, '181260532', '金角大王32', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (233, '181260533', '金角大王33', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (234, '181260534', '金角大王34', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (235, '181260535', '金角大王35', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (236, '181260536', '金角大王36', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (237, '181260537', '金角大王37', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (238, '181260538', '金角大王38', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (239, '181260539', '金角大王39', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (240, '181260540', '金角大王40', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (241, '181260541', '金角大王41', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (242, '181260542', '金角大王42', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (243, '181260543', '金角大王43', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (244, '181260544', '金角大王44', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (245, '181260545', '金角大王45', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (246, '181260546', '金角大王46', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (247, '181260547', '金角大王47', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (248, '181260548', '金角大王48', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (249, '181260549', '金角大王49', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (250, '181260550', '金角大王50', '181264', '', '江西省', '', 1607837031, 1607837031);
INSERT INTO `sy_student` VALUES (251, '18126061', '蟹老板1', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (252, '18126062', '蟹老板2', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (253, '18126063', '蟹老板3', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (254, '18126064', '蟹老板4', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (255, '18126065', '蟹老板5', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (256, '18126066', '蟹老板6', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (257, '18126067', '蟹老板7', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (258, '18126068', '蟹老板8', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (259, '18126069', '蟹老板9', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (260, '181260610', '蟹老板10', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (261, '181260611', '蟹老板11', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (262, '181260612', '蟹老板12', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (263, '181260613', '蟹老板13', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (264, '181260614', '蟹老板14', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (265, '181260615', '蟹老板15', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (266, '181260616', '蟹老板16', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (267, '181260617', '蟹老板17', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (268, '181260618', '蟹老板18', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (269, '181260619', '蟹老板19', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (270, '181260620', '蟹老板20', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (271, '181260621', '蟹老板21', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (272, '181260622', '蟹老板22', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (273, '181260623', '蟹老板23', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (274, '181260624', '蟹老板24', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (275, '181260625', '蟹老板25', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (276, '181260626', '蟹老板26', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (277, '181260627', '蟹老板27', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (278, '181260628', '蟹老板28', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (279, '181260629', '蟹老板29', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (280, '181260630', '蟹老板30', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (281, '181260631', '蟹老板31', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (282, '181260632', '蟹老板32', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (283, '181260633', '蟹老板33', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (284, '181260634', '蟹老板34', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (285, '181260635', '蟹老板35', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (286, '181260636', '蟹老板36', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (287, '181260637', '蟹老板37', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (288, '181260638', '蟹老板38', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (289, '181260639', '蟹老板39', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (290, '181260640', '蟹老板40', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (291, '181260641', '蟹老板41', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (292, '181260642', '蟹老板42', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (293, '181260643', '蟹老板43', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (294, '181260644', '蟹老板44', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (295, '181260645', '蟹老板45', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (296, '181260646', '蟹老板46', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (297, '181260647', '蟹老板47', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (298, '181260648', '蟹老板48', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (299, '181260649', '蟹老板49', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (300, '181260650', '蟹老板50', '181265', '', '江西省', '', 1607837087, 1607837087);
INSERT INTO `sy_student` VALUES (301, '18126071', '痞老班1', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (302, '18126072', '痞老班2', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (303, '18126073', '痞老班3', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (304, '18126074', '痞老班4', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (305, '18126075', '痞老班5', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (306, '18126076', '痞老班6', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (307, '18126077', '痞老班7', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (308, '18126078', '痞老班8', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (309, '18126079', '痞老班9', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (310, '181260710', '痞老班10', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (311, '181260711', '痞老班11', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (312, '181260712', '痞老班12', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (313, '181260713', '痞老班13', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (314, '181260714', '痞老班14', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (315, '181260715', '痞老班15', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (316, '181260716', '痞老班16', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (317, '181260717', '痞老班17', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (318, '181260718', '痞老班18', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (319, '181260719', '痞老班19', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (320, '181260720', '痞老班20', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (321, '181260721', '痞老班21', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (322, '181260722', '痞老班22', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (323, '181260723', '痞老班23', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (324, '181260724', '痞老班24', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (325, '181260725', '痞老班25', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (326, '181260726', '痞老班26', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (327, '181260727', '痞老班27', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (328, '181260728', '痞老班28', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (329, '181260729', '痞老班29', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (330, '181260730', '痞老班30', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (331, '181260731', '痞老班31', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (332, '181260732', '痞老班32', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (333, '181260733', '痞老班33', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (334, '181260734', '痞老班34', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (335, '181260735', '痞老班35', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (336, '181260736', '痞老班36', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (337, '181260737', '痞老班37', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (338, '181260738', '痞老班38', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (339, '181260739', '痞老班39', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (340, '181260740', '痞老班40', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (341, '181260741', '痞老班41', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (342, '181260742', '痞老班42', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (343, '181260743', '痞老班43', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (344, '181260744', '痞老班44', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (345, '181260745', '痞老班45', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (346, '181260746', '痞老班46', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (347, '181260747', '痞老班47', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (348, '181260748', '痞老班48', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (349, '181260749', '痞老班49', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (350, '181260750', '痞老班50', '181266', '', '江西省', '', 1607837120, 1607837120);
INSERT INTO `sy_student` VALUES (351, '18126081', '奥巴马1', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (352, '18126082', '奥巴马2', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (353, '18126083', '奥巴马3', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (354, '18126084', '奥巴马4', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (355, '18126085', '奥巴马5', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (356, '18126086', '奥巴马6', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (357, '18126087', '奥巴马7', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (358, '18126088', '奥巴马8', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (359, '18126089', '奥巴马9', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (360, '181260810', '奥巴马10', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (361, '181260811', '奥巴马11', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (362, '181260812', '奥巴马12', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (363, '181260813', '奥巴马13', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (364, '181260814', '奥巴马14', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (365, '181260815', '奥巴马15', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (366, '181260816', '奥巴马16', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (367, '181260817', '奥巴马17', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (368, '181260818', '奥巴马18', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (369, '181260819', '奥巴马19', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (370, '181260820', '奥巴马20', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (371, '181260821', '奥巴马21', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (372, '181260822', '奥巴马22', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (373, '181260823', '奥巴马23', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (374, '181260824', '奥巴马24', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (375, '181260825', '奥巴马25', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (376, '181260826', '奥巴马26', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (377, '181260827', '奥巴马27', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (378, '181260828', '奥巴马28', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (379, '181260829', '奥巴马29', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (380, '181260830', '奥巴马30', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (381, '181260831', '奥巴马31', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (382, '181260832', '奥巴马32', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (383, '181260833', '奥巴马33', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (384, '181260834', '奥巴马34', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (385, '181260835', '奥巴马35', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (386, '181260836', '奥巴马36', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (387, '181260837', '奥巴马37', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (388, '181260838', '奥巴马38', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (389, '181260839', '奥巴马39', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (390, '181260840', '奥巴马40', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (391, '181260841', '奥巴马41', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (392, '181260842', '奥巴马42', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (393, '181260843', '奥巴马43', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (394, '181260844', '奥巴马44', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (395, '181260845', '奥巴马45', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (396, '181260846', '奥巴马46', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (397, '181260847', '奥巴马47', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (398, '181260848', '奥巴马48', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (399, '181260849', '奥巴马49', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (400, '181260850', '奥巴马50', '181267', '', '江西省', '', 1607837147, 1607837147);
INSERT INTO `sy_student` VALUES (401, '18126091', '老王1', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (402, '18126092', '老王2', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (403, '18126093', '老王3', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (404, '18126094', '老王4', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (405, '18126095', '老王5', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (406, '18126096', '老王6', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (407, '18126097', '老王7', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (408, '18126098', '老王8', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (409, '18126099', '老王9', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (410, '181260910', '老王10', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (411, '181260911', '老王11', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (412, '181260912', '老王12', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (413, '181260913', '老王13', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (414, '181260914', '老王14', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (415, '181260915', '老王15', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (416, '181260916', '老王16', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (417, '181260917', '老王17', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (418, '181260918', '老王18', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (419, '181260919', '老王19', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (420, '181260920', '老王20', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (421, '181260921', '老王21', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (422, '181260922', '老王22', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (423, '181260923', '老王23', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (424, '181260924', '老王24', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (425, '181260925', '老王25', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (426, '181260926', '老王26', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (427, '181260927', '老王27', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (428, '181260928', '老王28', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (429, '181260929', '老王29', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (430, '181260930', '老王30', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (431, '181260931', '老王31', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (432, '181260932', '老王32', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (433, '181260933', '老王33', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (434, '181260934', '老王34', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (435, '181260935', '老王35', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (436, '181260936', '老王36', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (437, '181260937', '老王37', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (438, '181260938', '老王38', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (439, '181260939', '老王39', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (440, '181260940', '老王40', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (441, '181260941', '老王41', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (442, '181260942', '老王42', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (443, '181260943', '老王43', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (444, '181260944', '老王44', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (445, '181260945', '老王45', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (446, '181260946', '老王46', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (447, '181260947', '老王47', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (448, '181260948', '老王48', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (449, '181260949', '老王49', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (450, '181260950', '老王50', '181268', '', '江西省', '', 1607837199, 1607837199);
INSERT INTO `sy_student` VALUES (451, '181260101', '张无忌1', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (452, '181260102', '张无忌2', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (453, '181260103', '张无忌3', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (454, '181260104', '张无忌4', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (455, '181260105', '张无忌5', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (456, '181260106', '张无忌6', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (457, '181260107', '张无忌7', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (458, '181260108', '张无忌8', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (459, '181260109', '张无忌9', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (460, '1812601010', '张无忌10', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (461, '1812601011', '张无忌11', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (462, '1812601012', '张无忌12', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (463, '1812601013', '张无忌13', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (464, '1812601014', '张无忌14', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (465, '1812601015', '张无忌15', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (466, '1812601016', '张无忌16', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (467, '1812601017', '张无忌17', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (468, '1812601018', '张无忌18', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (469, '1812601019', '张无忌19', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (470, '1812601020', '张无忌20', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (471, '1812601021', '张无忌21', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (472, '1812601022', '张无忌22', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (473, '1812601023', '张无忌23', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (474, '1812601024', '张无忌24', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (475, '1812601025', '张无忌25', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (476, '1812601026', '张无忌26', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (477, '1812601027', '张无忌27', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (478, '1812601028', '张无忌28', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (479, '1812601029', '张无忌29', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (480, '1812601030', '张无忌30', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (481, '1812601031', '张无忌31', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (482, '1812601032', '张无忌32', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (483, '1812601033', '张无忌33', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (484, '1812601034', '张无忌34', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (485, '1812601035', '张无忌35', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (486, '1812601036', '张无忌36', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (487, '1812601037', '张无忌37', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (488, '1812601038', '张无忌38', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (489, '1812601039', '张无忌39', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (490, '1812601040', '张无忌40', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (491, '1812601041', '张无忌41', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (492, '1812601042', '张无忌42', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (493, '1812601043', '张无忌43', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (494, '1812601044', '张无忌44', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (495, '1812601045', '张无忌45', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (496, '1812601046', '张无忌46', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (497, '1812601047', '张无忌47', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (498, '1812601048', '张无忌48', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (499, '1812601049', '张无忌49', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (500, '1812601050', '张无忌50', '181269', '', '江西省', '', 1607837239, 1607837239);
INSERT INTO `sy_student` VALUES (501, '1812601111', '武大郎1', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (502, '1812601112', '武大郎2', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (503, '1812601113', '武大郎3', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (504, '1812601114', '武大郎4', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (505, '1812601115', '武大郎5', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (506, '1812601116', '武大郎6', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (507, '1812601117', '武大郎7', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (508, '1812601118', '武大郎8', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (509, '1812601119', '武大郎9', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (510, '18126011110', '武大郎10', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (511, '18126011111', '武大郎11', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (512, '18126011112', '武大郎12', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (513, '18126011113', '武大郎13', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (514, '18126011114', '武大郎14', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (515, '18126011115', '武大郎15', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (516, '18126011116', '武大郎16', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (517, '18126011117', '武大郎17', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (518, '18126011118', '武大郎18', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (519, '18126011119', '武大郎19', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (520, '18126011120', '武大郎20', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (521, '18126011121', '武大郎21', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (522, '18126011122', '武大郎22', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (523, '18126011123', '武大郎23', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (524, '18126011124', '武大郎24', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (525, '18126011125', '武大郎25', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (526, '18126011126', '武大郎26', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (527, '18126011127', '武大郎27', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (528, '18126011128', '武大郎28', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (529, '18126011129', '武大郎29', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (530, '18126011130', '武大郎30', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (531, '18126011131', '武大郎31', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (532, '18126011132', '武大郎32', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (533, '18126011133', '武大郎33', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (534, '18126011134', '武大郎34', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (535, '18126011135', '武大郎35', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (536, '18126011136', '武大郎36', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (537, '18126011137', '武大郎37', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (538, '18126011138', '武大郎38', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (539, '18126011139', '武大郎39', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (540, '18126011140', '武大郎40', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (541, '18126011141', '武大郎41', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (542, '18126011142', '武大郎42', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (543, '18126011143', '武大郎43', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (544, '18126011144', '武大郎44', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (545, '18126011145', '武大郎45', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (546, '18126011146', '武大郎46', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (547, '18126011147', '武大郎47', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (548, '18126011148', '武大郎48', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (549, '18126011149', '武大郎49', '1812610', '', '江西省', '', 1607837287, 1607837287);
INSERT INTO `sy_student` VALUES (550, '18126011150', '武大郎50', '1812610', '', '江西省', '', 1607837287, 1607837287);

-- ----------------------------
-- Table structure for sy_student_delete
-- ----------------------------
DROP TABLE IF EXISTS `sy_student_delete`;
CREATE TABLE `sy_student_delete`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `i_sid` char(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学号',
  `c_studentname` char(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名字',
  `i_classid` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班级id',
  `i_phone_number` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '手机号',
  `v_home_address` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '家庭地址',
  `i_parent_phone` char(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '父母联系方式 后改char',
  `create_time` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `i_sid`(`i_sid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for sy_teacher
-- ----------------------------
DROP TABLE IF EXISTS `sy_teacher`;
CREATE TABLE `sy_teacher`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `i_headmasterid` char(24) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班主任id/管理员登录账号  后改char',
  `v_headmastername` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '班主任名字',
  `v_password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '管理员登录密码',
  `i_state` char(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '管理员状态 0普通管理员/1超级管理员',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '添加时间',
  `update_time` int(11) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `i_headmasterid`(`i_headmasterid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sy_teacher
-- ----------------------------
INSERT INTO `sy_teacher` VALUES (1, '181260321', '小嵩', '14e1b600b1fd579f47433b88e8d85291', '0', 1607836203, 1607836203);
INSERT INTO `sy_teacher` VALUES (2, '181260322', '吴彦祖', '14e1b600b1fd579f47433b88e8d85291', '0', 1607836203, 1607836203);
INSERT INTO `sy_teacher` VALUES (3, '181260323', '彭于晏', '14e1b600b1fd579f47433b88e8d85291', '0', 1607836203, 1607836203);
INSERT INTO `sy_teacher` VALUES (4, '181260324', '李世民', '14e1b600b1fd579f47433b88e8d85291', '0', 1607836203, 1607836203);
INSERT INTO `sy_teacher` VALUES (5, '181260325', '赵四', '14e1b600b1fd579f47433b88e8d85291', '1', 1607836203, 1607836203);
INSERT INTO `sy_teacher` VALUES (6, '181260326', '马什么梅', '14e1b600b1fd579f47433b88e8d85291', '1', 1607836203, 1607836203);
INSERT INTO `sy_teacher` VALUES (7, '181260327', '海绵宝宝', '14e1b600b1fd579f47433b88e8d85291', '1', 1607836203, 1607836203);
INSERT INTO `sy_teacher` VALUES (8, '181260328', '刘德华', '14e1b600b1fd579f47433b88e8d85291', '1', 1607836203, 1607836203);

SET FOREIGN_KEY_CHECKS = 1;
