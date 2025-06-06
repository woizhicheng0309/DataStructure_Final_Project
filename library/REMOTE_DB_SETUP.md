# 遠端伺服器資料庫設定指南

## 🔧 設定步驟

### 1. 獲取資料庫資訊
請聯繫您的系統管理員或查看學校提供的資料庫資訊文件，獲取以下資訊：
- 資料庫使用者名稱 (通常是學號: D1299204)
- 資料庫密碼
- 資料庫名稱 (通常是學號: D1299204)

### 2. 修改配置檔案
編輯 `includes/config.php` 檔案，在遠端伺服器設定區塊中填入正確的資訊：

```php
if ($isRemoteServer) {
    // 遠端伺服器資料庫設定
    define('DB_HOST','localhost');
    define('DB_USER','D1299204');      // ← 確認使用者名稱
    define('DB_PASS','YOUR_PASSWORD'); // ← 填入正確密碼
    define('DB_NAME','D1299204');      // ← 確認資料庫名稱
}
```

### 3. 測試連接
修改配置後，重新訪問：
```
http://140.134.53.57/~D1299204/library/faculty.php
```

### 4. 初始化資料庫
連接成功後，訪問以下網址初始化資料庫：
```
http://140.134.53.57/~D1299204/library/database/setup.php
```

## 🚨 常見問題

### 問題 1: Access denied for user 'root'@'localhost'
**解決方案**: 遠端伺服器通常不允許使用 root 使用者，請使用您的學號作為使用者名稱。

### 問題 2: Unknown database 'library'
**解決方案**: 遠端伺服器上可能沒有 'library' 資料庫，請使用您的學號作為資料庫名稱。

### 問題 3: Access denied for user 'D1299204'@'localhost'
**解決方案**: 
1. 確認密碼是否正確
2. 確認使用者是否存在
3. 聯繫系統管理員檢查權限設定

## 📋 檢查清單

- [ ] 確認資料庫使用者名稱
- [ ] 確認資料庫密碼
- [ ] 確認資料庫名稱
- [ ] 測試基本連接
- [ ] 執行資料庫初始化
- [ ] 測試教師系統功能

## 🆘 需要幫助？

如果遇到問題，請提供以下資訊：
1. 完整的錯誤訊息
2. 您使用的資料庫使用者名稱和資料庫名稱
3. 是否能夠通過其他方式連接到資料庫

---
**注意**: 為了安全起見，請不要在公開場所分享您的資料庫密碼。
