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

class OrderLine extends AbstractItemCollection implements OrderLineInterface, FilterProviderInterface
{
    use OrderLineTrait;

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

        foreach($this->getItems() as $lineItem) {
            $lineItem->setOrderId($id);
        }
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
        } else {
            $this->setOrderId($order->getId());
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
        return $this;
    }
    
    public function getPrice($includeTax=false, $recursive=false)
    {
        $price = $this->price + ($includeTax ? $this->getTax() : 0);

        if ($recursive) {
            foreach ($this->getItems() as $item) {
                $price += $item->getPrice($includeTax, $recursive);
            }
        }
        return $price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getTax($recursive=false)
    {
        $tax = $this->tax;

        if($recursive) {
            foreach($this->getItems() as $item) {
                $tax += $item->getTax($recursive);
            }
        }

        return $tax;
    }
    
    public function setTax($tax)
    {
        $this->tax = $tax;
        return $this;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function setMeta(OrderLineMeta $meta)
    {
        $this->meta = $meta;
        return $this;
    }

    public function getExtPrice($includeTax=true, $recursive=false)
    {
        $price = $this->getPrice();

        if($includeTax) {
            $price += $this->getTax();
        }

        $price = $price * $this->getQuantityInvoiced();

        if($recursive) {
            foreach($this->getItems() as $item) {
                $price += $item->getExtPrice($includeTax, $recursive);
            }
        }

        return $price;
    }

    public function getExtTax($recursive=false)
    {
        $tax = $this->getTax() * $this->getQuantityInvoiced();

        if($recursive) {
            foreach($this->getItems() as $item) {
                $tax += $item->getExtTax($recursive);
            }
        }

        return $tax;
    }

    public function flatten(&$flatItems=[], $flattenTest)
    {
        /* @var $item \SpeckOrder\Entity\OrderLine */
        foreach($this->getItems() as $item) {
            $remove = $item->flatten($flatItems, $flattenTest);

            if($remove) {
                $item->setParent(null)->setParentLineId(null);
                $this->removeItem($item->getId());
            }
        }

        // If the flatten test is true or if the item is a top level item it needs adding
        if($flattenTest($this) || $this->getParentLineId() === null) {
            $flatItems[$this->getId()] = $this;
            return true;
        }

        return false;
    }

    public function __clone()
    {
        $clonedItems = [];

        foreach($this->getItems() as $item) {
            /* @var $item \SpeckOrder\Entity\OrderLine */
            /* @var $cloneItem \SpeckOrder\Entity\OrderLine */
            $cloneItem = clone $item;
            $cloneItem->setParent($this);
            $clonedItems[$item->getId()] = $cloneItem;
        }

        $this->setItems($clonedItems);
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
            'parentLineId',
        );

        $filter = new FilterComposite();

        foreach ($methods as $method) {
            $filter->addFilter($method, new MethodMatchFilter('get' . ucfirst($method), false));
        }
        $filter->addFilter('isInvoiceable', new MethodMatchFilter('isInvoiceable', false));
        return $filter;
    }
}
