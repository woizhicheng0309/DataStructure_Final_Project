<?php
session_start();
error_reporting(0);
include('../includes/config.php');

// Simple authentication check (you can integrate with your existing admin system)
$isAdmin = true; // For demo purposes, set to true. In production, implement proper authentication.

if (!$isAdmin) {
    header('Location: ../faculty.php');
    exit;
}

// Handle form submissions
if ($_POST) {
    try {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'add_faculty':
                    $stmt = $dbh->prepare("INSERT INTO faculty_members (faculty_id, name, name_en, category, extension, email, office, research_interests) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $_POST['faculty_id'],
                        $_POST['name'],
                        $_POST['name_en'],
                        $_POST['category'],
                        $_POST['extension'],
                        $_POST['email'],
                        $_POST['office'],
                        $_POST['research_interests']
                    ]);
                    
                    // Add specialties
                    if (!empty($_POST['specialties'])) {
                        $specialties = array_map('trim', explode(',', $_POST['specialties']));
                        $specialtyStmt = $dbh->prepare("INSERT INTO faculty_specialties (faculty_id, specialty) VALUES (?, ?)");
                        foreach ($specialties as $specialty) {
                            if (!empty($specialty)) {
                                $specialtyStmt->execute([$_POST['faculty_id'], $specialty]);
                            }
                        }
                    }
                    
                    $message = "教師資料新增成功！";
                    break;
                    
                case 'delete_faculty':
                    $stmt = $dbh->prepare("UPDATE faculty_members SET status = 'inactive' WHERE faculty_id = ?");
                    $stmt->execute([$_POST['faculty_id']]);
                    $message = "教師資料已刪除！";
                    break;
            }
        }
    } catch (PDOException $e) {
        $error = "操作失敗：" . $e->getMessage();
    }
}

// Get all faculty members
$stmt = $dbh->query("SELECT * FROM faculty_members WHERE status = 'active' ORDER BY category, name");
$facultyList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>教師資料管理 - 逢甲大學資訊系系網</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        .admin-header {
            background: #2c3e50;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .form-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .faculty-table {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .category-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            color: white;
        }
        .category-系主任 { background: #e74c3c; }
        .category-榮譽特聘講座 { background: #9b59b6; }
        .category-講座教授 { background: #3498db; }
        .category-特約講座 { background: #1abc9c; }
        .category-特聘教授 { background: #f39c12; }
        .category-專任教師 { background: #27ae60; }
        .category-兼任教師 { background: #95a5a6; }
        .category-退休老師 { background: #7f8c8d; }
    </style>
</head>
<body>
    <div class="admin-header">
        <div class="container">
            <h1><i class="fa fa-users"></i> 教師資料管理系統</h1>
            <p>逢甲大學資訊工程學系</p>
        </div>
    </div>

    <div class="container">
        <?php if (isset($message)): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-section">
                    <h3><i class="fa fa-plus"></i> 新增教師</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="add_faculty">
                        
                        <div class="form-group">
                            <label>教師編號 *</label>
                            <input type="text" name="faculty_id" class="form-control" required 
                                   placeholder="例：zhang_san" pattern="[a-z_]+" title="僅限小寫英文字母和下底線">
                        </div>
                        
                        <div class="form-group">
                            <label>中文姓名 *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label>英文姓名</label>
                            <input type="text" name="name_en" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>教師類別 *</label>
                            <select name="category" class="form-control" required>
                                <option value="">請選擇</option>
                                <option value="系主任">系主任</option>
                                <option value="榮譽特聘講座">榮譽特聘講座</option>
                                <option value="講座教授">講座教授</option>
                                <option value="特約講座">特約講座</option>
                                <option value="特聘教授">特聘教授</option>
                                <option value="專任教師">專任教師</option>
                                <option value="兼任教師">兼任教師</option>
                                <option value="退休老師">退休老師</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>分機號碼</label>
                            <input type="text" name="extension" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>電子郵件</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>辦公室</label>
                            <input type="text" name="office" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>專長領域</label>
                            <input type="text" name="specialties" class="form-control" 
                                   placeholder="請用逗號分隔，例：機器學習,資料科學,人工智慧">
                        </div>
                        
                        <div class="form-group">
                            <label>研究興趣</label>
                            <textarea name="research_interests" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> 新增教師
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-section">
                    <h3><i class="fa fa-info-circle"></i> 管理說明</h3>
                    <ul>
                        <li><strong>教師編號：</strong>必須是唯一的，建議使用英文姓名拼音加下底線</li>
                        <li><strong>專長領域：</strong>多個專長請用逗號分隔</li>
                        <li><strong>刪除教師：</strong>在下方列表中點擊刪除按鈕</li>
                        <li><strong>查看效果：</strong><a href="../faculty.php" target="_blank">前往教師列表頁面</a></li>
                    </ul>
                    
                    <h4>快捷操作</h4>
                    <p>
                        <a href="../database/setup.php" target="_blank" class="btn btn-info">
                            <i class="fa fa-database"></i> 初始化資料庫
                        </a>
                        <a href="../api/get_faculty_data.php" target="_blank" class="btn btn-warning">
                            <i class="fa fa-code"></i> 測試API
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="faculty-table">
            <h3><i class="fa fa-list"></i> 現有教師列表</h3>
            <?php if (empty($facultyList)): ?>
            <p class="text-muted">目前沒有教師資料。請先<a href="../database/setup.php" target="_blank">初始化資料庫</a>或新增教師。</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>教師編號</th>
                            <th>姓名</th>
                            <th>類別</th>
                            <th>分機</th>
                            <th>信箱</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($facultyList as $faculty): ?>
                        <tr>
                            <td><code><?php echo htmlspecialchars($faculty['faculty_id']); ?></code></td>
                            <td>
                                <strong><?php echo htmlspecialchars($faculty['name']); ?></strong>
                                <?php if ($faculty['name_en']): ?>
                                <br><small class="text-muted"><?php echo htmlspecialchars($faculty['name_en']); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="category-badge category-<?php echo htmlspecialchars($faculty['category']); ?>">
                                    <?php echo htmlspecialchars($faculty['category']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($faculty['extension'] ?: '-'); ?></td>
                            <td><?php echo htmlspecialchars($faculty['email'] ?: '-'); ?></td>
                            <td>
                                <a href="../faculty-profile.php?id=<?php echo urlencode($faculty['faculty_id']); ?>" 
                                   target="_blank" class="btn btn-sm btn-info" title="查看個人頁面">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <form method="POST" style="display: inline;" 
                                      onsubmit="return confirm('確定要刪除這位教師嗎？');">
                                    <input type="hidden" name="action" value="delete_faculty">
                                    <input type="hidden" name="faculty_id" value="<?php echo htmlspecialchars($faculty['faculty_id']); ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" title="刪除">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="../assets/js/jquery-1.10.2.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
</body>
</html>
