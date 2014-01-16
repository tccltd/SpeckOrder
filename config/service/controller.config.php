<?php
/**
 * SpeckOrder Controller Manager Configuration (invokables, services, factories, aliases, initializers,
 * abstract_factories).
 *
 * http://akrabat.com/zend-framework-2/zendservicemanager-configuration-keys/
 *
 * @created 2013-11-21
 */

use SpeckOrder\Controller\OrderController;

return array(
    'factories' => array(
        'speckorder_orderController' => function ($cm) {
            $sm = $cm->getServiceLocator();
            return new OrderController(
                $sm->get('speckcheckoutorder_checkoutService'),
                $sm->get('speckorder_orderService')
            );
        },
    ),
);
