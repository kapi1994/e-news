<?php
require "../../config/connection.php";
require "../functions.php";
if ($_GET['action'] == 'excel') {

    //var_dump($field);
    $field = getColumnIngridients();
    $data = getAll('categories');
    $timestamp = time();
    $filename = 'ingredientsKN318' . $timestamp . '.xls';
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    foreach ($field as $d)
        echo $d->COLUMN_NAME . "\t";
    echo "\n";
    foreach ($data as $d)
        echo $d->id . "\t" . $d->name . "\t" . $d->created_at . "\t" . $d->updated_at . "\t\n";

    exit();



    exit();;
} elseif ($_GET['action'] == 'word') {

    $timestamp = time();
    $filename = 'documentNJ326' . $timestamp . '.doc';
    header("Content-type: application/vnd.ms-word");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    echo "Nemanja Jovicic 326/14 \n";
    echo "I'm a twenty-something web developer, a level thirty-six Pokémon trainer
and a somewhat proud mother of two dumb dogs and an annoying cat.\n
 I enjoy making websites and I'm currently studying at the ICT College of
Vocational Studies in Belgrade. I like working as a team member as well as
independently; a team leader and a team player. I am curious and constantly learning.";

    exit();
} else {
    echo "NO";
}
