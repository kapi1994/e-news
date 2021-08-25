<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require_once '../../config/connection.php';
        require_once '../functions.php';
        $delete = deleteData('tags', 'id', $_POST['id']);
        http_response_code(204);
    } catch (PDOException $th) {
        echo json_encode($th->getMessage());
        http_response_code(500);
    }
} else {
    http_response_code(404);
}
