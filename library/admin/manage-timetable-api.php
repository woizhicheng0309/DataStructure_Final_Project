<?php
// manage-timetable-api.php
header('Content-Type: application/json');
try {
    include('../includes/config.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        if ($action === 'add') {
            $teacher_id = $_POST['老師編號'] ?? '';
            $class_time = $_POST['上課時間'] ?? '';
            $classroom = $_POST['上課教室'] ?? '';
            $sql = "INSERT INTO 老師課表 (老師編號, 上課時間, 上課教室) VALUES (:teacher_id, :class_time, :classroom)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':teacher_id', $teacher_id);
            $query->bindParam(':class_time', $class_time);
            $query->bindParam(':classroom', $classroom);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '新增失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'delete') {
            $teacher_id = $_POST['老師編號'] ?? '';
            $class_time = $_POST['上課時間'] ?? '';
            $sql = "DELETE FROM 老師課表 WHERE 老師編號 = :teacher_id AND 上課時間 = :class_time";
            $query = $dbh->prepare($sql);
            $query->bindParam(':teacher_id', $teacher_id);
            $query->bindParam(':class_time', $class_time);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '刪除失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }
        if ($action === 'edit') {
            $teacher_id = $_POST['老師編號'] ?? '';
            $class_time = $_POST['上課時間'] ?? '';
            $classroom = $_POST['上課教室'] ?? '';
            $old_teacher_id = $_POST['old_老師編號'] ?? $teacher_id;
            $old_class_time = $_POST['old_上課時間'] ?? $class_time;
            $sql = "UPDATE 老師課表 SET 老師編號 = :teacher_id, 上課時間 = :class_time, 上課教室 = :classroom WHERE 老師編號 = :old_teacher_id AND 上課時間 = :old_class_time";
            $query = $dbh->prepare($sql);
            $query->bindParam(':teacher_id', $teacher_id);
            $query->bindParam(':class_time', $class_time);
            $query->bindParam(':classroom', $classroom);
            $query->bindParam(':old_teacher_id', $old_teacher_id);
            $query->bindParam(':old_class_time', $old_class_time);
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
