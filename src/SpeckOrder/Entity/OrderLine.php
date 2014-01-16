<?php

namespace SpeckOrder\Entity;

use DateTime;
use SpeckCart\Entity\AbstractLineItem;
use SpeckOrder\Exception;
use Zend\Stdlib\Hydrator\Filter\FilterProviderInterface;
use Zend\Stdlib\Hydrator\Filter\FilterComposite;
use Zend\Stdlib\Hydrator\Filter\MethodMatchFilter;
use Zend\Stdlib\Hydrator\Filter\IsFilter;
use Zend\Stdlib\Hydrator\Filter\HasFilter;
use Zend\Stdlib\Hydrator\Filter\GetFilter;
use Zend\Stdlib\Hydrator\Filter\OptionalParametersFilter;

class OrderLine implements OrderLineInterface, FilterProviderInterface //extends AbstractLineItem implements OrderLineInterface
{
    use OrderLineTrait;

    //protected $id = 0;

    protected $order;

    protected $description;

    protected $price;
    
    protected $tax;
    
    protected $meta;

    /**
     * Returns order id. Proxies to order entity if present.
     *
     * @return null|integer
     */
    public function getOrderId()
    {
        if ($this->order) {
            return $this->order->getId();
        }
        return $this->orderId;
    }

    /**
     * Sets order id, if parent entity is not present.
     *
     * @param integer|null $id
     * @return OrderLineInterface Provides fluent interface
     *
     * @throws RuntimeException If order entity is set and have different id
     */
    public function setOrderId($id)
    {
        if ($id === null) {
            $this->order = null;
        }

        if ($this->order && $this->order->getId() != $id) {
            throw new Exception\RuntimeException('Ambiguous assignment. Order entity is set and have different id.');
        }

        $this->orderId = $id;
        return $this;
    }

    /**
     * Get the order entity
     *
     * @return OrderInterface|null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * set order
     *
     * @param OrderInterface $order
     * @return LineItemInterface provides fluent interface
     */
    public function setOrder(OrderInterface $order = null)
    {
        $this->order = $order;
        if ($order === null) {
            $this->orderId = null;
        }
        return $this;
    }




    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        // Fluent interface.
        return $this;
    }
    
    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        // Fluent interface.
        return $this;
    }
    
    public function getTax()
    {
    	return $this->tax;
    }
    
    public function setTax($tax)
    {
    	$this->tax = $tax;
    
    	// Fluent interface.
    	return $this;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function setMeta(OrderLineMeta $meta)
    {
        $this->meta = $meta;

        // Fluent interface.
        return $this;
    }



    public function getFilter()
    {
        $methods = array(
            'id',
            'orderId',
            'description',
            'price',
            'tax',
            'quantityInvoiced',
            'quantityRefunded',
            'quantityShipped',
            'meta',
        );

        $filter = new FilterComposite();

        foreach ($methods as $method) {
            $filter->addFilter($method, new MethodMatchFilter('get' . ucfirst($method), false));
        }
        $filter->addFilter('isInvoiceable', new MethodMatchFilter('isInvoiceable', false));
        return $filter;
    }
}
