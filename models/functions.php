<?php
function getHeadingsWithCategories()
{
    global $conn;
    $query = $conn->query("SELECT h.*, c.name as categoryName FROM headings h JOIN categories c ON h.category_id = h.id")->fetchAll();
    return $query;
}
function getComments($post_id)
{
    global $conn;
    $query = $conn->query("SELECT c.*, p.id as postId, u.first_name as firstName, u.last_name as lastName FROM comments c JOIN users u ON c.id_user=u.id LEFT JOIN posts p ON c.id_post=p.id WHERE p.id='$post_id'")->fetchAll();
    return $query;
}
function getAll($table)
{
    global $conn;
    $query = $conn->query("SELECT * FROM $table")->fetchAll();
    return $query;
}

function getOneWithoutFetch($table, $column, $value, $column2 = null, $value2 = null)
{
    global $conn;
    if ($column2 != null) {
        $query = $conn->prepare("SELECT * FROM $table WHERE $column = ? AND $column2 = ?");
        $query->execute([$value, $value2]);
    } else {
        $query = $conn->prepare("SELECT * FROM $table WHERE $column = ?");
        $query->execute([$value]);
    }
    return $query;
}

function getDataWithFetch($table, $column, $value, $column2 = null, $value2 = null)
{
    global $conn;
    if ($column2 != null) {
        $query = $conn->prepare("SELECT * FROM $table WHERE $column = ? AND $column2 = ?");
        $query->execute([$value, $value2]);
    } else {
        $query = $conn->prepare("SELECT * FROM $table WHERE $column = ?");
        $query->execute([$value]);
    }
    if ($query->rowCount()  > 1) {
        $rez = $query->fetchAll();
    } else {
        $rez = $query->fetch();
    }
    return $rez;
}

function deleteData($table, $column, $id)
{
    global $conn;
    $query = $conn->prepare("DELETE FROM $table WHERE $column=?");
    $query->execute([$id]);
    return $query;
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
function getPostTag($post_id)
{
    global $conn;
    $query = "SELECT * FROM tags WHERE id IN ";
    $query .= "(SELECT tag_id FROM post_tag WHERE post_id =
       ?)";
    $result = $conn->prepare($query);
    $result->execute([$post_id]);
    $data = $result->fetchAll();
    return $data;
}

function getColumnIngridients()
{
    global $conn;
    $query = "SELECT COLUMN_NAME 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE 
        TABLE_SCHEMA = Database()
    AND TABLE_NAME = 'categories'"; //"SELECT COUNT(COLUMN_NAME) FROM INFORMATION_SCHEMA.COLUMNS WHERE
    //TABLE_NAME = $table ";
    $result = $conn->query($query);
    return $result->fetchAll();
}
define("OFFSET", 5);
function postPagination($limit = 0)
{
    global $conn;
    $query = $conn->prepare("SELECT p.*, c.name as categoryName, h.name as headingName FROM posts p JOIN categories c ON p.category_id = c.id JOIN headings h ON p.heading_id = h.id LIMIT :limit, :offset");
    $limit = ((int)$limit) * OFFSET;
    $query->bindParam(":limit", $limit, PDO::PARAM_INT);
    $offset  = OFFSET;
    $query->bindParam(":offset", $offset, PDO::PARAM_INT);
    $query->execute();

    $rez = $query->fetchAll();
    return $rez;
}


function getNumOfPosts()
{
    global $conn;
    $rez = $conn->query("SELECT COUNT(*) AS numOfPosts FROM posts")->fetch();
    return $rez;
}
function numberOfPostPages()
{
    $postsNum = getNumOfPosts();
    $pagesCount = ceil($postsNum->numOfPosts / OFFSET);
    return $pagesCount;
}


function tagPagination($limit = 0)
{
    global $conn;
    $query = $conn->prepare("SELECT * FROM tags LIMIT :limit, :offset");
    $limit = ((int)$limit) * OFFSET;
    $offset  = OFFSET;
    $query->bindParam(":limit", $limit, PDO::PARAM_INT);
    $query->bindParam(":offset", $offset, PDO::PARAM_INT);
    $query->execute();
    $rez = $query->fetchAll();
    return $rez;
}


function getNumOfTag()
{
    global $conn;
    $rez = $conn->query("SELECT COUNT(*) AS numOfTags FROM tags")->fetch();
    return $rez;
}

function getNumOfPagesTags()
{
    $tagNum = getNumOfTag();
    $pagesCount = ceil($tagNum->numOfTags / OFFSET);
    return $pagesCount;
}

