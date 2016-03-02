<?php

namespace SpeckOrder\Entity;

use DateTime;
use Zend\Stdlib\Hydrator\Filter\FilterProviderInterface;
use Zend\Stdlib\Hydrator\Filter\FilterComposite;
use Zend\Stdlib\Hydrator\Filter\MethodMatchFilter;
use SpeckAddress\Entity\AddressInterface;

class Order extends AbstractItemCollection implements OrderInterface, FilterProviderInterface
{
    /**
     * @var Integer
     */
    protected $id;

    /**
     * @var String
     */
    protected $refNum;

    /**
     * @var String
     */
    protected $status;

    /**
     * @var array
     */
    protected $flags = array();

    /**
     * @var DateTime
     */
    protected $created;

    /**
     * @var AddressInterface
     */
    protected $billingAddress;

    /**
     * @var AddressInterface
     */
    protected $shippingAddress;

    /**
     * @var Integer
     */
    protected $quoteId;

    /**
     * @var Integer
     */
    protected $customerId;

    /**
     * @var String
     */
    protected $currencyCode;

    /**
     * @var OrderMetaInterface
     */
    protected $meta;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        foreach($this->getItems() as $lineItem) {
            $lineItem->setOrderId($id);
        }

        return $this;
    }

    /**
     * @return String
     */
    public function getRefNum()
    {
        return $this->refNum;
    }

    /**
     * @param string $refNum
     * @return $this
     */
    public function setRefNum($refNum)
    {
        $this->refNum = $refNum;
        return $this;
    }

    /**
     * @return String
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string $flag
     * @return bool
     */
    public function hasFlag($flag)
    {
        return array_key_exists((string)$flag, $this->flags);
    }

    /**
     * @param string $flag
     * @return $this
     */
    public function setFlag($flag)
    {
        $flag = (string)$flag;
        $this->flags[$flag] = $flag;
        return $this;
    }

    /**
     * @param string $flag
     * @return $this
     */
    public function unsetFlag($flag)
    {
        if (array_key_exists($flag, $this->flags)) {
            unset($this->flags[$flag]);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * @param \string[] $flags
     * @return $this
     */
    public function setFlags($flags)
    {
        $this->flags = array();
        foreach ($flags as $flag) {
            $this->setFlag($flag);
        }
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     * @return $this
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCreatedNow()
    {
        $this->created = new DateTime();
        return $this;
    }

    /**
     * @return AddressInterface
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param AddressInterface $address
     * @return $this
     */
    public function setBillingAddress(AddressInterface $address)
    {
        $this->billingAddress = $address;
        return $this;
    }

    /**
     * @return AddressInterface
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param AddressInterface $address
     * @return $this
     */
    public function setShippingAddress(AddressInterface $address)
    {
        $this->shippingAddress = $address;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuoteId()
    {
        return $this->quoteId;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setQuoteId($id)
    {
        $this->quoteId = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setCustomerId($id)
    {
        $this->customerId = $id;
        return $this;
    }

    /**
     * @return String
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param $code
     * @return $this
     */
    public function setCurrencyCode($code)
    {
        $this->currencyCode = $code;
        return $this;
    }

    /**
     * @return OrderMetaInterface
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param OrderMetaInterface $meta
     * @return $this
     */
    public function setMeta(OrderMetaInterface $meta)
    {
        $this->meta = $meta;

        // Fluent interface.
        return $this;
    }

    public function getTotal($includeTax=true, $recursive=true)
    {
        $total = 0;
        foreach($this->getItems() as $item)
        {
            $total += $item->getExtPrice($includeTax, $recursive);
        }

        return $total;
    }

    public function getTaxTotal($recursive=true)
    {
        $total = 0;
        foreach($this->getItems() as $item)
        {
            $total += $item->getExtTax($recursive);
        }

        return $total;
    }

    /**
     * @return FilterComposite
     */
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
