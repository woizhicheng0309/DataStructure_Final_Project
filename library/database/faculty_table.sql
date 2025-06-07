-- 教師資料表結構
-- 這個SQL檔案用於創建教師相關的資料表

-- 創建教師基本資料表
CREATE TABLE IF NOT EXISTS `faculty_members` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `faculty_id` VARCHAR(50) NOT NULL UNIQUE COMMENT '教師編號',
    `name` VARCHAR(100) NOT NULL COMMENT '姓名',
    `name_en` VARCHAR(100) DEFAULT NULL COMMENT '英文姓名',
    `category` ENUM('系主任', '榮譽特聘講座', '講座教授', '特約講座', '特聘教授', '專任教師', '兼任教師', '退休老師') NOT NULL COMMENT '教師類別',
    `extension` VARCHAR(20) DEFAULT NULL COMMENT '分機號碼',
    `email` VARCHAR(100) DEFAULT NULL COMMENT '電子郵件',
    `office` VARCHAR(100) DEFAULT NULL COMMENT '辦公室位置',
    `photo` VARCHAR(255) DEFAULT 'assets/img/faculty/default.jpg' COMMENT '照片路徑',
    `research_interests` TEXT DEFAULT NULL COMMENT '研究興趣',
    `personal_website` VARCHAR(255) DEFAULT NULL COMMENT '個人網站',
    `status` ENUM('active', 'inactive') DEFAULT 'active' COMMENT '狀態',
    `display_order` INT(11) DEFAULT 0 COMMENT '顯示順序',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_category` (`category`),
    KEY `idx_status` (`status`),
    KEY `idx_display_order` (`display_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='教師基本資料表';

-- 創建教師專長表
CREATE TABLE IF NOT EXISTS `faculty_specialties` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `faculty_id` VARCHAR(50) NOT NULL COMMENT '教師編號',
    `specialty` VARCHAR(100) NOT NULL COMMENT '專長領域',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_faculty_id` (`faculty_id`),
    FOREIGN KEY (`faculty_id`) REFERENCES `faculty_members`(`faculty_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='教師專長表';

-- 創建教師學歷表
CREATE TABLE IF NOT EXISTS `faculty_education` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `faculty_id` VARCHAR(50) NOT NULL COMMENT '教師編號',
    `degree` VARCHAR(50) NOT NULL COMMENT '學位',
    `major` VARCHAR(100) NOT NULL COMMENT '主修',
    `school` VARCHAR(200) NOT NULL COMMENT '學校',
    `year` YEAR DEFAULT NULL COMMENT '畢業年份',
    `display_order` INT(11) DEFAULT 0 COMMENT '顯示順序',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_faculty_id` (`faculty_id`),
    FOREIGN KEY (`faculty_id`) REFERENCES `faculty_members`(`faculty_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='教師學歷表';

-- 創建教師經歷表
CREATE TABLE IF NOT EXISTS `faculty_experience` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `faculty_id` VARCHAR(50) NOT NULL COMMENT '教師編號',
    `position` VARCHAR(200) NOT NULL COMMENT '職位',
    `organization` VARCHAR(200) NOT NULL COMMENT '機構',
    `start_year` YEAR DEFAULT NULL COMMENT '開始年份',
    `end_year` YEAR DEFAULT NULL COMMENT '結束年份',
    `is_current` BOOLEAN DEFAULT FALSE COMMENT '是否為目前職位',
    `display_order` INT(11) DEFAULT 0 COMMENT '顯示順序',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_faculty_id` (`faculty_id`),
    FOREIGN KEY (`faculty_id`) REFERENCES `faculty_members`(`faculty_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='教師經歷表';

-- 創建教師授課表
CREATE TABLE IF NOT EXISTS `faculty_courses` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `faculty_id` VARCHAR(50) NOT NULL COMMENT '教師編號',
    `course_name` VARCHAR(200) NOT NULL COMMENT '課程名稱',
    `course_code` VARCHAR(50) DEFAULT NULL COMMENT '課程代碼',
    `semester` VARCHAR(20) DEFAULT NULL COMMENT '學期',
    `year` YEAR DEFAULT NULL COMMENT '年度',
    `is_current` BOOLEAN DEFAULT TRUE COMMENT '是否為目前開課',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_faculty_id` (`faculty_id`),
    FOREIGN KEY (`faculty_id`) REFERENCES `faculty_members`(`faculty_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='教師授課表';

