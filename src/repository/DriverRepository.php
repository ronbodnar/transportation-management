<?php

class DriverRepository
{

    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

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
            if (!$result || !count($result)) {
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
            if (!$result || !count($result)) {
                return null;
            }
            if ($print) {
                echo '<pre>';
                print_r($result);
                echo '</pre>';
            }

            require_once 'ShipmentRepository.php';
            $shipmentRepository = new ShipmentRepository($this->connection);

            $results = array();
            foreach ($result as $row) {
                $shipment = $row['shipment_id'] == 0 ? null : $shipmentRepository->getShipment($row['shipment_id']);
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
            if (!$result || !count($result)) {
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
            if (!$result || !count($result)) {
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
            $statement->execute($id == 0 ? array() : array(':driver_id' => $id));
            $statement->setFetchMode(PDO::FETCH_NAMED);
            $result = $statement->fetchAll();
            if (!$result || !count($result)) {
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
}
