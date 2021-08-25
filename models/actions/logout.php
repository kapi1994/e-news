<?php
session_start();

if (isset($_SESSION['users'])) {
    require_once '../functions.php';
    $email = $_SESSION['users']->email;
    insertUserActivity($email, "Logout");
    unset($_SESSION['users']);
    header("Location:../../index.php?page=login");
}
