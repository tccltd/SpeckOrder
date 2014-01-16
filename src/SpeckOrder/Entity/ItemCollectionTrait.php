<?php

namespace SpeckOrder\Entity;

trait ItemCollectionTrait
{
    protected $items = array();

    protected $iterator;

    public function addItem(OrderLineInterface $item)
    {
        //$this->items[$item->getId()] = $item;
        $this->items[] = $item;

        return $this;
    }

    public function addItems(array $items)
    {
        $this->items = $this->items + $items;

        return $this;
    }

    public function removeItem($itemOrItemId)
    {
        if($itemOrItemId instanceOf OrderLineInterface)
        {
            $itemOrItemId = $itemOrItemId->getId();
        }

        unset($this->items[$itemOrItemId]);

        return $this;
    }

    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function current()
    {
        return $this->getIterator()->current();
    }

    public function next()
    {
        return $this->getIterator()->next();
    }

    public function key()
    {
        return $this->getIterator()->key();
    }

    public function valid()
    {
        return $this->getIterator()->valid();
    }

    public function rewind()
    {
        return $this->getIterator()->rewind();
    }

    public function count()
    {
        return $this->getIterator()->count();
    }

    public function getIterator()
    {
        if (!($this->iterator instanceof \ArrayIterator)) {
            $this->iterator = new \ArrayIterator($this->items);
        }
        return $this->iterator;
    }
}
