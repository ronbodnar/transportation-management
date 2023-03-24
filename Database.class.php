<?php

require 'User.class.php';
require 'Door.class.php';
require 'Shipment.class.php';
require 'Status.class.php';

date_default_timezone_set('America/Los_Angeles');

class Database
{

    private $connection;

    function __construct()
    {
        try {
            $this->connection = new PDO('mysql:host=' . host . ';dbname=' . database, username, password, array(
                PDO::ATTR_PERSISTENT => true
            ));
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error: ' . $e->getMessage() . '</strong><br />';
        }
    }

    /*
     * 
     */
    function validateLogin($username, $password)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT password FROM users WHERE username = :username'
            );
            $statement->execute(array('username' => $username));
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $result = $statement->fetch();
            $actualPassword = $result['password'];

            return password_verify($password, $actualPassword) == 1 ? true : false;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    /*
     * All functions relating to users
     */
    function getUserId($username)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT id FROM users WHERE username = :username'
            );
            $statement->execute(array('username' => $username));
            $result = $statement->fetch();

            return $result['id'];
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
        return null;
    }

    function getUserData($id, $print = false)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT * FROM users
                 INNER JOIN user_access_roles 
                     ON (users.access_role_id = user_access_roles.id) 
                 LEFT JOIN active_drivers 
                     ON (active_drivers.id = users.id) 
                 LEFT JOIN carriers 
                     ON (carriers.id = active_drivers.carrier_id) 
                 WHERE users.id = :id'
            );
            $statement->execute(array('id' => $id));
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetch();
            if ($statement->rowCount() === 0) {
                return null;
            }
            if ($print) {
                echo '<pre>';
                print_r($result);
                echo '</pre>';
            }
            $data = array(
                'id' => $result['id'][0],
                'email' => $result['email'],
                'username' => $result['username'],
                'password' => $result['password'],
                'accessRole' => $result['role'],
                'firstName' => $result['first_name'],
                'lastName' => $result['last_name'],
                'phoneNumber' => $result['phone_number'],
                'carrier' => $result['carrier']
            );
            $user = new User();
            $user->set(json_encode($data));
            return $user;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }


    function createUser($email, $username, $password, $accessRoleId, $firstName, $lastName, $id = null)
    {
        try {
            $statement = $this->connection->prepare(
                'INSERT INTO users(id, email, username, password, access_role_id, first_name, last_name) 
                 VALUES(:id, :email, :username, :password, :access_role_id, :first_name, :last_name)'
            );
            $statement->execute(array(
                ':id' => $id,
                ':email' => $email,
                ':username' => $username,
                ':password' => $password,
                ':access_role_id' => $accessRoleId,
                ':first_name' => $firstName,
                ':last_name' => $lastName,
            ));
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    //TODO
    function updateUser($user)
    {
        if (!($user instanceof User)) {
            echo 'failed to update user, the specified user is invalid:<br />';
            echo $user . '<br />';
            return;
        }
        try {
            $statement = $this->connection->prepare(
                'UPDATE users SET username=:username, password=:password, email=:email WHERE username=:username'
            );
            $statement->bindParam(':username', $user->username);
            $statement->bindParam(':password', $user->password);
            $statement->bindParam(':email', $user->email);
            $statement->execute();
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    //TODO
    function deleteUser($username)
    {
        try {
            $statement = $this->connection->prepare(
                'DELETE FROM users WHERE username = :username'
            );
            $statement->bindParam(':username', $username);
            $statement->execute();
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    /*
     * All functions relating to drivers
     */
    function getAllDrivers($northernOnly = true, $print = false)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT * FROM users 
                 INNER JOIN user_access_roles ON (users.access_role_id = user_access_roles.id) 
                 WHERE `access_role_id` = 2' . ($northernOnly ? ' AND users.access_role_id = 2 AND users.id < 10000 OR users.id > 10002' : '') . '
                 ORDER BY users.first_name ASC'
            );
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetchAll();
            if ($print) {
                echo '<pre>';
                print_r($result);
                echo '</pre>';
            }
            if ($statement->rowCount() === 0) {
                return null;
            }
            $results = array();
            foreach ($result as $row) {
                $data = array(
                    'id' => $row['id'][0],
                    'email' => $row['email'],
                    'username' => $row['username'],
                    'password' => $row['password'],
                    'accessRole' => $row['role'],
                    'firstName' => $row['first_name'],
                    'lastName' => $row['last_name'],
                    'phoneNumber' => $row['phone_number']
                );
                $user = new User();
                $user->set(json_encode($data));
                array_push($results, $user);
            }
            return $results;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getYardMovesByDriverId($id)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT SUM(`yard_moves`) 
                 FROM `driver_activity_logs` 
                 WHERE `driver_id` = :driver_id'
            );
            $statement->execute(array(':driver_id' => $id));
            $rowCount = $statement->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getActiveDriverCount()
    {
        try {
            $rowCount = $this->connection->query(
                'SELECT COUNT(*) FROM `active_drivers`
                 WHERE active_drivers.carrier_id = 1'
            )->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getActiveDrivers($print = false)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT * FROM `active_drivers` 
                 INNER JOIN users ON (active_drivers.id = users.id) 
                 INNER JOIN `driver_status` ON (active_drivers.status_id = driver_status.id) 
                 WHERE active_drivers.carrier_id = 1'
            );
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetchAll();
            if ($statement->rowCount() === 0) {
                return null;
            }
            if ($print) {
                echo '<pre>';
                print_r($result);
                echo '</pre>';
            }
            $results = array();
            foreach ($result as $row) {
                $shipment = $row['shipment_id'] == 0 ? null : $this->getShipment($row['shipment_id']);
                $data = array(
                    'id' => $row['id'][0],
                    'carrierId' => $row['carrier_id'],
                    'fullName' => $row['first_name'] . ' ' . $row['last_name'],
                    'status' => $row['status'],
                    'startTime' => $row['start_time'],
                    'shipmentId' => $shipment == null ? "-" : $shipment->getId(),
                    'location' => $row['location'],
                    'lastUpdate' => $row['last_update'],
                );
                array_push($results, $data);
            }
            return $results;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getAvailableDriverCount()
    {
        try {
            $rowCount = $this->connection->query(
                'SELECT COUNT(*) FROM `active_drivers`
                 WHERE active_drivers.status_id BETWEEN 1 AND 6 OR active_drivers.carrier_id = 2'
            )->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getAvailableDrivers()
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT * FROM `active_drivers` 
                 INNER JOIN users ON (active_drivers.id = users.id) 
                 INNER JOIN `driver_status` ON (active_drivers.status_id = driver_status.id) 
                 WHERE active_drivers.status_id BETWEEN 1 AND 6 OR active_drivers.carrier_id = 2
                 ORDER BY active_drivers.last_update ASC'
            );
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetchAll();
            if ($statement->rowCount() === 0) {
                return null;
            }
            $results = array();
            foreach ($result as $row) {
                $data = array(
                    'id' => $row['id'][0],
                    'carrierId' => $row['carrier_id'],
                    'fullName' => $row['first_name'] . ' ' . $row['last_name'],
                    'status' => $row['status'],
                    'startTime' => $row['start_time'],
                    'startingLocation' => $row['starting_location'],
                    'lastUpdate' => $row['last_update'],
                );
                array_push($results, $data);
            }
            return $results;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getTrailerIdByDriver($driverId)
    {
        try {
            $statement = $this->connection->prepare('SELECT `trailer_id` FROM `active_drivers` WHERE `id` = :driver_id');
            $statement->execute(array(':driver_id' => $driverId));
            $result = $statement->fetch();
            return $result['trailer_id'];
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
        return -1;
    }

    function getDriverStatus($driverId)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT active_drivers.status_id, driver_status.status FROM `active_drivers` 
                 INNER JOIN driver_status ON (active_drivers.status_id = driver_status.id) 
                 WHERE active_drivers.id = :driver_id'
            );
            $statement->execute(array(':driver_id' => $driverId));
            $result = $statement->fetch();
            return $result['status'];
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
        return -1;
    }

    function updateDriverStatus($driverId, $statusId)
    {
        try {
            $statement = $this->connection->prepare('UPDATE `active_drivers` SET `status_id` = :status_id, `last_update` = :last_update WHERE `id` = :driver_id');
            $statement->execute(array(':driver_id' => $driverId, ':status_id' => $statusId, ':last_update' => date('g:i A')));
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function giveDriverTask($driverId, $statusId, $facility)
    {
        try {
            $this->updateDriverStatus($driverId, $statusId);
            $statement = $this->connection->prepare('UPDATE `active_drivers` SET `location` = :facility WHERE `id` = :driver_id');
            $statement->execute(array(':driver_id' => $driverId, ':facility' => $facility));
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function addDriverActivityLog($logDate, $driverId, $facilityId, $arrivalTime, $instructionsReceived, $instructionsAccepted, $departureTime, $reason, $trailerId, $yardMoves, $flagged)
    {
        try {
            $statement = $this->connection->prepare(
                "INSERT INTO `driver_activity_logs` (`date`, `driver_id`, `facility_id`, `arrival_time`, `instructions_received`, `instructions_accepted`, `departure_time`, `reason`, `trailer_id`, `yard_moves`, `flagged`) 
                 VALUES (:log_date, :driver_id, :facility_id, :arrival_time, :instructions_received, :instructions_accepted, :departure_time, :reason, :trailer_id, :yard_moves, :flagged)"
            );
            $statement->execute(
                array(
                    ':log_date' => $logDate,
                    ':driver_id' => $driverId,
                    ':facility_id' => $facilityId,
                    ':arrival_time' => $arrivalTime,
                    ':instructions_received' => is_null($instructionsReceived) ? NULL : $instructionsReceived,
                    ':instructions_accepted' => is_null($instructionsAccepted) ? NULL : $instructionsAccepted,
                    ':departure_time' => $departureTime,
                    ':reason' => $reason,
                    ':trailer_id' => $trailerId,
                    ':yard_moves' => $yardMoves,
                    ':flagged' => $flagged
                )
            );
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getDriverActivityLogs($id = 0)
    {
        try {
            $statement = $this->connection->prepare(
                ($id == 0 ?
                    'SELECT * FROM `driver_activity_logs` 
                     INNER JOIN users ON (driver_activity_logs.driver_id = users.id) 
                     LEFT JOIN facilities ON (driver_activity_logs.facility_id = facilities.id)'
                    :
                    'SELECT * FROM `driver_activity_logs` 
                     INNER JOIN users ON (driver_activity_logs.driver_id = users.id) 
                     LEFT JOIN facilities ON (driver_activity_logs.facility_id = facilities.id) 
                     WHERE `driver_id` = :driver_id')
            );
            $statement->execute(array(':driver_id' => $id));
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetchAll();
            if ($statement->rowCount() === 0) {
                return null;
            }
            $results = array();
            foreach ($result as $row) {
                $driverData = array(
                    'id' => $row['driver_id'],
                    'firstName' => $row['first_name'],
                    'lastName' => $row['last_name']
                );
                $driver = new User();
                $driver->set(json_encode($driverData));

                $data = array(
                    'date' => $row['date'],
                    'driver' => $driver,
                    'facility' => $row['facility'],
                    'arrivalTime' => $row['arrival_time'],
                    'instructionsReceived' => $row['instructions_received'],
                    'instructionsAccepted' => $row['instructions_accepted'],
                    'departureTime' => $row['departure_time'],
                    'reason' => $row['reason'],
                    'trailerId' => $row['trailer_id'],
                    'yardMoves' => $row['yard_moves'],
                    'flagged' => $row['flagged']
                );
                array_push($results, $data);
            }
            return $results;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getFlaggedActivityLogsByDriverId($id)
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT COUNT(*) 
                 FROM `driver_activity_logs` 
                 WHERE `driver_id` = :driver_id
                 AND `flagged` = 1'
            );
            $statement->execute(array(':driver_id' => $id));
            $rowCount = $statement->fetchColumn();
            return $rowCount;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    function getFlaggedActivityLogs($id = 0)
    {
        try {
            $statement = $this->connection->prepare(
                ($id == 0 ?
                    'SELECT * FROM `driver_activity_logs` 
                     INNER JOIN users ON (driver_activity_logs.driver_id = users.id) 
                     LEFT JOIN facilities ON (driver_activity_logs.facility_id = facilities.id) 
                     WHERE `flagged` = 1'
                    :
                    'SELECT * FROM `driver_activity_logs` 
                     INNER JOIN users ON (driver_activity_logs.driver_id = users.id) 
                     LEFT JOIN facilities ON (driver_activity_logs.facility_id = facilities.id) 
                     WHERE `driver_id` = :driver_id AND `flagged` = 1')
            );
            $statement->execute(array(':driver_id' => $id));
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetchAll();
            if ($statement->rowCount() === 0) {
                return null;
            }
            $results = array();
            foreach ($result as $row) {
                $driverData = array(
                    'id' => $row['driver_id'],
                    'firstName' => $row['first_name'],
                    'lastName' => $row['last_name']
                );
                $driver = new User();
                $driver->set(json_encode($driverData));

                $data = array(
                    'date' => $row['date'],
                    'driver' => $driver,
                    'facility' => $row['facility'],
                    'arrivalTime' => $row['arrival_time'],
                    'instructionsReceived' => $row['instructions_received'],
                    'instructionsAccepted' => $row['instructions_accepted'],
                    'departureTime' => $row['departure_time'],
                    'reason' => $row['reason'],
                    'trailerId' => $row['trailer_id'],
                    'yardMoves' => $row['yard_moves'],
                    'flagged' => $row['flagged']
                );
                array_push($results, $data);
            }
            return $results;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    /*
     * All functions relating to shipments
     */
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
    function getOutboundShipments($status, $print = false)
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
                    'id' => $row['id'][0],
                    'orderNumber' => $row['purchase_order'],
                    'palletCount' => $row['pallets'],
                    'netWeight' => $row['net_weight'],
                    'dropLocation' => $result['drop_location'],
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
                    'dropLocation' => $result['drop_location'],
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

    /*
     * All functions relating to doors/docks
     */
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
                        'facilityId' => $row['facility_id'][0],
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

        $trailerId = $this->getTrailerIdByDriver($driverId);

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

    /*
     * All functions relating to the yard
     */
    function assignYardMove($source, $sourceType, $destination, $destinationType, $driverId)
    {
        try {
            $statements = array(
                //array('DELETE FROM `yard` WHERE `trailer_id` = :trailer_id', array(':trailer_id' => $shipment->getTrailerId())),
                //array('UPDATE `doors` SET `trailer_id` = 0 WHERE `trailer_id` = :trailer_id', array(':trailer_id' => $shipment->getTrailerId())),
                //array('UPDATE `active_drivers` SET `shipment_id` = :shipment_id, `status_id` = 9, `last_update` = :last_update WHERE `id` = :driver_id', array(':shipment_id' => $shipment->getId(), ':driver_id' => $driverId, ':last_update' => date('g:i A'))),
                //array('UPDATE `outbound_shipments` SET `status_id` = 4, `driver_id` = :driver_id WHERE `id` = :shipment_id', array(':shipment_id' => $shipment->getId(), ':driver_id' => $driverId))
            );

            $trailerNumber = 0;
            if (strcmp($sourceType, 'd') === 0) {
                $trailerNumber = $this->getTrailerIdFromDoor($source);
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
                        ':trailer_id' => ($sourceIsDoor ? $this->getTrailerIdFromDoor($source) : $source),
                        ':id' => $destination
                    )
                );
            } else { // Trailer is moving to the yard - add it
                $statement = $this->connection->prepare('INSERT INTO `yard`(`trailer_id`, `dropped_by_id`) VALUES (:trailer_id, :dropped_by_id)');
                $statement->execute(
                    array(
                        ':trailer_id' => $this->getTrailerIdFromDoor($source),
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
            $trailerId = $this->getTrailerIdByDriver($driverId);

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

    /*
     * Retrieves the number of OS&D Claims currently in the database
     */
    function getOSDClaimCount()
    {
        try {
            $rowCount = $this->connection->query('SELECT COUNT(*) FROM osd_claims')->fetchColumn();

            return $rowCount;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    /*
     * Adds a claim to the OS&D Claims database
     */
    function addOSDClaim($date, $tripNumer, $fbNumber, $cases, $type, $received, $driverId)
    {
        try {
            $statement = $this->connection->prepare(
                'INSERT INTO osd_claims(date, driver_id, trip_number, freight_bill_number, cases, damage_type, received, status) 
                 VALUES(:date, :trip_number, :fb_number, :cases, :type, :received, :driver_id, 0)'
            );
            $statement->execute(array(
                ':date' => $date,
                ':trip_number' => $tripNumer,
                ':fb_number' => $fbNumber,
                ':cases' => $cases,
                ':type' => $type,
                ':received' => $received,
                ':driver_id' => $driverId
            ));
            echo 'Claim added successfully';
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    /*
     * Updates the status (Pending / Complete) of an OS&D Claim
     */
    function updateOSDClaimStatus($id, $status)
    {
        try {
            $statement = $this->connection->prepare(
                'UPDATE osd_claims SET status = :status WHERE id = :id'
            );
            $statement->execute(array(
                ':status' => $status,
                ':id' => $id
            ));
            echo 'Updated claim #' . $id . '<br />';
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }

    /*
     * Validates user login details against the database. If no results are found from given user and driver ID, login fails.
     */
    function getAllOSDClaims()
    {
        try {
            $statement = $this->connection->prepare(
                'SELECT * FROM osd_claims'
            );
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo '<strong>PDO MySQL Error:</strong><br /> ' . $e->getMessage() . '<br />';
        }
    }
}
