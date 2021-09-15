<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once '../../config/config.php';
    require_once "../function.php";
    $tags = getAll('tags');
    echo json_encode($tags);
} else {
    http_response_code(404);
}
