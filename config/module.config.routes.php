<?php
return [
    'router' => [
        'routes' => [
            'order' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/order',
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'receipt' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/[:id]',
                            'defaults' => [
                                'controller' => 'speckorder_orderController',
                                'action'     => 'receipt',
                            ],
                        ],
                    ],
                    'process' => [
                        'type' => 'Literal',
                        'options' => [
                            'route' => '/process',
                            'defaults' => [
                                'controller' => 'speckorder_orderController',
                                'action'     => 'store',
                            ],
                        ],
                    ],
                ],
            ],
            'zfcadmin' => [
                'child_routes' => [
                    'manage-orders' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/manage-orders',
                            'defaults' => [
                                'controller' => 'speckorder_orderManagementController',
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'export-orders' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/export-orders',
                            'defaults' => [
                                'controller' => 'speckorder_orderManagementController',
                                'action'     => 'export',
                            ],
                        ],
                    ],
                    'manage-customers' => [
                        'type'    => 'Literal',
                        'options' => [
                            'route'    => '/manage-customers',
                            'defaults' => [
                                'controller' => 'order_management',
                                'action'     => 'customers',
                            ],
                        ],
                    ],
                    'order' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/order/:orderId',
                            'defaults' => [
                                'controller' => 'order_management',
                                'action'     => 'order',
                            ],
                        ],
                    ],
                    'manage-order' => [
                        'type'  => 'Literal',
                        'options' => [
                            'route' => '/manage-order',
                            'defaults' => [
                                'controller' => 'order_management',
                            ],
                        ],
                        'may_terminate' => false,
                        'child_routes' => [
                            'edit-address' => [
                                'type'    => 'Segment',
                                'options' => [
                                    'route' => '/edit-address/:orderId',
                                    'defaults' => [
                                        'action' => 'editAddress',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'manage-customer' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/manage-customer/:orderId[/:actionName]',
                            'defaults' => [
                                'controller' => 'order_management',
                                'action'     => 'customer',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
