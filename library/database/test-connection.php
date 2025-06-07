<?php
// 資料庫連接測試工具
// Database Connection Test Tool

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>🔧 資料庫連接測試工具</h2>";
echo "<p>請嘗試不同的資料庫設定組合</p>";

// 常見的資料庫設定組合
$testConfigs = [
    [
        'host' => 'localhost',
        'user' => 'D1299204',
        'pass' => '',
        'dbname' => 'D1299204'
    ],
    [
        'host' => 'localhost',
        'user' => 'D1299204',
        'pass' => 'D1299204',
        'dbname' => 'D1299204'
    ],
    [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'dbname' => 'D1299204'
    ],
    [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'root',
        'dbname' => 'D1299204'
    ],
    [
        'host' => 'localhost',
        'user' => 'D1299204',
        'pass' => '',
        'dbname' => 'mysql'
    ]
];

foreach ($testConfigs as $index => $config) {
    echo "<div style='border: 1px solid #ddd; margin: 10px 0; padding: 15px; border-radius: 5px;'>";
    echo "<h4>測試 #" . ($index + 1) . "</h4>";
    echo "<p><strong>設定:</strong> 主機={$config['host']}, 使用者={$config['user']}, 密碼=" . (empty($config['pass']) ? '(空白)' : $config['pass']) . ", 資料庫={$config['dbname']}</p>";
    
    try {
        $pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['user'], $config['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "<p style='color: green;'>✅ <strong>連接成功！</strong></p>";
        
        // 嘗試列出資料庫中的表格
        try {
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            if (count($tables) > 0) {
                echo "<p><strong>現有表格:</strong> " . implode(", ", $tables) . "</p>";
            } else {
                echo "<p><em>資料庫為空，沒有表格</em></p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: orange;'>⚠ 無法列出表格: " . $e->getMessage() . "</p>";
        }
        
    } catch (PDOException $e) {
        echo "<p style='color: red;'>❌ <strong>連接失敗:</strong> " . $e->getMessage() . "</p>";
    }
    echo "</div>";
}

echo "<hr>";
echo "<h3>📋 手動測試區</h3>";
echo "<p>如果上面的自動測試都失敗了，請嘗試以下步驟：</p>";
echo "<ol>";
echo "<li>登入您的伺服器控制面板 (如 cPanel, phpMyAdmin)</li>";
echo "<li>查看資料庫管理區域</li>";
echo "<li>確認以下資訊：</li>";
echo "<ul>";
echo "<li>資料庫名稱</li>";
echo "<li>資料庫使用者名稱</li>";
echo "<li>資料庫密碼</li>";
echo "</ul>";
echo "</ol>";

echo "<h3>🔍 系統資訊</h3>";
echo "<p><strong>伺服器軟體:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>PHP 版本:</strong> " . phpversion() . "</p>";
echo "<p><strong>當前目錄:</strong> " . __DIR__ . "</p>";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
h2, h3, h4 { color: #333; }
div { margin-bottom: 10px; }
</style>
