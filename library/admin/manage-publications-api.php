<?php
// manage-publications-api.php
header('Content-Type: application/json');
try {
    include('../includes/config.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        if ($action === 'add') {
            $paper_no = $_POST['論文標號'] ?? '';
            $publication_id = $_POST['論文編號'] ?? '';
            $publish_date = $_POST['發表日期'] ?? '';
            $title = $_POST['論文標題'] ?? '';
            $teacher_id = $_POST['老師編號'] ?? '';
            $sql = "INSERT INTO 論文 (論文標號, 論文編號, 發表日期, 論文標題, 老師編號) VALUES (:paper_no, :publication_id, :publish_date, :title, :teacher_id)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':paper_no', $paper_no);
            $query->bindParam(':publication_id', $publication_id);
            $query->bindParam(':publish_date', $publish_date);
            $query->bindParam(':title', $title);
            $query->bindParam(':teacher_id', $teacher_id);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '新增失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'delete') {
            $paper_no = $_POST['論文標號'] ?? '';
            $sql = "DELETE FROM 論文 WHERE 論文標號 = :paper_no";
            $query = $dbh->prepare($sql);
            $query->bindParam(':paper_no', $paper_no);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '刪除失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'edit') {
            $paper_no = $_POST['論文標號'] ?? '';
            $publication_id = $_POST['論文編號'] ?? '';
            $publish_date = $_POST['發表日期'] ?? '';
            $title = $_POST['論文標題'] ?? '';
            $teacher_id = $_POST['老師編號'] ?? '';
            $sql = "UPDATE 論文 SET 論文編號 = :publication_id, 發表日期 = :publish_date, 論文標題 = :title, 老師編號 = :teacher_id WHERE 論文標號 = :paper_no";
            $query = $dbh->prepare($sql);
            $query->bindParam(':paper_no', $paper_no);
            $query->bindParam(':publication_id', $publication_id);
            $query->bindParam(':publish_date', $publish_date);
            $query->bindParam(':title', $title);
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
