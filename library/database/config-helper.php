<!DOCTYPE html>
<html>
<head>
    <title>資料庫設定更新工具</title>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background: #007cba; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
        button:hover { background: #005a87; }
        .alert { padding: 15px; margin: 10px 0; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .code-block { background: #f8f9fa; padding: 10px; border-radius: 4px; font-family: monospace; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔧 資料庫設定更新工具</h2>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $host = $_POST['host'] ?? 'localhost';
            $user = $_POST['user'] ?? '';
            $pass = $_POST['pass'] ?? '';
            $dbname = $_POST['dbname'] ?? '';
            
            // 測試連接
            try {
                $testPdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $pass);
                $testPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                echo '<div class="alert alert-success">✅ <strong>連接測試成功！</strong></div>';
                
                // 生成配置代碼
                echo '<h3>📝 請複製以下代碼到 config.php 檔案</h3>';
                echo '<div class="code-block">';
                echo htmlspecialchars("// 在 config.php 的遠端伺服器設定區塊中使用以下設定:\n");
                echo htmlspecialchars("define('DB_HOST','{$host}');\n");
                echo htmlspecialchars("define('DB_USER','{$user}');\n");
                echo htmlspecialchars("define('DB_PASS','" . str_repeat('*', strlen($pass)) . "'); // 實際密碼: {$pass}\n");
                echo htmlspecialchars("define('DB_NAME','{$dbname}');");
                echo '</div>';
                
                echo '<p><strong>修改步驟:</strong></p>';
                echo '<ol>';
                echo '<li>打開 <code>includes/config.php</code> 檔案</li>';
                echo '<li>找到遠端伺服器設定區塊 (if ($isRemoteServer) { ... })</li>';
                echo '<li>將上面的設定代碼複製並貼上</li>';
                echo '<li>保存檔案並重新測試</li>';
                echo '</ol>';
                
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger">❌ <strong>連接失敗:</strong> ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        }
        ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="host">資料庫主機:</label>
                <input type="text" id="host" name="host" value="<?php echo htmlspecialchars($_POST['host'] ?? 'localhost'); ?>">
            </div>
            
            <div class="form-group">
                <label for="user">使用者名稱:</label>
                <input type="text" id="user" name="user" value="<?php echo htmlspecialchars($_POST['user'] ?? 'D1299204'); ?>">
            </div>
            
            <div class="form-group">
                <label for="pass">密碼:</label>
                <input type="password" id="pass" name="pass" placeholder="請輸入資料庫密碼">
            </div>
            
            <div class="form-group">
                <label for="dbname">資料庫名稱:</label>
                <input type="text" id="dbname" name="dbname" value="<?php echo htmlspecialchars($_POST['dbname'] ?? 'D1299204'); ?>">
            </div>
            
            <button type="submit">🧪 測試連接</button>
        </form>
        
        <hr style="margin: 30px 0;">
        
        <h3>💡 常見密碼組合</h3>
        <p>請嘗試以下常見的密碼：</p>
        <ul>
            <li><strong>空白密碼</strong> (留空)</li>
            <li><strong>與使用者名稱相同</strong>: D1299204</li>
            <li><strong>預設密碼</strong>: password, 123456, root</li>
            <li><strong>學校提供的密碼</strong> (請查看您的資料庫資訊文件)</li>
        </ul>
        
        <h3>🆘 需要幫助？</h3>
        <p>如果所有測試都失敗，請：</p>
        <ul>
            <li>聯繫系統管理員獲取正確的資料庫資訊</li>
            <li>檢查學校提供的資料庫設定文件</li>
            <li>確認您的帳號是否已啟用資料庫服務</li>
        </ul>
    </div>
</body>
</html>
