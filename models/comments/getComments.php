<?php
session_start();
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $post = $_POST['post_id'];
    $parent_comment = isset($_POST['comments']) ? $_POST['comments'] : 0;
    require_once '../../config/connection.php';
    require_once '../function.php';
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';
    $comments = getCommentsWithReaction($post, $parent_comment);
    echo json_encode([
        'comments' => $comments,
        'user' => $user
    ]);
} else {
    http_response_code(404);
}
