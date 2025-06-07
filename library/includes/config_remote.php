<?php 
// Remote server database configuration
// 遠端伺服器資料庫配置

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 遠端伺服器資料庫設定
// 請根據您的遠端伺服器資料庫資訊修改以下設定

define('DB_HOST','localhost');
define('DB_USER','D1299204');  // 通常使用您的學號作為資料庫使用者名稱
define('DB_PASS','#WcVh4FfF');          // 請填入您的資料庫密碼
define('DB_NAME','D1299204');  // 通常使用您的學號作為資料庫名稱

// 建立資料庫連接
try
{
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    // 更詳細的錯誤資訊
    echo "<div style='background:#f8d7da;color:#721c24;padding:15px;border:1px solid #f5c6cb;border-radius:4px;margin:10px;'>";
    echo "<h3>資料庫連接錯誤</h3>";
    echo "<p><strong>錯誤訊息:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>建議檢查:</strong></p>";
    echo "<ul>";
    echo "<li>資料庫伺服器是否正在運行</li>";
    echo "<li>資料庫使用者名稱是否正確 (通常是學號: D1299204)</li>";
    echo "<li>資料庫密碼是否正確</li>";
    echo "<li>資料庫名稱是否存在 (通常是學號: D1299204)</li>";
    echo "<li>使用者是否有訪問該資料庫的權限</li>";
    echo "</ul>";
    echo "<p><strong>當前設定:</strong></p>";
    echo "<ul>";
    echo "<li>主機: " . DB_HOST . "</li>";
    echo "<li>使用者: " . DB_USER . "</li>";
    echo "<li>資料庫: " . DB_NAME . "</li>";
    echo "</ul>";
    echo "</div>";
    exit();
}
?>
