<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $text = $_GET['text'];
    $compareString = trim("%$text%");
    $order = $_GET['order'];
    require_once '../../config/connection.php';
    $baseQuery =  "SELECT h.*, c.name as categoryName FROM headings h INNER JOIN categories c ON h.category_id = c.id ";
    if ($text) {
        // echo json_encode('filtriranje');
        $baseQuery .= "WHERE h.name LIKE '$compareString'";
        // echo json_encode($baseQuery);
    }
    if ($order) {
        if ($order == 0) {
            $baseQuery .= " ORDER BY h.created_at DESC";
        } else {
            $baseQuery .= " ORDER BY h.created_at ASC";
        }
    } else {
        $baseQuery .= " ORDER BY h.created_at DESC";
    }
    $query = $conn->query($baseQuery)->fetchAll();
    echo json_encode($query);
} else {
    http_response_code(404);
}
