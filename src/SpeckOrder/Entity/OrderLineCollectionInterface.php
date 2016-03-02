<?php

namespace SpeckOrder\Entity;

interface OrderLineCollectionInterface
{
    public function getOrderLines();

    public function getOrderLine($lineNumber);
}