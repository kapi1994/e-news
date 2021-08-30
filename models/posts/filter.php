<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $text = trim(isset($_GET['text'])) ? $_GET['text'] : '';
    $categories = isset($_GET['categories']) ? $_GET['categories'] : '';
    $headings = isset($_GET['headings']) ? $_GET['headings'] : '';
    $date = isset($_GET['sortByDate']) ? $_GET['sortByDate'] : '';
    $pagination  = isset($_GET['limit']) ? $_GET['limit'] : '';


    require_once '../../config/connection.php';
    require_once '../functions.php';

    $f = postFilter($text, $categories, $headings, $pagination, $date);
    $rez = $conn->query($f[0])->fetchAll();

    $res = $conn->query($f[1])->fetch(PDO::FETCH_ASSOC);
    $numOfPages = ceil($res['NumOfPost'] / 5);
    // ech ojsoN
    echo json_encode([
        'posts' => $rez,
        'pages' => $numOfPages
    ]);
} else {
    http_response_code(404);
}
