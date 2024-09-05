<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require '../src/database/Database.php';

$database = new Database();

echo '<strong>Output:</strong><pre>';
// USERS
//print_r($database->userRepository->getUserData(21155, true));

// DRIVERS
//print_r($database->driverRepository->getDriverActivityLogs());
//print_r($database->driverRepository->getDriverStatus(21149));
//print_r($database->driverRepository->getActiveDrivers(true));
//print_r($database->driverRepository->getYardMovesByDriverId(21149));
//print_r($database->driverRepository->getAllDrivers(false, true));

// SHIPMENTS
//print_r($database->shipmentRepository->assignShipment(5012802588, 21149));
print_r($database->shipmentRepository->getShipment(5012847241, true));
//print_r($database->shipmentRepository->getOutboundShipments('ALL', true));
//print_r($database->shipmentRepository->getInboundShipments(2, true));
//print_r($database->shipmentRepository->getOutboundShipmentCountByDriverId(21155));
//print_r($database->shipmentRepository->getOutboundShipmentsByDriverId(10000, true));
//print_r($database->shipmentRepository->getOutboundShipments(5));

// DOORS
//print_r($database->dockDoorRepository->getDoorsWithEmptyTrailer());
//print_r($database->dockDoorRepository->getTrailerIdFromDoor(8));
//print_r($database->dockDoorRepository->getDoorData('SOUTH', true));

// YARD
//print_r($database->getYardData(true));
//print_r($database->yardRepository->assignYardMove(6, 'd', 5, 'd', 21149));
echo '</pre>';
