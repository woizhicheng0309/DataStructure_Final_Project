# 逢甲大學資訊系教師資料系統

## 系統概述

這是一個完整的教師資料管理系統，包含前端展示頁面、資料庫管理和後台管理功能。

## 主要功能

### 1. 教師列表頁面 (`faculty.php`)
- 左側分類導航：8個教師類別
- 右側教師卡片展示：照片、姓名、聯絡方式、專長
- 點擊分類可篩選不同類型的教師
- 點擊教師姓名或照片可進入個人資料頁面
- 響應式設計，支援各種螢幕尺寸

### 2. 教師個人資料頁面 (`faculty-profile.php`)
- 美觀的漸層頭部區域，顯示教師照片和基本資訊
- 詳細的個人資訊：研究興趣、學歷、經歷、著作
- 側邊欄顯示：專長領域、授課科目、獲獎記錄
- 返回教師列表的導航功能

### 3. 資料庫管理
- 完整的資料表結構，支援教師的所有相關資訊
- 資料庫初始化腳本 (`database/setup.php`)
- API接口 (`api/get_faculty_data.php`) 提供JSON格式的教師資料

### 4. 後台管理 (`admin/manage-faculty.php`)
- 新增教師資料
- 查看現有教師列表
- 刪除教師資料
- 簡單直觀的管理介面

## 檔案結構

```
library/
├── faculty.php                 # 教師列表主頁
├── faculty-profile.php         # 教師個人資料頁
├── admin/
│   └── manage-faculty.php      # 後台管理介面
├── api/
│   └── get_faculty_data.php    # 教師資料API
├── database/
│   ├── library.sql.txt          # 完整資料表結構和測試資料 (包含教師系統)
│   └── setup.php              # 資料庫初始化腳本
└── assets/
    └── img/
        └── faculty/            # 教師照片目錄
            └── default.jpg     # 預設教師照片
```

## 資料庫結構

### 主要資料表

1. **faculty_members** - 教師基本資料
   - 姓名、類別、聯絡方式、辦公室等

2. **faculty_specialties** - 教師專長
   - 支援多個專長領域

3. **faculty_education** - 學歷資訊
   - 學位、主修、學校、年份

4. **faculty_experience** - 工作經歷
   - 職位、機構、任職時間

5. **faculty_courses** - 授課科目
   - 課程名稱、代碼、學期

6. **faculty_publications** - 學術著作
   - 期刊論文、會議論文、書籍等

7. **faculty_awards** - 獲獎記錄
   - 獎項名稱、頒獎機構、年份

## 安裝和設定

### 1. 資料庫設定
1. 確保XAMPP已啟動MySQL服務
2. 資料庫結構已整合至 `database/library.sql.txt` 檔案中
3. 訪問 `http://localhost/Online-Library-Management-System-PHP/library/database/setup.php` 執行資料庫初始化
4. 系統將自動創建所有必要的教師相關資料表並插入測試資料

### 2. 測試系統
1. 前端頁面：`http://localhost/Online-Library-Management-System-PHP/library/faculty.php`
2. 後台管理：`http://localhost/Online-Library-Management-System-PHP/library/admin/manage-faculty.php`
3. API測試：`http://localhost/Online-Library-Management-System-PHP/library/api/get_faculty_data.php`

## 教師類別

系統支援以下8個教師類別：
- 系主任
- 榮譽特聘講座
- 講座教授
- 特約講座
- 特聘教授
- 專任教師
- 兼任教師
- 退休老師

## 特色功能

### 1. 彈性的資料來源
- 優先從資料庫讀取資料
- 當資料庫不可用時，自動使用測試資料
- 確保系統在各種情況下都能正常運作

### 2. 現代化界面設計
- Bootstrap響應式框架
- 美觀的卡片設計
- 漸層色彩和陰影效果
- Font Awesome圖示

### 3. 安全性考量
- 使用PDO預準語句防止SQL注入
- 輸出時使用htmlspecialchars防止XSS
- 資料驗證和錯誤處理

### 4. 良好的用戶體驗
- 直觀的分類導航
- 平滑的hover效果
- 清晰的視覺回饋
- 移動裝置友好

## 擴展功能

系統設計具有良好的擴展性，可以輕鬆添加：
- 教師照片上傳功能
- 更詳細的個人資料編輯
- 搜尋和過濾功能
- 匯出功能（PDF、Excel）
- 多語言支援

## 技術規格

- **後端**：PHP 7.4+
- **資料庫**：MySQL 5.7+
- **前端**：HTML5, CSS3, JavaScript (jQuery)
- **框架**：Bootstrap 3.x
- **圖示**：Font Awesome 4.x

## 支援和維護

系統包含完整的錯誤處理和日誌記錄功能，便於問題診斷和系統維護。所有的資料操作都有適當的錯誤回饋，確保系統的穩定性和可靠性。
