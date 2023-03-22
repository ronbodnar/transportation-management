<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require '../src/Database.class.php';

$database = new Database();

echo '<strong>Output:</strong><pre>';
// USERS
//print_r($database->getUserData(21155, true));

// DRIVERS
//print_r($database->getDriverActivityLogs());
//print_r($database->getDriverStatus(21149));
//print_r($database->getActiveDrivers(true));
//print_r($database->getYardMovesByDriverId(21149));
//print_r($database->getAllDrivers(false, true));

// SHIPMENTS
//print_r($database->assignShipment(5012802588, 21149));
print_r($database->getShipment(5012847241, true));
//print_r($database->getOutboundShipments('ALL', true));
//print_r($database->getInboundShipments(2, true));
//print_r($database->getOutboundShipmentCountByDriverId(21155));
//print_r($database->getOutboundShipmentsByDriverId(10000, true));
//print_r($database->getOutboundShipments(5));

// DOORS
//print_r($database->getDoorsWithEmptyTrailer());
//print_r($database->getTrailerIdFromDoor(8));
//print_r($database->getDoorData('SOUTH', true));

// TRAILERS
//print_r($database->assignYardMove(6, 'd', 5, 'd', 21149));

// YARD
//print_r($database->getYardData(true));
echo '</pre>';