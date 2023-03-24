<?php

class Shipment
{

    public $id;

    public $timestamp;

    public $trailerId;

    public $orderNumber;

    public $palletCount;

    public $netWeight;

    public ?User $driver;

    public $facility;

    public $status;

    public $dropLocation;

    public $carrier;

    public function __construct($id = null, $timestamp = null, $trailerId = 0, $carrier = null, $orderNumber = null, $palletCount = null, $netWeight = null, $driver = null, $facility = null, $status = null, $dropLocation = null)
    {
        $this->id = $id;
        $this->timestamp = $timestamp;
        $this->trailerId = $trailerId;
        $this->orderNumber = $orderNumber;
        $this->palletCount = $palletCount;
        $this->netWeight = $netWeight;
        $this->driver = $driver;
        $this->carrier = $carrier;
        $this->facility = $facility;
        $this->status = $status;
        $this->dropLocation = $dropLocation;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getTrailerId()
    {
        return $this->trailerId;
    }

    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    public function getPalletCount()
    {
        return $this->palletCount;
    }

    public function getNetWeight()
    {
        return $this->netWeight;
    }

    public function getGrossWeight()
    {
        return ($this->netWeight + ($this->palletCount * 64));
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function getCarrier() {
        return $this->carrier;
    }

    public function getFacility()
    {
        return str_replace("_", " ", $this->facility);
    }

    public function getStatus($pretty = false)
    {
        return $pretty ? ucwords(strtolower(str_replace("_", "-", $this->status))) : $this->status;
    }

    public function getDropLocation() {
        return $this->dropLocation;
    }

    public function set($json)
    {
        $data = json_decode($json, true);
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function setDriver($json)
    {
        $data = json_decode($json, true);

        $driver = new User();
        $driver->set($data);

        $this->driver = $driver;
    }
}
