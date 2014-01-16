<?php

namespace SpeckOrder\Entity;

interface OrderLineCollectionInterface
{
    protected $orderLines;

    public function getOrderLines();

    public function getOrderLine($lineNumber);
}