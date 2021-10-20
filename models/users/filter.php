<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $text = $_GET['text'];
    $compareString = trim("%$text%");
    $order = $_GET['order'] ? $_GET['order'] : 0;
    $role = $_GET['role'];
    $limit = isset($_GET['limit']) ? $_GET['limit'] : 0;

    require_once '../../config/connection.php';
    require_once '../function.php';
    $usersPagination = userPagination($limit, $compareString, $role, $order);
    $userPages = getNumOfUsers('pagination', $compareString, $role);
    echo json_encode([
        'res' => $usersPagination,
        'pages' => $userPages,
        'limit' => $limit
    ]);
} else {
    http_response_code(404);
}
