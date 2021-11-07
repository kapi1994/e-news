<?php
session_start();
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $comment_id = $_GET['comment_id'];
    $user_id = isset($_SESSION['user']) ? $_SESSION['user']->id : "";

    require_once '../../config/connection.php';
    require_once '../function.php';
    $res = getVote($comment_id, $user_id);
    echo json_encode($res);
} else {
    http_response_code(404);
}
