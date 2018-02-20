<?php

namespace SpeckOrder\Mapper;

use SpeckOrder\Entity\OrderInterface as OrderEntityInterface;
use Zend\Db\Sql\Where;
use ZfcBase\Mapper\AbstractDbMapper;

class OrderMapper extends AbstractDbMapper implements OrderInterface
{
    protected $idField = 'id';
    protected $tableName = 'order_order';

    public function persist(OrderEntityInterface $order)
    {
        if($order->getId() > 0) {
            $where = new Where();
            $where->equalTo($this->idField, $order->getId());
            $this->update($order, $where);
        } else {
            $result = $this->insert($order);
            $order->setId($result->getGeneratedValue());
        }


        // Persist address links.




        return $order;
    }

    public function findById($id)
    {
        $select = $this->getSelect();

        $where = new Where;
        $where->equalTo($this->idField, $id);

        $resultSet = $this->select($select->where($where));
        return $resultSet->current();
    }

    public function fetchAll()
    {
        $select = $this->getSelect();

        $resultSet = $this->select($select);
        return $resultSet;
    }
}
