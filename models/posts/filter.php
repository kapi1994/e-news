<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $text = $_GET['text'];
    $compareString = trim("%$text%");
    $order  = $_GET['order'];
    $categories = isset($_GET['categories']) ? $_GET['categories'] : '';
    $headings = isset($_GET['headings']) ? $_GET['headings'] : '';


    require_once '../../config/connection.php';
    require_once '../function.php';

    $baseQuery = "SELECT p.*, c.name as categoryName, h.name as headingName FROM posts p JOIN categories c ON p.category_id = c.id JOIN headings h ON p.heading_id = h.id";


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


    // echo json_encode($baseQuery);
    $res = $conn->query($baseQuery)->fetchAll();
    echo json_encode($res);
} else {
    http_response_code(404);
}
