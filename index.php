<?php
session_start();
require_once 'config/connection.php';
include 'models/function.php';
include 'pages/fixed/head.php';
include 'pages/fixed/navigation.php';
$page = '';
if (isset($_GET['page'])) {
    $page =  $_GET['page'];
    switch ($page) {

        case 'home':
            include 'pages/pages/user/index.php';
            break;

        case 'login':
            include 'pages/pages/logAndReg/login.php';
            break;
        case 'register':
            include 'pages/pages/logAndReg/register.php';
            break;

        case 'news':
            include 'pages/pages/user/news.php';
            break;
        case 'singleNews':
            include 'pages/pages/user/singleNews.php';
            break;

        case 'author':
            include 'pages/pages/user/author.php';
            break;
        case 'contact':
            include 'pages/pages/user/contact.php';
            break;
        default:
            include 'pages/fixed/status.php';
    }
} else {
    include 'pages/pages/user/index.php';
}
include 'pages/fixed/footer.php';
