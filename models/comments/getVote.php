<?php
session_start();
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $comment_id = $_GET['comment_id'];
    $user_id = isset($_SESSION['user']) ? $_SESSION['user']->id : "";
    $action = isset($_GET['action']);
    require_once '../../config/connection.php';
    require_once '../function.php';
    $res = getVote($comment_id, $user_id);
    $countLikeVotes = countVote($comment_id, 'likes', 'likeCount');
    $countDisslikeVotes = countVote($comment_id, 'disslikes', 'disslikeCount');
    echo json_encode([
        'vote' => $res,
        'user_id' => $user_id,
        'likeCount' => $countLikeVotes,
        'disslikeCount' => $countDisslikeVotes
    ]);
} else {
    http_response_code(404);
}
