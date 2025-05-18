<?php
// manage-professors-api.php
header('Content-Type: application/json');
try {
    include('../includes/config.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        if ($action === 'add') {
            $teacher_id = $_POST['teacher_id'] ?? '';
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $extension = $_POST['extension'] ?? '';
            $education = $_POST['education'] ?? '';
            $schedule = $_POST['schedule'] ?? '';
            $specialty = $_POST['specialty'] ?? '';
            $category = $_POST['category'] ?? '';
            $sql = "INSERT INTO 老師 (老師編號, 姓名, 信箱, 分機, 學歷, 課表時間, 專長, 類別) VALUES (:teacher_id, :name, :email, :extension, :education, :schedule, :specialty, :category)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':teacher_id', $teacher_id);
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':extension', $extension);
            $query->bindParam(':education', $education);
            $query->bindParam(':schedule', $schedule);
            $query->bindParam(':specialty', $specialty);
            $query->bindParam(':category', $category);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '新增失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'delete') {
            $teacher_id = $_POST['teacher_id'] ?? '';
            $sql = "DELETE FROM 老師 WHERE 老師編號 = :teacher_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':teacher_id', $teacher_id);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '刪除失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'edit') {
            $teacher_id = $_POST['teacher_id'] ?? '';
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $extension = $_POST['extension'] ?? '';
            $education = $_POST['education'] ?? '';
            $schedule = $_POST['schedule'] ?? '';
            $specialty = $_POST['specialty'] ?? '';
            $category = $_POST['category'] ?? '';
            $sql = "UPDATE 老師 SET 姓名 = :name, 信箱 = :email, 分機 = :extension, 學歷 = :education, 課表時間 = :schedule, 專長 = :specialty, 類別 = :category WHERE 老師編號 = :teacher_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':teacher_id', $teacher_id);
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->bindParam(':extension', $extension);
            $query->bindParam(':education', $education);
            $query->bindParam(':schedule', $schedule);
            $query->bindParam(':specialty', $specialty);
            $query->bindParam(':category', $category);
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
