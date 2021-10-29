<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    require_once '../../config/connection.php';
    try {
        require_once '../function.php';
        deleteData('tasks', 'id', $id);
        http_response_code(204);
    } catch (PDOException $ex) {
        echo json_encode($ex->getMessage());
        http_response_code(500);
    }
} else {
    http_response_code(404);
}
