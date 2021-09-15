<?php
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $name = $_POST['name'];
    $description = $_POST['postDesc'];
    $image = $_FILES['image'];
    $category = $_POST['category'];
    $heading = $_POST['heading'];
    $tags = $_POST['tags'];
    $tags_arr = explode(',', $tags);
    $errors = [];
    // var_dump($image);
    $image_tmp = $image['tmp_name'];
    $image_type = $image['type'];
    $image_size = $image['size'];
    $image_name = $image['name'];

    if ($name == "") {
        array_push($errors, "Name dont leave empty");
    }
    if ($description == "") {
        array_push($errors, "Description must not be empty");
    }
    if ($category == 0) {
        array_push($errors, "U must pick category");
    }
    if ($heading == 0) {
        array_push($errors, "U must pick heading");
    }
    if (count($tags_arr) == 0) {
        array_push($errors, "You must pick at least one tag");
    }
    if ($image_size > 3000000) {
        array_push($errors, "Image must be less than 3mb");
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo json_encode($error);
            http_response_code(422);
        }
    } else {
        require_once '../../config/connection.php';
        require_once '../function.php';
        $resize_image =  resizeImage($_FILES['image'], '../../assets/images/posts/normal/', '../../assets/images/posts/thumbnail/');

        $checkPostName = getOneFetchAndCheckData('posts', 'name', $_POST['name'], 'check');
        if ($checkPostName > 0) {
            echo json_encode("This name for the post is already taken");
            http_response_code(409);
        } else {
            try {
                insertPost($name, $description, $resize_image, $category, $heading, $tags_arr);
                echo json_encode("Post is successfully added");
                http_response_code(201);
            } catch (PDOException $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        }
    }
} else {
    http_response_code(404);
}
