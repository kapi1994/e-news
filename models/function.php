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


function getComments($postId, $parentComment = 0)
{
    global $conn;
    $res = $conn->query("SELECT c.*, u.first_name as firstName, u.last_name as lastName FROM comments c JOIN users u ON c.user_id = u.id WHERE post_id='$postId' AND parent_id ='$parentComment' ORDER BY created_at ASC")->fetchAll();
    return $res;
}

function getCommentsWithReaction($post_id, $user_id, $comment_id = 0)
{
    $comments = getComments($post_id, $comment_id);

    foreach ($comments as $comment) {

        $comment->user_reaction = userReactions($comment->id, $user_id);
        $comment->likes = countVote($comment->id, 'likes', 'likesCount');
        $comment->disslikes = countVote($comment->id, 'disslikes', 'disslikesCount');
        $comment->countChild =  countChild($comment->id);
    }

    return $comments;
}
function countChild($comment_id)
{
    global $conn;
    $res = $conn->query("SELECT COUNT(*) as childComments FROM comments WHERE parent_id = '$comment_id'  ")->fetch();
    return $res;
}
function userReactions($comment_id, $user_id)
{
    global $conn;
    $res = $conn->query("SELECT * FROM reactions WHERE comment_id = '$comment_id' AND user_id = '$user_id' ")->fetch();
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

    $newHeight = 200;
    $newWidth = $width / ($height / $newHeight);
    $imageExtension = pathinfo($new_normal_path, PATHINFO_EXTENSION);
    if ($imageExtension == 'png') {
        $resource = imagecreatefrompng($new_normal_path);
        $canvars  = imagecreatetruecolor($newHeight, $newHeight);
        imagecopyresampled($canvars, $resource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagepng($canvars, $new_small_path);
    } else {
        $resource = imagecreatefromjpeg($new_normal_path);
        $canvars  = imagecreatetruecolor($newHeight, $newHeight);
        imagecopyresampled($canvars, $resource, 0, 0, 0, 0, $newHeight, $newHeight, $width, $height);
        imagejpeg($canvars, $new_small_path);
    }

    return $new_image_name;
}

function insertPost($user_id, $name, $description, $image_path, $category_id, $heading_id, $tags_arr)
{
    global $conn;
    $res = $conn->prepare("INSERT INTO posts (name, description, image_path, category_id, heading_id,user_id) VALUES(?,?,?,?,?,?)");
    $res->execute([$name, $description, $image_path, $category_id, $heading_id, $user_id]);

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
function insertComment($table, $user_id, $comment_id = 0, $post_id, $text)
{
    global $conn;
    $queryInsert = "";
    if ($comment_id == 0) {
        $queryInsert  = $conn->prepare("INSERT INTO $table (text,user_id, post_id) VALUES(?,?,?)");
        $queryInsert->execute([$text, $user_id, $post_id]);
    } else {
        $queryInsert  = $conn->prepare("INSERT INTO $table (text,user_id, post_id,parent_id) VALUES(?,?,?,?)");
        $queryInsert->execute([$text, $user_id, $post_id, $comment_id]);
    }
}

function countVotes($comment_id, $action)
{
    global $conn;
    $res = '';
    if ($action != "disslike") {
        $res = $conn->query("SELECT  COUNT(likes) as likesCount FROM reactions WHERE  likes > 0 AND comment_id='$comment_id' ")->fetch();
    } {
        $res = $conn->query("SELECT   COUNT(disslikes) as disslikesCount  FROM reactions WHERE disslikes> 0 AND comment_id='$comment_id'")->fetch();
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


function getHeadingWithCategory($limit = 0, $keyword = '', $order = 0)
{
    global $conn;
    $res = '';
    $limitQuery = "";
    $orderQuery = ' ORDER BY h.created_at DESC';
    $query = "";
    $baseQuery = "SELECT h.*, c.name as categoryName FROM headings h JOIN categories c ON h.category_id = c.id ";
    if ($keyword != '') {
        $query = " WHERE h.name LIKE '$keyword'";
        $baseQuery .= $query;
    }
    if ($order) {
        if ($order == 1) {
            $orderQuery = " ORDER BY h.created_at ASC ";
        } else {
            $orderQuery = " ORDER BY h.created_at DESC";
        }
    }
    $limitQuery = " LIMIT :limit, :offset";
    $baseQuery = $baseQuery . $orderQuery . $limitQuery;
    $query = $conn->prepare($baseQuery);
    $limit  = ((int)$limit) * ELEMENTS_OFFSET;
    $query->bindValue(":limit", $limit, PDO::PARAM_INT);
    $offset = ELEMENTS_OFFSET;
    $query->bindValue(':offset', $offset, PDO::PARAM_INT);
    $query->execute();
    $res = $query->fetchAll();
    return $res;
}

function getNumOfHeadings($action, $keyword = '')
{
    global $conn;
    $res = '';
    $query = '';
    $baseQuery = "SELECT COUNT(*) as numOfHeadings FROM headings";
    if ($keyword != '') {
        $query = " WHERE name LIKE '$keyword'";
        $baseQuery = $baseQuery . $query;
    }
    if ($action == "count") {
        $res = $conn->query($baseQuery)->fetch();
    } else {
        $pages = $conn->query($baseQuery)->fetch();
        $res = ceil($pages->numOfHeadings / ELEMENTS_OFFSET);
    }
    return $res;
}

function rowCount($query)
{
    global $conn;
    $res = $conn->query($query)->fetch();
    return $res;
}


function getAllTags($limit = 0, $keyword = '', $order = 0)
{
    global $conn;
    $res = '';
    $query =  '';
    $orderQuery = ' ORDER BY created_at DESC';
    $limitQuery = ' LIMIT :limit, :offset';

    $baseQuery = "SELECT * FROM tags";
    if ($keyword != '') {
        $query = " WHERE name LIKE '$keyword'";
        $baseQuery .= $query;
    }
    if ($order) {
        if ($order > 0) {
            $orderQuery = " ORDER BY created_at ASC";
        } else {
            $orderQuery =  " ORDER BY created_at DESC";
        }
    }

    $limit  = ((int)$limit) * ELEMENTS_OFFSET;
    $offset = ELEMENTS_OFFSET;

    $baseQuery = $baseQuery . $orderQuery . $limitQuery;
    $query = $conn->prepare($baseQuery);
    $query->bindValue(":limit", $limit, PDO::PARAM_INT);
    $query->bindValue(":offset", $offset, PDO::PARAM_INT);
    $query->execute();
    $res = $query->fetchAll();
    return $res;
}

function getNumOfTags($action, $keyword = '')
{
    global $conn;
    $query = '';
    $baseQuery = "SELECT COUNT(*)  as numOfTags FROM tags";
    if ($keyword != '') {
        $query = " WHERE name LIKE '$keyword'";
        $baseQuery .= $query;
    }

    if ($action == 'count') {
        $res = $conn->query($baseQuery)->fetch();
    } else {
        $pages = $conn->query($baseQuery)->fetch();
        $res = ceil($pages->numOfTags / ELEMENTS_OFFSET);
    }
    return $res;
}




function postPagination($user_id, $limit = 0, $keyword = '', $order = 0, $categories = '', $headings = '')
{

    global $conn;
    $res = '';
    $orderQuery = " ORDER BY p.created_at DESC";
    $query = '';
    $limitQuery = ' LIMIT :limit, :offset';


    $baseQuery = "SELECT p.*, c.name as categoryName, h.name as headingName FROM posts p JOIN categories c ON p.category_id = c.id JOIN headings h ON p.heading_id = h.id";


    if ($user_id->roleName == "Journalist") {
        $query = " WHERE p.user_id = '$user_id->id'";
        $baseQuery .= $query;
    }
    if ($keyword != '') {
        if ($user_id->roleName == "Journalist") {
            $query .= " AND  p.name LIKE '$keyword'";
            $baseQuery .= $query;
        } else {
            $query = " WHERE p.name LIKE '$keyword'";
            $baseQuery .= $query;
        }
    }

    if ($categories !=   '') {
        if (($keyword != "" && $user_id->roleName == "Journalist") || $keyword != "") {
            $query .= " AND p.category_id IN ($categories)";
            $baseQuery .= $query;
        } else {
            $query = " WHERE p.category_id IN ($categories)";
            $baseQuery .= $query;
        }
    }
    if ($headings != '') {
        if (($categories != '' && $keyword != '' && $user_id->roleName == "Journalist") || ($keyword != '' || $categories != '')) {
            $query .= " AND p.heading_id IN ('$headings')";
            $baseQuery .= $query;
        } else {
            $query = " WHERE p.heading_id IN ('$headings')";
            $baseQuery .= $query;
        }
    }

    if ($order) {
        if ($order == 1) {

            $orderQuery = " ORDER BY p.created_at ASC";
        } else {

            $orderQuery = " ORDER BY p.created_at DESC";
        }
    }

    $limit = ((int)$limit) * ELEMENTS_OFFSET;
    $offset = ELEMENTS_OFFSET;

    $baseQuery = $baseQuery . $orderQuery . $limitQuery;


    $query = $conn->prepare($baseQuery);
    $query->bindValue(":limit", $limit, PDO::PARAM_INT);
    $query->bindValue(":offset", $offset, PDO::PARAM_INT);
    $query->execute();
    $res = $query->fetchAll();

    return $res;
}

function getNumOfPosts($action, $keyword = '', $categories = '', $heading = '')
{
    global $conn;
    $baseQuery = "SELECT COUNT(*) as numberOfPosts FROM posts";
    $query = '';
    if ($keyword != '') {
        $query = " WHERE name LIKE '$keyword'";
    }
    $baseQuery .= $query;
    if ($action == 'count') {
        $res = $conn->query($baseQuery)->fetch();
    } else {
        $pages = $conn->query($baseQuery)->fetch();
        $res = ceil($pages->numberOfPosts / ELEMENTS_OFFSET);
    }

    return $res;
}


function categoriesCount()
{
    global $conn;
    $res = $conn->query("SELECT COUNT(*) as numberOfCategories FROM categories")->fetch();
    return $res;
}

function userPagination($limit = 0, $keyword = '', $order = 0, $role_id = 0)
{
    global $conn;
    $query = " WHERE r.name != 'Admin'";
    $baseQuery = "SELECT u.*, r.name as roleName From users u JOIn roles r ON u.role_id = r.id";
    $orderQuery = ' ORDER BY u.created_at DESC';
    $limitQuery = ' LIMIT :limit, :offset';

    if ($keyword != '') {
        $query .= " AND (u.first_name LIKE '$keyword' OR u.last_name LIKE '$keyword')";
    }
    if ($role_id != 0) {
        $query .= " AND u.role_id = '$role_id'";
    }
    if ($order == 1) {
        $orderQuery = " ORDER BY u.created_at ASC";
    } else {
        $orderQuery  = " ORDER BY u.created_at DESC";
    }
    $baseQuery = $baseQuery . $query . $orderQuery . $limitQuery;
    $limit = ((int)$limit) * ELEMENTS_OFFSET;
    $offset = ELEMENTS_OFFSET;
    $query = $conn->prepare($baseQuery);
    $query->bindValue(":limit", $limit, PDO::PARAM_INT);
    $query->bindValue(":offset", $offset, PDO::PARAM_INT);
    $query->execute();
    $res = $query->fetchAll();
    return $res;
}

function getNumOfUsers($action, $keyword = '', $role_id = 0)
{
    global $conn;
    $query = '';
    $res = '';
    $baseQuery = "SELECT COUNT(*) as numberOfUsers FROM users u JOIN roles r ON u.role_id = u.id";
    $query = " WHERE r.name !='Admin' ";

    if ($keyword != '') {
        $query .= " AND (u.first_name LIKE '$keyword' OR u.last_name LIKE '$keyword')";
    }
    if ($role_id != 0) {
        $query .= " AND u.role_id = '$role_id'";
    }

    $baseQuery = $baseQuery . $query;
    if ($action == 'count') {
        $res = $conn->query($baseQuery)->fetch();
    } else {
        $pages = $conn->query($baseQuery)->fetch();
        $res = ceil($pages->numberOfUsers / ELEMENTS_OFFSET);
    }

    return $res;
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

function countChildComments($comment_id)
{
    global $conn;
    $res = $conn->query("SELECT COUNT(*) as childComments FROM comments WHERE parent_id='$comment_id'")->fetch();
    return $res;
}

function cutName($name)
{
    $res = '';
    if (strlen($name) > 20) {
        $subStr = substr($name, 0, 20);
        $res = $subStr . ' ...';
    } else {
        $res = $name;
    }
    return $res;
}

function insertActivity($action, $email)
{
    $file_open = fopen('../../data/userLog.txt', 'a');
    $date = date("d-m-Y H:i:s");
    $content = "{$email}\t{$action}\t{$date}\n";
    fwrite($file_open, $content);
    fclose($file_open);
}

function loggedInToday($path)
{
    $counter = 0;
    $file_users  = fopen("../../data/userLog.txt", "r");
    $data_users = file("../../data/userLog.txt");
    fclose($file_users);
    foreach ($data_users as $user) {
        $data = explode("\t", $user);
        $action = $data[1];
        $date = date("d m y", strtotime($data[2]));
        $today  = date("d m y");
        if ($action == "Login" && $today == $date) {
            $counter++;
        }
    }
    return $counter;
}

function inTheLast24H($date)
{
    $todayMin = time() - 86400;
    $todayMax = time() + 86400;

    $check = strtotime($date);
    if ($todayMin <= $check && $check <= $todayMax) {
        return true;
    } else {
        return false;
    }
}

function registetedUsersCount()
{
    global $conn;
    $res = $conn->query("SELECT COUNT(*) as numberOfUsers FROM users u JOIN roles r ON u.role_id = r.id WHERE r.name ='User'")->fetch();
    return $res;
}

function getPostFromCategory($categoryName)
{
    global $conn;
    $res = $conn->query("SELECT p.* FROM posts p JOIN categories c ON p.category_id = c.id WHERE c.name ='$categoryName'")->fetchAll();
    return $res;
}

function getPostWithHeadingAndAuthor($postId)
{
    global $conn;
    $res = $conn->query("SELECT p.*, h.name as headingName,u.first_name, u.last_name from posts p JOIN headings h ON p.heading_id = h.id  JOIN users u ON p.user_id = u.id WHERE p.id = '$postId'")->fetch();
    return $res;
}
function countPosts()
{
    global $conn;
    $res = $conn->query("SELECT COUNT(*) as numberOfPosts FROM posts")->fetch();
    return $res;
}
function getPostTag($action, $value)
{
    global $conn;
    $res = '';
    if ($action == 'tags') {
    } else {
    }
}


function insertTasks($name, $user_id)
{
    global $conn;
    $query = $conn->prepare("INSERT INTO tasks (name, user_id) VALUE(?,?)");
    $query->execute([$name, $user_id]);
    return $query;
}

function updateTask($description, $user_id, $id)
{
    global $conn;
    $query = $conn->prepare("UPDATE tasks SET name=?, user_id =? WHERE id=?");
    $query->execute([$description, $user_id, $id]);
    return $query;
}

// function userTasks()
// {
//     global $conn;
//     $res = $conn->query("SELECT t.*, u.first_name, u.last_name FROM tasks t  JOIN users u ON t.user_id = u.id")->fetchAll();
//     return $res;
// }

function getAllTasks($user_id = '')
{
    global $conn;
    $res = '';
    if ($user_id != "") {
        $res = $conn->query("SELECT t.* FROM tasks t JOIN users u ON t.user_id = u.id WHERE t.user_id = '$user_id'")->fetchAll();
    } else {
        $res = $conn->query("SELECT t.*,u.first_name, u.last_name FROM tasks t JOIN users u ON t.user_id = u.id ")->fetchAll();
    }
    return $res;
}

function getUsersWithRoleOfJournalist()
{
    global $conn;
    $res = $conn->query("SELECT u.id, u.first_name, u.last_name FROM users u JOIN roles r ON u.role_id =r.id WHERE r.name ='Journalist'")->fetchAll();
    return $res;
}

function getPostsWithoutThis($post_id)
{
    global $conn;
    $query = $conn->query("SELECT * FROM posts WHERE id !=  $post_id LIMIT 3")->fetchAll();
    return $query;
}

function getSelectedPosts($tagName)
{
    global $conn;
    $query = "SELECT * FROM posts WHERE id IN";
    $query .= "( SELECT post_id FROM post_tag WHERE tag_id = ?)";
    $result = $conn->prepare($query);
    $result->execute([$tagName]);
    $data = $result->fetchAll();
    return $data;
}

function getHeadingsPosts($headingName)
{
    global $conn;
    $query = $conn->query("SELECT p.* FROM posts p JOIN headings h ON p.heading_id = h.id WHERE h.name = '$headingName' ")->fetchAll();
    return $query;
}

function getVote($comment, $user)
{
    global $conn;
    $res = $conn->query("SELECT * FROM reactions WHERE comment_id = $comment AND user_id = $user")->fetch();
    return $res;
}

function countVote($comment_id, $column, $columnName)
{
    global $conn;
    $res = $conn->query("SELECT COUNT(`$column`) as $columnName FROM reactions WHERE $column > 0 AND comment_id = $comment_id")->fetch();
    return $res;
}

function getHeadingsByCategoryName($categoryName)
{
    global $conn;
    $res = $conn->query("SELECT h.name as headingName FROM headings h JOIN categories c ON h.category_id = c.id WHERE c.name = '$categoryName'")->fetchAll();
    return $res;
}
