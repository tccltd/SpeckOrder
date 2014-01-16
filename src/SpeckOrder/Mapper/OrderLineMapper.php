<?php

namespace SpeckOrder\Mapper;

use Zend\Db\Sql\Where;
use ZfcBase\Mapper\AbstractDbMapper;
use SpeckOrder\Entity\OrderLine;
use SpeckOrder\Entity\Order;
use Zend\Stdlib\ArrayUtils;

class OrderLineMapper extends AbstractDbMapper
{
    protected $tableName = 'order_line';
    //protected $addressIdField = 'address_id';

    public function persist(OrderLine $orderLine)
    {
        // TODO: How to handle inserting / updating.
        $result = $this->insert($orderLine);


        /*
        if($orderAddress->getAddressId() > 0) {
            $where = new Where;
            $where->equalTo($this->addressIdField, $address->getAddressId());
            $this->update($address, $where);
        } else {
            $result = $this->insert($address);
            $address->setAddressId($result->getGeneratedValue());
        }*/

        return $result;
    }

    public function persistFromOrder(Order $order)
    {
        foreach ($order as $line) {
            $this->persist($line);
        }
        return $this;
    }

    public function fetchAllByOrderId($orderId)
    {
        $select = $this->getSelect()->where(array('order_id' => $orderId));
        return $this->select($select);
    }

    /*
    public function findById($id)
    {
        $select = $this->getSelect();

        $where = new Where;
        $where->equalTo($this->addressIdField, $id);

        $resultSet = $this->select($select->where($where));
        return $resultSet->current();
    }*/


    //public function fetch
}
