<?php

class Carrier
{

    public $id;

    public $name;

    public function __construct($id = 0, $name = '')
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function set($json)
    {
        $data = json_decode($json, true);
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
