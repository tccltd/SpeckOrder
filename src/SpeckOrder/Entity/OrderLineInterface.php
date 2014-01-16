<?php

namespace SpeckOrder\Entity;

interface OrderLineInterface
{
    public function getOrderId();

    public function setOrderId($orderId);

    public function getQuantityInvoiced();

    public function setQuantityInvoiced($quantityInvoiced);

    public function getQuantityRefunded();

    public function setQuantityRefunded($quantityRefunded);

    public function getQuantityShipped();

    public function setQuantityShipped($quantityShipped);

    public function isInvoiceable();

    public function setInvoiceable($invoiceable);
}
