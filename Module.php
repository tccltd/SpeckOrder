<?php

namespace SpeckOrder;

use TccAbstractModule\Module\AbstractModule;

class Module extends AbstractModule
{
    public function onBootstrap($e)
    {
        if($e->getRequest() instanceof \Zend\Console\Request){
            return;
        }

        $app = $e->getParam('application');
        $em  = $app->getEventManager()->getSharedManager();

        $placeHolder = $app->getServiceManager()->get('speckorder_event_placeholder');
        $em->attach(
            'SpeckOrder\Controller\OrderManagementController',
            'renderOrderPlaceHolders',
            array($placeHolder, 'orderView')
        );

        $orderActions = $app->getServiceManager()->get('speckorder_event_order');
        $em->attach(
            'SpeckOrder\Controller\OrderManagementController',
            'orderAction.pre',
            array($orderActions, 'orderActions')
        );
    }
}
