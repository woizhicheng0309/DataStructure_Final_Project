<?php
/**
 * 資料庫初始化腳本
 * 用於創建教師相關的資料表和初始資料
 */

// 設定錯誤報告
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 包含資料庫配置
require_once('../includes/config.php');

echo "<h2>逢甲大學資訊系教師資料庫初始化</h2>\n";

try {
    // 開始交易
    $dbh->beginTransaction();

    echo "<p>正在創建教師相關資料表...</p>\n";

    // 讀取並執行SQL檔案
    $sqlFile = __DIR__ . '/faculty_table.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("SQL檔案不存在：{$sqlFile}");
    }

    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
        throw new Exception("無法讀取SQL檔案");
    }

    // 分割SQL語句
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        function($stmt) {
            return !empty($stmt) && !preg_match('/^\s*--/', $stmt);
        }
    );

    $successCount = 0;
    foreach ($statements as $statement) {
        if (!empty(trim($statement))) {
            try {
                $dbh->exec($statement);
                $successCount++;
                echo "<p style='color: green;'>✓ 執行成功：" . substr(trim($statement), 0, 50) . "...</p>\n";
            } catch (PDOException $e) {
                echo "<p style='color: orange;'>⚠ 跳過：" . substr(trim($statement), 0, 50) . "... (可能已存在)</p>\n";
            }
        }
    }

    // 提交交易
    $dbh->commit();

    echo "<p style='color: green; font-weight: bold;'>✓ 資料庫初始化完成！成功執行 {$successCount} 個SQL語句。</p>\n";

    // 檢查資料
    echo "<h3>資料檢查</h3>\n";
    
    $tables = ['faculty_members', 'faculty_specialties', 'faculty_education', 'faculty_experience', 'faculty_courses', 'faculty_publications', 'faculty_awards'];
    
    foreach ($tables as $table) {
        try {
            $stmt = $dbh->query("SELECT COUNT(*) FROM `{$table}`");
            $count = $stmt->fetchColumn();
            echo "<p>• {$table}: {$count} 筆記錄</p>\n";
        } catch (PDOException $e) {
            echo "<p style='color: red;'>• {$table}: 表格不存在或查詢失敗</p>\n";
        }
    }

    echo "<h3>測試API</h3>\n";
    echo "<p><a href='../api/get_faculty_data.php' target='_blank'>測試教師資料API</a></p>\n";
    echo "<p><a href='../faculty.php' target='_blank'>查看教師列表頁面</a></p>\n";

} catch (Exception $e) {
    // 回滾交易
    if ($dbh->inTransaction()) {
        $dbh->rollBack();
    }
    
    echo "<p style='color: red; font-weight: bold;'>✗ 初始化失敗：" . $e->getMessage() . "</p>\n";
    echo "<p>請檢查資料庫連接和權限設定。</p>\n";
}

echo "<hr><p><small>初始化完成時間：" . date('Y-m-d H:i:s') . "</small></p>\n";
?>
