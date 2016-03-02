<?php

namespace SpeckOrder\Service;

use SpeckOrder\Entity\OrderLineInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use SpeckOrder\Entity\OrderInterface;
use Zend\Stdlib\ArrayUtils;

class OrderService implements
    EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    protected $serviceLocator;

    protected $orderMapper;

    protected $orderAddressMapper;

    protected $orderLineMapper;

    public function getAllFlags()
    {
        //$flags = $this->getMapper()->getAllFlags();
        $flags = array(
            1 => 'International',
            2 => 'Shipped',
            3 => 'Canceled',
            4 => 'Archived',
            5 => 'Fraud',
            6 => 'Paid',
            7 => 'Completed',
            8 => 'Follow Up',
            9 => 'Rma Request',
        );
        return $flags;
    }

    public function getAllTags()
    {
        //$tags = $this->getMapper()->getAllTags();
        $tags = array(
            1 => 'International',
            2 => 'Shipped',
            3 => 'Canceled',
            4 => 'Archived',
            5 => 'Fraud',
            6 => 'Paid',
            7 => 'Completed',
            8 => 'Follow Up',
            9 => 'Rma Request',
        );
        return $tags;
    }

    /**
     * persist
     *
     * @param OrderEntityInterface $order
     * @return OrderServiceInterface
     */
    public function persist(OrderInterface $order)
    {
        $this->getOrderMapper()->persist($order);
        $this->getOrderLineMapper()->persistFromOrder($order);
        $this->getEventManager()->trigger(
            OrderEvent::EVENT_ORDER_PERSIST_POST,
            $this,
            array('order' => $order)
        );


        return $this;
   }

    public function getReceiptData($order)
    {
        if(!$order instanceof OrderInterface) {
            $order = $this->getOrder($order);
        }

        $receiptData = [
            'number'     => $order->getId(),
            'createDate' => $order->getCreated(),
            'customerId' => $order->getCustomerId(),
            'totalGross' => $order->getTotal(false, true),
            'totalTax'   => $order->getTaxTotal(true),
            'totalNet'   => $order->getTotal(true, true),
            'meta'       => $order->getMeta(),
        ];

        $items = [];
        foreach($order as $item) {
            $items[] = $this->getReceiptDataFromLine($item);
        }

        $receiptData['items']     = $items;
        $receiptData['itemCount'] = count($items);

        return $receiptData;
    }

    protected function getReceiptDataFromLine(OrderLineInterface $line)
    {
        $options = [];
        foreach($line->getMeta()->getAdditionalMeta() as $meta) {
            $options[] = $meta->getIdentifier();
        }

        $lineTotalGross = $line->getExtPrice(false, false);
        $lineTotalTax   = $line->getExtTax(false);

        $item = [
            'product'     => $line->getDescription(),
            'options'     => $options,
            'priceGross'  => $line->getPrice(),
            'tax'         => $line->getTax(),
            'priceNet'    => $line->getPrice() + $line->getTax(),
            'quantity'    => $line->getQuantityInvoiced(),
            'totalGross'  => $lineTotalGross,
            'totalTax'    => $lineTotalTax,
            'totalNet'    => $lineTotalGross + $lineTotalTax,
            'meta'        => $line->getMeta(),
        ];

        $children = [];
        foreach($line as $childLine) {
            $children[] = $this->getReceiptDataFromLine($childLine);
        }

        $item['items'] = $children;
        return $item;
    }

    /**
     * @param $id
     * @return OrderInterface
     */
    public function getOrder($id)
    {
        $order = $this->getOrderMapper()->findById($id);
        $order->setItems(ArrayUtils::iteratorToArray($this->getOrderLineMapper()->fetchAllByOrderId($order->getId()), false));

        return $order;
    }

    public function getOrderMapper()
    {
        return $this->orderMapper;
    }

    public function setOrderMapper($orderMapper)
    {
        $this->orderMapper = $orderMapper;

        // Fluent interface.
        return $this;
    }

    public function getOrderAddressMapper()
    {
        return $this->orderAddressMapper;
    }

    public function setOrderAddressMapper($orderAddressMapper)
    {
        $this->orderAddressMapper = $orderAddressMapper;

        // Fluent interface.
        return $this;
    }

    public function getOrderLineMapper()
    {
        return $this->orderLineMapper;
    }

    public function setOrderLineMapper($orderLineMapper)
    {
        $this->orderLineMapper = $orderLineMapper;

        // Fluent interface.
        return $this;
    }
}
