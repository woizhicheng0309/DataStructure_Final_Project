<?php
// manage-teacher-plans-api.php
header('Content-Type: application/json');
try {
    include('../includes/config.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        if ($action === 'add') {
            $plan_id = $_POST['plan_id'] ?? '';
            $category = $_POST['category'] ?? '';
            $topic = $_POST['topic'] ?? '';
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';
            $institution = $_POST['institution'] ?? '';
            $sql = "INSERT INTO 老師計劃 (計劃編號, 分類, 研究主題, 研究開始日期, 研究結束日期, 資助機構) VALUES (:plan_id, :category, :topic, :start_date, :end_date, :institution)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':plan_id', $plan_id);
            $query->bindParam(':category', $category);
            $query->bindParam(':topic', $topic);
            $query->bindParam(':start_date', $start_date);
            $query->bindParam(':end_date', $end_date);
            $query->bindParam(':institution', $institution);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '新增失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'delete') {
            $plan_id = $_POST['plan_id'] ?? '';
            $sql = "DELETE FROM 老師計劃 WHERE 計劃編號 = :plan_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':plan_id', $plan_id);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '刪除失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'edit') {
            $plan_id = $_POST['plan_id'] ?? '';
            $category = $_POST['category'] ?? '';
            $topic = $_POST['topic'] ?? '';
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';
            $institution = $_POST['institution'] ?? '';
            $sql = "UPDATE 老師計劃 SET 分類 = :category, 研究主題 = :topic, 研究開始日期 = :start_date, 研究結束日期 = :end_date, 資助機構 = :institution WHERE 計劃編號 = :plan_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':plan_id', $plan_id);
            $query->bindParam(':category', $category);
            $query->bindParam(':topic', $topic);
            $query->bindParam(':start_date', $start_date);
            $query->bindParam(':end_date', $end_date);
            $query->bindParam(':institution', $institution);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '修改失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
    }
    echo json_encode(['status' => 'error', 'msg' => 'Invalid request']);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'msg' => 'Exception', 'error' => $e->getMessage()]);
    exit;
}
