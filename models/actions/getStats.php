<?php
include "../../config/connection.php";
include "../functions.php";
$file = fopen("../../data/logs.txt", "r");
$rows = file("../../data/logs.txt");
fclose($file);
$stats = [];
$total = 0;
$total24 = 0;
$mainPages = ["home" => 0, "news" => 0, "contact" => 0, "author" => 0];
$mainPages24 = ["home" => 0, "news" => 0, "contact" => 0, "author" => 0];
$visitedPages = [];
foreach ($rows as $row) {
    //ne racunaju se modeli
    $data = explode("\t", $row);
    $url = $data[0]; /// "pphp/sajt/index.php?page=home"
    $url = explode("?", $url); /// [pphp/sajt/index.php] [page=home"]
    $mainUrl = $url[0]; /// "pphp/sajt/index.php"
    $visited = explode("/", $mainUrl); /// [pphp] [sajt] [index.php]
    $index = $visited[count($visited) - 1]; /// "index.php"
    if ($index != "index.php") {
        continue;
    }
    if (count($url) == 1) { //samo je index.php
        $mainPages["home"]++;
        $total++;
    } else {
        $page = $url[1]; // "page=home&something"
        $page = explode("&", $page)[0]; //[page=home] // [something]
        $page = explode("=", $page); //[page] [home]
        if ($page[0] == "page" && count($page) > 1) {
            if (array_key_exists($page[1], $mainPages)) {
                $mainPages[$page[1]]++;
                $total++;
                if (inTheLast24H($data[1]))
                    $mainPages24[$page[1]]++;
            }
        }
    }
}
$logins = loggedInToday();
$registeredUsers = registeredusers();
$stats = ["overallViews" => $mainPages, "todayViews" => $mainPages24, "todayLogin" =>
$logins, "registeredUsers" => $registeredUsers];
echo json_encode($stats);
