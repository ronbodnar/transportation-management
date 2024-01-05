<?php

require '../Database.class.php';

$database = new Database();

if (!isset($_GET['action'])) {
    die('action not provided');
}
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Populate a list of all drivers assigned to the account
if (strcmp($action, 'list') === 0) {
    $output = array();
    $shipments = $database->getAllDrivers(false);
    foreach ($shipments as $shipment) {
        $data = array(
            'id' => $shipment->getId(),
            'name' => '<a href="/projects/logistics-management/src/modules/drivers?id=' . $shipment->getId() . '" class="text-mron">' . $shipment->getFullName() . '</a>',
        );

        array_push($output, $data);
    }
    echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
// Populate a list of drivers that are currently active (on-duty).
} else if (strcmp($action, 'activeList') === 0) {
    $output = array();
    $shipments = $database->getActiveDrivers();
    foreach ($shipments as $shipment) {
        $lastUpdate = new DateTime($shipment['lastUpdate']);
        $lastUpdate = $lastUpdate->format('g:i A');

        $status = ucwords(str_replace("_", " - ", strtolower($shipment['status'])));
        $data = array(
            'id' => $shipment['id'],
            'carrierId' => $shipment['carrierId'],
            'name' => '<a href="/projects/logistics-management/src/modules/drivers?id=' . $shipment['id'] . '" class="text-mron">' . $shipment['fullName'] . '</a>',
            'startTime' => $shipment['startTime'],
            'location' => $shipment['location'],
            'shipment' => (strpos($shipment['shipmentId'], '-') !== false ? '-' : '<a href="" class="text-mron" data-type="outbound-shipment-details" data-toggle="popover-assign" data-bs-placement="left" data-index="' . $shipment['shipmentId'] . '">' . $shipment['shipmentId'] . '</a>'),
            'status' => ucwords($status, "-"),
            'lastUpdate' => $lastUpdate
        );

        array_push($output, $data);
    }
    echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
// Populate a list of drivers that are available (at the facility and not tied to a shipment).
} else if (strcmp($action, 'availableList') === 0) {
    $output = array();
    $shipments = $database->getAvailableDrivers();
    $index = 1;
    foreach ($shipments as $shipment) {
        $lastUpdate = new DateTime($shipment['lastUpdate']);
        $lastUpdate = $lastUpdate->format('g:i A');

        $status = ucwords(str_replace(array("_", "available - "), array(" - ", ""), strtolower($shipment['status'])));
        $action = '<a href="" class="text-mron" data-type="driver" data-toggle="popover-assign" data-bs-placement="left" data-index="' . $index . '" data-driver-name="' . $shipment['fullName'] . '" data-driver-id="' . $shipment['id'] . '">Assign</a>';
        if (strcmp($shipment['startingLocation'], 'Cordova') === 0) {
            $action = '<a href="" class="text-mron" data-type="driver-cordova" data-toggle="popover-assign" data-bs-placement="left" data-index="' . $index . '" data-driver-name="' . $shipment['fullName'] . '" data-driver-id="' . $shipment['id'] . '">Assign</a>';
        }
        $data = array(
            'order' => $index++,
            'id' => $shipment['id'],
            'carrierId' => $shipment['carrierId'],
            'name' => '<a href="/projects/logistics-management/src/modules/drivers?id=' . $shipment['id'] . '" class="text-mron">' . $shipment['fullName'] . '</a>',
            'startTime' => $shipment['startTime'],
            'startingLocation' => $shipment['startingLocation'],
            'status' => ucwords($status, "-"),
            'lastUpdate' => $lastUpdate,
            'action' => $action
        );
        array_push($output, $data);
    }

    usort($output, function ($a, $b) {
        if (strcmp($b['startingLocation'], 'Cordova') === 0)
            return 1;
    });
    echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
// Retrieve the number of available drivers
} else if (strcmp($action, 'availableCount') === 0) {
    echo $database->getAvailableDriverCount();
// Retrieve the specified driver's status
} else if (strcmp($action, 'get-status') == 0) {
    if (!isset($_GET['driverId'])) {
        die('Missing driver id');
    }
    $status = $database->getDriverStatus($_GET['driverId']);

    $output = array('status' => $status);

    echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
// Assign a task (yard move, shipment, backhaul, etc.) to a driver.
} else if (strcmp($action, 'assign-task') == 0) {
    if (!isset($_GET['driverId'])) {
        die('Missing driverId');
    }
    $database->updateDriverStatus($_GET['driverId'], 9);
} else {
    die('Invalid action: ' . $action);
}
