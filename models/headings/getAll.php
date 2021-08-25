<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once '../../config/connection.php';
    $headings = $conn->query('SELECT h.*, c.name as categoryName FROM headings h JOIN categories c ON h.category_id = c.id')->fetchAll();
    echo json_encode($headings);
} else {
    http_response_code(404);
}
