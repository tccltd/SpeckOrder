<?php

namespace SpeckOrder\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SpeckOrder\Entity\OrderInterface;
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
//     * @return OrderInterface|null
//     */
//    public function findById($id){}
//
//    /**
//     * fundByCustomerId
//     *
//     * @param mixed $id
//     * @return OrderInterface[]
//     */
//    public function findByCustomerId($id){}
//
//    /**
//     * findByInvoice
//     *
//     * @param InvoiceInterface $invoice
//     * @return OrderInterface|null
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
    * @param OrderInterface $order
    * @return OrderServiceInterface
    */
   public function persist(OrderInterface $order)
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
//         $ba = new Address();
//         $ba->setAddressId(2)
//            ->setName('By Fraud')
//            ->setStreetAddress('33 Little Street')
//            ->setCity('Bigtown')
//            ->setProvince('Largeville')
//            ->setPostalCode('BI13 1DH')
//            ->setCountry('United Kingdom');
        
//         $ca = new Address();
//         $ca->setAddressId(2)
//            ->setName('Innocent Man')
//            ->setStreetAddress('33 Mark Street')
//            ->setCity('Contown')
//            ->setProvince('Middleville')
//            ->setPostalCode('MD13 1DH')
//            ->setCountry('United Kingdom');
        
        
//         $temp = new OrderMeta();
//         $temp->setCustomerCompanyName('Awesome Corp')
//              ->setCustomerCompanySize(300)
//              ->setCustomerEmail('mr.awesome@tcc-net.com')
//              ->setCustomerFirstName('Angus')
//              ->setCustomerLastName('Awesome')
//              ->setCustomerJobTitle('Head of Awesome Division')
//              ->setCustomerTelephone('01234 567890')
//              ->setCustomerTitle('Mr.')
//              ->setCustomerAddress($ca);

//         $ba = new Address();
//         $ba->setAddressId(2)
//            ->setName('By Fraud')
//            ->setStreetAddress('33 Little Street')
//            ->setCity('Bigtown')
//            ->setProvince('Largeville')
//            ->setPostalCode('BI13 1DH')
//            ->setCountry('United Kingdom');

//         $temp->setBillingFirstName('Ipay')
//              ->setBillingLastName('Allthebills')
//              ->setBillingTelephone('09876543210')
//              ->setBillingAddress($ba);
        
//         $om = $this->getOrderMapper();
//         $o = $om->findbyId(87);
//         $o->setMeta($temp);
//         $om->persist($o);
//         die();
        
        
        
        if(!$order instanceof OrderInterface) {
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
                'product'     => trim(strtok($item->getDescription(), '-')),
                'description' => trim(strtok('')),
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
