<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    require_once '../../config/connection.php';
    require_once '../functions.php';

    $getHeadings = getDataWithFetch('headings', 'category_id', $_GET['id']);
    echo json_encode($getHeadings);
} else {
    http_response_code(404);
}
