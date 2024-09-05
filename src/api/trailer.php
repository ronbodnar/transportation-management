<?php

require '../database/Database.php';

$database = new Database();

if (!isset($_GET['action'])) {
    die('action not provided');
}
$action = isset($_GET['action']) ? $_GET['action'] : '';

if (strcmp($action, 'yardMove') === 0) {
    $source = $_GET['source'];
    $sourceType = $_GET['sourceType'];
    $destination = $_GET['destination'];
    $destinationType = $_GET['destinationType'];
    $driverId = $_GET['driverId'];

    if (!isset($source) || !isset($destination) || !isset($sourceType) || !isset($destinationType) || !isset($driverId)) {
        die('missing parameters, required: source, destination, sourceType, destinationType, driverId');
    }
    $database->yardRepository->assignYardMove($source, $sourceType, $destination, $destinationType, $driverId);
} else if (strcmp($action, 'availableList') === 0) {
} else {
    die('Invalid action: ' . $action);
}
