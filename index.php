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
        case 'categories':
            include 'pages/pages/admin/categories/index.php';
            break;
        case 'category_action':
            include 'pages/pages/admin/categories/insert_update_category.php';
            break;

        case 'headings':
            include "pages/pages/admin/headings/index.php";
            break;
        case 'heading_action':
            include 'pages/pages/admin/headings/insert_update_heading.php';
            break;

        case 'tags':
            include 'pages/pages/admin/tags/index.php';
            break;
        case 'tag_action':
            include 'pages/pages/admin/tags/insert_update_category.php';
            break;


        case 'posts':
            include 'pages/pages/admin/posts/index.php';
            break;
        case 'post_action':
            include 'pages/pages/admin/posts/insert_update_post.php';
            break;
        case 'post_details':
            include 'pages/pages/admin/posts/post_details.php';
            break;
        case 'users':
            include 'pages/pages/admin/users/index.php';
            break;
        case 'user_action':
            include 'pages/pages/admin/users/insert_update_action_user.php';
            break;

        case 'home':
            include 'pages/pages/user/index.php';
            break;

        case 'admin_home':
            include 'pages/pages/admin/index.php';
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
    }
}
include 'pages/fixed/footer.php';
