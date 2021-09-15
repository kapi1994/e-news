<?php
function getAll($table)
{
    global $conn;
    $rez  = $conn->query("SELECT * FROM $table")->fetchAll();
    return $rez;
}

function getOneFetchAndCheckData($table, $column, $value, $action)
{
    global $conn;
    $res = "";

    $dbQuery = $conn->query("SELECT * FROM $table WHERE $column = '$value' ");

    if ($action == "fetch") {
        if ($dbQuery->rowCount() == 1) {
            $res = $dbQuery->fetch();
        } else {
            $res = $dbQuery->fetchAll();
        }
    } else if ($action == "check") {
        $res = $dbQuery->rowCount();
    }

    return $res;
}

function deleteData($table, $column, $value)
{
    global $conn;
    $deleteQuery = $conn->prepare("DELETE FROM $table WHERE $column =? ");
    $deleteQuery->execute([$value]);
    return $deleteQuery;
}

function insertCategory($name)
{
    global $conn;
    $queryInsert = $conn->prepare("INSERT INTO categories (name) VALUES(?)");
    $queryInsert->execute([$name]);
    return $queryInsert;
}

function updateCategory($name, $date, $id)
{
    global $conn;
    $queryUpdate = $conn->prepare("UPDATE categories SET name=?, updated_at =? WHERE id=?");
    $queryUpdate->execute([$name, $date, $id]);
    return $queryUpdate;
}
function insertTag($name)
{
    global $conn;
    $queryInsert = $conn->prepare("INSERT INTO tags (name) VALUES(?)");
    $queryInsert->execute([$name]);
    return $queryInsert;
}
function updateTag($name, $date, $id)
{
    global $conn;
    $res = $conn->prepare("UPDATE tags SET name=?,date=? WHERE id=? ");
    $res->execute([$name, $date, $id]);
    return $res;
}

function getHeadingWithCategory()
{
    global $conn;
    $res = '';
    $query = $conn->query("SELECT h.*, c.name as categoryName FROM headings h JOIN categories c ON h.category_id = c.id");
    if ($query->rowCount() == 1) {
        $res = $query->fetch();
    } else {
        $res = $query->fetchAll();
    }
    return $res;
}

function insertHeading($name, $categoryId)
{
    global $conn;
    $res = $conn->prepare("INSERT INTO headings (name, category_id) VALUES(?,?)");
    $res->execute([$name, $categoryId]);
    return $res;
}
function updateHeading($name, $categoryId, $date, $id)
{
    global $conn;
    $res = $conn->prepare("UPDATE headings SET name=?, updated_at=?, category_id =? WHERE id=?");
    $res->execute([$name, $date, $categoryId, $id]);
    return $res;
}
function getAllPosts($id = null)
{
    global $conn;
    $res = '';
    if ($id != null) {
        $query = $conn->query("SELECT p.*, c.name as categoryName, h.name as headingName FROM posts p JOIN categories c ON p.category_id = c.id JOIN headings h ON p.heading_id = h.id WHERE p.id = $id");


        if ($query->rowCount() == 1) {
            $res = $query->fetch();
        } else {
            $res = $query->fetchAll();
        }
    } else {
        $query = $conn->query("SELECT p.*, c.name as categoryName, h.name as headingName FROM posts p JOIN categories c ON p.category_id = c.id JOIN headings h ON p.heading_id = h.id");
        if ($query->rowCount() == 1) {
            $res = $query->fetch();
        } else {
            $res = $query->fetchAll();
        }
    }
    return $res;
}

function getAllUsers()
{
    global $conn;
    $res = '';
    $query = $conn->query("SELECT u.*, r.name as roleName FROM users u JOIN roles r ON u.role_id = r.id WHERE r.name != 'Admin'");

    if ($query->rowCount() == 1) {
        $res = $query->fetch();
    } else {
        $res = $query->fetchAll();
    }
    return $res;
}

function insertUser($firstName, $lastName, $email, $password, $role_id)
{
    global $conn;
    $res = $conn->prepare("INSERT INTO users (first_name,last_name, email, password, role_id");
    $res->execute([$firstName, $lastName, $email, md5($password), $role_id]);
    return $res;
}

function updateUser($firstName, $lastName, $email, $role_id, $date)
{
    global $conn;
    $res = $conn->prepare("UPDATE users SET first_name=?, last_name=?, ");
}


function getComments($postId)
{
    global $conn;
    $res = '';
    $query = $conn->query("SELECT c.*, u.first_name as firstName, u.last_name as lastName FROM comments c JOIN posts p ON c.id_post = p.id JOIN users u ON c.id_user = u.id WHERE c.id_post = '$postId' ");
    if ($query->rowCount() == 1) {
        $res = $query->fetch();
    } else {
        $res = $query->fetchAll();
    }

    return $res;
}

function getLastFive($postId)
{
    global $conn;
    $res = $conn->query("SELECT id, name, image_path, created_at FROM posts WHERE id != '$postId' ORDER BY created_at DESC LIMIT 3")->fetchAll();
    return $res;
}



function resizeImage($file, $normal_path, $small_path)
{
    $image = $file;
    $new_image_name = time() . '_' . $image['name'];
    $tmp_name = $image['tmp_name'];
    $new_normal_path = $normal_path . $new_image_name;
    $new_small_path = $small_path . $new_image_name;
    move_uploaded_file($tmp_name, $new_normal_path);
    $getImageDimensions = getimagesize($new_normal_path);
    //var_dump($getImageDimensions);
    $width = $getImageDimensions[0];
    $height = $getImageDimensions[1];

    $newWidth = 100;
    $newHeight = $height / ($width / $newWidth);
    $imageExtension = pathinfo($new_normal_path, PATHINFO_EXTENSION);
    if ($imageExtension == 'png') {
        $resource = imagecreatefrompng($new_normal_path);
        $canvars  = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($canvars, $resource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagepng($canvars, $new_small_path);
    } else {
        $resource = imagecreatefromjpeg($new_normal_path);
        $canvars  = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($canvars, $resource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagejpeg($canvars, $new_small_path);
    }

    return $new_image_name;
}

function insertPost($name, $description, $image_path, $category_id, $heading_id, $tags_arr)
{
    global $conn;
    $res = $conn->prepare("INSERT INTO posts (name, description, image_path, category_id, heading_id) VALUES(?,?,?,?,?)");
    $res->execute([$name, $description, $image_path, $category_id, $heading_id]);

    $id = $conn->lastInsertId();

    if (count($tags_arr) > 0) {
        $queryParams = [];
        $values = [];
        foreach ($tags_arr as $tag) {
            $queryParams[] = "(?,?)";
            $values[] = (int)$id;
            $values[] = (int)$tag;
        }

        $post_tag_insert = $conn->prepare("INSERT INTO post_tag VALUES" . implode(", ", $queryParams));
        $post_tag_insert->execute($values);
    }
}

function loginUser($email, $password)
{
    global $conn;
    $res = $conn->prepare("SELECT u.*, r.name as roleName FROM users u JOIN roles r WHERE email=? AND password = ?");
    $res->execute([$email, md5($password)]);
    $user = $res->fetch();
    return $user;
}
