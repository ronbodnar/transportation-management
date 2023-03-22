<?php

$config = array();

if (isset($_POST['action']) && strpos($_POST['action'], 'save') !== false) {
    if (isset($_POST['accoi']) && isset($_POST['acont']) && isset($_POST['lineage'])) {
        $config = array(
            'targets' => array(
                'accoi' => $_POST['accoi'],
                'acont' => $_POST['acont'],
                'lineage' => $_POST['lineage']
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
    file_put_contents("config.json", json_encode($config)) or print_r(error_get_last());
}

function loadConfig()
{
    global $config;
    $contents = file_get_contents("config.json");
    $config = json_decode($contents, true);
}
