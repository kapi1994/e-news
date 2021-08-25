<?php
define("BASE_URL", $_SERVER['DOCUMENT_ROOT'] . "/e-news-master/");
define("ENV_FILE", BASE_URL . '/config/.env');
define("LOG_FILE", BASE_URL . '/data/logs.txt');



define("HOST", env('HOST'));
define('NAME', env('NAME'));
define('USERNAME', env('USERNAME'));
define('PASSWORD', env('PASSWORD'));

function env($name)
{
    $data = file(ENV_FILE);
    $value = "";
    foreach ($data as $row) {
        $configuration = explode("=", $row);
        if ($configuration[0] == $name) {
            $value = trim($configuration[1]);
        }
    }
    return $value;
}
