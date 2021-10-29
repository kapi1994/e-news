<?php
session_start();
if (isset($_SESSION['user'])) {
    require_once '../function.php';
    insertActivity("Logout", $_SESSION['user']->email);
    unset($_SESSION['user']);
    header("Location:../../index.php?page=home");
}
