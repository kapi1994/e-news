<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $post = $_POST['post_id'];
    $parent_comment = isset($_POST['comments']) ? $_POST['comments'] : 0;
    require_once '../../config/connection.php';
    require_once '../function.php';

    $comments = getCommentsWithReaction($post, $parent_comment);
} else {
    http_response_code(404);
}
