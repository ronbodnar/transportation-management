<?php

require '../Database.class.php';

$database = new Database();

$requestMethod = $_SERVER["REQUEST_METHOD"];

if (strcmp($requestMethod, 'GET') === 0) {
    if (!isset($_GET['action'])) {
        die('action not provided');
    }
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    // Retrieve a list of doors on the North side of the building
    if (strcmp($action, 'northList') === 0) {
        $doors = $database->getDoorData('NORTH');

        $doorsOutOfService = array(
            11, 12
        );

        $output = array();
        foreach ($doors as $key => $value) {
            $doorOutOfService = false;
            $shipment = $value['shipment'];

            if (strpos($value['status'], "EMPTY") !== false || ($shipment == null && $value['trailerId'] != 0)) {
                $backgroundColor = '#ef716f'; // blue
            } else if ($shipment === null && $value['trailerId'] == 0) {
                $backgroundColor = '#009b9b'; // red
            } else if (strpos($value['status'], "LOADING") !== false) {
                $backgroundColor = '#E69322'; // yellow
            } else {
                $backgroundColor = '#4b9307'; // green
            }

            if (in_array((intval($value['id']) - 20), $doorsOutOfService)) {
                $doorOutOfService = true;
            }

            $status = '';

            if ($doorOutOfService) {
                $status = '<span id="oos-tooltip" class="badge rounded-pill" style="background-color: red; cursor: help;" data-bs-toggle="tooltip" data-bs-placement="top" title="Out of service"><span class="tooltip-underline">OOS</span></span>';
            } else if ($shipment == null) {
                $status = '<span class="badge rounded-pill" style="background-color: ' . $backgroundColor . ';">' . ($value['trailerId'] == 0 ? "Open" : 'Empty') . '</span>';
            } else {
                $status = '<span class="badge rounded-pill" style="background-color: ' . $backgroundColor . ';"><a class="text-decoration-none" style="color: white;" href="" data-type="shipment-details" data-toggle="popover-shipment" data-bs-placement="left" data-index="' . $shipment->getId() . '">' . ($value['trailerId'] == 0 ? "Open" : ($shipment == null ? 'Empty' : ucfirst(strtolower($value['status'])))) . '</a></span>';
            }

            $data = array(
                'door' => (intval($value['id']) - 20),
                //'carrier' => ($value['carrier'] == null ? '-' : explode(' ', $value['carrier'])[0]),
                'carrier' => ($value['carrier'] == null ? '-' : $value['carrier']),
                'trailer' => ($value['trailerId'] == 0 ? "-" : $value['trailerId']),
                'status' => $status
            );

            array_push($output, $data);
        }
        echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
    // Retrieve a list of doors on the South side of the building.
    } else if (strcmp($action, 'southList') === 0) {
        $doors = $database->getDoorData('SOUTH');

        $doorsOutOfService = array(
            9
        );

        $output = array();
        foreach ($doors as $key => $value) {
            $doorOutOfService = false;
            $shipment = $value['shipment'];

            if (strpos($value['status'], "EMPTY") !== false || ($shipment == null && $value['trailerId'] != 0)) {
                $backgroundColor = '#ef716f'; // red
            } else if ($shipment === null && $value['trailerId'] == 0) {
                $backgroundColor = '#009b9b'; // blue
            } else if (strpos($value['status'], "LOADING") !== false) {
                $backgroundColor = '#E69322'; // yellow
            } else {
                $backgroundColor = '#4b9307'; // green
            }

            if (in_array(intval($value['id']), $doorsOutOfService)) {
                $doorOutOfService = true;
            }

            $status = '';

            if ($doorOutOfService) {
                $status = '<span id="oos-tooltip" class="badge rounded-pill" style="background-color: red; cursor: help;" data-bs-toggle="tooltip" data-bs-placement="top" title="Out of service"><span class="tooltip-underline">OOS</span></span>';
            } else if ($shipment == null) {
                $status = '<span class="badge rounded-pill" style="background-color: ' . $backgroundColor . ';">' . ($value['trailerId'] == 0 ? "Open" : 'Empty') . '</span>';
            } else {
                $status = '<span class="badge rounded-pill" style="background-color: ' . $backgroundColor . ';"><a class="text-decoration-none" style="color: white;" href="" data-type="' . $value['type'] . '-shipment-details" data-toggle="popover-shipment" data-bs-placement="left" data-index="' . $shipment->getId() . '">' . ($value['trailerId'] == 0 ? "Open" : ($shipment == null ? 'Empty' : ucfirst(strtolower($value['status'])))) . '</a></span>';
            }

            $data = array(
                'door' => $value['id'],
                //'carrier' => ($value['carrier'] == null ? '-' : explode(' ', $value['carrier'])[0]),
                'carrier' => ($value['carrier'] == null ? '-' : $value['carrier']),
                'trailer' => ($value['trailerId'] == 0 ? "-" : $value['trailerId']),
                'status' => $status
            );

            array_push($output, $data);
        }
        echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
    // Retrieve a list of available (open) dock doors.
    } else if (strcmp($action, 'availableList') == 0) {
        $availableDoors = $database->getAvailableDoors();

        $output = array();
        foreach ($availableDoors as $door) {
            array_push($output, $door);
        }
        echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
    // Retrieve the number of open doors
    } else if (strcmp($action, 'count') === 0) {
        echo $database->countOpenDoors();
    } else {
        die('Invalid action: ' . $action);
    }
} else if (strcmp($requestMethod, 'POST') === 0) {
    if (!isset($_POST['action'])) {
        die('action not provided');
    }
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    // Add a trailer to the door with the driver's ID.
    if (strcmp($action, 'add') === 0) {
        if (isset($_POST['door']) && isset($_POST['driverId'])) {
            $database->addToDoor($_POST['door'], $_POST['driverId']);
        } else {
            die('Missing required parameters: door, trailerId, driverId');
        }
    // Remove a trailer from its door
    } else if (strcmp($action, 'remove') === 0) {
        if (isset($_POST['door'])) {
            $database->removeFromDoor($_POST['door']);
        } else {
            die('Missing required parameters: door');
        }
    }
} else {
}
