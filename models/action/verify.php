<?php
session_start();
require_once '../../config/connection.php';
require_once '../function.php';

if (isset($_GET['id']) || isset($_GET['token'])) {
    $id = $_GET['id'];
    $user = getOneFetchAndCheckData('users', 'id', $id, 'fetch');
    if (enableAccount($_GET['id'], $_GET['token'])) {
        $_SESSION['activateAcc'] = true;
        header("Location: ../../index.php?page=login");
    } else {
        echo "no functuoin";
    }
} else {
    echo "undefiend token";
}
