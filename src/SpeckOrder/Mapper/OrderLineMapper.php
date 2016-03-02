<?php

namespace SpeckOrder\Mapper;

use SpeckOrder\Entity\OrderLineInterface;
use SpeckOrder\Service\OrderInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use ZfcBase\Mapper\AbstractDbMapper;
use SpeckOrder\Entity\OrderLine;
use SpeckOrder\Entity\Order as OrderEntity;
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

    public function persistFromOrder(OrderEntity $order)
    {
        foreach ($order as $line) {
            $result = $this->persist($line);
            $line->setId($result->getGeneratedValue());
            $this->persistChildren($line);
        }
        return $this;
    }

    protected function persistChildren(OrderLineInterface $orderLine)
    {
        foreach($orderLine as $line) {
            $line->setParentLineId($orderLine->getId());
            $result = $this->persist($line);
            $line->setId($result->getGeneratedValue());
            $this->persistChildren($line);
        }
    }

    public function fetchAllByOrderId($orderId)
    {
        $hydrator = new OrderLineRecursiveHydrator();
        $adapter = $this->getDbAdapter();
        $statement = $adapter->createStatement();

        $where = new Where();
        $where->equalTo('order_id', $orderId);

        $select = new Select();
        $select->from($this->tableName)
            ->order('parent_line_id ASC')
            ->where($where)
            ->prepareStatement($adapter, $statement);

        $result = $statement->execute();

        $resultSet = new ResultSet(ResultSet::TYPE_ARRAY);
        $resultSet = $resultSet->initialize($result)->toArray();
        $resultSet = $hydrator->hydrate($resultSet, $this->getEntityPrototype());

        return $resultSet;
    }

    public function findById($id)
    {
        $select = $this->getSelect();
        $select->where(['id' => $id]);

        $resultSet = $this->select($select);
        return $resultSet->current();
    }
}
