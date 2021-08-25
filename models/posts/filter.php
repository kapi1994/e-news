<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $text = trim(isset($_GET['text'])) ? $_GET['text'] : '';
    $categories = isset($_GET['categories']) ? $_GET['categories'] : '';
    $headings = isset($_GET['headings']) ? $_GET['headings'] : '';
    $date = isset($_GET['sortByDate']) ? $_GET['sortByDate'] : '';
    $pagination  = isset($_GET['limit']) ? $_GET['limit'] : '';


    require_once '../../config/connection.php';
    // echo json_encode($pagination);
    $query = '';
    define("OFFSET", 5);
    $queryA = "SELECT COUNT(*) AS numOfPosts FROM posts ";
    $baseQuery = "SELECT * FROM posts ";
    if ($text) {
        $query .= " WHERE";
        $query .= " name LIKE '%$text%'";
    }
    if ($categories) {
        $query .= " WHERE";
        if ($text) {
            $query .= " AND category_id IN (" . implode(',', $categories) . ")";
        } else {
            $query .= " category_id IN (" . implode(',', $categories) . ")";
        }
    }
    if ($headings) {

        if ($text || $categories) {
            $query .= " AND heading_id IN (" . implode(',', $headings) . ")";
        } else {
            $query .= "  heading_id IN (" . implode(',', $headings) . ")";
        }
    }

    $queryA = $queryA . $query;


    if ($date != 0) {
        if ($date == 1) {
            $query .= " ORDER BY created_at DESC ";
        } else {
            $query .= " ORDER BY created_at ASC";
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
    $baseQuery = $baseQuery . $query;
    //echo json_encode($baseQuery);
    $rez = $conn->query($baseQuery)->fetchAll();
    //echo json_encode($baseQuery);
    $res = $conn->query($queryA)->fetch(PDO::FETCH_ASSOC);
    // echo json_encode($baseQuery);
    $numOfPages = ceil($res['numOfPosts'] / OFFSET);

    echo json_encode([
        'posts' => $rez,
        'pages' => $numOfPages
    ]);
} else {
    http_response_code(404);
}
