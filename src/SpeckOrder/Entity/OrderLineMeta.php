<?php

namespace SpeckOrder\Entity;

class OrderLineMeta implements \ArrayAccess
{
    protected $arrayProperties = [
        'delegates' => true,
        'additionalInformation' => true,
        'additionalMetadata' => true,
        'productId' => true,
        'itemNumber' => true,
        'manufacturer' => true,
        'productType' => true,
    ];

    protected $delegates = array();

    protected $productId;

    protected $itemNumber;

    protected $manufacturer;

    protected $productType;

    protected $additionalInformation = array();

    protected $additionalMetadata = array();

    public function __construct(array $config = array())
    {
    }

    /**
     * An array of arrays containing first name, last name and email.
     *
     * @param unknown $delegates
     */
    public function setDelegates($delegates)
    {

    }

    public function addDelegate($firstName, $lastName, $email)
    {
        $this->delegates[] = array(
            'firstName' => $firstName,
            'lastName'  => $lastName,
            'email'     => $email,
        );
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setItemNumber($itemNumber)
    {
        $this->itemNumber = $itemNumber;
        return $this;
    }

    public function getItemNumber()
    {
        return $this->itemNumber;
    }

    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function getProductType()
    {
        return $this->productType;
    }

    public function setProductType($productType)
    {
        $this->productType = $productType;
        return $this;
    }

    public function addAdditionalInformation($title, $information)
    {
         $this->additionalInformation[$title] = $information;
    }

    public function addAdditionalMetadata(AbstractOrderLineAdditionalMeta $metadata)
    {
        $this->additionalMetadata[$metadata->getIdentifier()] = $metadata;
    }

    public function removeAdditionalMeta($key)
    {
        if(isset($this->additionalMetadata[$key])) {
            unset($this->additionalMetadata[$key]);
        }
    }

    public function getAdditionalMeta($key=null) {
        if(isset($key)) {
            return isset($this->additionalMetadata[$key]) ? $this->additionalMetadata[$key] : false;
        } else {
            return $this->additionalMetadata;
        }
    }


    public function offsetExists($offset)
    {
        return isset($this->arrayProperties[$offset]) && $this->arrayProperties[$offset];
    }

    public function offsetGet($offset)
    {
        if($this->offsetExists($offset)) {
            return $this->$offset;
        }
        // Should probably throw an exception...
        return false;
    }

    public function offsetSet($offset, $value)
    {
        // Do nothing yet.
    }

    public function offsetUnset($offset)
    {
        // Do nothing yet.
    }
}
