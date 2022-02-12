<?php
session_start();
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {


    $user = $_SESSION['user'];
    $text = $_GET['text'];
    $compareString = trim("%$text%");
    $order = $_GET['order']  ? $_GET['order'] : 0;

    $limit = isset($_GET['limit']) ? $_GET['limit'] : 0;


    require_once '../../config/connection.php';
    require_once '../function.php';

    $res = getHeadingWithCategory($user, $limit, $compareString, $order);
    $pages = getNumOfHeadings($user, 'pagination', $compareString);
    echo json_encode([
        'headings' => $res,
        'pages' => $pages,
        'limit' => $limit
    ]);
    http_response_code(200);
} else {
    http_response_code(404);
}
