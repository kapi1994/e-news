<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $post = $_POST['post_id'];
    $parent_comment = isset($_POST['comments']) ? $_POST['comments'] : 0;
    require_once '../../config/connection.php';
    require_once '../function.php';

    $comments = getComments($post, $parent_comment);
    $comment_like_count = [];
    var_dump($comments);

    // echo json_encode([
    //     'comments' => $comments,
    //     'comment_like' => $comment_like_count
    // ]);
    // echo json_encode($comments);
} else {
    http_response_code(404);
}
