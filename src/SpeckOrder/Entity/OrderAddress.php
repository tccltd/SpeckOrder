<?php

namespace SpeckOrder\Entity;

use SpeckAddress\Entity\AddressInterface;
class OrderAddress
{
    protected $order;

    protected $address;

    protected $type;

    public function __construct(OrderInterface $order, AddressInterface $address, $type)
    {
        $this->order = $order;
        $this->address = $address;
        $this->type = $type;
    }

    public function getOrderId()
    {
        return $this->order->getId();
    }

    public function getAddressId()
    {
        return $this->address->getAddressId();
    }

    public function getType()
    {
        return $this->type;
    }
}