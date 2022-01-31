<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    require_once '../../config/connection.php';
    require_once '../function.php';
    $users = getAllUsers();
    define('LIMIT', 0);
    $pages = getNumOfUsers('pagination');
    echo json_encode([
        'users' => $users,
        'pages' => $pages,
        'limit' => LIMIT
    ]);
    echo json_encode($users);
} else {
    http_response_code(404);
}
