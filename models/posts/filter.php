<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $text = $_GET['text'];
    $compareString = trim("%$text%");
    $order  = $_GET['order'];
    $categories = isset($_GET['categories']) ? $_GET['categories'] : '';
    $headings = isset($_GET['headings']) ? $_GET['headings'] : '';
    $pagination = $_GET['limit'];
    define("OFFSET", 5);
    $offset = OFFSET;
    require_once '../../config/connection.php';
    require_once '../function.php';
    $baseQueryA = "SELECT COUNT(*) as postCount from posts p";
    $baseQueryB = "SELECT p.*, c.name as categoryName, h.name as headingName FROM posts p JOIN categories c ON p.category_id = c.id JOIN headings h ON p.heading_id = h.id";

    $baseQuery = '';
    if ($text) {
        $baseQuery .= " WHERE p.name LIKE '$compareString'";
    }

    if ($categories) {
        //echo json_encode('da');
        if ($text && $categories) {
            $baseQuery .= " AND p.category_id IN (" . implode(',', $categories) . ")";
        } else {
            $baseQuery .= " WHERE p.category_id IN (" . implode(',', $categories) . ")";
        }
    }

    if ($headings) {
        if ($text && $categories) {
            $baseQuery .= " AND p.heading_id IN (" . implode(',', $headings) . ")";
        } else if ($text) {
            $baseQuery .= " AND p.heading_id IN (" . implode(',', $headings) . ")";
        } else if ($categories) {
            $baseQuery .= " AND p.heading_id IN (" . implode(',', $headings) . ")";
        } else {
            $baseQuery .= " WHERE p.heading_id IN (" . implode(',', $headings) . ")";
        }
    }

    if ($order) {
        if ($order == 0) {
            $baseQuery .= " ORDER BY p.created_at DESC";
        } else {
            $baseQuery .= " ORDER BY p.created_at ASC";
        }
    } else {
        $baseQuery .= " ORDER BY p.created_at DESC";
    }

    $baseQueryA = $baseQueryA . $baseQuery;
    if ($pagination && $pagination > 0) {
        $limit = ((int)$_GET['limit']) * OFFSET;
        $offset = OFFSET;
        $baseQuery .= " LIMIT $limit, $offset";
    } else if ($pagination == 0 || !$pagination) {
        $limit = 0;
        $offset = OFFSET;
        $baseQuery .= " LIMIT $limit, $offset";
    }
    // echo json_encode($baseQueryA);
    $baseQueryB = $baseQueryB . $baseQuery;
    // // echo json_encode($baseQueryA);
    $rez = $conn->query($baseQueryB)->fetchAll();
    $res = $conn->query($baseQueryA)->fetch();
    $numOfPages = ceil($res->postCount / OFFSET);
    echo json_encode([
        'posts' => $rez,
        'pages' => $numOfPages,
        'limit' => $pagination
    ]);
} else {
    http_response_code(404);
}
