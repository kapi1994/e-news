<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $text = $_GET['text'];
    $compareString = trim("%$text%");
    $order = $_GET['order'];
    $role = $_GET['role'];


    require_once '../../config/connection.php';
    $baseQuery = "SELECT  u.*, r.name as roleName FROM users u JOIN roles r ON u.role_id = r.id WHERE r.name != 'Admin'";
    if ($compareString) {
        $baseQuery .= " AND (last_name like '$compareString' OR first_name LIKE '$compareString')";
    }
    if ($role) {
        $baseQuery .= " AND role_id = '$role'";
    }
    if ($order) {
        if ($order == 0) {
            $baseQuery .= " ORDER BY created_at DESC";
        } else {
            $baseQuery .= " ORDER BY created_at ASC";
        }
    } else {
        $baseQuery .= " ORDER BY created_at DESC";
    }
    $res = $conn->query($baseQuery)->fetchAll();
    echo json_encode($res);
} else {
    http_response_code(404);
}
