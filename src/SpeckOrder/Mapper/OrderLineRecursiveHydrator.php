<?php

namespace SpeckOrder\Mapper;

use SpeckOrder\Entity\OrderLine;
use SpeckOrder\Entity\OrderLineInterface;

class OrderLineRecursiveHydrator extends OrderLineHydrator
{
    protected $index;

    public function extract(OrderLineInterface $object)
    {
    }

    public function hydrate(array $data, OrderLineInterface $object) {
        $this->index = [];
        $result = [];

        foreach($data as $row) {
            if(!$object) {
                $cloneObject = new OrderLine();
            } else {
                $cloneObject = clone $object;
            }

            $item = $this->hydrateSingle($row, $cloneObject);

            If(!$item->getParentLineId()) {
                $result[] = $item;
            }
        }

        return $result;
    }


    protected function hydrateSingle(array $data, $object)
    {
        $cloneObject = clone $object;

        if(isset($this->index[$data['id']])) {
            $this->index[$data['id']]['hydrated'] = true;
            return $this->index[$data['id']]['object'];
        }

        $item = parent::hydrate($data, $cloneObject);

        $this->index[$data['id']] = [
            'object' => $item,
            'hydrated' => true
        ];

        if($data['parent_line_id']) {
            $parent = $this->getParent($data['parent_line_id'], $object);
            $item->setParent($parent);
            $parent->addItem($item);
        }

        return $item;
    }

    protected function getParent($id, $object=null)
    {
        if(isset($this->index[$id]) && $this->index[$id]['object'] !== null) {
            return $this->index[$id]['object'];
        } else {
            return $this->addPrototype($id, $object);
        }
    }

    protected function addPrototype($id, $object=null)
    {
        if(isset($object)) {
            $cloneObject = clone $object;
        } else {
            $cloneObject = new OrderLine();
        }

        $cloneObject->setId($id);
        $this->index[$id] = [
            'object' => $cloneObject,
            'hydrated' => false
        ];

        return $cloneObject;
    }

}
