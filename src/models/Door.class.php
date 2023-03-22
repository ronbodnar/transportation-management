<?php

class Door
{

    public $id;

    public $carrier;

    public $trailerNumber;

    public Shipment $shipment;

    public $status;

    public function __construct($id = null, $carrier = null, $trailerNumber = null, $shipment = null, $status = null)
    {
        $this->id = $id;
        $this->carrier = $carrier;
        $this->trailerNumber = $trailerNumber;
        $this->shipment = $shipment;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCarrier()
    {
        return $this->carrier;
    }

    public function getTrailerNumber()
    {
        return $this->trailerNumber;
    }

    public function getShipment()
    {
        return $this->shipment;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function set($json)
    {
        $data = json_decode($json, true);
        foreach ($data as $key => $value) $this->{$key} = $value;
    }
}
