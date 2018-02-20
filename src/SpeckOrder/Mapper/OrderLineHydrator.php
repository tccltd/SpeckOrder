<?php

namespace SpeckOrder\Mapper;

use SpeckOrder\Entity\OrderLineInterface;
use SpeckOrder\Exception\RuntimeException;

class OrderLineHydrator
{
    public function extract(OrderLineInterface $object)
    {
        $result = array(
            'order_id'               => $object->getOrderId(),
            'parent_line_id'         => $object->getParentLineId(),
            'description'            => $object->getDescription(),
            'price'                  => $object->getPrice() ?: 0.00,
            'tax'                    => $object->getTax() ?: 0,
            'quantity_invoiced'      => $object->getQuantityInvoiced() ?: 0,
            'quantity_refunded'      => $object->getQuantityRefunded() ?: 0,
            'quantity_shipped'       => $object->getQuantityShipped() ?: 0,
            'is_invoiceable'         => $object->isInvoiceable() ? 1 : 0,
            'meta'                   => serialize($object->getMeta()),
        );

        if ($object->getId() !== null) {
            $result['id'] = $object->getId();
        }

        return $result;
    }

    public function hydrate(array $data, OrderLineInterface $object)
    {
        $object->setId($data['id'])
            ->setOrderId($data['order_id'])
            ->setParentLineId($data['parent_line_id'])
            ->setDescription($data['description'])
            ->setPrice($data['price'])
            ->setTax($data['tax'])
            ->setQuantityInvoiced($data['quantity_invoiced'])
            ->setQuantityRefunded($data['quantity_refunded'])
            ->setQuantityShipped($data['quantity_shipped'])
            ->setInvoiceable($data['is_invoiceable'] == 0 ? false : true);

        // Unserialize metadata. If this fails, throw an exception.
        if (!($meta = unserialize($data['meta']))) {
            throw new RuntimeException(
                'Failed unserializing meta for OrderLine ' . $data['id'] . ', Order ' . $data['order_id'] . '.'
            );
        };

        // Set the unserialized metadata in the OrderLine.
        $object->setMeta($meta);

        return $object;
    }
}
