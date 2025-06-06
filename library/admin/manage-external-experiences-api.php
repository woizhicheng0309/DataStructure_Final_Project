<?php
// manage-external-experiences-api.php
header('Content-Type: application/json');
try {
    include('../includes/config.php');

    // Test database connection and table access
    try {
        $stmt = $dbh->query("SELECT COUNT(*) FROM 老師校外經歷");
        $count = $stmt->fetchColumn();
        echo json_encode(['status' => 'success', 'msg' => '資料表連接成功', 'count' => $count]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'msg' => '資料表連接失敗', 'error' => $e->getMessage()]);
        exit;
    }

    // Clear any previous output
    ob_clean();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'add') {
            $teacher_id = $_POST['老師編號'] ?? '';
            $organization_name = $_POST['機構名稱'] ?? '';
            $position = $_POST['職位'] ?? '';

            // Check for duplicate entry
            $sql_check = "SELECT COUNT(*) FROM 老師校外經歷 WHERE 老師編號 = :teacher_id AND 機構名稱 = :organization_name";
            $query_check = $dbh->prepare($sql_check);
            $query_check->bindParam(':teacher_id', $teacher_id);
            $query_check->bindParam(':organization_name', $organization_name);
            $query_check->execute();
            if ($query_check->fetchColumn() > 0) {
                echo json_encode(['status' => 'error', 'msg' => '該老師的此項經歷已存在，無法重複新增。']);
                exit;
            }

            $sql = "INSERT INTO 老師校外經歷 (老師編號, 機構名稱, 職位) VALUES (:teacher_id, :organization_name, :position)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':teacher_id', $teacher_id);
            $query->bindParam(':organization_name', $organization_name);
            $query->bindParam(':position', $position);

            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '新增失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }

        if ($action === 'delete') {
            $teacher_id = $_POST['老師編號'] ?? '';
            $organization_name = $_POST['機構名稱'] ?? '';

            $sql = "DELETE FROM 老師校外經歷 WHERE 老師編號 = :teacher_id AND 機構名稱 = :organization_name";
            $query = $dbh->prepare($sql);
            $query->bindParam(':teacher_id', $teacher_id);
            $query->bindParam(':organization_name', $organization_name);

            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '刪除失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }

        if ($action === 'edit') {
            $teacher_id = $_POST['老師編號'] ?? '';
            $organization_name = $_POST['機構名稱'] ?? '';
            $position = $_POST['職位'] ?? '';
            $old_teacher_id = $_POST['old_老師編號'] ?? '';
            $old_organization_name = $_POST['old_機構名稱'] ?? '';

            $sql = "UPDATE 老師校外經歷 SET 老師編號 = :teacher_id, 機構名稱 = :organization_name, 職位 = :position WHERE 老師編號 = :old_teacher_id AND 機構名稱 = :old_organization_name";
            $query = $dbh->prepare($sql);
            $query->bindParam(':teacher_id', $teacher_id);
            $query->bindParam(':organization_name', $organization_name);
            $query->bindParam(':position', $position);
            $query->bindParam(':old_teacher_id', $old_teacher_id);
            $query->bindParam(':old_organization_name', $old_organization_name);

            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '更新失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'msg' => '系統錯誤', 'error' => $e->getMessage()]);
}