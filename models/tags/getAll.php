<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once '../../config/config.php';
    require_once "../function.php";
    $tags = getAll('tags');
    $pages =  getNumOfTags('pagination');
    define('LIMIT', 0);
    // echo json_encode($tags);
    echo json_encode([
        'tags' => $tags,
        'pages' => $pages,
        'limit' => LIMIT
    ]);
} else {
    http_response_code(404);
}
