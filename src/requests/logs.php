<?php

require '../Database.class.php';

$database = new Database();

if (!isset($_GET['action'])) {
    die('action not provided');
}
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Retrieve a list of all driver logs by ID.
if (strcmp($action, 'get') === 0) {
    if (!isset($_GET['id']) || strlen($_GET['id'] < 1)) {
        die('missing id');
    }
    $output = array();
    $logs = $database->getDriverActivityLogs($_GET['id']);
    foreach ($logs as $log) {
        $date = $log['date'];
        $driver = $log['driver'];
        $facility = $log['facility'];
        $arrivalTime = $log['arrivalTime'];
        $instructionsReceived = $log['instructionsReceived'];
        $instructionsAccepted = $log['instructionsAccepted'];
        $departureTime = $log['departureTime'];
        $reason = $log['reason'];
        $trailerId = $log['trailerId'];
        $yardMoves = $log['yardMoves'];
        $flagged = $log['flagged'];

        $data = array(
            'date' => $date,
            'driver' => $driver,
            'facility' => $facility,
            'arrivalTime' => $arrivalTime,
            'instructionsReceived' => $instructionsReceived,
            'instructionsAccepted' => $instructionsAccepted,
            'departureTime' => $departureTime,
            'reason' => $reason,
            'trailerId' => $trailerId,
            'yardMoves' => $yardMoves,
            'flagged' => $flagged
        );

        array_push($output, $data);
    }
    echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
// Retrive a list of all flagged logs by ID.
} else if (strcmp($action, 'get-flagged') === 0) {
    if (!isset($_GET['id']) || strlen($_GET['id'] < 1)) {
        die('missing id');
    }
    $output = array();
    $logs = $database->getFlaggedActivityLogs($_GET['id']);
    foreach ($logs as $log) {
        $date = $log['date'];
        $driver = $log['driver'];
        $facility = $log['facility'];
        $arrivalTime = $log['arrivalTime'];
        $instructionsReceived = $log['instructionsReceived'];
        $instructionsAccepted = $log['instructionsAccepted'];
        $departureTime = $log['departureTime'];
        $reason = $log['reason'];
        $trailerId = $log['trailerId'];
        $yardMoves = $log['yardMoves'];
        $flagged = $log['flagged'];

        $data = array(
            'date' => $date,
            'driver' => $driver,
            'facility' => $facility,
            'arrivalTime' => $arrivalTime,
            'instructionsReceived' => $instructionsReceived,
            'instructionsAccepted' => $instructionsAccepted,
            'departureTime' => $departureTime,
            'reason' => $reason,
            'trailerId' => $trailerId,
            'yardMoves' => $yardMoves,
            'flagged' => $flagged
        );

        array_push($output, $data);
    }
    echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
// Retrive a list of all logs for all drivers.
} else if (strcmp($action, 'get-all') === 0) {
    $output = array();
    $logs = $database->getDriverActivityLogs();
    foreach ($logs as $log) {
        $date = $log['date'];
        $driver = $log['driver'];
        $facility = $log['facility'];
        $arrivalTime = $log['arrivalTime'];
        $instructionsReceived = $log['instructionsReceived'];
        $instructionsAccepted = $log['instructionsAccepted'];
        $departureTime = $log['departureTime'];
        $reason = $log['reason'];
        $trailerId = $log['trailerId'];
        $yardMoves = $log['yardMoves'];
        $flagged = $log['flagged'];

        $data = array(
            'date' => $date,
            'driver' => $driver,
            'facility' => $facility,
            'arrivalTime' => $arrivalTime,
            'instructionsReceived' => $instructionsReceived,
            'instructionsAccepted' => $instructionsAccepted,
            'departureTime' => $departureTime,
            'reason' => $reason,
            'trailerId' => $trailerId,
            'yardMoves' => $yardMoves,
            'flagged' => $flagged
        );

        array_push($output, $data);
    }
    echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
// Retrieve a list of all flagged logs for all drivers.
} else if (strcmp($action, 'get-all-flagged') === 0) {
    $output = array();
    $logs = $database->getFlaggedActivityLogs();
    foreach ($logs as $log) {
        $date = $log['date'];
        $driver = $log['driver'];
        $facility = $log['facility'];
        $arrivalTime = $log['arrivalTime'];
        $instructionsReceived = $log['instructionsReceived'];
        $instructionsAccepted = $log['instructionsAccepted'];
        $departureTime = $log['departureTime'];
        $reason = $log['reason'];
        $trailerId = $log['trailerId'];
        $yardMoves = $log['yardMoves'];
        $flagged = $log['flagged'];

        $data = array(
            'date' => $date,
            'driver' => $driver->getFullName(),
            'facility' => $facility,
            'arrivalTime' => $arrivalTime,
            'instructionsReceived' => $instructionsReceived,
            'instructionsAccepted' => $instructionsAccepted,
            'departureTime' => $departureTime,
            'reason' => $reason,
            'trailerId' => $trailerId,
            'yardMoves' => $yardMoves,
            'flagged' => $flagged
        );

        array_push($output, $data);
    }
    echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
} else {
    die('Invalid action: ' . $action);
}
