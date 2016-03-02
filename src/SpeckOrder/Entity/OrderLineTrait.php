<?php

namespace SpeckOrder\Entity;

trait OrderLineTrait
{
    protected $orderId;
    protected $id;
    protected $parentLineId;
    protected $quantityInvoiced;
    protected $quantityRefunded;
    protected $quantityShipped;
    protected $invoiceable;

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getParentLineId()
    {
        return $this->parentLineId;
    }

    public function setParentLineId($parentLineId)
    {
        $this->parentLineId = $parentLineId;
        return $this;
    }

    public function getQuantityInvoiced()
    {
        return $this->quantityInvoiced;
    }

    public function setQuantityInvoiced($quantityInvoiced)
    {
        $this->quantityInvoiced = $quantityInvoiced;
        return $this;
    }

    public function getQuantityRefunded()
    {
        return $this->quantityRefunded;
    }

    public function setQuantityRefunded($quantityRefunded)
    {
        $this->quantityRefunded = $quantityRefunded;
        return $this;
    }

    public function getQuantityShipped()
    {
        return $this->quantityShipped;
    }

    public function setQuantityShipped($quantityShipped)
    {
        $this->quantityShipped = $quantityShipped;
        return $this;
    }

    public function isInvoiceable()
    {
        return $this->invoiceable;
    }

    public function setInvoiceable($invoiceable)
    {
        $this->invoiceable = $invoiceable;
        return $this;
    }
}
