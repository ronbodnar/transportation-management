<?php

require __DIR__ . '/../models/DockDoor.php';

class DockDoorRepository
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    function countOpenDoors()
    {
        try {
            $rowCount = $this->connection->query(
                'SELECT COUNT(*) FROM doors WHERE trailer_id = 0'
            )->fetchColumn();
            return $rowCount - 3;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getAvailableDoors()
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT * FROM doors WHERE trailer_id = 0'
            );
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $doors = array();
            foreach ($result as $row) {
                array_push($doors, $row['id']);
            }
            return $doors;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getDoorsWithEmptyTrailer()
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT * FROM doors 
                 WHERE NOT EXISTS (SELECT trailer_id FROM outbound_shipments WHERE doors.trailer_id = outbound_shipments.trailer_id AND outbound_shipments.status_id != 5) 
                 AND trailer_id != 0 
                 ORDER BY doors.id ASC'
            );
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_NAMED);
            $doors = array();
            foreach ($result as $row) {
                array_push($doors, array('id' => $row['id'], 'trailerId' => $row['trailer_id']));
            }
            return $doors;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getDoorData($direction, $print = false)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT *  
                 FROM doors 
                 LEFT JOIN trailers ON (doors.trailer_id = trailers.id) 
                 LEFT JOIN carriers ON (trailers.carrier_id = carriers.id) 
                 LEFT JOIN outbound_shipments ON (doors.trailer_id = outbound_shipments.trailer_id AND outbound_shipments.status_id != 5 AND outbound_shipments.trailer_id != 0) 
                 LEFT JOIN outbound_shipment_status ON (outbound_shipments.status_id = outbound_shipment_status.id) 
                 LEFT JOIN inbound_shipments ON (doors.trailer_id = inbound_shipments.trailer_id AND inbound_shipments.status_id = 2 AND inbound_shipments.trailer_id != 0) 
                 LEFT JOIN inbound_shipment_status ON (inbound_shipments.status_id = inbound_shipment_status.id) 
                 WHERE doors.id ' . (strpos($direction, 'SOUTH') !== false ? '<= 17' : '> 17') . ' 
                 ORDER BY doors.id ASC'
            );
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetchAll();
            $data = array();

            if ($print) {
                echo '<pre>';
                print_r($result);
                echo '</pre>';
            }

            foreach ($result as $row) {
                $outboundShipment = $row['id'][3] && strlen($row['id'][3] > 0);
                if ($outboundShipment) {
                    $shipmentData = array(
                        'id' => $row['id'][3],
                        'orderNumber' => $row['purchase_order'][0],
                        'palletCount' => $row['pallets'][0],
                        'netWeight' => $row['net_weight'][0],
                        'trailerId' => $row['trailer_id'][1],
                        'statusId' => $row['status_id'][0],
                        'facilityId' => is_int($row['facility_id']) ? $row['facility_id'] : $row['facility_id'][0],
                        'carrier' => $row['carrier']
                    );
                } else {
                    $shipmentData = array(
                        'id' => $row['reference'],
                        'orderNumber' => $row['purchase_order'][1],
                        'palletCount' => $row['pallets'][1],
                        'netWeight' => $row['net_weight'][1],
                        'trailerId' => $row['trailer_id'][2],
                        'statusId' => $row['status_id'][1],
                        'facility' => 'Danone',
                        'carrier' => $row['carrier']
                    );
                }

                require_once __DIR__ . '/../models/Shipment.php';
                $shipment = new Shipment();
                $shipment->set(json_encode($shipmentData, true));

                $rowData = array(
                    'id' => $row['id'][0],
                    'type' => ($outboundShipment ? 'outbound' : 'inbound'),
                    'carrier' => $row['carrier'],
                    'trailerId' => $row['trailer_id'][0],
                    'shipment' => $row['trailer_id'][0] == 0 || $row['trailer_id'][($outboundShipment ? 1 : 2)] == 0 ? null : $shipment,
                    'status' => $row['status'][($outboundShipment ? 0 : 1)]
                );
                array_push($data, $rowData);
            }
            return $data;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function addToDoor($door, $driverId)
    {
        echo 'Door: ' . $door;
        echo 'Driver: ' . $driverId;

        require_once 'DriverRepository.php';
        $driverRepository = new DriverRepository($this->connection);
        $trailerId = $driverRepository->getTrailerIdByDriver($driverId);

        echo 'Trailer ID: ' . $trailerId;

        try {
            $statements = array(
                array('UPDATE `doors` SET `trailer_id` = :trailer_id, `dropped_by_id` = :driver_id WHERE `id` = :door_id', array(':door_id' => $door, ':trailer_id' => $trailerId, ':driver_id' => $driverId)),
                array('UPDATE `active_drivers` SET `status_id` = 1, `last_update` = :last_update WHERE `id` = :driver_id', array(':driver_id' => $driverId, ':last_update' => date('g:i A'))),
                //array('INSERT INTO `trailers` (`id`, `carrier`) VALUES(:trailer_id, `Northern`) ON DUPLICATE KEY UPDATE name="A"', array())
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

    function removeFromDoor($door)
    {
        try {
            $statement = $this->connection->prepare('UPDATE `doors` SET `trailer_id` = 0 WHERE `id` = :door_id');
            $statement->execute(array(':door_id' => $door));
            echo 'Successfully ran statement, no errors.';
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getTrailerIdFromDoor($id)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT `trailer_id` FROM `doors` WHERE `id` = :id'
            );
            $statement->execute(array(':id' => $id));
            $result = $statement->fetch();
            return $result['trailer_id'];
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }
}
