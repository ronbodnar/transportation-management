<?php

require_once __DIR__ . '/DatabaseConnection.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/DriverRepository.php';
require_once __DIR__ . '/../repository/DockDoorRepository.php';
require_once __DIR__ . '/../repository/ShipmentRepository.php';
require_once __DIR__ . '/../repository/YardRepository.php';

date_default_timezone_set('America/Los_Angeles');

class Database
{
    private $connection;
    public $userRepository;
    public $driverRepository;
    public $dockDoorRepository;
    public $shipmentRepository;
    public $yardRepository;

    public function __construct()
    {
        $this->connection = (new DatabaseConnection())->getConnection();
        $this->userRepository = new UserRepository($this->connection);
        $this->driverRepository = new DriverRepository($this->connection);
        $this->dockDoorRepository = new DockDoorRepository($this->connection);
        $this->shipmentRepository = new ShipmentRepository($this->connection);
        $this->yardRepository = new YardRepository($this->connection);
    }
}
