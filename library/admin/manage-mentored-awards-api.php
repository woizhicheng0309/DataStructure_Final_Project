<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// manage-mentored-awards-api.php
header('Content-Type: application/json');
try {
    include('../includes/config.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $team_id = $_POST['team_id'] ?? '';
        $member_id = $_POST['member_id'] ?? '';
        $teacher_id = $_POST['teacher_id'] ?? '';
        $award_id = $_POST['award_id'] ?? null;
        $competition_name = $_POST['competition_name'] ?? null;
        $category = $_POST['category'] ?? null;

        // 主鍵必填檢查
        if (in_array($action, ['add', 'edit', 'delete'])) {
            if ($team_id === '' || $member_id === '' || $teacher_id === '') {
                echo json_encode(['status' => 'error', 'msg' => '缺少必要主鍵欄位']);
                exit;
            }
        }

        if ($action === 'add') {
            $sql = "INSERT INTO 學生參賽 (隊伍編號, 組員學號, 老師編號, 獲獎記錄編號, 比賽名字, 參賽類別) VALUES (:team_id, :member_id, :teacher_id, :award_id, :competition_name, :category)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':team_id', $team_id);
            $query->bindParam(':member_id', $member_id);
            $query->bindParam(':teacher_id', $teacher_id);
            $query->bindParam(':award_id', $award_id);
            $query->bindParam(':competition_name', $competition_name);
            $query->bindParam(':category', $category);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '新增失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'delete') {
            $sql = "DELETE FROM 學生參賽 WHERE 隊伍編號 = :team_id AND 組員學號 = :member_id AND 老師編號 = :teacher_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':team_id', $team_id);
            $query->bindParam(':member_id', $member_id);
            $query->bindParam(':teacher_id', $teacher_id);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '刪除失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'edit') {
            $sql = "UPDATE 學生參賽 SET 獲獎記錄編號 = :award_id, 比賽名字 = :competition_name, 參賽類別 = :category WHERE 隊伍編號 = :team_id AND 組員學號 = :member_id AND 老師編號 = :teacher_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':award_id', $award_id);
            $query->bindParam(':competition_name', $competition_name);
            $query->bindParam(':category', $category);
            $query->bindParam(':team_id', $team_id);
            $query->bindParam(':member_id', $member_id);
            $query->bindParam(':teacher_id', $teacher_id);
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
