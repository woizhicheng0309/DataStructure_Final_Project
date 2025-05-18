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
        // 這三個是主鍵，必填
        $team_id = isset($_POST['team_id']) && $_POST['team_id'] !== '' ? (int)$_POST['team_id'] : null;
        $member_id = isset($_POST['member_id']) && $_POST['member_id'] !== '' ? (int)$_POST['member_id'] : null;
        $teacher_id = isset($_POST['teacher_id']) && $_POST['teacher_id'] !== '' ? (int)$_POST['teacher_id'] : null;
        $award_id = isset($_POST['award_id']) && $_POST['award_id'] !== '' ? (int)$_POST['award_id'] : null;
        $competition_name = isset($_POST['competition_name']) && $_POST['competition_name'] !== '' ? $_POST['competition_name'] : null;
        $category = isset($_POST['category']) && $_POST['category'] !== '' ? $_POST['category'] : null;

        if (in_array($action, ['add', 'edit', 'delete'])) {
            if ($team_id === null || $member_id === null || $teacher_id === null) {
                echo json_encode(['status' => 'error', 'msg' => '缺少必要主鍵欄位']);
                exit;
            }
        }

        if ($action === 'add') {
            $sql = "INSERT INTO 學生參賽 (隊伍編號, 組員學號, 老師編號, 獲獎記錄編號, 比賽名字, 參賽類別) VALUES (:team_id, :member_id, :teacher_id, :award_id, :competition_name, :category)";
            $query = $dbh->prepare($sql);
            $query->bindValue(':team_id', $team_id, PDO::PARAM_INT);
            $query->bindValue(':member_id', $member_id, PDO::PARAM_INT);
            $query->bindValue(':teacher_id', $teacher_id, PDO::PARAM_INT);
            if ($award_id === null) {
                $query->bindValue(':award_id', null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(':award_id', $award_id, PDO::PARAM_INT);
            }
            if ($competition_name === null) {
                $query->bindValue(':competition_name', null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(':competition_name', $competition_name, PDO::PARAM_STR);
            }
            if ($category === null) {
                $query->bindValue(':category', null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(':category', $category, PDO::PARAM_STR);
            }
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
            $query->bindValue(':team_id', $team_id, PDO::PARAM_INT);
            $query->bindValue(':member_id', $member_id, PDO::PARAM_INT);
            $query->bindValue(':teacher_id', $teacher_id, PDO::PARAM_INT);
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
            if ($award_id === null) {
                $query->bindValue(':award_id', null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(':award_id', $award_id, PDO::PARAM_INT);
            }
            if ($competition_name === null) {
                $query->bindValue(':competition_name', null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(':competition_name', $competition_name, PDO::PARAM_STR);
            }
            if ($category === null) {
                $query->bindValue(':category', null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(':category', $category, PDO::PARAM_STR);
            }
            $query->bindValue(':team_id', $team_id, PDO::PARAM_INT);
            $query->bindValue(':member_id', $member_id, PDO::PARAM_INT);
            $query->bindValue(':teacher_id', $teacher_id, PDO::PARAM_INT);
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
