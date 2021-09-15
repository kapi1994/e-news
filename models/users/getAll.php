<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    require_once '../../config/connection.php';
    require_once '../function.php';
    $users = getAllUsers();
    echo json_encode($users);
} else {
    http_response_code(404);
}
