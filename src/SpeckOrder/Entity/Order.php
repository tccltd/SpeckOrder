<?php

namespace SpeckOrder\Entity;

use DateTime;
use SpeckOrder\Entity\ItemCollectionTrait;
use Zend\Stdlib\Hydrator\Filter\FilterProviderInterface;
use Zend\Stdlib\Hydrator\Filter\FilterComposite;
use Zend\Stdlib\Hydrator\Filter\MethodMatchFilter;
use SpeckAddress\Entity\AddressInterface;

class Order implements OrderInterface, FilterProviderInterface
{
    use ItemCollectionTrait;

    protected $id;
    protected $refNum;
    protected $status;
    protected $flags = array();
    protected $created;
    protected $billingAddress;
    protected $shippingAddress;
    protected $quoteId;
    protected $customerId;
    protected $currencyCode;

    protected $meta;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getRefNum()
    {
        return $this->refNum;
    }

    public function setRefNum($refNum)
    {
        $this->refNum = $refNum;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function hasFlag($flag)
    {
        return array_key_exists((string)$flag, $this->flags);
    }

    public function setFlag($flag)
    {
        $flag = (string)$flag;
        $this->flags[$flag] = $flag;
        return $this;
    }

    public function unsetFlag($flag)
    {
        if (array_key_exists($flag, $this->flags)) {
            unset($this->flags[$flag]);
        }
        return $this;
    }

    public function getFlags()
    {
        return $this->flags;
    }

    public function setFlags($flags)
    {
        $this->flags = array();
        foreach ($flags as $flag) {
            $this->setFlag($flag);
        }
        return $this;
    }

    /**
     *
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     *
     * @param DateTime $date
     * @return self
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    public function setCreatedNow()
    {
        $this->created = new DateTime();
        return $this;
    }

    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(AddressInterface $address)
    {
        $this->billingAddress = $address;
        return $this;
    }

    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(AddressInterface $address)
    {
        $this->shippingAddress = $address;
        return $this;
    }

    public function getQuoteId()
    {
        return $this->quoteId;
    }

    public function setQuoteId($id)
    {
        $this->quoteId = $id;
        return $this;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }

    public function setCustomerId($id)
    {
        $this->customerId = $id;
        return $this;
    }

    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode($code)
    {
        $this->currencyCode = $code;
        return $this;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function setMeta( $meta)
    {
        $this->meta = $meta;

        // Fluent interface.
        return $this;
    }

    // TODO: Is this all the best way to do this - could it be drier?
    public function getFilter()
    {
        $methods = array(
            'id',
            'refNum',
            'status',
            'created',
            'quoteId',
            'customerId',
            'currencyCode',
            'meta',
        );

        $filter = new FilterComposite();

        foreach ($methods as $method) {
            $filter->addFilter($method, new MethodMatchFilter('get' . ucfirst($method), false));
            //$filter->addFilter($method, new MethodMatchFilter('set' . ucfirst($method), false));
        }
        return $filter;
    }
}
