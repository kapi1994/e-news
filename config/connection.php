<?php

require_once 'config.php';

pageAccess();
try {
    $conn = new PDO('mysql:host=' . HOST . ';dbname=' . NAME, USERNAME, PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch (PDOException  $th) {
    echo json_encode($th->getMessage());
}


function pageAccess()
{
    $file = fopen(LOG_FILE, "a");
    if ($file) {
        $date = date('d-m-Y H:i:s');

        fwrite(
            $file,
            "{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}\t{$date}\t{$_SERVER['REMOTE_ADDR']}\t\n"
        );
        fclose($file);
    }
}
