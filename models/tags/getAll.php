<?php
header("Contnet-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once '../../config/connection.php';
    require_once '../functions.php';
    $getAll = getAll('tags');
    echo json_encode($getAll);
} else {
    http_response_code(500);
}
