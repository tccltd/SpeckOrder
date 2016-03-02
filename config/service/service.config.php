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
use SpeckOrder\Mapper\OrderMapper;
use SpeckOrder\Entity\Order;
use Zend\Stdlib\Hydrator\ClassMethods;
use TccPayment\Hydrator\Strategy\DateTime;
use TccPayment\Hydrator\Filter\KeyFilter;
use SpeckOrder\Mapper\OrderAddressMapper;
use SpeckOrder\Mapper\OrderLineMapper;
use Zend\Stdlib\Hydrator\Strategy\SerializableStrategy;
use Zend\Serializer\Adapter\PhpSerialize;
use SpeckOrder\Entity\OrderLine;
use SpeckOrder\Hydrator\Strategy\JsonStrategy;

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
        'speckorder_form_ordersearch' => function ($sm) {
            $orderService = $sm->get('speckorder_service_orderservice');
            $opts['tags'] = $orderService->getAllTags();
            $form = new \SpeckOrder\Form\OrderSearch($opts);
            return $form;
        },
        'speckorder_config' => function ($sm) {
            $config = array(
                'view_order_placeholders' => array(
                    //relative to view directory
                    'content_1' => '/speck-order/order-management/order/placeholder/content-1',
                    'content_2' => '/speck-order/order-management/order/placeholder/content-2',
                    'content_3' => '/speck-order/order-management/order/placeholder/content-3',
                ),
                'search_form_fieldset_partials' => array(
                    //relative to view directory
                    'filters' => '/speck-order/order-management/search/partial/search-filters',
                    'text'    => '/speck-order/order-management/search/partial/search-text',
                    'default' => '/speck-order/order-management/search/partial/search-fieldset',
                ),
                'order_actions' => array(
                    'invoice' => array(
                        'type'  => 'uri',
                        'index' => 'invoice',
                        'uri'   => '/manage-order/{order_id}/invoice',
                        'label' => 'View Invoice',
                        'title' => 'Invoice - Payment Due',
                    ),
                    'receipt' => array(
                        'type'  => 'uri',
                        'index' => 'receipt',
                        'label' => 'View Receipt',
                        'title' => 'Payment Not Received',
                    ),
                ),
            );
            $smConfig = $sm->get('Config');
            if(isset($smConfig['speckorder'])) {
                $config = \Zend\Stdlib\ArrayUtils::merge($config, $smConfig['speckorder']);
            }
            return $config;
        },
        'speckorder_form_ordertags' => function ($sm) {
            $orderService = $sm->get('speckorder_service_orderservice');
            $opts['tags'] = $orderService->getAllTags();
            $form = new \SpeckOrder\Form\OrderTags($opts);
            return $form;
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
            $hydrator->addStrategy('meta', new SerializableStrategy(new PhpSerialize()));

            $orderLineMapper = new OrderLineMapper();
            $orderLineMapper->setHydrator($hydrator);
            $orderLineMapper->setEntityPrototype(new OrderLine());

            return $orderLineMapper;
        },


    ),
);
