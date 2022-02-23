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
    // return $queryUpdate;
}
function insertTag($name, $headings)
{
    global $conn;
    $queryInsert = $conn->prepare("INSERT INTO tags (name) VALUES(?)");
    $queryInsert->execute([$name]);
    $lastId = $conn->lastInsertId();
    insertHeadingTag($lastId, $headings);

    // return $queryInsert;
}
function insertHeadingTag($tag_id, $headings)
{
    global $conn;
    if (count($headings) > 0) {
        $queryParams = [];
        $values = [];
        foreach ($headings as $heading) {
            $queryParams[] = "(?,?)";
            $values[] = (int)$heading;
            $values[] = (int)$tag_id;
        }

        $heading_tag_insert = $conn->prepare("INSERT INTO heading_tag VALUES" . implode(",", $queryParams));
        $heading_tag_insert->execute($values);
    }
}
function updateTag($name, $date, $headings_arr, $id)
{
    global $conn;
    $res = $conn->prepare("UPDATE tags SET name=?,updated_at=? WHERE id=? ");
    $res->execute([$name, $date, $id]);
    deleteHeadingTag($id);
    insertHeadingTag($id, $headings_arr);
}
function getTagHeadings($heading_id)
{
    global $conn;
    $query = 'SELECT id FROM headings WHERE id IN ';
    $query .= " (SELECT heading_id FROM heading_tag WHERE tag_id = ?)";
    $result = $conn->prepare($query);
    $result->execute([$heading_id]);
    $data = $result->fetchAll();

    $headingsArr  = [];
    foreach ($data as $d) {
        array_push($headingsArr, $d->id);
    }
    return $headingsArr;
}
function getTagIdNameByHeading($heading_id)
{
    global $conn;
    $query = "SELECT id, name FROM tags WHERE id IN ";
    $query .= " (SELECT tag_id FROM heading_tag WHERE heading_id = ?)";
    $q = $conn->prepare($query);
    $q->execute([$heading_id]);
    $res = $q->fetchAll();
    return $res;
}
function deleteHeadingTag($tag_id)
{
    deleteData('heading_tag', 'tag_id', $tag_id);
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
    $res = $conn->query("SELECT u.*, r.name as roleName FROM users u JOIN roles r ON u.role_id = r.id WHERE r.name != 'Admin' ORDER BY u.created_at DESC")->fetchAll();

    return $res;
}

function insertUser($firstName, $lastName, $email, $password, $role, $journalistRole)
{
    global $conn;
    $res = $conn->prepare("INSERT INTO users (first_name,last_name, email, password, role_id,category_id) VALUES(?,?,?,?,?,?)");
    $res->execute([$firstName, $lastName, $email, md5($password), $role, $journalistRole]);
    return $res;
}

function updateUser($firstName, $lastName, $email, $role_id, $date, $id)
{
    global $conn;
    $query = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email =?, role_id =?, updated_at =? WHERE id =?");
    $query->execute([
        $firstName, $lastName, $email, $role_id, $date, $id
    ]);
}


