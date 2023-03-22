<?php

require '../Database.class.php';

$database = new Database();

addInboundShipments();

//for ($i = 0; $i < 20; $i++) {
    //addActivityLogs();
//}

function randomDateInRange(DateTime $start, DateTime $end)
{
    $randomTimestamp = mt_rand($start->getTimestamp(), $end->getTimestamp());
    $randomDate = new DateTime();
    $randomDate->setTimestamp($randomTimestamp);
    return $randomDate;
}

function getRandomWeightedElement(array $weightedValues)
{
    $rand = mt_rand(1, (int) array_sum($weightedValues));

    foreach ($weightedValues as $key => $value) {
        $rand -= $value;
        if ($rand <= 0) {
            return $key;
        }
    }
}

function getMinuteDifference($base, $comparator)
{
    $difference = $base->diff($comparator);

    $minutes = $difference->days * 24 * 60;
    $minutes += $difference->h * 60;
    $minutes += $difference->i;

    return $minutes;
}

function addActivityLogs()
{
    global $database;

    $reasons = array(
        'Shipment', 'Shipment', 'Shipment', 'Shipment', 'Shipment', 'Shipment', 'Shipment',
        'Shipment', 'Shipment', 'Shipment', 'Shipment',
        "Returning Empty", "Returning Empty", "Returning Empty", "Returning Empty", "Returning Empty",
        "Returning Empty", "Returning Empty",
        'Pickup Empty', 'Pickup Backhaul', 'Backhaul', 'Backhaul',
        'Backhaul', 'Yard Moves'
    );

    $start = new DateTime("2022-08-01 01:30:33");
    $end = new DateTime();
    $randomDate = randomDateInRange($start, $end);

    $reason = $reasons[rand(0, count($reasons) - 1)];

    $logDate = $randomDate->format('Y-m-d');

    $add = rand(1, (rand(0, 20) === 0 ? 60 : 10));

    $arrivalDT = $randomDate->format('Y-m-d H:i:s');

    $receivedDT = (($reason !== "Shipment" && $reason !== "Returning Empty" && $reason !== "Backhaul") ? null : $randomDate->modify("+{$add} minutes")->format('Y-m-d H:i:s'));

    $acceptedDT = $receivedDT === null ? null : $randomDate->modify("+{$add} minutes")->format('Y-m-d H:i:s');

    $add = rand(10, (rand(0, 20) === 0 ? 80 : 35));

    $departureDT = $randomDate->modify("+{$add} minutes")->format('Y-m-d H:i:s');

    $driverId = 21149 + rand(0, 10);

    $shipment = $database->getRandomShipmentId();

    $reason = ($reason === "Shipment" ? $shipment['id'] : $reason);

    $trailerId = ($reason === $shipment['id'] ? $shipment['trailerId'] : 0);
    $facilityId = ($reason === $shipment['id'] ? $shipment['facilityId'] : ($reason === "Returning Empty" ? 1 : rand(2, 4)));

    $yardMoves = getRandomWeightedElement(array(0 => 50, 1 => 10, 2 => 10, 3 => 10, 4 => 10, 5 => 10));

    $arrivalTime = new DateTime($arrivalDT);
    $instructionsReceived = $receivedDT === null ? null : new DateTime($receivedDT);
    $instructionsAccepted = $acceptedDT === null ? null : new DateTime($acceptedDT);
    $departureTime = new DateTime($departureDT);

    $flagged = 0;
    if ($instructionsAccepted === null && $instructionsReceived === null) {
        $minutes = getMinuteDifference($arrivalTime, $departureTime);
        if ($minutes > 30) {
            $flagged = 1;
        }
    } else {
        $minutes = getMinuteDifference($instructionsReceived, $instructionsAccepted);
        if ($minutes > 10) {
            $flagged = 1;
        }

        $minutes = getMinuteDifference($instructionsAccepted, $departureTime);
        if ($minutes > (20 + ($yardMoves * 7))) {
            $flagged = 1;
        }
    }

    $database->addDriverActivityLog($logDate, $driverId, $facilityId, $arrivalDT, $receivedDT, $acceptedDT, $departureDT, $reason, $trailerId, $yardMoves, $flagged);

    echo '<pre>';
    print_r(get_defined_vars());
    echo '</pre>';
}

function addOutboundShipments()
{
    global $database;

    $referenceBase = '501284';
    $orderNumberBase = '450348';
    for ($i = 0; $i < 500; $i++) {
        $start = new DateTime("2022-08-01 01:30:33");
        $end = new DateTime();
        $rand = randomDateInRange($start, $end);
        //echo $rand . '<br />';

        $reference = $referenceBase . rand(1000, 9999);
        $order = $orderNumberBase . rand(1000, 9999);
        $driver = 21149 + rand(0, 10);
        $status = 5;
        $trailer = 0;
        $facility = rand(2, 4);
        $weight = rand(27000, 46300);
        $pallets = (rand(0, 2) == 0 ? 24 : (rand(0, 3) == 1 ? 18 : 20));
        $database->addInboundShipment($rand->format('Y-m-d H:i:s'), $reference, $order, $pallets, $weight, $facility, $trailer, $status, $driver);
        //echo 'INSERT INTO shipments (`timestamp`, `reference`, `purchase_order`, `pallets`, `net_weight`, `facility_id`, `trailer_id`, `status_id`, `driver_id` VALUES();';
    }
}

function addInboundShipments()
{
    global $database;

    $referenceBase = '501284';
    $orderNumberBase = '450348';
    for ($i = 0; $i < 500; $i++) {
        $start = new DateTime("2022-08-01 01:30:33");
        $end = new DateTime();
        $rand = randomDateInRange($start, $end);

        $reference = $referenceBase . rand(1000, 9999);
        $order = $orderNumberBase . rand(1000, 9999);
        $driver = 10000 + rand(0, 2);
        $status = 2;
        $trailer = 0;
        $weight = rand(17000, 36300);
        $pallets = (rand(0, 2) == 0 ? 24 : (rand(0, 3) == 1 ? 18 : 20));
        $database->addInboundShipment($rand->format('Y-m-d H:i:s'), $reference, $order, $pallets, $weight, $trailer, $status, 2, $driver);
        //echo 'INSERT INTO shipments (`timestamp`, `reference`, `purchase_order`, `pallets`, `net_weight`, `facility_id`, `trailer_id`, `status_id`, `driver_id` VALUES();';
    }
}
