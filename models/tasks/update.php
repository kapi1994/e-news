<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
    if ($desc) {
        echo json_encode("desc");
    } else {
        echo json_encode($id);
    }
} else {
    http_response_code(404);
}
