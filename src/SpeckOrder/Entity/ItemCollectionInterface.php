<?php
namespace SpeckOrder\Entity;

use \Iterator;
use \Countable;

interface ItemCollectionInterface extends Iterator, Countable
{
    public function addItem(OrderLineInterface $item);

    public function addItems(array $items);

    public function removeItem($itemOrItemId);

    public function setItems(array $items);

    public function getItems();
}
