<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once '../../config/connection.php';
    $post_id = $_GET['post_id'];
    $comment_id = isset($_GET['comment_id']) ? $_GET['comment_id'] : 0;
    $getAll = readComments('comments', 'users', $post_id, $comment_id);
    echo json_encode($getAll);
} else {
    http_response_code(404);
}
