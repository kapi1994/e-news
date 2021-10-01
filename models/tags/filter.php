<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $text = $_GET['text'];
    $order = $_GET['order'];
    $compareString = trim("%$text%");
    require_once '../../config/connection.php';
    $baseQuery =  "SELECT * FROM tags ";
    if ($text) {
        // echo json_encode('filtriranje');
        $baseQuery .= "WHERE name LIKE '$compareString'";
        // echo json_encode($baseQuery);
    }
    if ($order) {
        if ($order == 0) {
            $baseQuery .= " ORDER BY created_at DESC";
        } else {
            $baseQuery .= " ORDER BY created_at ASC";
        }
    } else {
        $baseQuery .= " ORDER BY created_at DESC";
    }
    $query = $conn->query($baseQuery)->fetchAll();
    echo json_encode($query);
} else {
    http_response_code(404);
}
