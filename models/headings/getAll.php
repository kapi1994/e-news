<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once '../../config/connection.php';
    require_once '../function.php';
    define('LIMIT', 0);
    $headings = getHeadingWithCategory();
    $pages = getNumOfHeadings('pagination');
    echo json_encode([
        'headings' => $headings,
        'pages' => $pages,
        'limit' => LIMIT
    ]);
} else {
    http_response_code(404);
}
