<?php

class YardRepository
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    function assignYardMove($source, $sourceType, $destination, $destinationType, $driverId)
    {
        try {
            $statements = array(
                //array('DELETE FROM `yard` WHERE `trailer_id` = :trailer_id', array(':trailer_id' => $shipment->getTrailerId())),
                //array('UPDATE `doors` SET `trailer_id` = 0 WHERE `trailer_id` = :trailer_id', array(':trailer_id' => $shipment->getTrailerId())),
                //array('UPDATE `active_drivers` SET `shipment_id` = :shipment_id, `status_id` = 9, `last_update` = :last_update WHERE `id` = :driver_id', array(':shipment_id' => $shipment->getId(), ':driver_id' => $driverId, ':last_update' => date('g:i A'))),
                //array('UPDATE `outbound_shipments` SET `status_id` = 4, `driver_id` = :driver_id WHERE `id` = :shipment_id', array(':shipment_id' => $shipment->getId(), ':driver_id' => $driverId))
            );

            $dockDoorRepository = new DockDoorRepository($this->connection);

            $trailerNumber = 0;
            if (strcmp($sourceType, 'd') === 0) {
                $trailerNumber = $dockDoorRepository->getTrailerIdFromDoor($source);
            }

            $sourceIsOC = strpos($source, '(OC)') !== false;
            $sourceIsDoor = strcmp($sourceType, 'd') === 0;

            $destinationIsOC = strpos($destination, '(OC)') !== false;
            $destinationIsDoor = strcmp($destinationType, 'd') === 0;

            $source = str_replace(" (OC)", "", $source);
            $destination = str_replace(" (OC)", "", $destination);

            if ($sourceIsOC) $source += 20;
            if ($destinationIsOC) $destination += 20;

            if ($destinationIsDoor) { // Trailer is moving to a door - add it
                $statement = $this->connection->prepare('UPDATE `doors` SET `trailer_id` = :trailer_id WHERE `id` = :id');
                $statement->execute(
                    array(
                        ':trailer_id' => ($sourceIsDoor ? $dockDoorRepository->getTrailerIdFromDoor($source) : $source),
                        ':id' => $destination
                    )
                );
            } else { // Trailer is moving to the yard - add it
                $statement = $this->connection->prepare('INSERT INTO `yard`(`trailer_id`, `dropped_by_id`) VALUES (:trailer_id, :dropped_by_id)');
                $statement->execute(
                    array(
                        ':trailer_id' => $dockDoorRepository->getTrailerIdFromDoor($source),
                        ':dropped_by_id' => $driverId
                    )
                );
            }

            if ($sourceIsDoor) { // Trailer is moving out of a door - remove it
                $statement = $this->connection->prepare('UPDATE `doors` SET `trailer_id` = 0 WHERE `id` = :id');
                $statement->execute(array(':id' => $source));
            } else if (!$sourceIsDoor) { // Trailer is moving out of the yard - remove it
                $statement = $this->connection->prepare('DELETE FROM `yard` WHERE `trailer_id` = :trailer_id');
                $statement->execute(array(':trailer_id' => $source));
            }

            // Update Driver status
            $statement = $this->connection->prepare('UPDATE `active_drivers` SET `status_id` = 9, `last_update` = :last_update WHERE `id` = :driver_id');
            $statement->execute(array(':driver_id' => $driverId, ':last_update' => date('Y-m-d H:i:s')));
            return true;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
        return false;
    }

    function countTrailersInYard()
    {
        try {
            $rowCount = $this->connection->query(
                'SELECT COUNT(*) FROM yard'
            )->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getYardData($print = false)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT *
                 FROM yard 
                 INNER JOIN trailers ON (yard.trailer_id = trailers.id) 
                 LEFT JOIN carriers ON (trailers.carrier_id = carriers.id) 
                 LEFT JOIN outbound_shipments ON (yard.trailer_id = outbound_shipments.trailer_id AND outbound_shipments.status_id != 5) 
                 LEFT JOIN outbound_shipment_status ON (outbound_shipment_status.id = outbound_shipments.status_id) 
                 LEFT JOIN inbound_shipments ON (yard.trailer_id = inbound_shipments.trailer_id AND inbound_shipments.status_id = 2 AND inbound_shipments.trailer_id != 0) 
                 LEFT JOIN inbound_shipment_status ON (inbound_shipments.status_id = inbound_shipment_status.id) 
                 LEFT JOIN facilities ON (facilities.id = outbound_shipments.facility_id) 
                 ORDER BY carriers.carrier ASC'
            );
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetchAll();

            if ($print) {
                echo '<strong>Yard Data:</strong><pre>';
                print_r($result);
                echo '</pre>';
            }

            $data = array();
            foreach ($result as $row) {
                $inboundShipment = $row['reference'] && strlen($row['reference'] > 0);
                if ($inboundShipment) {
                    $shipmentData = array(
                        'id' => $row['reference'],
                        'trailerId' => $row['trailer_id'][2],
                        'timestamp' => $row['timestamp'][1],
                        'orderNumber' => $row['purchase_order'][1],
                        'palletCount' => $row['pallets'][1],
                        'netWeight' => $row['net_weight'][1],
                        'facility' => 'Danone',
                        'status' => $row['status'][1]
                    );
                } else {
                    $shipmentData = array(
                        'id' => $row['id'][3],
                        'trailerId' => $row['trailer_id'][1],
                        'timestamp' => $row['timestamp'][0],
                        'orderNumber' => $row['purchase_order'][0],
                        'palletCount' => $row['pallets'][0],
                        'netWeight' => $row['net_weight'][0],
                        'facility' => $row['facility'],
                        'status' => $row['status'][0]
                    );
                }

                require_once __DIR__ . '/../models/Shipment.php';
                $shipment = new Shipment();
                $shipment->set(json_encode($shipmentData, true));

                $rowData = array(
                    'type' => ($inboundShipment ? 'inbound' : 'outbound'),
                    'trailerId' => $row['trailer_id'][0],
                    'carrier' => $row['carrier'],
                    'shipment' => (strlen($row['id'][3]) > 0 || $inboundShipment ? $shipment : null)
                );
                array_push($data, $rowData);
            }
            return $data;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function addToYard($driverId)
    {
        try {
            require_once 'DriverRepository.php';
            $driverRepository = new DriverRepository($this->connection);
            $trailerId = $driverRepository->getTrailerIdByDriver($driverId);

            $statements = array(
                array('INSERT INTO `yard` (`trailer_id`, `dropped_by_id`) VALUES(:trailer_id, :driver_id)', array(':trailer_id' => $trailerId, ':driver_id' => $driverId)),
                array('UPDATE `active_drivers` SET `status_id` = 1, `last_update` = :last_update WHERE `id` = :driver_id', array(':driver_id' => $driverId, ':last_update' => date('g:i A')))
            );

            foreach ($statements as $data) {
                echo 'Running query: <strong>' . $data[0] . '</strong><br /><br />';
                $statement = $this->connection->prepare($data[0]);
                $statement->execute($data[1]);
            }
            echo 'Successfully ran statement, no errors.';
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function removeFromYard($trailerId)
    {
        try {
            $statement = $this->connection->prepare('DELETE FROM `yard` WHERE `trailer_id` = :trailer_id');
            $statement->execute(array(':trailer_id' => $trailerId));
            echo 'Successfully ran statement, no errors.';
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }
}
