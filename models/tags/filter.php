<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $text = $_GET['text'];
    $order = $_GET['order'];
    $compareString = trim("%$text%");
    $pagination = $_GET['limit'];
    require_once '../../config/connection.php';
    $query  = '';
    $baseQueryA = "SELECT COUNT(*) as numOfTags FROM tags";
    $baseQueryB =  "SELECT * FROM tags ";
    if ($text) {
        // echo json_encode('filtriranje');
        $query .= "WHERE name LIKE '$compareString'";
        // echo json_encode($baseQuery);
    }
    if ($order) {
        if ($order == 0) {
            $query .= " ORDER BY created_at DESC";
        } else {
            $query .= " ORDER BY created_at ASC";
        }
    } else {
        $query .= " ORDER BY created_at DESC";
    }
    define("OFFSET", 5);
    // $offse
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

    // $query = $conn->query($baseQuery)->fetchAll();
    // echo json_encode($query);

    $baseQueryB = $baseQueryB . $query;
    $res = $conn->query($baseQueryA)->fetch();
    $elements = $conn->query($baseQueryB)->fetchAll();
    $numOfPages = ceil($res->numOfTags / $offset);
    echo json_encode([
        'tags' => $elements,
        'pages' => $numOfPages,
        'limit' => $pagination
    ]);
} else {
    http_response_code(404);
}
