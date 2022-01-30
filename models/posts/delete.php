<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once '../../config/connection.php';
    require_once '../function.php';
    try {
        deleteData('posts', 'id', $_POST['id']);
        http_response_code(204);
    } catch (PDOException $th) {
        echo json_encode("This data can't be delete");
        http_response_code(500);
    }
} else {
    http_response_code(404);
}
