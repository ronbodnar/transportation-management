<?php

require '../Database.class.php';

$database = new Database();

$requestMethod = $_SERVER["REQUEST_METHOD"];

if (strcmp($requestMethod, 'GET') === 0) {
    if (!isset($_GET['action'])) {
        die('action not provided');
    }
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    if (strcmp($action, 'trailerList') === 0) {
        $doors = $database->getYardData();

        $output = array();
        foreach ($doors as $key => $value) {
            $shipment = $value['shipment'];

            if ($shipment === null) {
                $backgroundColor = '#ef716f';
            } else {
                $backgroundColor = '#4b9307';
            }

            $status = 'Loaded';

            if ($shipment === null) {
                if ($value['trailerId'] == 84923) {
                    $status = 'Dump';
                    $backgroundColor = '#009b9b';
                } else if ($value['trailerId'] == 5001) {
                    $status = 'CHEP Pallets';
                    $backgroundColor = '#009b9b';
                } else {
                    $status = 'Empty';
                }
            }

            if ($shipment !== null) {
                $status = '<a class="text-decoration-none" style="color: white;" href="" data-type="' . $value['type'] . '-shipment-details" data-toggle="popover-shipment" data-bs-placement="left" data-index="' . $shipment->getId() . '">' . $status . '</a>';
            }

            $data = array(
                'carrier' => explode(' ', $value['carrier'])[0],
                'trailer' => $value['trailerId'],
                'status' => '<span class="badge rounded-pill" style="background-color: ' . $backgroundColor . '">' . $status . '</span>'
            );

            array_push($output, $data);
        }
        echo json_encode(array('draw' => 1, 'recordsTotal' => count($output), 'recordsFiltered' => count($output), 'data' => $output));
    } else if (strcmp($action, 'count') === 0) {
        echo $database->countTrailersInYard();
    } else {
        die('Invalid action: ' . $action);
    }
} else if (strcmp($requestMethod, 'POST') === 0) {
    if (!isset($_POST['action'])) {
        die('action not provided');
    }
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    if (strcmp($action, 'add') === 0) {
        if (isset($_POST['driverId'])) {
            $database->addToYard($_POST['driverId']);
        } else {
            die('Missing required parameters: trailerId, driverId');
        }
    } else if (strcmp($action, 'remove') === 0) {
        if (isset($_POST['trailerId'])) {
            $database->removeFromYard($_POST['trailerId']);
        } else {
            die('Missing required parameters: trailerId');
        }
    }
} else {
}
