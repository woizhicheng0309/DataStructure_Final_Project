<?php
// manage-conference-papers-api.php
header('Content-Type: application/json');
try {
    include('../includes/config.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        if ($action === 'add') {
            $paper_id = $_POST['論文標號'] ?? '';
            $conference_name = $_POST['會議名稱'] ?? '';
            $conference_location = $_POST['會議地點'] ?? '';
            $publish_date = $_POST['發佈日期'] ?? '';
            $author = $_POST['作者'] ?? '';
            $sql = "INSERT INTO 會議論文 (論文標號, 會議名稱, 會議地點, 發佈日期, 作者) VALUES (:paper_id, :conference_name, :conference_location, :publish_date, :author)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':paper_id', $paper_id);
            $query->bindParam(':conference_name', $conference_name);
            $query->bindParam(':conference_location', $conference_location);
            $query->bindParam(':publish_date', $publish_date);
            $query->bindParam(':author', $author);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '新增失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'delete') {
            $paper_id = $_POST['論文標號'] ?? '';
            $sql = "DELETE FROM 會議論文 WHERE 論文標號 = :paper_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':paper_id', $paper_id);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '刪除失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'edit') {
            $paper_id = $_POST['論文標號'] ?? '';
            $conference_name = $_POST['會議名稱'] ?? '';
            $conference_location = $_POST['會議地點'] ?? '';
            $publish_date = $_POST['發佈日期'] ?? '';
            $author = $_POST['作者'] ?? '';
            $old_paper_id = $_POST['old_論文標號'] ?? $paper_id;
            $sql = "UPDATE 會議論文 SET 論文標號 = :paper_id, 會議名稱 = :conference_name, 會議地點 = :conference_location, 發佈日期 = :publish_date, 作者 = :author WHERE 論文標號 = :old_paper_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':paper_id', $paper_id);
            $query->bindParam(':conference_name', $conference_name);
            $query->bindParam(':conference_location', $conference_location);
            $query->bindParam(':publish_date', $publish_date);
            $query->bindParam(':author', $author);
            $query->bindParam(':old_paper_id', $old_paper_id);
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
