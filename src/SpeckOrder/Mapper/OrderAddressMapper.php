<?php

namespace SpeckOrder\Mapper;

use Zend\Db\Sql\Where;
use ZfcBase\Mapper\AbstractDbMapper;
use SpeckOrder\Entity\OrderAddress;

class OrderAddressMapper extends AbstractDbMapper
{
    protected $tableName = 'order_order_address';
    protected $addressIdField = 'address_id';

    public function persist(OrderAddress $orderAddress)
    {
        // TODO: How to handle inserting / updating.
        $result = $this->insert($orderAddress);


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

    /*
    public function findById($id)
    {
        $select = $this->getSelect();

        $where = new Where;
        $where->equalTo($this->addressIdField, $id);

        $resultSet = $this->select($select->where($where));
        return $resultSet->current();
    }*/
}
