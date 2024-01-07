<?php

$config = array();

if (isset($_POST['action']) && strpos($_POST['action'], 'save') !== false) {
    if (isset($_POST['coi']) && isset($_POST['ontario']) && isset($_POST['riverside'])) {
        $config = array(
            'targets' => array(
                'coi' => $_POST['coi'],
                'ontario' => $_POST['ontario'],
                'riverside' => $_POST['riverside']
            )
        );
        saveConfig();
    } else {
        die('missing parameters');
    }
}

if (isset($_POST['action']) && strpos($_POST['action'], 'get') !== false) {
    loadConfig();
    die(json_encode($config));
}

function saveConfig()
{
    global $config;
    echo 'Adding config to file:';
    echo '<pre>';
    print_r(json_encode($config));
    echo '</pre>';
    file_put_contents(__DIR__ . "/../config/targets.json", json_encode($config)) or print_r(error_get_last());
}

function loadConfig()
{
    global $config;
    $contents = file_get_contents(__DIR__ . "/../config/targets.json");
    $config = json_decode($contents, true);
}
