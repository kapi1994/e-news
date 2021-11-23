<?php

header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    try {
        require_once '../../config/connection.php';
        require_once '../function.php';
        deleteData('users', 'id', $_POST['id']);
        http_response_code(204);
    } catch (PDOException $th) {
        echo json_encode($th->getMessage());
        http_response_code(500);
    }
} else {
    http_response_code(404);
}
