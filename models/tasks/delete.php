<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id -  $_POST['id'];
    require_once '../../config/connection.php';
    try {
        $del =  $conn->prepare("DELETE tasks FROM id = ?");
        $del->execute([$id]);
        http_response_code(204);
    } catch (PDOException $ex) {
        echo json_encode($ex->getMessage());
        http_response_code(500);
    }
} else {
    http_response_code(404);
}
