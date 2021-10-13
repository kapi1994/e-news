<?php
session_start();
header("Content-type:application/json");
$res = '';
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    require_once '../../config/connection.php';
    $baseQuery = "SELECT * FROM tasks";
    if (isset($_SESSION['user']) && $_SESSION['user']->roleName == "Urednik") {
        $user = $_SESSION['user'];
        $query = "WHERE user_id == '$user->id'";
        $baseQuery = $baseQuery . $query;
    }
    $base = $conn->query($baseQuery);
    if ($base->rowCount() > 1) {
        $res = $base->fetchAll();
    } else {
        $res = $base->fetch();
    }
    echo json_encode($res);
} else {
    http_response_code(404);
}
