<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $text = isset($_GET['text']) ? $_GET['text'] : '';
    $date = isset($_GET['date']) ? $_GET['text'] : '';
    $pagination = isset($_GET['limit']) ? $_GET['limit'] : '';
    require_once '../../config/connection.php';

    define("OFFSET", 5);

    $queryA = "SELECT  COUNT(*) as numOfUsers FROM users";
    $queryB = "SELECT * FROM users";

    $query = '';
    if ($text) {
        $query .= " WHERE first_name LIKE '%$text%' OR last_name LIKE '%$text%' OR email LIKE '%$text%' ";
    }
    $queryA = $queryA . $query;

    if ($date != 0) {
        if ($date == 1) {
            $query .= " ORDER BY created_at DESC, email";
        } else {
            $query .= " ORDER BY created_at ASC, email";
        }
    }


    if ($pagination && $pagination > 0) {
        $limit = ((int)$_GET['limit']) * OFFSET;
        $offset = OFFSET;
        $query .= " LIMIT $limit, $offset";
    } else if ($pagination == 0 || !$pagination) {
        $limit = 0;
        $offset = OFFSET;
        $query .= " LIMIT $limit, $offset";
    }
    $res = $conn->query($queryA)->fetch(PDO::FETCH_ASSOC);
    $queryB  = $queryB . $query;
    $resB = $conn->query($queryB)->fetchAll();
    $numOfPages = ceil($res['numOfUsers'] / OFFSET);
    echo json_encode([
        'users' => $resB,
        'pages' => $numOfPages
    ]);
} else {
    http_response_code(404);
}
