<?php
// manage-book-papers-api.php
header('Content-Type: application/json');
try {
    include('../includes/config.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        if ($action === 'add') {
            $paper_id = $_POST['論文標號'] ?? '';
            $title = $_POST['書名'] ?? '';
            $isbn = $_POST['ISBN'] ?? '';
            $publisher = $_POST['出版社'] ?? '';
            $pub_year = $_POST['出版年份'] ?? '';
            $author = $_POST['作者'] ?? '';
            $sql = "INSERT INTO 專書論文 (論文標號, 書名, ISBN, 出版社, 出版年份, 作者) VALUES (:paper_id, :title, :isbn, :publisher, :pub_year, :author)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':paper_id', $paper_id);
            $query->bindParam(':title', $title);
            $query->bindParam(':isbn', $isbn);
            $query->bindParam(':publisher', $publisher);
            $query->bindParam(':pub_year', $pub_year);
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
            $sql = "DELETE FROM 專書論文 WHERE 論文標號 = :paper_id";
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
            $title = $_POST['書名'] ?? '';
            $isbn = $_POST['ISBN'] ?? '';
            $publisher = $_POST['出版社'] ?? '';
            $pub_year = $_POST['出版年份'] ?? '';
            $author = $_POST['作者'] ?? '';
            $old_paper_id = $_POST['old_論文標號'] ?? $paper_id;
            $sql = "UPDATE 專書論文 SET 論文標號 = :paper_id, 書名 = :title, ISBN = :isbn, 出版社 = :publisher, 出版年份 = :pub_year, 作者 = :author WHERE 論文標號 = :old_paper_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':paper_id', $paper_id);
            $query->bindParam(':title', $title);
            $query->bindParam(':isbn', $isbn);
            $query->bindParam(':publisher', $publisher);
            $query->bindParam(':pub_year', $pub_year);
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
