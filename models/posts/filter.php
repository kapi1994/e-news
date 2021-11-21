<?php
session_start();
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $text = $_GET['text'];
    $order  = $_GET['order'] ? $_GET['order'] : 0;
    $categories = isset($_GET['categories']) ? $_GET['categories'] : '';

    $headings = isset($_GET['headings']) ? $_GET['headings'] : '';

    $pagination = isset($_GET['limit']) ? $_GET['limit'] : 0;

    $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';
    require_once '../../config/connection.php';
    require_once '../function.php';
    $categories_arr =  isset($_GET['categories']) ? implode(', ', $categories) : '';
    $headings_arr =   isset($_GET['headings']) ? implode(', ', $headings) : '';


    $elements =  postPagination($user, $pagination, $text, $order, $categories_arr, $headings_arr);
    $pages = getNumOfPosts('pagination', $user, $categories_arr, $headings_arr, $text);

    echo json_encode([
        'posts' => $elements,
        'pages' => $pages,
        'limit' => $pagination
    ]);
} else {
    http_response_code(404);
}
