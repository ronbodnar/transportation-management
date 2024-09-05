<?php
class User
{

    public $id, $email, $username, $password, $accessRole, $firstName, $lastName, $phoneNumber, $carrier;

    public function __construct($id = -1, $email = null, $username = null, $password = null, $accessRole = null, $firstName = null, $lastName = null, $phoneNumber = null, $carrier = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->accessRole = $accessRole;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->carrier = $carrier;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getAccessRole()
    {
        return $this->accessRole;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function getCarrier()
    {
        return $this->carrier;
    }

    public function isDriver()
    {
        return $this->accessRole === 'DRIVER';
    }

    public function isWarehouse()
    {
        return $this->accessRole === 'WAREHOUSE';
    }

    public function isAdmin()
    {
        return $this->accessRole === 'ADMIN';
    }

    public function set($json)
    {
        $data = json_decode($json, true);
        foreach ($data as $key => $value) $this->{$key} = $value;
    }

    public function toJson() {}
}
