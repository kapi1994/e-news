<?php
session_start();
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require_once '../../config/connection.php';
    require_once '../functions.php';
    $action = $_POST['action'];
    $post_id = $_POST['post'];
    // echo json_encode($post_id);
    $comment_id = $_POST['comment'];

    $id_user = isset($_SESSION['users']) ? $_SESSION['users']->id : '';
    // echo json_encode($post_id);
    // echo json_encode($comment_id);
    // echo json_encode($action);

    $q = checkIsReacted('reactions', $post_id, $comment_id, $id_user);
    //var_dump($q);
    define("REACT_ON", 1);
    define("REACT_OFF", 0);
    if ($q->rowCount() == 0) {

        if ($action == "like") {
            try {
                insertReaction('reactions', 'like', $post_id, $comment_id, $id_user, REACT_ON);
                echo json_encode("Commet is added");
                http_response_code(201);
            } catch (PDOException $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        } else {
            try {
                insertReaction('reactions', 'disslike', $post_id, $comment_id, $id_user, REACT_ON);
                echo json_encode("Disslike is added");
                http_response_code(201);
            } catch (PDOException $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        }
    } else {
        $res = $q->fetch();
        // echo json_encode($res);
        if ($action == "like") {
            // echo json_encode('like');
            if ($res->likes > 0) {
                try {
                    deleteVote('reactions', 'like', $post_id, $comment_id, $id_user);
                    http_response_code(204);
                } catch (PDOException $th) {
                    echo json_encode($th->getMessage());
                    http_response_code(500);
                }
            } else if ($res->likes ==  0 && $res->disslikes > 0) {
                try {
                    voteChange('reactions', 'disslike', 'like', REACT_ON, REACT_OFF, $comment_id, $post_id, $id_user);
                } catch (PDOException $th) {
                    echo json_encode($th->getMessage());
                    http_response_code(500);
                }
            }
        } else {
            if ($res->disslikes > 0) {
                try {
                    deleteVote('reactions', 'disslike', $post_id, $comment_id, $id_user);
                    http_response_code(204);
                } catch (PDOException $th) {
                    echo json_encode($th->getMessage());
                }
            } else if ($rez->disslikes == 0 && $res->likes > 0) {
                try {
                    voteChange('reactions', 'like', 'disslike', REACT_OFF, REACT_ON, $comment_id, $post_id, $id_user);
                } catch (PDOException $th) {
                    echo json_encode($th->getMessage());
                    http_response_code(500);
                }
            }
        }
    }
} else {
    http_response_code(404);
}
