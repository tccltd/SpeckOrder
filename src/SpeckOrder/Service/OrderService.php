<?php

namespace SpeckOrder\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SpeckOrder\Entity\OrderInterface as OrderEntityInterface;
use SpeckOrder\Entity\OrderAddress;
use Zend\Stdlib\ArrayUtils;
use SpeckOrder\Entity\OrderMeta;
use SpeckAddress\Entity\Address;
//use SpeckOrder\Entity\InvoiceInterface;
//use SpeckOrder\Entity\OrderInterface;
//use SpeckOrder\Entity\OrderLineInterface;

class OrderService implements ServiceLocatorAwareInterface// ,OrderServiceInterface
{
    protected $serviceLocator;

    protected $orderMapper;

    protected $orderAddressMapper;

    protected $orderLineMapper;

    /**
     * @return serviceLocator
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param $serviceLocator
     * @return self
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

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

//    /**
//     * findById
//     *
//     * @param int $id
//     * @return OrderEntityInterface|null
//     */
//    public function findById($id){}
//
//    /**
//     * fundByCustomerId
//     *
//     * @param mixed $id
//     * @return OrderEntityInterface[]
//     */
//    public function findByCustomerId($id){}
//
//    /**
//     * findByInvoice
//     *
//     * @param InvoiceInterface $invoice
//     * @return OrderEntityInterface|null
//     */
//    public function findByInvoice(InvoiceInterface $invoice){}
//
//    /**
//     * findByOrderLine
//     *
//     * @param OrderLineInterface $orderLine
//     * @return OrderLineInterface|null
//     */
//    public function findByOrderLine(OrderLineInterface $orderLine){}
//
   /**
    * persist
    *
    * @param OrderEntityInterface $order
    * @return OrderServiceInterface
    */
   public function persist(OrderEntityInterface $order)
   {
        $this->getOrderMapper()->persist($order);
        $this->getOrderLineMapper()->persistFromOrder($order);
        return $this;
   }
//
//    /**
//     * persistLine
//     *
//     * @param OrderLineInterface $orderLine
//     * @return OrderServiceInterface
//     */
//    public function persistLine(OrderLineInterface $orderLine){}



    public function getReceiptData($order)
    {
        if(!$order instanceof OrderEntityInterface) {
            $order = $this->getOrder($order);
        }

        $receiptData = [
            'number'     => $order->getId(),
            'payment'    => [
                'type'        => 'CC',
                'description' => 'Credit / Debit Card',
            ],
        	'totalGross' => 0,
        	'totalTax'   => 0,
        	'totalNet'   => 0,
        ];

        $items = [];
        foreach($order as $item) {
            $lineTotalGross = $item->getPrice() * $item->getQuantityInvoiced();
            $lineTotalTax   = $item->getTax() * $item->getQuantityInvoiced();
            $lineTotalNet   = $lineTotalGross + $lineTotalTax;

            $items[] = [
                // TODO: Update price stuff to match new stuff for CartItem entity.
                // TODO: Use new separate functions for recursive descriptions?
                'product'     => trim(strtok($item->getDescription(), '-')),
                'options'     => trim(strtok('')),
                'priceGross'  => $item->getPrice(),
                'tax'         => $item->getTax(),
                'priceNet'    => $item->getPrice() + $item->getTax(),
                'quantity'    => $item->getQuantityInvoiced(),
                'totalGross'  => $lineTotalGross,
                'totalTax'    => $lineTotalTax,
                'totalNet'    => $lineTotalNet,

                'meta'        => $item->getMeta(),
            ];

            // Update order totals.
            $receiptData['totalGross'] += $lineTotalGross;
            $receiptData['totalTax']   += $lineTotalTax;
            $receiptData['totalNet']   += $lineTotalNet;
        }

        $receiptData['items']     = $items;
        $receiptData['itemCount'] = count($items);
        $receiptData['meta']      = $order->getMeta();

        return $receiptData;
    }



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