function getComments($postId, $parentComment = 0)
{
    global $conn;
    $query  = "SELECT c.*, u.first_name as firstName, u.last_name as lastName
         FROM comments c JOIN users u ON c.id_user = u.id WHERE c.id_post = $postId AND c.parent_id = $parentComment";
    $comments = $conn->query($query)->fetchAll();
    return $comments;
}
function getReactionBySingleComment($comment_id)
{
    global $conn;
    $res = $conn->query("SELECT likes, disslikes,first_name, last_name FROM reactions r JOIN users u ON r.user_id = u.id WHERE comment_id = $comment_id ")->fetchAll();
    return $res;
}
function getCommentsWithReaction($post_id, $user_id = '', $comment_id = 0)
{
    // return $comment_id;
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
    $w = $getImageDimensions[0];
    $h = $getImageDimensions[1];
    $tw = 300;
    $th = ($tw * $h) / $w;
    $thumbnail = imagecreatetruecolor($tw, $th);
    imagealphablending($thumbnail, false);
    imagesavealpha($thumbnail, true);
    $transparent = imagecolorallocatealpha($thumbnail, 255, 255, 255, 127);
    imagefilledrectangle($thumbnail, 0, 0, $tw, $th, $transparent);
    switch ($image['type']) {
        case 'image/png':
            $source = imagecreatefrompng($new_normal_path);
            break;
        default:
            $source = imagecreatefromjpeg($new_normal_path);
            break;
    }
    imagecopyresampled($thumbnail, $source, 0, 0, 0, 0, $tw, $th, $w, $h);
    switch ($image['type']) {
        case 'image/png':
            imagepng($thumbnail, $new_small_path);
            break;
        default:
            imagejpeg($thumbnail, $new_small_path);
            break;
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
function insertComment($table, $text, $comment_id, $post_id, $user_id)
{
    global $conn;
    $queryInsert = "";
    if ($comment_id == 0) {
        $queryInsert  = $conn->prepare("INSERT INTO $table (text,id_post, id_user) VALUES(?,?,?)");
        $queryInsert->execute([$text,  $post_id, $user_id]);
    } else {
        $queryInsert  = $conn->prepare("INSERT INTO $table ( text ,parent_id, id_post, id_user) VALUES(?,?,?,?)");
        $queryInsert->execute([$text, $comment_id, $post_id, $user_id]);
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
    $query = "SELECT id, name FROM tags WHERE id IN ";
    $query .= "(SELECT tag_id FROM post_tag WHERE post_id = ?)";
    $result = $conn->prepare($query);
    $result->execute([$post_id]);
    $data = $result->fetchAll();
    return $data;
}

// PAGINACIJA
define("ELEMENTS_OFFSET", 10);
function numOfData($query)
{
    global $conn;
    $res = $conn->query($query)->fetch();
    return $res;
}


function getHeadingWithCategory($user, $limit = 0, $keyword = '', $order = 0)
{
    global $conn;
    $res = '';
    $limitQuery = "";
    $orderQuery = ' ORDER BY h.created_at DESC';
    $query = "";
    $baseQuery = "SELECT h.*, c.name as categoryName FROM headings h JOIN categories c ON h.category_id = c.id ";
    if ($user->roleName == "Journalist") {
        $query .= " category_id == $user->category_id ";
    }
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

function getNumOfHeadings($user, $action, $keyword = '')
{
    global $conn;
    $res = '';
    $query = '';
    $baseQuery = "SELECT COUNT(*) as numOfHeadings FROM headings";
    if ($user->roleName == "Journalist") {
        $query = " WHERE category_id = $user->category_id";
        $baseQuery .= $query;
    }
    if ($keyword != '') {
        if ($user->roleName == "Journalist") {
            $query .= " AND name LIKE '$keyword'";
            $baseQuery .= $query;
        } else {
            $query = " WHERE name LIKE '$keyword'";
            $baseQuery .=  $query;
        }
    }
    // return $baseQuery;
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

function getIdNameFromHeadingsByCategoryId($category_id)
{
    global $conn;
    $query = $conn->query("SELECT id, name FROM headings WHERE category_id = $category_id")->fetchAll();
    return $query;
}

function getAllTags($user, $limit = 0, $keyword = '', $order = 0)
{
    global $conn;
    $res = '';
    // $query =  '';
    $orderQuery = ' ORDER BY created_at DESC';
    $limitQuery = ' LIMIT :limit, :offset';

    $baseQuery = "SELECT t.* FROM tags t";
    if ($user->roleName == "Journalist") {
        $category_id = $user->category_id;
        $query = "  JOIN heading_tag ht  ON t.id=ht.tag_id JOIN headings h ON ht.heading_id = h.id WHERE h.category_id = $category_id ";
        $baseQuery .= $query;
    }

    if ($keyword != '') {
        if ($user->roleName == "Journalist") {
            $query = " AND t.name LIKE '$keyword'";
            $baseQuery .= $query;
        } else {
            $query = " WHERE t.name LIKE '$keyword'";
            $baseQuery .= $query;
        }
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

    $baseQuery .= $orderQuery . $limitQuery;
    // return $baseQuery;
    $query = $conn->prepare($baseQuery);
    $query->bindValue(":limit", $limit, PDO::PARAM_INT);
    $query->bindValue(":offset", $offset, PDO::PARAM_INT);
    $query->execute();
    $res = $query->fetchAll();
    return $res;
}

function getNumOfTags($user, $action, $keyword = '')
{
    global $conn;
    $query = '';
    $baseQuery = "SELECT COUNT(*)  as numOfTags FROM tags t";
    if ($user->roleName == "Journalist") {
        $category_id = $user->category_id;
        $query = "  JOIN heading_tag ht  ON t.id=ht.tag_id JOIN headings h ON ht.heading_id = h.id WHERE h.category_id = $category_id ";
        $baseQuery .= $query;
    }
    if ($keyword != '') {
        if ($user->roleName == "Journalist") {
            $query = " AND t.name LIKE '$keyword'";
        } else {
            $query = " WHERE name LIKE '$keyword'";
            $baseQuery .= $query;
        }
    }

    if ($action == 'count') {
        $res = $conn->query($baseQuery)->fetch();
    } else {
        $pages = $conn->query($baseQuery)->fetch();
        $res = ceil($pages->numOfTags / ELEMENTS_OFFSET);
    }
    return $res;
}




function    postPagination($user, $limit = 0, $text = "", $order = 0, $categories = "", $headings = "")
{

    global $conn;
    $res = '';
    $orderQuery = " ORDER BY p.created_at DESC";
    $query = '';
    $limitQuery = ' LIMIT :limit, :offset';
    $compareString = trim("%$text%");

    $baseQuery = "SELECT p.*, c.name as categoryName, h.name as headingName FROM posts p JOIN categories c ON p.category_id = c.id JOIN headings h ON p.heading_id = h.id";
    if ($user->roleName == "Journalist") {
        $user_id = $user->id;
        $query = " WHERE p.user_id = '$user_id'";
        // $baseQuery .= $query;
    }

    if ($text != "") {
        if ($user->roleName == "Journalist") {
            $query .= " AND p.name LIKE '$compareString'";
            // $baseQuery .= $query;
        } else {
            $query = " WHERE p.name LIKE '$compareString'";
            // $baseQuery .= $query;
        }
    }


    if ($categories != "") {
        if ($user->roleName == "Journalist") {
            $query .= " AND p.category_id IN ($categories)";
            // $baseQuery .= $query;
            // return $baseQuery;
        } else {
            if ($text != "") {
                $query .= " AND p.category_id IN ($categories)";
            } else {
                $query = " WHERE p.category_id IN ($categories)";
                // $baseQuery .= $query;
            }
        }
        // $baseQuery .= $query;
    }

    if ($headings != "") {
        if ($user->roleName == "Journalist") {
            $query .= " AND p.heading_id IN ('$headings')";
            // $baseQuery .= $query;
            // return $baseQuery;
        } else {
            if ($text != "" || $categories != "") {
                $query .= " AND p.heading_id IN ('$headings')";
                // $baseQuery .= $query;
            } else {
                $query = " WHERE p.heading_id IN ('$headings')";
                // $baseQuery .= $query;
            }
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

    $baseQuery .= $query . $orderQuery . $limitQuery;

    // return $baseQuery;
    $query = $conn->prepare($baseQuery);
    $query->bindValue(":limit", $limit, PDO::PARAM_INT);
    $query->bindValue(":offset", $offset, PDO::PARAM_INT);
    $query->execute();
    $res = $query->fetchAll();

    return $res;
    // return $baseQuery;
}

function getNumOfPosts($action, $user, $text = "", $categories = '', $headings = '')
{
    global $conn;
    $query = "";
    $baseQuery = "SELECT COUNT(*) as numberOfPosts FROM posts";

    $compareString = trim("%$text%");
    if ($user->roleName == "Journalist") {
        $user_id = $user->id;
        $query = " WHERE user_id = '$user_id'";
    }
    if ($text != "") {
        if ($user->roleName == "Journalist") {
            $query .= " AND name LIKE '$compareString'";
            // $baseQuery .= $query;
        } else {
            $query = " WHERE name LIKE '$compareString'";
            // $baseQuery .= $query;
        }
    }


    if ($categories != "") {

        if ($user->roleName == "Journalist") {
            $query .= " AND category_id IN ($categories)";
        } else {
            if ($text != "") {
                $query .= " AND category_id IN ($categories)";
            } else {
                $query .= " WHERE category_id IN ($categories)";
            }
            // $baseQuery .= $query;
        }
    }

    if ($headings != "") {
        if ($user->roleName == "Journalist") {
            $query .= " AND heading_id IN ('$headings')";
            // $baseQuery .= $query;
        } else {
            if ($text != "" || $categories != "") {
                $query .= " AND heading_id IN ('$headings')";
            } else {
                $query .= " WHERE heading_id IN ('$headings')";
                // $baseQuery .= $query;
            }
        }
    }

    $baseQuery .=  $query;
    // return $baseQuery;
    if ($action == 'count') {
        $res = $conn->query($baseQuery)->fetch();
    } else {
        $pages = $conn->query($baseQuery)->fetch();
        $res = ceil($pages->numberOfPosts / ELEMENTS_OFFSET);
    };
    return $res;
    // return $baseQuery;
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
    $query = "";
    $baseQuery = "SELECT u.*, r.name as roleName from users u join roles r ON u.role_id = r.id WHERE r.name != 'Admin'";
    $orderQuery = ' ORDER BY u.created_at DESC';
    $limitQuery = ' LIMIT :limit, :offset';

    if ($keyword != '') {
        $query .= " AND (u.first_name LIKE '$keyword' OR u.last_name LIKE '$keyword')";
        $baseQuery .= $query;
    }
    if ($role_id != 0) {
        $query .= " AND u.role_id = '$role_id'";
        $baseQuery .= $query;
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

    $baseQuery = "SELECT COUNT(*) as numberOfUsers FROM users u JOIN roles r ON u.role_id = r.id WHERE r.name !='Admin'";


    if ($keyword != '') {
        $query .= " AND (u.first_name LIKE '$keyword' OR u.last_name LIKE '$keyword')";
        $baseQuery .= $query;
    }
    if ($role_id != 0) {
        $query .= " AND u.role_id = '$role_id'";
        $baseQuery .= $query;
    }

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



function loggedInToday($path)
{
    $counter = 0;
    $file_users  = fopen($path, "r");
    $data_users = file($path);
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



function insertTasks($name, $user_id)
{
    global $conn;
    $query = $conn->prepare("INSERT INTO tasks (description, user_id) VALUE(?,?)");
    $query->execute([$name, $user_id]);
    return $query;
}

function updateTask($description, $user_id, $id)
{
    global $conn;
    $query = $conn->prepare("UPDATE tasks SET description=?, user_id =? WHERE id=?");
    $query->execute([$description, $user_id, $id]);
    return $query;
}



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
    $query = $conn->query("SELECT * FROM posts WHERE id !=  $post_id  ORDER BY created_at DESC LIMIT 4")->fetchAll();
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

function getHeadingsByCategoryId($categoryId)
{
    global $conn;
    $res = $conn->query("SELECT h.name as headingName FROM headings h JOIN categories c ON h.category_id = c.id WHERE c.name = '$categoryId'")->fetchAll();
    return $res;
}
function getHeadingsByCategoryName($categoryName)
{
    global $conn;
    $res = $conn->query("SELECT h.name as headingName FROM headings h JOIN categories c ON h.category_id = c.id WHERE c.name = '$categoryName'")->fetchAll();
    return $res;
}

function rolesWithoutAdmin()
{
    global $conn;
    $res = $conn->query("SELECT * FROM roles WHERE name!='Admin'")->fetchAll();
    return $res;
}

function getHeadingByCategoryId($id)
{
    global $conn;
    $res = $conn->query("SELECT h.*, c.name as categoryName FROM headings h JOIN categories c ON h.category_id = c.id WHERE h.category_id = '$id' ")->fetchAll();
    return $res;
}
function getTagsByCategory($category_id)
{
    global $conn;
    $res = $conn->query("SELECT id, name FROM tags WHERE category_id='$category_id'")->fetchAll();
    return $res;
}

function getTagByHeading($category_id)
{
    global $conn;
    $res = $conn->query("SELECT id, name FROM headings WHERE category_id ='$category_id' ")->fetchAll();
    return $res;
}
function accountIsDisabled($user_email)
{
    $fileU = fopen("../../data/userLog.txt", "r");
    $rowsU = file("../../data/userLog.txt");
    fclose($fileU);
    foreach ($rowsU as $row) {
        $data = explode("\t", $row);
        if ($data[0] == $user_email && $data[1] == "Dissabled account") {
            return true;
        }
    }
    return false;
}

function insertActivity($action, $email)
{
    $file_open = fopen('../../data/userLog.txt', 'a');
    $date = date("d-m-Y H:i:s");
    $content = "{$email}\t{$action}\t{$date}\n";
    fwrite($file_open, $content);
    fclose($file_open);

    if ($action == "Dissabled account") {
        sendDissMail($email, $date);
    }
}


function insertThreeTimesInFive($user_email)
{
    $fileU = fopen("../../data/userLog.txt", "r");
    $rowsU = file("../../data/userLog.txt");
    fclose($fileU);
    $dates = [];
    foreach ($rowsU as $row) {
        $data  = explode("\t", $row);
        if ($data[0] == $user_email && $data[1] == "Invalid password") {
            array_push($dates, $data[2]);
        }
    }

    if (count($dates) < 3) {
        return false;
    }
    if (threeInFiveMinutes($dates)) {
        return true;
    } else {
        return false;
    }
}

function threeInFiveMinutes($array)
{
    $first = strtotime($array[count($array) - 3] . " +5 minutes");
    $last = strtotime($array[count($array) - 1]);

    if ($first >= $last) {
        return true;
    } else {
        return false;
    }
}

function sendDissMail($email, $date)
{
    global $conn;
    // echo $email;
    $from = "masternews247@gmail.com";
    $usernameFrom = "E-news Admin";
    $user = $conn->prepare("SELECT * FROM users WHERE email=?");
    $user->execute([$email]);
    $userData = $user->fetch();
    $token = md5($userData->email . $date);
    $to = $userData->email;
    $usernameTo = $userData->first_name . " " . $userData->last_name;

    $message = "Your account has been disabled! Click here to verify it;s you: http://localhost/e-news-master/models/action/verify.php?token=" . $token . "&id=" . $userData->id;
    $messageHTML = "<div><h1>Your account has been disabled!</h1> <br/><p> Please click <a href='https://localhost/e-news-master/models/action/verify.php?token=" . $token . "&id=" . $userData->id . "'>this link</a> to verify that this is you.</p></div>";
    $subject = "Your Account Has Been Disabled";

    include 'sendEmail.php';
}
function enableAccount($user_id, $token)
{

    $fileU = fopen("../../data/userLog.txt", "r");
    $rowsU = file("../../data/userLog.txt");
    fclose($fileU);
    $user = getOneFetchAndCheckData('users', 'id', $user_id, 'fetch');
    // echo $token;
    $email = $user->email; /*$new = tokenMatch($rowsU, $user_id, $token); return [$token, $email, $new];*/
    // return $email;
    // echo $user_id;
    if (tokenMatch($rowsU, $user_id, $token)) {
        $new = "";
        foreach ($rowsU as $row) {
            $data = explode("\t", $row);
            echo $data;
            if (!($data[0] == $email && (($data[1] == "Dissabled account") || ($data[1] == "Invalid password")))) {
                $new .= $row;
                echo $new;
            }
        }
        $fileU = fopen("../../data/userLog.txt", "w");
        fwrite($fileU, $new);
        fclose($fileU);
        return true;
    } else {
        return 'ne';
    }
}

function tokenMatch($rowsU, $user_id, $token)
{

    $user = getOneFetchAndCheckData('users', 'id', $user_id, 'fetch');
    // echo $user_id;
    $email = $user->email;
    // echo $email;
    /*$token = md5($user->email.$date);*/
    foreach ($rowsU as $row) {
        $data = explode("\t", $row);
        if (($data[0] == $email && $data[1] == "Dissabled account")) {
            // echo $token;
            // echo md5($email . trim($data[2]));
            // return 'da';
            return $token == md5($email . trim($data[2]));
        }
    }
    return false;
}

function lastOne()
{
    global $conn;
    $res = $conn->query("SELECT p.id, p.name, p.image_path, p.created_at,c.name as categoryName FROM posts p JOIN categories c ON p.category_id = c.id ORDER BY p.created_at ASC LIMIT 1")->fetch();
    return $res;
}

function exceptLastOne($id)
{
    global $conn;
    $res = $conn->query("SELECT p.id, p.name, p.image_path, c.name as categoryName FROM posts p JOIN categories c ON p.category_id
    = c.id ORDER BY p.created_at ASC LIMIT $id, 4")->fetchAll();
    return $res;
}
function getPostsFilteredByCategory($category_id)
{
    global $conn;
    $res = $conn->query("SELECT p.*, h.name as headingName FROM posts p JOIN headings h ON p.heading_id = h.id WHERE p.category_id = $category_id LIMIT 4")->fetchAll();
    return $res;
}
