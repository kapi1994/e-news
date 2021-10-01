<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $category = $_GET['id'];
    require_once '../../config/connection.php';
    require_once '../function.php';
    $res = getOneFetchAndCheckData('headings', 'category_id', $category, 'fetch');
    echo json_encode($res);
} else {
    http_response_code(404);
}
