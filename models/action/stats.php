    <?php
    header("Content-type:application/json");
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        require_once '../../config/connection.php';
        require_once '../function.php';
        $file_open = fopen("../../data/logs.txt", "r");
        $data = file("../../data/logs.txt");

        $stats = [];
        $total = 0;
        $total24 = 0;


        $mainPaiges = ['home' => 0, "news" => 0, 'singleNews' => 0, "author" => 0];
        $mainPaiges24 = ['home' => 0, "news" => 0, 'singleNews' => 0, "author" => 0];
        fclose($file_open);
        foreach ($data as $d) {
            $split_slash_t = explode("\t", $d);
            $split_slashes = explode('/', $split_slash_t[0]);
            $split_query = explode('?', $split_slashes[2]);

            if ($split_query[0] != 'index.php') {
                continue;
            }

            if ($split_query[0] == "index.php" && count($split_query) == 1) {
                $mainPaiges['home']++;
            } else {
                $page = $split_query[1];
                $page = explode('&', $page);
                $page_split_equal = explode("=", $page[0]);
                if ($page_split_equal[0] == "page" && count($page)) {
                    if (array_key_exists($page_split_equal[1], $mainPaiges)) {
                        $mainPaiges[$page_split_equal[1]]++;
                        $total++;

                        if (inTheLast24H($split_slash_t[1])) {
                            $mainPaiges24[$page_split_equal[1]]++;
                        }
                    }
                }
            }
        }
        $totalUsers = registetedUsersCount();
        $totalPosts = countPosts();
        // echo json_encode($totalUsers);
        $logins = loggedInToday("../../data/userLog.txt");
        $stats = [
            "overallViews" => $mainPaiges, "todayViews" => $mainPaiges24, "todayLogins" => $logins,
            "totalUsers" => $totalUsers, "totalPosts" => $totalPosts
        ];
        echo json_encode($stats);
    } else {
        http_response_code(404);
    }
