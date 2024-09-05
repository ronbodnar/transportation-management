<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require '../Database.class.php';

$database = new Database();

echo '<pre>';
print_r($database->getUserData(1));
echo '</pre>';

function checkDirectories()
{
    var_dump(getcwd());

    echo '<br/>';

    var_dump(dirname(__FILE__));

    echo '<br/>';

    var_dump(basename(__DIR__));

    echo '<br/>';

    var_dump(basename(dirname(__FILE__, 2)));

    echo '<br/>';
}
