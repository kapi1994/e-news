<?php
session_start();
require_once 'config/connection.php';
include 'models/functions.php';
include 'pages/fixed/head.php';
include 'pages/fixed/navigation.php';
$page = '';
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'categories':
            include 'pages/pages/admin/categories/index.php';
            break;
        case 'action-categories':
            include 'pages/pages/admin/categories/create_update.php';
            break;
        case 'headings':
            include 'pages/pages/admin/headings/index.php';
            break;
        case 'action-heading':
            include 'pages/pages/admin/headings/action_heading.php';
            break;
        case 'tags':
            include 'pages/pages/admin/tags/index.php';
            break;
        case 'action-tag':
            include 'pages/pages/admin/tags/action_tag.php';
            break;
        case 'posts':
            include 'pages/pages/admin/posts/index.php';
            break;
        case 'action-post':
            include 'pages/pages/admin/posts/action_post.php';
            break;
        case 'post_details':
            include 'pages/pages/admin/posts/post_details.php';
            break;
        case 'users':
            include 'pages/pages/admin/users/index.php';
            break;
        case 'action-user':
            include 'pages/pages/admin/users/action-user.php';
            break;
        case 'login':
            include 'pages/pages/logAndReg/login.php';
            break;
        case 'register':
            include 'pages/pages/logAndReg/register.php';
            break;
        case 'admin_home':
            include 'pages/pages/admin/home.php';
            break;
        case 'news':
            include 'pages/pages/users/posts.php';
            break;
        case 'single-post':
            include 'pages/pages/users/singlePost.php';
            break;
        case 'author':
            include 'pages/pages/users/author.php';
            break;
        case 'home':
            include 'pages/pages/users/home.php';
            break;
        default:
            include 'pages/pages/users/home.php';
            break;
    }
}
include 'pages/fixed/footer.php';
