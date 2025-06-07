<?php
// 快速資料庫連接測試
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>🧪 資料庫連接快速測試</h2>";
echo "<p>測試使用密碼: #WcVh4FfF</p>";

try {
    $pdo = new PDO("mysql:host=localhost;dbname=D1299204", "D1299204", "#WcVh4FfF");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div style='background:#d4edda;color:#155724;padding:15px;border:1px solid #c3e6cb;border-radius:4px;margin:10px;'>";
    echo "<h3>✅ 資料庫連接成功！</h3>";    // 測試資料庫資訊
    try {
        $stmt = $pdo->query("SELECT DATABASE() as current_db");
        $dbInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $pdo->query("SELECT USER() as current_user");
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $pdo->query("SELECT VERSION() as mysql_version");
        $versionInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<p><strong>當前資料庫:</strong> " . $dbInfo['current_db'] . "</p>";
        echo "<p><strong>當前使用者:</strong> " . $userInfo['current_user'] . "</p>";
        echo "<p><strong>資料庫版本:</strong> " . $versionInfo['mysql_version'] . "</p>";
    } catch (Exception $e) {
        echo "<p><strong>⚠ 無法獲取資料庫資訊:</strong> " . $e->getMessage() . "</p>";
    }
    
    // 檢查教師表格是否存在
    try {
        $stmt = $pdo->query("SHOW TABLES LIKE 'faculty_members'");
        if ($stmt->rowCount() > 0) {
            echo "<p><strong>✅ faculty_members 表格已存在</strong></p>";
            
            // 檢查資料數量
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM faculty_members");
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p><strong>教師資料數量:</strong> " . $count['count'] . " 筆</p>";
        } else {
            echo "<p><strong>⚠ faculty_members 表格不存在</strong></p>";
            echo "<p>請執行資料庫初始化: <a href='setup.php'>setup.php</a></p>";
        }
    } catch (Exception $e) {
        echo "<p><strong>⚠ 無法檢查表格:</strong> " . $e->getMessage() . "</p>";
    }
    
    echo "</div>";
    
    echo "<h3>🎯 下一步</h3>";
    echo "<ol>";
    echo "<li><a href='setup.php'>執行資料庫初始化</a> (如果表格不存在)</li>";
    echo "<li><a href='../faculty.php'>訪問教師列表頁面</a></li>";
    echo "<li><a href='../admin/manage-faculty.php'>訪問教師管理後台</a></li>";
    echo "</ol>";
    
} catch (PDOException $e) {
    echo "<div style='background:#f8d7da;color:#721c24;padding:15px;border:1px solid #f5c6cb;border-radius:4px;margin:10px;'>";
    echo "<h3>❌ 資料庫連接失敗</h3>";
    echo "<p><strong>錯誤訊息:</strong> " . $e->getMessage() . "</p>";
    echo "</div>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
a { color: #007cba; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>
