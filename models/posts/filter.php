<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $text = $_GET['text'];
    $compareString = trim("%$text%");
    $order  = $_GET['order'] ? $_GET['limit'] : 0;
    $categories = isset($_GET['categories']) ? $_GET['categories'] : '';
    $headings = isset($_GET['headings']) ? $_GET['headings'] : '';
    $pagination = isset($_GET['limit']) ? $_GET['limit'] : 0;

    require_once '../../config/connection.php';
    require_once '../function.php';
    $categories_arr =  isset($_GET['categories'])    ? implode(', ', $categories) : '';
    $headings_arr =   isset($_GET['headings']) ? implode(', ', $headings) : '';

    $elements =  postPagination($pagination, $compareString, $categories_arr, $headings_arr, $order);
    $pages = getPostPagination('pagination', $categories_arr, $headings_arr, $compareString);

    echo json_encode([
        'posts' => $elements,
        'pages' => $pages,
        'limit' => $pagination
    ]);
} else {
    http_response_code(404);
}
