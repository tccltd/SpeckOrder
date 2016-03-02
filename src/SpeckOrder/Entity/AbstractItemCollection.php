<?php

namespace SpeckOrder\Entity;
use \Iterator;
use \Countable;

abstract class AbstractItemCollection implements ItemCollectionInterface
{
    /**
     * @var array
     */
    protected $items = array();

    /**
     * @var object
     */
    protected $parent = null;

    /**
     * constructor
     *
     * @param array items already in cart
     */
    public function __construct(array $items = array())
    {
        $this->setItems($items);
    }

    public function addItem(OrderLineInterface $item)
    {
        if ($item->getId() == null) {
            $this->items[] = $item;
        } else {
            $this->items[$item->getId()] = $item;
        }
        return $this;
    }

    public function addItems(array $items)
    {
        foreach ($items as $i) {
            $this->addItem($i);
        }

        return $this;
    }

    public function removeItem($itemOrItemId)
    {
        if ($itemOrItemId instanceof OrderLineInterface) {
            $itemOrItemId = $itemOrItemId->getId();
        }
        if (isset($this->items[$itemOrItemId])) {
            unset($this->items[$itemOrItemId]);
        }

        return $this;
    }

    public function setItems(array $items)
    {
        $this->items = array();
        $this->addItems($items);

        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function count()
    {
        return count($this->items);
    }

    public function current()
    {
        return current($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function next()
    {
        next($this->items);
    }

    public function rewind()
    {
        reset($this->items);
    }

    public function valid()
    {
        return current($this->items) !== false;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }
}