-- 創建教師著作表
CREATE TABLE IF NOT EXISTS `faculty_publications` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `faculty_id` VARCHAR(50) NOT NULL COMMENT '教師編號',
    `title` TEXT NOT NULL COMMENT '論文標題',
    `authors` TEXT DEFAULT NULL COMMENT '作者',
    `journal` VARCHAR(200) DEFAULT NULL COMMENT '期刊名稱',
    `conference` VARCHAR(200) DEFAULT NULL COMMENT '會議名稱',
    `year` YEAR DEFAULT NULL COMMENT '發表年份',
    `volume` VARCHAR(50) DEFAULT NULL COMMENT '卷號',
    `pages` VARCHAR(50) DEFAULT NULL COMMENT '頁數',
    `type` ENUM('journal', 'conference', 'book', 'other') DEFAULT 'journal' COMMENT '類型',
    `display_order` INT(11) DEFAULT 0 COMMENT '顯示順序',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_faculty_id` (`faculty_id`),
    KEY `idx_type` (`type`),
    FOREIGN KEY (`faculty_id`) REFERENCES `faculty_members`(`faculty_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='教師著作表';

-- 創建教師獲獎表
CREATE TABLE IF NOT EXISTS `faculty_awards` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `faculty_id` VARCHAR(50) NOT NULL COMMENT '教師編號',
    `award_name` VARCHAR(200) NOT NULL COMMENT '獎項名稱',
    `organization` VARCHAR(200) DEFAULT NULL COMMENT '頒獎機構',
    `year` YEAR DEFAULT NULL COMMENT '獲獎年份',
    `description` TEXT DEFAULT NULL COMMENT '獎項描述',
    `display_order` INT(11) DEFAULT 0 COMMENT '顯示順序',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_faculty_id` (`faculty_id`),
    FOREIGN KEY (`faculty_id`) REFERENCES `faculty_members`(`faculty_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='教師獲獎表';

-- 插入測試資料
INSERT INTO `faculty_members` (`faculty_id`, `name`, `name_en`, `category`, `extension`, `email`, `office`, `research_interests`) VALUES
('zhang_san', '張三', 'Zhang San', '系主任', '2001', 'zhang@fcu.edu.tw', '資電館 501', '主要研究領域包括機器學習、深度學習、資料探勘、人工智慧應用等。'),
('li_si', '李四', 'Li Si', '榮譽特聘講座', '2002', 'li@fcu.edu.tw', '資電館 502', '專精於軟體工程、系統設計與軟體品質保證。'),
('wang_wu', '王五', 'Wang Wu', '講座教授', '2003', 'wang@fcu.edu.tw', '資電館 503', '研究重點在計算機網路、資訊安全與網路協定設計。'),
('zhao_liu', '趙六', 'Zhao Liu', '特約講座', '2004', 'zhao@fcu.edu.tw', '資電館 504', '致力於大資料分析、雲端運算與分散式系統研究。'),
('sun_qi', '孫七', 'Sun Qi', '特聘教授', '2005', 'sun@fcu.edu.tw', '資電館 505', '專長領域包括影像處理、電腦視覺與多媒體技術。'),
('zhou_ba', '周八', 'Zhou Ba', '專任教師', '2006', 'zhou@fcu.edu.tw', '資電館 506', '主要研究演算法設計與分析、資料結構最佳化。'),
('wu_jiu', '吳九', 'Wu Jiu', '專任教師', '2007', 'wu@fcu.edu.tw', '資電館 507', '專精於網頁開發、資料庫系統與Web技術應用。'),
('zheng_shi', '鄭十', 'Zheng Shi', '兼任教師', '2008', 'zheng@fcu.edu.tw', '資電館 508', '專長於行動裝置開發、UI/UX設計與使用者體驗研究。'),
('chen_shiyi', '陳十一', 'Chen Shiyi', '退休老師', '-', 'chen@fcu.edu.tw', '-', '理論計算機科學、離散數學與演算法理論。');

-- 插入專長資料
INSERT INTO `faculty_specialties` (`faculty_id`, `specialty`) VALUES
('zhang_san', '資料科學'), ('zhang_san', '機器學習'), ('zhang_san', '人工智慧'),
('li_si', '軟體工程'), ('li_si', '系統設計'),
('wang_wu', '計算機網路'), ('wang_wu', '資訊安全'),
('zhao_liu', '大資料分析'), ('zhao_liu', '雲端運算'),
('sun_qi', '影像處理'), ('sun_qi', '電腦視覺'),
('zhou_ba', '演算法'), ('zhou_ba', '資料結構'),
('wu_jiu', '網頁開發'), ('wu_jiu', '資料庫系統'),
('zheng_shi', '行動裝置開發'), ('zheng_shi', 'UI/UX設計'),
('chen_shiyi', '理論計算機科學'), ('chen_shiyi', '離散數學');
