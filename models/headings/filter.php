<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $query = '';

    $text = $_GET['text'];
    $compareString = trim("%$text%");
    $order = $_GET['order'];
    $pagination = $_GET['limit'];
    define("OFFSET", 5);
    $offset = OFFSET;
    require_once '../../config/connection.php';
    require_once '../function.php';
    // $query = ''
    $baseQueryA = "SELECT COUNT(*) as headingElementsCount FROM headings h JOIN categories c ON h.category_id = c.id";
    $baseQueryB = "SELECT h.*, c.name as categoryName FROM headings h JOIN categories c ON h.category_id = c.id";
    if ($text) {
        $query .= "WHERE h.name LIKE '$compareString'";
    }
    if ($order) {
        if ($order == 0) {
            $query .= " ORDER BY h.created_at DESC";
        } else {
            $query .= " ORDER BY h.created_at ASC";
        }
    } else {
        $query .= " ORDER BY h.created_at DESC";
    }
    $baseQueryA = $baseQueryA . $query;
    if ($pagination && $pagination > 0) {
        $limit = ((int)$_GET['limit']) * OFFSET;
        $offset = OFFSET;
        $query .= " LIMIT $limit, $offset";
    } else if ($pagination == 0 || !$pagination) {
        $limit = 0;
        $offset = OFFSET;
        $query .= " LIMIT $limit, $offset";
    }

    $baseQueryB = $baseQueryB . $query;
    // echo json_encode($baseQueryA);
    $rez = $conn->query($baseQueryB)->fetchAll();
    $res = $conn->query($baseQueryA)->fetch();
    $numOfPages = ceil($res->headingElementsCount / OFFSET);
    echo json_encode([
        'headings' => $rez,
        'pages' => $numOfPages,
        'limit' => $pagination
    ]);
} else {
    http_response_code(404);
}
