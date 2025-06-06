<?php
header('Content-Type: application/json');
session_start();
ob_clean();

// Ensure no HTML or warnings are output before JSON response
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    include('../includes/config.php');

    // Log output for debugging
    ob_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        error_log('Action: ' . $action);
        error_log('POST Data: ' . print_r($_POST, true));

        if ($action === 'add') {
            $teacherId = $_POST['teacherId'] ?? '';
            $department = $_POST['department'] ?? '';
            $position = $_POST['position'] ?? '';

            // Validate input
            if (!is_numeric($teacherId) || empty($department) || empty($position)) {
                echo json_encode(['status' => 'error', 'msg' => '缺少必要欄位或資料格式不正確']);
                exit;
            }

            try {
                // Check if teacherId already exists
                $sqlCheck = "SELECT COUNT(*) FROM 老師校內經歷 WHERE 老師編號 = :teacherId";
                $queryCheck = $dbh->prepare($sqlCheck);
                $queryCheck->bindParam(':teacherId', $teacherId, PDO::PARAM_INT);
                $queryCheck->execute();
                $count = $queryCheck->fetchColumn();

                error_log('SQL Check Query: ' . $sqlCheck);
                error_log('Bound Parameters for Check: teacherId=' . $teacherId);

                if ($count > 0) {
                    echo json_encode(['status' => 'error', 'msg' => '老師編號已存在，無法新增']);
                    exit;
                }

                $sql = "INSERT INTO 老師校內經歷 (老師編號, 部門, 職位) VALUES (:teacherId, :department, :position)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':teacherId', $teacherId, PDO::PARAM_INT);
                $query->bindParam(':department', $department, PDO::PARAM_STR);
                $query->bindParam(':position', $position, PDO::PARAM_STR);

                error_log('Database connection successful.');
                error_log('SQL Insert Query: ' . $sql);
                error_log('Bound Parameters for Insert: teacherId=' . $teacherId . ', department=' . $department . ', position=' . $position);

                if ($query->execute()) {
                    echo json_encode(['status' => 'success', 'msg' => '新增成功']);
                } else {
                    $errorInfo = $query->errorInfo();
                    error_log('Insert Error Info: ' . print_r($errorInfo, true));
                    echo json_encode(['status' => 'error', 'msg' => '新增失敗', 'errorInfo' => $errorInfo]);
                }
            } catch (PDOException $e) {
                error_log('PDOException: ' . $e->getMessage());
                error_log('PDO Error Code: ' . $e->getCode());
                echo json_encode(['status' => 'error', 'msg' => '資料庫操作失敗', 'error' => $e->getMessage(), 'code' => $e->getCode()]);
            } catch (Exception $e) {
                error_log('Exception: ' . $e->getMessage());
                echo json_encode(['status' => 'error', 'msg' => '例外錯誤', 'error' => $e->getMessage()]);
            }
            exit;
        }

        if ($action === 'edit') {
            $id = $_POST['id'] ?? '';
            $department = $_POST['department'] ?? '';
            $position = $_POST['position'] ?? '';
            $sql = "UPDATE 老師校內經歷 SET 部門 = :department, 職位 = :position WHERE id = :id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id);
            $query->bindParam(':department', $department);
            $query->bindParam(':position', $position);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '修改失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }

        if ($action === 'delete') {
            $id = $_POST['id'] ?? '';
            $sql = "DELETE FROM 老師校內經歷 WHERE id = :id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id);
            if ($query->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => '刪除失敗', 'errorInfo' => $query->errorInfo()]);
            }
            exit;
        }

        if ($action === 'fetch') {
            $sql = "SELECT * FROM 老師校內經歷";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($results);
            exit;
        }
    }
    echo json_encode(['status' => 'error', 'msg' => 'Invalid request']);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'msg' => 'Exception', 'error' => $e->getMessage()]);
    exit;
}
?>
