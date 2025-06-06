<?php
header('Content-Type: application/json');
try {
    include('../includes/config.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        // Log received POST data for debugging
        error_log('Received POST data: ' . json_encode($_POST));

        if ($action === 'add') {
            // Map front-end field names to back-end variables
            $teacher_id = $_POST['老師編號'] ?? '';
            $lecture_name = $_POST['演講名稱'] ?? '';
            $location = $_POST['地點'] ?? '';
            $date = $_POST['日期'] ?? '';

            // Validate input
            if (empty($teacher_id) || empty($lecture_name) || empty($location) || empty($date)) {
                echo json_encode(['status' => 'error', 'msg' => '缺少必要欄位']);
                exit;
            }

            // Check for duplicate entry
            $sql_check = "SELECT COUNT(*) FROM 老師演講 WHERE 老師編號 = :teacher_id AND 演講名稱 = :lecture_name";
            $query_check = $dbh->prepare($sql_check);
            $query_check->bindParam(':teacher_id', $teacher_id, PDO::PARAM_STR);
            $query_check->bindParam(':lecture_name', $lecture_name, PDO::PARAM_STR);
            $query_check->execute();
            if ($query_check->fetchColumn() > 0) {
                echo json_encode(['status' => 'error', 'msg' => '該演講已存在，無法重複新增']);
                exit;
            }

            $sql = "INSERT INTO 老師演講 (老師編號, 演講名稱, 地點, 日期) VALUES (:teacher_id, :lecture_name, :location, :date)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':teacher_id', $teacher_id, PDO::PARAM_STR);
            $query->bindParam(':lecture_name', $lecture_name, PDO::PARAM_STR);
            $query->bindParam(':location', $location, PDO::PARAM_STR);
            $query->bindParam(':date', $date, PDO::PARAM_STR);

            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                error_log('SQL Error: ' . json_encode($query->errorInfo()));
                echo json_encode(['status' => 'error', 'msg' => '新增失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }

        if ($action === 'delete') {
            $teacher_id = $_POST['teacher_id'] ?? '';
            $lecture_name = $_POST['lecture_name'] ?? '';

            // Validate input
            if (empty($teacher_id) || empty($lecture_name)) {
                echo json_encode(['status' => 'error', 'msg' => '缺少必要欄位']);
                exit;
            }

            $sql = "DELETE FROM 老師演講 WHERE 老師編號 = :teacher_id AND 演講名稱 = :lecture_name";
            $query = $dbh->prepare($sql);
            $query->bindParam(':teacher_id', $teacher_id, PDO::PARAM_STR);
            $query->bindParam(':lecture_name', $lecture_name, PDO::PARAM_STR);

            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                error_log('SQL Error: ' . json_encode($query->errorInfo()));
                echo json_encode(['status' => 'error', 'msg' => '刪除失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }

        if ($action === 'edit') {
            $teacher_id = $_POST['teacher_id'] ?? '';
            $lecture_name = $_POST['lecture_name'] ?? '';
            $location = $_POST['location'] ?? '';
            $date = $_POST['date'] ?? '';
            $old_teacher_id = $_POST['old_teacher_id'] ?? '';
            $old_lecture_name = $_POST['old_lecture_name'] ?? '';

            // Validate input
            if (empty($teacher_id) || empty($lecture_name) || empty($location) || empty($date) || empty($old_teacher_id) || empty($old_lecture_name)) {
                echo json_encode(['status' => 'error', 'msg' => '缺少必要欄位']);
                exit;
            }

            $sql = "UPDATE 老師演講 SET 老師編號 = :teacher_id, 演講名稱 = :lecture_name, 地點 = :location, 日期 = :date WHERE 老師編號 = :old_teacher_id AND 演講名稱 = :old_lecture_name";
            $query = $dbh->prepare($sql);
            $query->bindParam(':teacher_id', $teacher_id, PDO::PARAM_STR);
            $query->bindParam(':lecture_name', $lecture_name, PDO::PARAM_STR);
            $query->bindParam(':location', $location, PDO::PARAM_STR);
            $query->bindParam(':date', $date, PDO::PARAM_STR);
            $query->bindParam(':old_teacher_id', $old_teacher_id, PDO::PARAM_STR);
            $query->bindParam(':old_lecture_name', $old_lecture_name, PDO::PARAM_STR);

            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                error_log('SQL Error: ' . json_encode($query->errorInfo()));
                echo json_encode(['status' => 'error', 'msg' => '修改失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
    }

    echo json_encode(['status' => 'error', 'msg' => 'Invalid request']);
} catch (Throwable $e) {
    http_response_code(500);
    error_log('Exception in manage-teacher-lectures-api.php: ' . $e->getMessage());
    error_log('Stack Trace: ' . $e->getTraceAsString());
    echo json_encode(['status' => 'error', 'msg' => 'Exception', 'error' => $e->getMessage()]);
    exit;
}
