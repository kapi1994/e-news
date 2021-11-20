<?php
session_start();
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $post = $_GET['post'];
    $parent_comment = isset($_GET['comment']) ? $_GET['comment'] : 0;
    $user_id = $_GET['user'];
    require_once '../../config/connection.php';
    require_once '../function.php';
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';
    $comments = getCommentsWithReaction($post, $user_id, $parent_comment);
    echo json_encode([
        'comments' => $comments,
        'user' => $user
    ]);
} else {
    http_response_code(404);
}
