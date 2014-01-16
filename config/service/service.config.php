<?php
/**
 * SpeckOrder Service Manager Configuration (invokables, services, factories, aliases, initializers,
 * abstract_factories).
 *
 * http://akrabat.com/zend-framework-2/zendservicemanager-configuration-keys/
 *
 * @created 2013-11-21
 */

use SpeckOrder\Service\OrderService;
use SpeckOrder\Mapper\Order as OrderMapper;
use SpeckOrder\Entity\Order;
use Zend\Stdlib\Hydrator\ClassMethods;
use TccPayment\Hydrator\Strategy\DateTime;
use TccPayment\Hydrator\Filter\KeyFilter;
use SpeckOrder\Mapper\OrderAddressMapper;
use SpeckOrder\Entity\OrderAddress;
use SpeckOrder\Mapper\OrderLineMapper;
use Zend\Stdlib\Hydrator\Strategy\SerializableStrategy;
use Zend\Serializer\Adapter\PhpSerialize;
use Zend\Stdlib\Hydrator\Filter\MethodMatchFilter;
use Zend\Stdlib\Hydrator\Filter\FilterComposite;
use SpeckOrder\Entity\OrderLine;

return array(
    'aliases' => array(
        'speckorder_dbAdapter' => 'Zend\Db\Adapter\Adapter',
    ),
    'invokables' => array(
    ),
    'factories' => array(
        'speckorder_orderService' => function ($sm) {
            $orderService = new OrderService();
            $orderService->setOrderMapper($sm->get('speckorder_orderMapper'));
            $orderService->setOrderAddressMapper($sm->get('speckorder_orderAddressMapper'));
            $orderService->setOrderLineMapper($sm->get('speckorder_orderLineMapper'));
            return $orderService;
        },
        'speckorder_orderMapper' => function ($sm) {
            $hydrator = new ClassMethods();
            $hydrator->addStrategy('created', new DateTime());
            $hydrator->addStrategy('meta', new SerializableStrategy(new PhpSerialize()));
//             $hydrator->addFilter('keys', new KeyFilter(array(
//                 'id',
//                 'ref_num',
//                 'status',
//                 'created',
//                 'quote_id',
//                 'customer_id',
//                 'currency_code',
//             )));

            $orderMapper = new OrderMapper();
            $orderMapper->setEntityPrototype(new Order());
            $orderMapper->setHydrator($hydrator);
            return $orderMapper;
        },
        'speckorder_orderAddressMapper' => function ($sm) {
            $orderAddressMapper = new OrderAddressMapper();
            $orderAddressMapper->setHydrator(new ClassMethods());
            // TODO: Should be order address but can't because of constructor injection...
            $orderAddressMapper->setEntityPrototype(new stdClass());

            return $orderAddressMapper;
        },

        'speckorder_orderLineMapper' => function ($sm) {
            $hydrator = new ClassMethods();
//            $hydrator->addFilter('getOrder', new MethodMatchFilter('getOrder', FilterComposite::CONDITION_AND));
//                      ->addFilter('getOrder', new MethodMatchFilter('getOrder', FilterComposite::CONDITION_AND));
            $hydrator->addStrategy('meta', new SerializableStrategy(new PhpSerialize()));

            $orderLineMapper = new OrderLineMapper();
            $orderLineMapper->setHydrator($hydrator);
            $orderLineMapper->setEntityPrototype(new OrderLine());

            return $orderLineMapper;
        },


    ),
);
