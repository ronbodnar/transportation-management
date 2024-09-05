<?php

require '../Database.class.php';

$database = new Database();

$requestMethod = $_SERVER["REQUEST_METHOD"];

if (strcmp($requestMethod, 'GET') === 0) {
    if (!isset($_GET['action'])) {
        die('action not provided');
    }
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    if (strcmp($action, 'get-shipment') === 0) {
        if (!isset($_GET['query'])) {
            die('shipment id not provided');
        }
        $query = $_GET['query'];
        $shipment = $database->getShipment($query);
        if (!$shipment) {
            die('Shipment not found');
        }
        echo json_encode($shipment);
    } else if (strcmp($action, 'get-shipments') === 0) {
        if (!isset($_GET['query'])) {
            die('query not provided');
        }
        $query = $_GET['query'];
        $output = array();
        $shipments = $database->getOutboundShipments($query);
        foreach ($shipments as $shipment) {
            $timestamp = $shipment->getTimestamp();

            $backgroundColor = '#276E05';
            if (strpos($shipment->getStatus(), "LOADING") !== false) {
                $backgroundColor = '#E49B0F';
            } else if (strpos($shipment->getStatus(), "READY") !== false) {
                $backgroundColor = '#3BA608';
            } else if (strpos($shipment->getStatus(), "IN_TRANSIT") !== false) {
                $backgroundColor = '#DA70D6';
            }

            $date = date("n/j/Y", strtotime($timestamp));
            $time = date("g:i a", strtotime($timestamp));
            $id = '<a class="text-mron" href="/projects/logistics-management/src/views/shipments/details.php?id=' . $shipment->getId() . '" target="_blank">' . $shipment->getId() . '</a>';
            $orderNumber = $shipment->getOrderNumber();
            $pallets = $shipment->getPalletCount();
            $netWeight = number_format($shipment->getNetWeight());
            $grossWeight = number_format($shipment->getGrossWeight());
            $trailerId = $shipment->getTrailerId();
            $driver = ($shipment->getDriver() === null  ? '-' : $shipment->getDriver()->getFullName());
            $facility = $shipment->getFacility();
            $trailer = $shipment->getTrailerId();
            $images = '<a class="text-mron" href="/assets/warehouses/bol-1.png" target="_blank">1</a> | <a class="text-mron" href="../warehouses/bol-2.png" target="_blank">2</a>';
            $status = '<span class="badge rounded-pill" style="background-color: ' . $backgroundColor . '">' . $shipment->getStatus(true) . '</span>';
            $assign = '<a class="text-mron" href="">Assign</a>';
            $action = '<a class="text-mron" href="#">Claim</a>';

            $data = array(
                'date' => $date,
                'time' => $time,
                'id' => $id,
                'orderNumber' => $orderNumber,
                'pallets' => $pallets,
                'netWeight' => $netWeight,
                'grossWeight' => $grossWeight,
                'trailerId' => $trailerId,
                'driver' => $driver,
                'facility' => $facility,
                'door' => rand(1, 10) == 5 ? "Yard" : "Door " . rand(1, 36),
                'images' => $images,
                'status' => $status,
                'assign' => $assign,
                'trailer' => $trailer,
                'action' => $action
            );

            array_push($output, $data);
        }
        echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
    } else if (strcmp($action, 'get-driver-shipments') === 0) {
        if (!isset($_GET['id'])) {
            die('query not provided');
        }
        $query = $_GET['id'];
        $output = array();
        $shipments = $database->getOutboundShipmentsByDriverId($query);
        foreach ($shipments as $shipment) {
            $timestamp = $shipment->getTimestamp();

            $backgroundColor = '#276E05';
            if (strpos($shipment->getStatus(), "LOADING") !== false) {
                $backgroundColor = '#E49B0F';
            } else if (strpos($shipment->getStatus(), "READY") !== false) {
                $backgroundColor = '#3BA608';
            } else if (strpos($shipment->getStatus(), "IN_TRANSIT") !== false) {
                $backgroundColor = '#DA70D6';
            }

            $date = date("n/j/Y", strtotime($timestamp));
            $time = date("g:i a", strtotime($timestamp));
            $id = '<a class="text-mron" href="/projects/logistics-management/src/views/shipments/details.php?id=' . $shipment->getId() . '" target="_blank">' . $shipment->getId() . '</a>';
            $orderNumber = $shipment->getOrderNumber();
            $pallets = $shipment->getPalletCount();
            $netWeight = number_format($shipment->getNetWeight());
            $grossWeight = number_format($shipment->getGrossWeight());
            $trailerId = $shipment->getTrailerId();
            $driver = ($shipment->getDriver() === null  ? '-' : $shipment->getDriver()->getFullName());
            $facility = $shipment->getFacility();
            $trailer = $shipment->getTrailerId();
            $images = '<a class="text-mron" href="../warehouses/bol-1.png" target="_blank">1</a> | <a class="text-mron" href="../warehouses/bol-2.png" target="_blank">2</a>';
            $status = '<span class="badge rounded-pill" style="background-color: ' . $backgroundColor . '">' . $shipment->getStatus(true) . '</span>';
            $assign = '<a class="text-mron" href="">Assign</a>';
            $action = '<a class="text-mron" href="#">Claim</a>';

            $data = array(
                'date' => $date,
                'time' => $time,
                'id' => $id,
                'orderNumber' => $orderNumber,
                'pallets' => $pallets,
                'netWeight' => $netWeight,
                'grossWeight' => $grossWeight,
                'trailerId' => $trailerId,
                'driver' => $driver,
                'facility' => $facility,
                'door' => rand(1, 10) == 5 ? "Yard" : "Door " . rand(1, 36),
                'images' => $images,
                'status' => $status,
                'assign' => $assign,
                'trailer' => $trailer,
                'action' => $action
            );

            array_push($output, $data);
        }
        echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
    } else if (strcmp($action, 'get-inbound-shipments') === 0) {
        if (!isset($_GET['query'])) {
            die('query not provided');
        }
        $query = $_GET['query'];
        $output = array();
        $shipments = $database->getInboundShipments($query);
        foreach ($shipments as $shipment) {
            $timestamp = $shipment->getTimestamp();

            $backgroundColor = '#276E05';
            if (strpos($shipment->getStatus(), "LOADING") !== false) {
                $backgroundColor = '#E49B0F';
            } else if (strpos($shipment->getStatus(), "READY") !== false) {
                $backgroundColor = '#3BA608';
            } else if (strpos($shipment->getStatus(), "IN_TRANSIT") !== false) {
                $backgroundColor = '#DA70D6';
            }

            $date = date("n/j/Y", strtotime($timestamp));
            $time = date("g:i a", strtotime($timestamp));
            $id = '<a class="text-mron" href="/projects/logistics-management/src/views/shipments/details.php?id=' . $shipment->getId() . '" target="_blank">' . $shipment->getId() . '</a>';
            $orderNumber = $shipment->getOrderNumber();
            $pallets = $shipment->getPalletCount();
            $netWeight = number_format($shipment->getNetWeight());
            $grossWeight = number_format($shipment->getGrossWeight());
            $trailerId = $shipment->getTrailerId();
            $driver = ($shipment->getDriver() === null  ? '-' : $shipment->getDriver()->getFullName());
            $trailer = $shipment->getTrailerId();
            $carrier = $shipment->getCarrier();
            $images = '<a class="text-mron" href="../warehouses/bol-1.png" target="_blank">1</a> | <a class="text-mron" href="../warehouses/bol-2.png" target="_blank">2</a>';
            $status = '<span class="badge rounded-pill" style="background-color: ' . $backgroundColor . '">' . $shipment->getStatus(true) . '</span>';
            $assign = '<a class="text-mron" href="">Assign</a>';
            $action = '<a class="text-mron" href="#">Claim</a>';

            $data = array(
                'date' => $date,
                'time' => $time,
                'reference' => $id,
                'orderNumber' => $orderNumber,
                'pallets' => $pallets,
                'netWeight' => $netWeight,
                'grossWeight' => $grossWeight,
                'trailerId' => $trailerId,
                'driver' => $driver,
                'door' => rand(1, 10) == 5 ? "S/B" : "D" . rand(5, 30),
                'images' => $images,
                'status' => $status,
                'assign' => $assign,
                'trailer' => $trailer,
                'action' => $action,
                'carrier' => $carrier
            );

            array_push($output, $data);
        }
        echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
    } else if (strcmp($action, 'get-ready-shipments') === 0) {
        $output = array();
        $shipments = $database->getOutboundShipments(3);
        foreach ($shipments as $shipment) {
            $id = $shipment->getId();
            $location = $shipment->getLocation();
            $trailer = $shipment->getTrailerId();

            $data = array(
                'id' => $id,
                'door' => $location,
                'trailer' => $trailer
            );

            array_push($output, $data);
        }
        echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
    } else {
        die('Invalid action: ' . $action);
    }
} else if (strcmp($requestMethod, 'POST') === 0) {
    if (!isset($_POST['action'])) {
        die('action not provided');
    }
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    if (strcmp($action, 'assign-shipment') === 0) {
        if (isset($_POST['id']) && isset($_POST['driverId'])) {
            $database->assignShipment($_POST['id'], $_POST['driverId']);
        } else {
            die('Missing required parameters: id, driverId');
        }
    }
} else {
}
