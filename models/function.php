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


function getComments($postId, $parent_comment = null)
{
    global $conn;
    $res = '';
    if ($parent_comment == null) {
        $query = $conn->query("SELECT c.*, u.first_name as firstName, u.last_name as lastName FROM comments c JOIN posts p ON c.id_post = p.id JOIN users u ON c.id_user = u.id WHERE c.id_post = '$postId' ");
        if ($query->rowCount() > 1) {
            $res = $query->fetchAll();
        } else {
            $res = $query->fetch();
        }
    } else {
        $query = $conn->query("SELECT c.*, u.first_name as firstName, u.last_name as lastName FROM comments c JOIN posts p ON c.id_post = p.id JOIN users u ON c.id_user = u.id WHERE c.id_post = '$postId' AND c.parent_id = $parent_comment ");
        if ($query->rowCount() > 1) {
            $res = $query->fetchAll();
        } else {
            $res = $query->fetch();
        }
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
    $res = $conn->prepare("SELECT u.*, r.name as roleName FROM users u JOIN roles r ON u.role_id = r.id WHERE email=? AND password = ?");
    $res->execute([$email, md5($password)]);
    $user = $res->fetch();
    return $user;
}
function insertComment($table, $user_id, $comment_id = null, $post_id, $text)
{
    global $conn;
    $queryInsert = "";
    if ($comment_id == null) {
        $queryInsert  = $conn->prepare("INSERT INTO $table (text,id_user, id_post) VALUES(?,?,?)");
        $queryInsert->execute([$text, $user_id, $post_id]);
    } else {
        $queryInsert  = $conn->prepare("INSERT INTO $table (text,id_user, id_post,parent_id) VALUES(?,?,?,?)");
        $queryInsert->execute([$text, $user_id, $post_id, $comment_id]);
    }
}

function countVotes($comment_id, $action)
{
    global $conn;
    $res = '';
    if ($action == 'like') {
        $res = $conn->query("SELECT COUNT(likes) as likes FROM reactions WHERE likes > 0 AND comment_id='$comment_id'")->fetch();
    } else {
        $res = $conn->query("SELECT COUNT(disslikes) as disslikes  FROM reactions WHERE disslikes > 0 AND comment_id='$comment_id'")->fetch();
    }

    return $res;
}

function getUserVotes($user, $post, $comment)
{
}


function insertVote($action, $comment, $user, $reaction)
{
    global $conn;
    $queryInsert  = $conn->prepare("INSERT INTO reactions (comment_id, user_id, $action) VALUES(?,?,?)");
    $queryInsert->execute([$comment, $user, $reaction]);

    return $queryInsert;
}

function getReactions($user_id, $comment, $action)
{
    global $conn;
    $res = '';
    // echo json_encode($action);
    $baseQuery = $conn->query("SELECT * FROM reactions WHERE user_id = '$user_id'  AND comment_id = '$comment'");
    if ($action === "rowCount") {
        $res = $baseQuery->rowCount();
    } else {
        $res = $baseQuery->fetch();
    }
    return $res;
}

function updateStatusVote($user_id, $comment, $action, $react_on, $react_off)
{
    $actionChange = switchActionVote($action);
    $reaction = getReactions($user_id, $comment, 'fetch');
    // echo json_encode($reaction);
    // echo json_encode($action);
    if ($action == 'likes') {
        if ($reaction->likes == 1) {
            deleteVote($comment, $user_id);
        } else {
            updateVote($user_id, $comment, $action, $react_on, $actionChange, $react_off);
        }
    } else {
        if ($reaction->disslikes == 1) {
            deleteVote($comment, $user_id);
        } else {
            updateVote($user_id, $comment, $action, $react_on, $actionChange, $react_off);
        }
    }
}
function updateVote($user, $comment, $action, $valueOne, $actionTwo = null, $valueTwo = null)
{
    global $conn;
    echo json_encode($actionTwo . " " . $action);
    $query = '';


    if ($actionTwo == null && $valueTwo == null) {
        $query = $conn->prepare("UPDATE reactions SET $action =? WHERE user_id=? AND comment_id=?");
        $query->execute([$valueOne, $user, $comment]);
    } else {
        $query = $conn->prepare("UPDATE reactions SET $action =?, $actionTwo =? WHERE user_id=? AND comment_id =?");
        $query->execute([$valueOne, $valueTwo, $user, $comment]);
    }
    return $query;
}

function switchActionVote($action)
{
    $column = '';
    if ($action == 'likes') {
        $column = 'disslikes';
    } else {
        $column = 'likes';
    }
    return $column;
}

function deleteVote($comment, $user)
{
    global $conn;
    $q = $conn->prepare("DELETE FROM reactions WHERE user_id =? AND comment_id = ?");
    $q->execute([$user, $comment]);
    return $q;
}