function userPagination($limit = 0)
{
    global $conn;
    $query = $conn->prepare("SELECT * FROM users LIMIT :limit, :offset");
    $limit = ((int)$limit) * OFFSET;
    $offset  = OFFSET;
    $query->bindParam(":limit", $limit, PDO::PARAM_INT);
    $query->bindParam(":offset", $offset, PDO::PARAM_INT);
    $query->execute();
    $rez = $query->fetchAll();
    return $rez;
}

function getNumOfUsers()
{
    global $conn;
    $rez = $conn->query("SELECT COUNT(*) AS numOfUsers FROM users")->fetch();
    return $rez;
}

function getPagesOfUsers()
{
    $tagUser = getNumOfUsers();
    $pagesCount = ceil($tagUser->numOfUsers / OFFSET);
    return $pagesCount;
}


function inTheLast24H($date)
{
    $todayMax = time() + 86400;
    $todayMin = time() - 86400;
    $check = strtotime($date);
    if ($todayMin <= $check && $check <= $todayMax)
        return true;
    else
        return false;
}


function loggedInToday()
{
    $br = 0;
    $fileU = fopen("../../data/userLog.txt", "r");
    $rowsU = file("../../data/userLog.txt");
    fclose($fileU);
    foreach ($rowsU as $row) {
        $data = explode("\t", $row);
        $action = $data[1];
        $date = date("d m y", strtotime($data[2]));
        $today = date("d m y");
        if ($action == "Login" && $today == $date)
            $br++;
    }
    return $br;
}
function registeredusers()
{
    global $conn;
    $query = "SELECT COUNT(*) as users FROM users";
    $result = $conn->query($query);
    $result = $result->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function insertUserActivity($email, $action)
{
    $file = fopen("../../data/userLog.txt", "a");
    $date = date('d-m-Y H:i:s');
    fwrite($file, "{$email}\t{$action}\t{$date}\n");
    fclose($file);
}


function insertNewCategory($table, $name)
{
    global $conn;
    $queryInsert = $conn->prepare("INSERT INTO $table (name) VALUES(?)");
    $queryInsert->execute([$name]);
    return $queryInsert;
}
function updateCategory($table, $name, $updated_at, $id)
{
    global $conn;
    $queryUpdate = $conn->prepare("UPDATE $table SET name=?, updated_at=? WHERE id=?");
    $queryUpdate->execute([$name, $updated_at, $id]);
    return $queryUpdate;
}
function insertNewHeading($table, $name, $category_id)
{
    global $conn;
    $queryInsert = $conn->prepare("INSERT INTO $table (name, category_id) VALUES(?,?)");
    $queryInsert->execute([$name, $category_id]);
    return $queryInsert;
}

function updateHeading($table, $name, $category_id, $date, $id)
{
    global $conn;
    $queryUpdate = $conn->prepare("UPDATE $table SET name=?, updated_at=?, category_id=? WHERE id=?");
    $queryUpdate->execute([$name, $date, $category_id, $id]);
    return $queryUpdate;
}

function insertNewTag($table, $name)
{
    global $conn;
    $queryInsert = $conn->prepare("INSERT INTO $table (name) VALUES(?)");
    $queryInsert->execute([$name]);
    return $queryInsert;
}

function updateTag($table, $name, $date, $id)
{
    global $conn;
    $queryUpdate = $conn->prepare("UPDATE $table SET name=?, updated_at=? WHERE id=?");
    $queryUpdate->execute([$name, $date, $id]);
    return $queryUpdate;
}

function insertNewUser($table, $first_name, $last_name, $email, $password, $role_id)
{
    global $conn;

    $queryInsert = $conn->prepare("INSERT INTO $table (first_name, last_name, email, password, role_id) VALUES(?,?,?,?,?)");
    $queryInsert->execute([$first_name, $last_name, $email, md5($password), $role_id]);
    return $queryInsert;
}

function updateUser($table, $first_name, $last_name, $email,  $role_id, $date, $id)
{
    global $conn;
    $queryUpdate = $conn->prepare("UPDATE $table SET first_name=?, last_name=?, email=?, updated_at=?,role_id=? WHERE id=?");
    $queryUpdate->execute([$first_name, $last_name, $email, $date, $role_id, $id]);
    return $queryUpdate;
}

function createNewPost($table1, $table2, $postName, $postDescription, $postImage, $category_id, $heading_ig, $tags_arr)
{
    global $conn;

    $queryInsert = $conn->prepare("INSERT INTO $table1 (name, description, image_path, category_id, heading_id) VALUES(?,?,?,?,?)");
    $queryInsert->execute([$postName, $postDescription, $postImage, $category_id, $heading_ig]);
    $id = $conn->lastInsertId();
    if (count($tags_arr) > 0) {
        $queryParams = [];
        $values = [];
        foreach ($tags_arr as $tag) {
            $queryParams[] = "(?,?)";
            $values[] = (int)$id;
            $values[] = (int)$tag;
        }

        $post_tag_insert = $conn->prepare("INSERT INTO $table2 VALUES" . implode(", ", $queryParams));
        $post_tag_insert->execute($values);
    }
}

function updatePosts($table1, $table2, $postName, $postDesc, $image = "", $category_id, $heading_ig, $tags_arr)
{
    global $conn;
    if ($image == "") {
        $queryUpdate = $conn->prepare("UPDATE $table1 SET name=?, description=?, image_path=?, updated_at=?, category_id=?, heading_id=?");
        $queryUpdate->execute();
    }
}


function insertNewComment($table, $id_post, $id_user, $comment, $parent_comment)
{
    global $conn;
    $query = $conn->prepare("INSERT INTO $table (id_post, id_user, comment, parent_comment) VALUES(?,?,?,?)");
    $query->execute([$id_post, $id_user, $comment, $parent_comment]);
    return $query;
}


function readComments($table1, $table2, $post_id, $comment_id)
{
    global $conn;
    $query = $conn->query("SELECT c.*, u.first_name as firstName, u.last_name as postName FROM '$table1' c JOIN `$table2` u ON c.id_user = u.id WHERE parent_comment =  '$comment_id' AND id_post='$post_id' ")->fetchAll();
    return $query;
}


function checkIsReacted($table, $post_id, $comment_id, $user_id)
{
    // var_dump($post_id, $user_id, $comment_id);
    global $conn;
    $query = $conn->query("SELECT * FROM $table WHERE user_id = $user_id AND post_id = $post_id AND comment_id = $comment_id");
    return $query;
}


function insertReaction($table, $action, $post_id, $comment_id, $user_id, $vote)
{
    global $conn;
    $query = '';
    if ($action == "like") {
        $query = $conn->prepare("INSERT INTO $table (comment_id, post_id, user_id, likes) VALUES(?,?,?,?)");
        $query->execute([$comment_id, $post_id, $user_id, $vote]);
    } else {
        $query = $conn->prepare("INSERT INTO $table (comment_id, post_id, user_id, disslikes) VALUES(?,?,?,?)");
        $query->execute([$comment_id, $post_id, $user_id, $vote]);
    }
    return $query;
}

function deleteVote($table, $action, $post_id, $comment_id, $user_id)
{
    global $conn;
    $query = '';
    if ($action == 'like') {
        $query = $conn->prepare("DELETE FROM $table WHERE post_id=? AND user_id=? AND comment_id=?");
        $query->execute([$post_id, $user_id, $comment_id]);
    } else {
        $query = $conn->prepare("DELETE FROM $table WHERE post_id=? AND user_id=? AND comment_id=?");
        $query->execute([$post_id, $user_id, $comment_id]);
    }
}

function voteChange($table, $from, $to, $like, $disslike, $comment_id, $post_id, $user_id)
{
    global $conn;
    // $queryUpdate = $conn->prepare("UPDATE reactions SET likes =?, disslikes=? WHERE comment_id=? AND user_id=?");
    // $queryUpdate->execute([REACT_ON, REACT_OFF, $comment_id, $id]);
    if ($from == 'like' && $to == "disslike") {
        // echo json_encode("od like to disslike");
        $queryUpdate = $conn->prepare("UPDATE $table SET  likes=?, disslikes=? WHERE post_id=? AND user_id=? AND comment_id=? ");
        $queryUpdate->execute([$like, $disslike, $post_id, $user_id, $comment_id]);
    } else {
        $queryUpdate = $conn->prepare("UPDATE $table SET  likes=?, disslikes=? WHERE post_id=? AND user_id=? AND comment_id=? ");
        $queryUpdate->execute([$like, $disslike, $post_id, $user_id, $comment_id]);
    }

    return $queryUpdate;
}


function getReactions($post_id, $user_id)
{
    global $conn;
    $query = $conn->query("SELECT * FROM reactions WHERE post_id=  $post_id AND user_id = $user_id")->fetchAll();
    return $query;
}
