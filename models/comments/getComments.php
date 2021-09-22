<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $post = $_GET['post'];
    $comment = $_GET['comment'];
    require_once '../../config/connection.php';
    require_once '../function.php';
    $comments = getComments($post, $comment);
} else {
    http_response_code(404);
}
