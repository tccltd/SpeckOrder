<?php
// TODO: Remove closures in config file as it kills caching. Check elsewhere too!

$config = array(
    'controllers' => array(
        'invokables' => array(
            'order_management'  => 'SpeckOrder\Controller\OrderManagementController',
            'order'             => 'SpeckOrder\Controller\OrderController',
            'process-order'     => 'SpeckOrder\Controller\OrderController',
        ),
    ),
    'view_helpers' => array(
        'shared' => array(
            //'speckCatalogForm' => false,
        ),
        'invokables' => array(
            'speckOrderSearchFilterRadio' => 'SpeckOrder\Form\View\Helper\SearchFilterRadio',
            'speckOrder' => 'SpeckOrder\View\Helper\SpeckOrder',
        ),
    ),
    'service_manager' => array(
        'shared' => array(
            'speckorder_form_ordertags' => false,
        ),
        'invokables' => array(
            'speckorder_service_orderservice' => 'SpeckOrder\Service\OrderService',
            'speckorder_event_placeholder'    => 'SpeckOrder\Event\PlaceHolder',
            'speckorder_event_order'          => 'SpeckOrder\Event\Order',
            'speckorder_form_customersearch'  => 'SpeckOrder\Form\CustomerSearch',
        ),
        'factories' => array(
            'SpeckOrder\Form\Address'         => 'SpeckOrder\Form\AddressFactory',
            'SpeckOrder\Form\EditAddress'     => 'SpeckOrder\Form\EditAddressFactory',
        ),
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../public',
            ),
        ),
    ),
    'navigation' => array(
        'admin' => array(
            'manage-orders' => array(
                'label' => 'Orders',
                'route' => 'zfcadmin/manage-orders',
                'pages' => array(
                    'export-orders' => array(
                        'label' => 'Export',
                        'route' => 'zfcadmin/export-orders'
                    )
                )
            ),
            'manage-customers' => array(
                'label' => 'Customers',
                'route' => 'zfcadmin/manage-customers',
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
return $config;

