<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Shipment.php';

class ShipmentRepository
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    function getOutboundShipmentCountByDriverId($id)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT COUNT(`driver_id`) FROM `outbound_shipments`
                 WHERE outbound_shipments.driver_id = :driver_id'
            );
            $statement->execute(array(':driver_id' => $id));
            $rowCount = $statement->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }
    function getOutboundShipments($status)
    {
        try {
            $statement = $this->connection->prepare(
                strpos($status, 'ALL') !== false ?
                    'SELECT * 
                     FROM outbound_shipments 
                     INNER JOIN outbound_shipment_status ON (outbound_shipments.status_id = outbound_shipment_status.id) 
                     LEFT JOIN users ON (outbound_shipments.driver_id = users.id) 
                     LEFT JOIN trailers ON (outbound_shipments.trailer_id = trailers.id) 
                     LEFT JOIN facilities ON (outbound_shipments.facility_id = facilities.id) 
                     LEFT JOIN doors ON (trailers.id = doors.trailer_id) 
                     LEFT JOIN yard ON (trailers.id = yard.trailer_id)'
                    :
                    'SELECT * 
                     FROM outbound_shipments 
                     INNER JOIN outbound_shipment_status ON (outbound_shipments.status_id = outbound_shipment_status.id) 
                     LEFT JOIN users ON (outbound_shipments.driver_id = users.id) 
                     LEFT JOIN trailers ON (outbound_shipments.trailer_id = trailers.id) 
                     LEFT JOIN facilities ON (outbound_shipments.facility_id = facilities.id) 
                     LEFT JOIN doors ON (trailers.id = doors.trailer_id) 
                     LEFT JOIN yard ON (trailers.id = yard.trailer_id) 
                     WHERE outbound_shipments.status_id = :status 
                     ORDER BY doors.id ASC'
            );
            $statement->execute(strpos($status, 'ALL') !== false ? array() : array(':status' => $status));
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetchAll();

            $shipments = array();
            foreach ($result as $row) {
                $driverData = array(
                    'id' => $row['driver_id'],
                    'firstName' => $row['first_name'],
                    'lastName' => $row['last_name']
                );
                $driver = new User();
                $driver->set(json_encode($driverData));

                $shipmentData = array(
                    'timestamp' => $row['timestamp'],
                    'location' => empty($row['trailer_id'][1]) ? 'sb' : $row['id'][5],
                    'trailerId' => $row['trailer_id'][0],
                    'id' => $row['id'][0],
                    'orderNumber' => $row['purchase_order'],
                    'palletCount' => $row['pallets'],
                    'netWeight' => $row['net_weight'],
                    'dropLocation' => $row['drop_location'],
                    'facility' => $row['facility'],
                    'status' => $row['status']
                );

                $shipment = new Shipment();
                $shipment->set(json_encode($shipmentData, true));
                $shipment->driver = $row['driver_id'] == 0 ? null : $driver;

                array_push($shipments, $shipment);
            }
            return $shipments;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getRandomShipmentId()
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT `id`, `trailer_id`, `facility_id` FROM `outbound_shipments` ORDER BY RAND() LIMIT 1'
            );
            $statement->execute();
            $result = $statement->fetch();
            return array('id' => $result['id'], 'trailerId' => $result['trailer_id'], 'facilityId' => $result['facility_id']);
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getShipment($id, $print = false)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT *
                     FROM outbound_shipments 
                     INNER JOIN outbound_shipment_status ON (outbound_shipments.status_id = outbound_shipment_status.id) 
                     LEFT JOIN users ON (outbound_shipments.driver_id = users.id) 
                     LEFT JOIN facilities ON (outbound_shipments.facility_id = facilities.id) 
                     LEFT JOIN carriers ON (outbound_shipments.carrier_id = carriers.id) 
                     LEFT JOIN doors ON (outbound_shipments.trailer_id = doors.trailer_id) 
                     LEFT JOIN yard ON (outbound_shipments.trailer_id = yard.trailer_id) 
                     WHERE outbound_shipments.id = :id'
            );
            $statement->execute(array(':id' => $id));
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetch();

            $inboundShipment = !is_array($result);

            if ($inboundShipment) { // no outbound shipments found, try inbound
                $statement = $this->connection->prepare(
                    'SELECT *
                     FROM inbound_shipments 
                     INNER JOIN inbound_shipment_status ON (inbound_shipments.status_id = inbound_shipment_status.id) 
                     LEFT JOIN users ON (inbound_shipments.driver_id = users.id) 
                     LEFT JOIN carriers ON (inbound_shipments.carrier_id = carriers.id) 
                     LEFT JOIN doors ON (inbound_shipments.trailer_id = doors.trailer_id) 
                     LEFT JOIN yard ON (inbound_shipments.trailer_id = yard.trailer_id) 
                     WHERE inbound_shipments.reference = :id'
                );
                $statement->execute(array(':id' => $id));
                $statement->setFetchMode(PDO::FETCH_NAMED);
                $result = $statement->fetch();
            }


            if ($print) {
                echo '<pre>';
                print_r($result);
                echo '</pre>';
            }

            $driverData = array(
                'id' => $result['driver_id'],
                'firstName' => $result['first_name'],
                'lastName' => $result['last_name']
            );
            $driver = new User();
            $driver->set(json_encode($driverData));

            $shipmentData = array(
                'id' => ($inboundShipment ? $result['reference'] : $result['id'][0]),
                'timestamp' => $result['timestamp'],
                'trailerId' => $result['trailer_id'][0],
                'location' => isset($result['trailer_id'][1]) ? $result['trailer_id'][1] : 'sb',
                'orderNumber' => $result['purchase_order'],
                'palletCount' => $result['pallets'],
                'netWeight' => $result['net_weight'],
                'dropLocation' => $result['drop_location'],
                'facility' => strlen($result['facility']) > 0 ? $result['facility'] : 'Danone COI',
                'status' => $result['status'],
                'carrier' => $result['carrier']
            );

            $shipment = new Shipment();
            $shipment->set(json_encode($shipmentData, true));
            $shipment->driver = $driver;

            return strlen($result['id'][0]) <= 0 ? null : $shipment;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getOutboundShipmentsByDates($startDate, $endDate, $print = false)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT *
                 FROM outbound_shipments 
                 INNER JOIN outbound_shipment_status ON (outbound_shipments.status_id = outbound_shipment_status.id) 
                 LEFT JOIN users ON (outbound_shipments.driver_id = users.id) 
                 LEFT JOIN facilities ON (outbound_shipments.facility_id = facilities.id) 
                 LEFT JOIN doors ON (outbound_shipments.trailer_id = doors.trailer_id) 
                 LEFT JOIN yard ON (outbound_shipments.trailer_id = yard.trailer_id) 
                 WHERE outbound_shipments.timestamp >= :start_date AND outbound_shipments.timestamp <= :end_date 
                 ORDER BY outbound_shipments.timestamp ASC'
            );
            $statement->execute(array(':start_date' => $startDate, ':end_date' => $endDate));
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetchAll();

            if ($print) {
                echo '<pre>';
                print_r($result);
                echo '</pre>';
            }

            $shipments = array();
            foreach ($result as $row) {
                $driverData = array(
                    'id' => $row['driver_id'],
                    'firstName' => $row['first_name'],
                    'lastName' => $row['last_name']
                );
                $driver = new User();
                $driver->set(json_encode($driverData));

                $shipmentData = array(
                    'timestamp' => $row['timestamp'],
                    'location' => empty($row['trailer_id'][1]) ? 'sb' : $row['id'][5],
                    'trailerId' => $row['trailer_id'][0],
                    'id' => $row['id'][0],
                    'orderNumber' => $row['purchase_order'],
                    'dropLocation' => $result['drop_location'],
                    'palletCount' => $row['pallets'],
                    'netWeight' => $row['net_weight'],
                    'facility' => $row['facility'],
                    'status' => $row['status']
                );

                $shipment = new Shipment();
                $shipment->set(json_encode($shipmentData, true));
                $shipment->driver = $row['driver_id'] == 0 ? null : $driver;

                array_push($shipments, $shipment);
            }
            return $shipments;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getOutboundShipmentsByDriverId($driverId, $print = false)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT *
                 FROM outbound_shipments 
                 INNER JOIN outbound_shipment_status ON (outbound_shipments.status_id = outbound_shipment_status.id) 
                 LEFT JOIN users ON (outbound_shipments.driver_id = users.id) 
                 LEFT JOIN facilities ON (outbound_shipments.facility_id = facilities.id) 
                 LEFT JOIN doors ON (outbound_shipments.trailer_id = doors.trailer_id) 
                 LEFT JOIN yard ON (outbound_shipments.trailer_id = yard.trailer_id) 
                 WHERE outbound_shipments.driver_id = :driver_id 
                 ORDER BY outbound_shipments.timestamp ASC'
            );
            $statement->execute(array(':driver_id' => $driverId));
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetchAll();

            $inboundShipment = empty($result);

            if ($inboundShipment) {
                $statement = $this->connection->prepare(
                    'SELECT *
                     FROM inbound_shipments 
                     INNER JOIN inbound_shipment_status ON (inbound_shipments.status_id = inbound_shipment_status.id) 
                     LEFT JOIN users ON (inbound_shipments.driver_id = users.id) 
                     WHERE inbound_shipments.driver_id = :driver_id 
                     ORDER BY inbound_shipments.timestamp ASC'
                );
                $statement->execute(array(':driver_id' => $driverId));
                $statement->setFetchMode(PDO::FETCH_NAMED);
                $result = $statement->fetchAll();
            }

            if ($print) {
                echo '<pre>';
                print_r($result);
                echo '</pre>';
            }

            $shipments = array();
            foreach ($result as $row) {
                $driverData = array(
                    'id' => $row['driver_id'],
                    'firstName' => $row['first_name'],
                    'lastName' => $row['last_name']
                );
                $driver = new User();
                $driver->set(json_encode($driverData));

                $shipmentData = array(
                    'timestamp' => $row['timestamp'],
                    'location' => empty($row['trailer_id'][1]) ? 'sb' : $row['id'][5],
                    'trailerId' => $row['trailer_id'][0],
                    'id' => ($inboundShipment ? $row['reference'] : $row['id'][0]),
                    'orderNumber' => $row['purchase_order'],
                    'palletCount' => $row['pallets'],
                    'dropLocation' => $result['drop_location'],
                    'netWeight' => $row['net_weight'],
                    'facility' => ($inboundShipment ? 'Danone COI' : $row['facility']),
                    'status' => $row['status']
                );

                $shipment = new Shipment();
                $shipment->set(json_encode($shipmentData, true));
                $shipment->driver = $row['driver_id'] == 0 ? null : $driver;

                array_push($shipments, $shipment);
            }
            return $shipments;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }


    function addOutboundShipment($timestamp, $id, $purchaseOrder, $pallets, $weight, $facilityId, $trailerId, $statusId, $driverId)
    {
        try {
            $statement = $this->connection->prepare(
                'INSERT INTO outbound_shipments (`id`, `purchase_order`, `pallets`, `net_weight`, `facility_id`, `trailer_id`, `status_id`, `driver_id`, `timestamp`) 
                 VALUES(:id, :purchase_order, :pallets, :net_weight, :facility_id, :trailer_id, :status_id, :driver_id, :timestamp)'
            );
            $statement->execute(array(
                ':id' => $id,
                ':purchase_order' => $purchaseOrder,
                ':pallets' => $pallets,
                ':net_weight' => $weight,
                ':facility_id' => $facilityId,
                ':trailer_id' => $trailerId,
                ':status_id' => $statusId,
                ':driver_id' => $driverId,
                ':timestamp' => $timestamp,
            ));
            echo 'Shipment added successfully: ' . $id . '<br />';
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getInboundShipment($id, $print = false)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT *
                 FROM inbound_shipments 
                 INNER JOIN inbound_shipment_status ON (inbound_shipments.status_id = inbound_shipment_status.id) 
                 LEFT JOIN users ON (inbound_shipments.driver_id = users.id) 
                 LEFT JOIN carriers ON (inbound_shipments.carrier_id = carriers.id) 
                 LEFT JOIN doors ON (inbound_shipments.trailer_id = doors.trailer_id) 
                 LEFT JOIN yard ON (inbound_shipments.trailer_id = yard.trailer_id) 
                 WHERE inbound_shipments.reference = :id'
            );
            $statement->execute(array(':id' => $id));
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetch();

            if ($print) {
                echo '<pre>';
                print_r($result);
                echo '</pre>';
            }

            $driverData = array(
                'id' => $result['driver_id'],
                'firstName' => $result['first_name'],
                'lastName' => $result['last_name']
            );
            $driver = new User();
            $driver->set(json_encode($driverData));

            $shipmentData = array(
                'id' => $result['reference'],
                'timestamp' => $result['timestamp'],
                'trailerId' => $result['trailer_id'][0],
                'location' => isset($result['trailer_id'][1]) ? $result['trailer_id'][1] : 'sb',
                'orderNumber' => $result['purchase_order'],
                'palletCount' => $result['pallets'],
                'dropLocation' => $result['drop_location'],
                'netWeight' => $result['net_weight'],
                'carrier' => $result['carrier'],
                'status' => $result['status']
            );

            $shipment = new Shipment();
            $shipment->set(json_encode($shipmentData, true));
            $shipment->driver = $driver;

            return strlen($result['id'][0]) <= 0 ? null : $shipment;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getInboundShipments($status, $print = false)
    {
        try {
            $statement = $this->connection->prepare(
                strpos($status, 'ALL') !== false ?
                    'SELECT * 
                     FROM inbound_shipments 
                     INNER JOIN inbound_shipment_status ON (inbound_shipments.status_id = inbound_shipment_status.id) 
                     LEFT JOIN users ON (inbound_shipments.driver_id = users.id) 
                     LEFT JOIN trailers ON (inbound_shipments.trailer_id = trailers.id) 
                     LEFT JOIN carriers ON (inbound_shipments.carrier_id = carriers.id) 
                     LEFT JOIN doors ON (trailers.id = doors.trailer_id) 
                     LEFT JOIN yard ON (trailers.id = yard.trailer_id)'
                    :
                    'SELECT * 
                     FROM inbound_shipments 
                     INNER JOIN inbound_shipment_status ON (inbound_shipments.status_id = inbound_shipment_status.id) 
                     LEFT JOIN users ON (inbound_shipments.driver_id = users.id) 
                     LEFT JOIN trailers ON (inbound_shipments.trailer_id = trailers.id) 
                     LEFT JOIN doors ON (trailers.id = doors.trailer_id) 
                     LEFT JOIN carriers ON (inbound_shipments.carrier_id = carriers.id) 
                     LEFT JOIN yard ON (trailers.id = yard.trailer_id) 
                     WHERE inbound_shipments.status_id = :status 
                     ORDER BY doors.id ASC'
            );
            $statement->execute(array(':status' => $status));
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetchAll();

            if ($print) {
                echo '<pre>';
                print_r($result);
                echo '</pre>';
            }

            $shipments = array();
            foreach ($result as $row) {
                $driverData = array(
                    'id' => $row['driver_id'],
                    'firstName' => $row['first_name'],
                    'lastName' => $row['last_name']
                );
                $driver = new User();
                $driver->set(json_encode($driverData));

                $shipmentData = array(
                    'timestamp' => $row['timestamp'],
                    'location' => empty($row['trailer_id'][1]) ? 'sb' : $row['id'][5],
                    'trailerId' => $row['trailer_id'][0],
                    'id' => $row['reference'],
                    'orderNumber' => $row['purchase_order'],
                    'palletCount' => $row['pallets'],
                    'dropLocation' => $row['drop_location'],
                    'netWeight' => $row['net_weight'],
                    'status' => $row['status'],
                    'carrier' => $row['carrier']
                );

                $shipment = new Shipment();
                $shipment->set(json_encode($shipmentData, true));
                $shipment->driver = $row['driver_id'] == 0 ? null : $driver;

                array_push($shipments, $shipment);
            }
            return $shipments;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    //$rand->format('Y-m-d H:i:s'), $reference, $order, $pallets, $weight, $trailer, $status, $driver, 2
    function addInboundShipment($timestamp, $reference, $purchaseOrder, $pallets, $weight, $trailerId, $statusId, $carrierId, $driverId)
    {
        try {
            $statement = $this->connection->prepare(
                'INSERT INTO inbound_shipments (`reference`, `purchase_order`, `pallets`, `net_weight`, `trailer_id`, `status_id`, `driver_id`, `carrier_id`, `timestamp`) 
                 VALUES(:reference, :purchase_order, :pallets, :net_weight, :trailer_id, :status_id, :driver_id, :carrier_id, :timestamp)'
            );
            $statement->execute(array(
                ':reference' => $reference,
                ':purchase_order' => $purchaseOrder,
                ':pallets' => $pallets,
                ':net_weight' => $weight,
                ':trailer_id' => $trailerId,
                ':status_id' => $statusId,
                ':driver_id' => $driverId,
                ':carrier_id' => $carrierId,
                ':timestamp' => $timestamp
            ));
            echo 'Shipment added successfully: ' . $reference . '<br />';
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function assignShipment($id, $driverId)
    {
        $shipment = $this->getShipment($id);
        if ($shipment == null) {
            return false;
        }
        try {
            $statements = array(
                array('DELETE FROM `yard` WHERE `trailer_id` = :trailer_id', array(':trailer_id' => $shipment->getTrailerId())),
                array('UPDATE `doors` SET `trailer_id` = 0 WHERE `trailer_id` = :trailer_id', array(':trailer_id' => $shipment->getTrailerId())),
                array('UPDATE `active_drivers` SET `shipment_id` = :shipment_id, `status_id` = 9, `last_update` = :last_update WHERE `id` = :driver_id', array(':shipment_id' => $shipment->getId(), ':driver_id' => $driverId, ':last_update' => date('Y-m-d H:i:s'))),
                array('UPDATE `outbound_shipments` SET `status_id` = 4, `driver_id` = :driver_id WHERE `id` = :shipment_id', array(':shipment_id' => $shipment->getId(), ':driver_id' => $driverId))
            );

            foreach ($statements as $data) {
                echo 'Running query: <strong>' . $data[0] . '</strong><br /><br />';
                //$statement = $this->connection->prepare($data[0]);
                //$statement->execute($data[1]);
            }
            echo 'Successfully ran statement, no errors.';
            $response = array('result' => 'OK', '');
            return json_encode($response);
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
        return json_encode(array('result' => 'ERROR'));
    }
}
