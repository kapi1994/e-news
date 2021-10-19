<?php
function getAll($table, $ordering = null, $param = null)
{
    global $conn;
    if ($ordering != null) {

        $rez  = $conn->query("SELECT * FROM $table ORDER BY $param DESC")->fetchAll();
    }
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
    $query = $conn->query("SELECT u.*, r.name as roleName FROM users u JOIN roles r ON u.role_id = r.id WHERE r.name != 'Admin' ORDER BY u.created_at DESC");

    if ($query->rowCount() == 1) {
        $res = $query->fetch();
    } else {
        $res = $query->fetchAll();
    }
    return $res;
}

function insertUser($firstName, $lastName, $email, $password, $role)
{
    global $conn;
    $res = $conn->prepare("INSERT INTO users (first_name,last_name, email, password, role_id) VALUES(?,?,?,?,?)");
    $res->execute([$firstName, $lastName, $email, md5($password), $role]);
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
        if ($query->rowCount() == 0) {
            $res = $query->rowCount();
        } else if ($query->rowCount() == 1) {
            $res = $query->fetch();
        } else {
            $res = $query->fetchAll();
        }
    } else {
        $query = $conn->query("SELECT c.*, u.first_name as firstName, u.last_name as lastName FROM comments c JOIN posts p ON c.id_post = p.id JOIN users u ON c.id_user = u.id WHERE c.id_post = '$postId' AND c.parent_id = $parent_comment ");
        if ($query->rowCount() == 0) {
            $res = $query->rowCount();
        } else if ($query->rowCount() == 1) {
            $res = $query->fetch();
        } else {
            $res = $query->fetchAll();
        }
    }
    return $res;
}

function getCommentsWithReaction($post_id, $comment_id)
{
    $comments = getComments($post_id, $comment_id);
    // var_dump($comments);
    if (is_array($comments)) {
        foreach ($comments as $comment) {
            $comment->likes = countVotes($comment->id, 'like');
            $comment->disslikes = countVotes($comment->id, 'disslikes');
        }
    } else {
        $comments->likes = countVotes($comments->id, 'like');
        $comments->disslikes = countVotes($comments->id, 'disslikes');
    }

    return $comments;
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
        $res = $conn->query("SELECT user_id as UserId,  COUNT(likes) as likes FROM reactions WHERE likes > 0 AND comment_id='$comment_id'")->fetch();
    } else {
        $res = $conn->query("SELECT user_id as UserId, COUNT(disslikes) as disslikes  FROM reactions WHERE disslikes > 0 AND comment_id='$comment_id'")->fetch();
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


function countRows($column, $name, $table, $condition, $value)
{
    global $conn;
    $query = $conn->query("SELECT COUNT('$column') as '$name' FROM '$table' WHERE '$condition' = '$value'")->fetchAll();
    return $query;
}

function getColumnsTable()
{
    global $conn;
    $q = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = Database() AND TABLE_NAME = 'categories'";
    $query = $conn->query($q)->fetchAll();
    return $query;
}

function getSelectedTags($post_id)
{
    global $conn;
    $query = "SELECT * FROM tags WHERE id IN ";
    $query .= "(SELECT tag_id FROM post_tag WHERE post_id = ?)";
    $result = $conn->prepare($query);
    $result->execute([$post_id]);
    $data = $result->fetchAll();
    return $data;
}

// PAGINACIJA
define("ELEMENTS_OFFSET", 5);
function numOfData($query)
{
    global $conn;
    $res = $conn->query($query)->fetch();
    return $res;
}


function getHeadingWithCategory($limit = 0)
{
    global $conn;
    $res = '';
    $query = $conn->prepare("SELECT h.*, c.name as categoryName FROM headings h JOIN categories c ON h.category_id = c.id  ORDER BY h.created_at DESC LIMIT :limit, :offset");
    $limit  = ((int)$limit) * ELEMENTS_OFFSET;
    $query->bindValue(":limit", $limit, PDO::PARAM_INT);
    $offset = ELEMENTS_OFFSET;
    $query->bindValue(':offset', $offset, PDO::PARAM_INT);
    $query->execute();
    if ($query->rowCount() > 1) {
        $res = $query->fetchAll();
    } else {
        $res = $query->fetch();
    }
    return $res;
}

function getNumOfHeadings()
{
    $movies = rowCount('SELECT COUNT(*)  as numOfHeadings FROM headings h JOIN categories c ON h.category_id = c.id');
    return $movies;
}

function rowCount($query)
{
    global $conn;
    $res = $conn->query($query)->fetch();
    return $res;
}
function paginationHeadings()
{
    $numOfHeadings = getNumOfHeadings();
    $numOfPages = ceil($numOfHeadings->numOfHeadings) / ELEMENTS_OFFSET;
    return $numOfPages;
}

function getAllTags($limit = 0)
{
    global $conn;
    $res = '';
    $query = $conn->prepare("SELECT * FROM tags  ORDER BY created_at DESC LIMIT :limit, :offset");
    $limit  = ((int)$limit) * ELEMENTS_OFFSET;
    $query->bindValue(":limit", $limit, PDO::PARAM_INT);
    $offset = ELEMENTS_OFFSET;
    $query->bindValue(':offset', $offset, PDO::PARAM_INT);
    $query->execute();
    if ($query->rowCount() > 1) {
        $res = $query->fetchAll();
    } else {
        $res = $query->fetch();
    }
    return $res;
}

function getNumOfTags()
{
    //SELECT COUNT(*)  as numOfHeadings FROM headings h JOIN categories c ON h.category_id = c.id'
    $tags = rowCount("SELECT COUNT(*) as numberOfTags FROM tags");
    return $tags;
}


function tagsPagination()
{
    $tagElments = getNumOfTags();
    $numOfPages = ceil($tagElments->numberOfTags) / ELEMENTS_OFFSET;
    return $numOfPages;
}


// function getAllUsers()
// {
// }

function postPagination($limit = 0)
{
    $res = '';
    global $conn;
    $query = $conn->prepare("SELECT p.* , c.name as categoryName, h.name as headingName FROM posts p JOIN categories c ON p.category_id = c.id JOIN headings h ON p.heading_id = h.id ORDER BY p.created_at DESC LIMIT :limit, :offset");
    $limit = ((int)$limit) * ELEMENTS_OFFSET;
    $offset = ELEMENTS_OFFSET;

    $query->bindValue(":limit", $limit, PDO::PARAM_INT);
    $query->bindValue(":offset", $offset, PDO::PARAM_INT);

    $query->execute();
    if ($query->rowCount() > 1) {
        $res = $query->fetchAll();
    } else {
        $res = $query->fetch();
    }

    return $res;
}

function getNumOfPosts()
{
    //SELECT COUNT(*)  as numOfHeadings FROM headings h JOIN categories c ON h.category_id = c.id'
    $posts = rowCount("SELECT COUNT(*) as numberOfPosts FROM posts");
    return $posts;
}


function postNumOfPages()
{
    $postElements = getNumOfPosts();
    $numOfPages = ceil($postElements->numberOfPosts) / ELEMENTS_OFFSET;
    return $numOfPages;
}

function categoriesCount()
{
    global $conn;
    $res = $conn->query("SELECT COUNT(*) as numberOfCategories FROM categories")->fetch();
    return $res;
}
