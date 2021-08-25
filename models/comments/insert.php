<?php
session_start();
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $comment_id = isset($_POST['comment_id']) ? $_POST['comment_id'] : 0;
    $post_id  = $_POST['post_id'];
    $text = $_POST['text'];
    $user_id = isset($_SESSION['users']) ? $_SESSION['users']->id : '';

    try {
        require_once '../../config/connection.php';
        require_once '../functions.php';
        insertNewComment('comments', $post_id, $user_id, $comment_id, $text);
        echo json_encode("Comment is sussfull added");
        http_response_code(201);
    } catch (PDOException $th) {
        echo json_encode($th->getMessage());
        http_response_code(500);
    }
} else {
    http_response_code(404);
}
