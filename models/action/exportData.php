<?php
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    require_once '../../config/connection.php';
    require_once '../function.php';
    if ($action == 'excel') {
        $field = getColumnsTable();
        $data = getAll('categories');
        $timestamp = time();
        $filename = 'categoriesNJ' . $timestamp . '.xls';
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        foreach ($field as $d) echo $d->COLUMN_NAME . "\t";
        echo "\n";
        foreach ($data as $d) echo $d->id . "\t" . $d->name . "\t" . $d->created_at . "\t" . $d->updated_at . "\t\n";
        exit();
    } else {
        $timestamp = time();
        $filename = 'dokumentacijaNJ' . $timestamp . '.doc';
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        echo "Nemanja Jovicic \n";
        echo "Ljubitelj video igara";
        exit();
    }
}
