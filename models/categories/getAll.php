<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    require_once '../../config/connection.php';
    require_once '../functions.php';
    $categories  = getAll('categories');
    echo json_encode($categories);
} else {
    http_response_code(404);
}
