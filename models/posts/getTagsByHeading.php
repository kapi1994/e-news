<?php
header("Content-type:appilcation/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $heading_id = $_GET['heading_id'];
    $post = $_GET['post_id'];
    try {
        require_once '../../config/connection.php';
        require_once '../function.php';
        $getAllTags = getTagsByHeading($heading_id);
        $postTags = getSelectedTags($post);
        echo json_encode([
            'allTags' => $getAllTags,
            'postTag' => $postTags
        ]);
    } catch (PDOException $th) {
        echo json_encode($th->getMessage());
        http_response_code(500);
    }
} else {
    http_response_code(404);
}
