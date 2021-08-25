<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $comment_id = $_GET['comment'];
    require_once '../../config/connection.php';
    $id = isset($_SESSION['users']) ? $_SESSION['users']->id : '';
    $userLikes = $conn->query("SELECT user_id FROM reactions WHERE comment_id = $comment_id AND user_id = $id  AND likes != 0")->fetch();
    $userDislike = $conn->query("SELECT user_id FROM reactions WHERE comment_id = $comment_id AND user_id = $id AND disslikes > 0")->fetch();
    $countLikes = $conn->query("SELECT COUNT(likes) as likes FROM reactions WHERE comment_id = $comment_id AND likes > 0 LIMIT 1")->fetch();
    $countDislike = $conn->query("SELECT COUNT(disslikes) as disslike FROM reactions WHERE comment_id = $comment_id AND disslikes > 0 LIMIT 1")->fetch();
    echo json_encode([
        'user_id' => $id,
        'userLikes' => $userLikes,
        'userDisslikes' => $userDislike,
        'countLikes' => $countLikes,
        'countDisslike' => $countDislike
    ]);
} else {
    http_response_code(404);
}
