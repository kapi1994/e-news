<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $text = trim(isset($_GET['text'])) ? $_GET['text'] : '';
    $date = isset($_GET['sortByDate']) ? $_GET['sortByDate'] : '';
    $pagination  = isset($_GET['limit']) ? $_GET['limit'] : '';


    require_once '../../config/connection.php';

    $query = '';
    define("OFFSET", 5);
    $queryA = "SELECT COUNT(*) AS numOfTags FROM tags";
    $baseQuery = "SELECT * FROM tags";
    if ($text) {
        $query .= " WHERE name LIKE '%$text%'";
    }
    if ($date != 0) {
        if ($date == 1) {
            $query .= " ORDER BY created_at DESC ";
        } else {
            $query .= " ORDER BY created_at ASC";
        }
    }
    $queryA = $queryA . $query;

    if ($pagination && $pagination > 0) {
        $limit = ((int)$_GET['limit']) * OFFSET;
        $offset = OFFSET;
        $query .= " LIMIT $limit, $offset";
    } else if ($pagination == 0 || !$pagination) {
        $limit = 0;
        $offset = OFFSET;
        $query .= " LIMIT $limit, $offset";
    }
    $baseQuery = $baseQuery . $query;

    //echo json_encode($queryA);
    $rez = $conn->query($baseQuery)->fetchAll();
    $res = $conn->query($queryA)->fetch(PDO::FETCH_ASSOC);
    //echo json_encode($res);
    // echo json_encode($rezPages['numOfTags']);
    // echo json_encode(gettype($rezPages['numOfTags']));
    $numOfPages = ceil($res['numOfTags'] / OFFSET);
    //echo json_encode($numOfPages);


    // $numOfPages = ceil((int)$rezPages['numOfTags'] / OFFSET);
    // // echo json_encode($rezPages);
    echo json_encode([
        'tags' => $rez,
        'pages' => $numOfPages
    ]);

    //echo json_encode($rez);
} else {
    http_response_code(404);
}
