<?php
header("Content-type:application/json");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rename  = '/^[A-Z][a-z]{3,15}$/';
    $errors = [];
    if (!preg_match($rename, $_POST['name'])) {
        array_push($errors, "Category isn't good");
    }
    if (count($errors) == 0) {
        require_once '../../config/connection.php';
        require_once '../functions.php';
        $date = date("Y-m-d H:i:s");
        $checkName = getOneWithoutFetch('categories', 'name', $_POST['name']);
        if ($checkName->rowCount() > 0) {
            $category = getDataWithFetch('categories', 'name', $_POST['name']);
            if ($category->name == $_POST['name'] && $category->id == $_POST['id']) {
                try {
                    updateCategory('categories', $_POST['name'], $date, $_POST['id']);
                } catch (PDOException $th) {
                    echo json_encode($th->getMessage());
                    http_response_code(500);
                }
            } else {
                echo json_encode("This data is already in use! Choose another name.");
                http_response_code(409);
            }
        } else {
            try {
                updateCategory('categories', $_POST['name'], $date, $_POST['id']);
                http_response_code(204);
            } catch (PDOException $th) {
                echo json_encode($th->getMessage());
                http_response_code(500);
            }
        }
    } else {
        foreach ($errors as $error) {
            echo json_encode("Error: " . $error);
            http_response_code(422);
        }
    }
} else {
    http_response_code(404);
}
