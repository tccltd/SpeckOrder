<?php

namespace SpeckOrder\Entity;

use SpeckAddress\Entity\Address as BaseAddress;

class Address extends BaseAddress
{
    protected $firstName;
    protected $middleName;
    protected $lastName;
    protected $company;
    protected $line2;
    protected $line3;
    protected $line4;
    protected $line5;
    protected $phone;

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($name)
    {
        $this->firstName = $name;
        return $this;
    }

    public function getMiddleName()
    {
        return $this->middleName;
    }

    public function setMiddleName($name)
    {
        $this->middleName = $name;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($name)
    {
        $this->lastName = $name;
        return $this;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($companyName)
    {
        $this->company = $companyName;
        return $this;
    }

    public function getLine2()
    {
        return $this->line2;
    }

    public function setLine2($line2)
    {
        $this->line2 = $line2;
        return $this;
    }

    public function getLine3()
    {
        return $this->line3;
    }

    public function setLine3($line3)
    {
        $this->line3 = $line3;
        return $this;
    }

    public function getLine4()
    {
        return $this->line4;
    }

    public function setLine4($line4)
    {
        $this->line4 = $line4;
        return $this;
    }

    public function getLine5()
    {
        return $this->line5;
    }

    public function setLine5($line5)
    {
        $this->line5 = $line5;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
}
