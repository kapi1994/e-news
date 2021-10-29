<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $text = $_GET['text'];
    $order = $_GET['order'] ? $_GET['order'] : 0;

    $compareString = trim("%$text%");
    $pagination = isset($_GET['limit']) ? $_GET['limit'] : 0;
    require_once '../../config/connection.php';
    require_once '../function.php';

    $elements = getAllTags($pagination, $compareString, $order);
    $numOfPages = getNumOfTags('pagination', $compareString);
    echo json_encode([
        'tags' => $elements,
        'pages' => $numOfPages,
        'limit' => $pagination
    ]);
} else {
    http_response_code(404);
}
