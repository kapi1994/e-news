<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once '../../config/connection.php';
    require_once '../function.php';
    $headings = getHeadingWithCategory();
    echo json_encode($headings);
} else {
    http_response_code(404);
}
