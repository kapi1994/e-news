<?php

header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once '../../config/connection.php';
    require_once '../function.php';
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';
    $posts = getAllPosts();
    $pages = getNumOfPosts('pagination', $user);
    define("LIMIT", 0);

    echo json_encode([
        'posts' => $posts,
        'pages' => $pages,
        'limit' => LIMIT
    ]);
} else {
    http_response_code(404);
}
