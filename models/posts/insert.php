<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $desc = $_POST['postDesc'];
    $image = $_FILES['image'];
    $category = $_POST['category'];
    $heading = $_POST['heading'];
    $tags = $_POST['tags'];
    $tags_arr = explode(",", $tags);


    $errors = [];
    if ($image['size'] > 3000000) {
        array_push($errors, "Image size must be less than 3mb");
    }
    if ($category == 0) {
        array_push($errors, "You must choose category for the post!");
    }
    if ($heading == 0) {
        array_push($errors, "You must choose heading for the post");
    }
    if (count($tags_arr) == 0) {
        array_push($errors, "You must choose at least one tag!");
    }
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode("Error: " . $error);
            http_response_code(422);
        }
    } else {
        require_once '../../config/connection.php';
        require_once '../functions.php';
        $checkName = getOneWithoutFetch('posts', 'name', $_POST['name']);
        if ($checkName->rowCount() > 0) {
            echo json_encode('Name of the post is already taken');
            http_response_code(409);
        } else {
            try {
                $image = resizeImage($_FILES['image'], "../../assets/images/posts/normal/", "../../assets/images/posts/thumbnail/");
                $conn->beginTransaction();
                createNewPost('posts', 'post_tag', $name, $desc, $image, $category, $heading, $tags_arr);
                $conn->commit();
                http_response_code(201);
                echo json_encode("Post is successfully created");
            } catch (PDOException $th) {
                $conn->rollback();
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        }
    }
}
