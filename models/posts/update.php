<?php
session_start();
header("Content-type:application/json");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $desc = $_POST['postDesc'];

    $category = isset($_SESSION['user']) ? $_SESSION['user']->category_id : $_POST['category'];
    $heading = $_POST['heading'];
    $tags = $_POST['tags'];
    $tags_arr = explode(",", $tags);


    $errors = [];
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        if ($image['size'] > 3000000) {
            array_push($errors, "Image size must be less than 3mb");
        }
    }

    if (isset($_SESSION['user'])  && $_SESSION['user']->roleName == "Admin") {
        if ($category == 0) {
            array_push($errors, "You must choose category for the post!");
        }
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
        $date = date("Y-m-d H:i:s");
        require_once '../../config/connection.php';
        require_once '../function.php';
        $checkName = getOneFetchAndCheckData('posts', 'name', $_POST['name'], 'check');

        if ($checkName > 0) {
            $post =  getOneFetchAndCheckData('posts', 'name', $name, 'fetch');
            if ($post->id == $id && $post->name == $name) {
                if (isset($_FILES['image'])) {
                    try {
                        $image = resizeImage($_FILES['image'], '../../assets/images/posts/normal/', '../../assets/images/posts/thumbnail/');
                        $conn->beginTransaction();
                        $updateQuery = $conn->prepare("UPDATE posts SET name=?, description=?,image_path=?, updated_at=?, category_id =?, heading_id=?  WHERE id=?");
                        $updateQuery->execute([$name, $desc, $image, $date, $category, $heading, $id]);
                        // delete from post tag
                        $deletePostTag = deleteData('post_tag', 'post_id', $id);
                        if (count($tags_arr) > 0) {
                            $queryParams = [];
                            $values = [];
                            foreach ($tags_arr as $tag) {
                                $queryParams[] = "(?,?)";
                                $values[] =  (int)$id;
                                $values[] = (int)$tag;
                            }
                            $update_post_tag = $conn->prepare("INSERT INTO post_tag (post_id, tag_id) VALUES" . implode(',', $queryParams));
                            $update_post_tag->execute($values);
                        }
                        $conn->commit();
                        http_response_code(204);
                    } catch (PDOException $th) {
                        $conn->rollBack();
                        echo json_encode($th->getMessage());
                        http_response_code(500);
                    }
                } else {
                    try {
                        $conn->beginTransaction();
                        $updateQuery = $conn->prepare("UPDATE posts SET name=?, description=?, updated_at=?, category_id =?, heading_id=?  WHERE id=?");
                        $updateQuery->execute([$name, $desc, $date, $category, $heading, $id]);
                        // delete from post tag
                        $deletePostTag = deleteData('post_tag', 'post_id', $id);
                        if (count($tags_arr) > 0) {
                            $queryParams = [];
                            $values = [];
                            foreach ($tags_arr as $tag) {
                                $queryParams[] = "(?,?)";
                                $values[] =  (int)$id;
                                $values[] = (int)$tag;
                            }
                            $update_post_tag = $conn->prepare("INSERT INTO post_tag (post_id, tag_id) VALUES" . implode(',', $queryParams));
                            $update_post_tag->execute($values);
                        }
                        $conn->commit();
                        http_response_code(204);
                    } catch (PDOException $th) {
                        $conn->rollBack();
                        echo json_encode($th->getMessage());
                        http_response_code(500);
                    }
                }
            } else if ($post->id != $id && $post->name == $name) {
                echo json_encode("This name is already taken!");
                http_response_code(409);
            }
        } else {
            if (isset($_FILES['image'])) {
                $image = resizeImage($_FILES['image'], '../../assets/images/posts/normal/', '../../assets/images/posts/thumbnail/');
                try {
                    $conn->beginTransaction();
                    $updateQuery = $conn->prepare("UPDATE posts SET name=?, description=?,image_path=?, updated_at=?, category_id =?, heading_id=?  WHERE id=?");
                    $updateQuery->execute([$name, $desc, $image, $date, $category, $heading, $id]);
                    // delete from post tag
                    $deletePostTag = deleteData('post_tag', 'post_id', $id);
                    if (count($tags_arr) > 0) {
                        $queryParams = [];
                        $values = [];
                        foreach ($tags_arr as $tag) {
                            $queryParams[] = "(?,?)";
                            $values[] =  (int)$id;
                            $values[] = (int)$tag;
                        }
                        $update_post_tag = $conn->prepare("INSERT INTO post_tag (post_id, tag_id) VALUES" . implode(',', $queryParams));
                        $update_post_tag->execute($values);
                    }
                    $conn->commit();
                    http_response_code(204);
                } catch (PDOException $th) {
                    $conn->rollBack();
                    echo json_encode($th->getMessage());
                    http_response_code(500);
                }
            } else {
                try {
                    $conn->beginTransaction();
                    $updateQuery = $conn->prepare("UPDATE posts SET name=?, description=?, updated_at=?, category_id =?, heading_id=?  WHERE id=?");
                    $updateQuery->execute([$name, $desc, $date, $category, $heading, $id]);
                    // delete from post tag
                    $deletePostTag = deleteData('post_tag', 'post_id', $id);
                    if (count($tags_arr) > 0) {
                        $queryParams = [];
                        $values = [];
                        foreach ($tags_arr as $tag) {
                            $queryParams[] = "(?,?)";
                            $values[] =  (int)$id;
                            $values[] = (int)$tag;
                        }
                        $update_post_tag = $conn->prepare("INSERT INTO post_tag (post_id, tag_id) VALUES" . implode(',', $queryParams));
                        $update_post_tag->execute($values);
                    }
                    $conn->commit();
                    http_response_code(204);
                } catch (PDOException $th) {
                    $conn->rollBack();
                    echo json_encode($th->getMessage());
                    http_response_code(500);
                }
            }
        }
    }
} else {
    http_response_code(404);
}
