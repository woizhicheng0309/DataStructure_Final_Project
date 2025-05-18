<?php
// manage-students-api.php
header('Content-Type: application/json');
try {
    include('../includes/config.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        if ($action === 'add') {
            $student_id = $_POST['student_id'] ?? '';
            $name = $_POST['name'] ?? '';
            $class = $_POST['class'] ?? '';
            $department = $_POST['department'] ?? '';
            $sql = "INSERT INTO 學生 (學生學號, 姓名, 班級, 系所) VALUES (:student_id, :name, :class, :department)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':student_id', $student_id);
            $query->bindParam(':name', $name);
            $query->bindParam(':class', $class);
            $query->bindParam(':department', $department);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '新增失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'delete') {
            $student_id = $_POST['student_id'] ?? '';
            $sql = "DELETE FROM 學生 WHERE 學生學號 = :student_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':student_id', $student_id);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '刪除失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'edit') {
            $student_id = $_POST['student_id'] ?? '';
            $name = $_POST['name'] ?? '';
            $class = $_POST['class'] ?? '';
            $department = $_POST['department'] ?? '';
            $sql = "UPDATE 學生 SET 姓名 = :name, 班級 = :class, 系所 = :department WHERE 學生學號 = :student_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':student_id', $student_id);
            $query->bindParam(':name', $name);
            $query->bindParam(':class', $class);
            $query->bindParam(':department', $department);
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
