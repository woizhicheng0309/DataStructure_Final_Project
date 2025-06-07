<?php
/**
 * 教師資料API
 * 用於獲取教師資訊，支援按類別篩選
 */

// 設定header
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// 包含資料庫配置
include('../includes/config.php');

try {
    // 獲取請求參數
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    
    // 類別對應表
    $categoryMap = [
        'department_head' => '系主任',
        'honorary_chair' => '榮譽特聘講座',
        'chair_professor' => '講座教授',
        'special_chair' => '特約講座',
        'distinguished_professor' => '特聘教授',
        'full_time' => '專任教師',
        'part_time' => '兼任教師',
        'retired' => '退休老師'
    ];
    
    // 準備SQL查詢
    $sql = "SELECT f.faculty_id, f.name, f.category, f.extension, f.email, f.office, f.photo, f.research_interests
            FROM faculty_members f 
            WHERE f.status = 'active'";
    
    $params = [];
    
    // 如果指定了類別，添加篩選條件
    if (!empty($category) && isset($categoryMap[$category])) {
        $sql .= " AND f.category = :category";
        $params[':category'] = $categoryMap[$category];
    }
    
    $sql .= " ORDER BY f.display_order ASC, f.name ASC";
    
    $stmt = $dbh->prepare($sql);
    $stmt->execute($params);
    $facultyMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // 獲取每位教師的專長
    $facultyData = [];
    foreach ($facultyMembers as $faculty) {
        $specialtyStmt = $dbh->prepare("SELECT specialty FROM faculty_specialties WHERE faculty_id = :faculty_id");
        $specialtyStmt->execute([':faculty_id' => $faculty['faculty_id']]);
        $specialties = $specialtyStmt->fetchAll(PDO::FETCH_COLUMN);
        
        // 轉換類別名稱為前端使用的key
        $categoryKey = array_search($faculty['category'], $categoryMap);
        
        $facultyItem = [
            'id' => $faculty['faculty_id'],
            'name' => $faculty['name'],
            'category' => $faculty['category'],
            'category_key' => $categoryKey,
            'extension' => $faculty['extension'] ?: '-',
            'email' => $faculty['email'],
            'office' => $faculty['office'],
            'specialties' => $specialties,
            'photo' => $faculty['photo'] ?: 'assets/img/faculty/default.jpg',
            'research_interests' => $faculty['research_interests']
        ];
        
        // 按類別分組
        if (!isset($facultyData[$categoryKey])) {
            $facultyData[$categoryKey] = [];
        }
        $facultyData[$categoryKey][] = $facultyItem;
    }
    
    // 返回成功響應
    echo json_encode([
        'success' => true,
        'data' => $facultyData,
        'message' => 'Faculty data loaded successfully'
    ], JSON_UNESCAPED_UNICODE);
    
} catch (PDOException $e) {
    // 資料庫錯誤
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'data' => [],
        'message' => 'Database error: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    // 其他錯誤
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'data' => [],
        'message' => 'Server error: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
