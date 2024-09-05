<?php

function isLoggedIn()
{
    return true; //isset($_SESSION['id']);
}

function getRelativePath()
{
    $folder_depth = substr_count(dirname($_SERVER['DOCUMENT_URI']), "/");

    if ($folder_depth == false)
        $folder_depth = 1;

    return str_repeat("../", $folder_depth - 2);
}
