<?php

namespace SpeckOrder\Controller;

use SpeckOrder\Service\OrderService;
use Zend\Mvc\Controller\AbstractActionController;
use SpeckOrder\Entity\OrderInterface;

class OrderController extends AbstractActionController
{
    /**
     * Most likely to be SpeckCheckoutOrder\Service\CheckoutService - a bridging module between SpeckCheckout and
     * SpeckOrder.
     *
     * @var \stdClass
     */
    protected $checkoutService;

    /**
     * @var \SpeckOrder\Service\OrderService
     */
    protected $orderService;

    /**
     * @param \stdClass $checkoutService
     * @param \SpeckOrder\Service\OrderService $orderService
     */
    public function __construct($checkoutService, $orderService)
    {
        $this->checkoutService = $checkoutService;
        $this->orderService = $orderService;
    }

    /**
     * Get the current order and store it in the order system.
     */
    public function storeAction()
    {
        // Retrieve the current order from the session for storage.
        $order = $this->getCheckoutService()->getOrder();

        // If an order is not available to be stored, skip storing.
        if($order instanceof OrderInterface) {
            $eventResult = $this->getEventManager()->trigger(
                'storeAction.pre',
                $this,
                array('parameters' => array('order' => $order))
            );

            $this->getOrderService()->persist($order);

            $receiptData = $this->getOrderService()->getReceiptData($order);
            $eventResult = $this->getEventManager()->trigger(
                'storeAction.post',
                $this,
                array('order' => $receiptData)
            );
        }

        $this->redirect()->toRoute('order/receipt', [ 'id' => $order->getId() ]);
    }

    /**
     * Display a receipt for the supplied order id.
     */
    public function receiptAction()
    {
        // Retrieve the order data required to create a receipt using the supplied order id.
        $receiptData = $this->getOrderService()->getReceiptData($this->params()->fromRoute('id'));

        return [
            'order'    => $receiptData,
            'order_id' => $this->params()->fromRoute('id'),
            'user'     => $this->zfcUserAuthentication()->getIdentity(),
        ];
    }

    /**
     * Get the associated CheckoutService.
     *
     * @return stdClass
     */
    public function getCheckoutService()
    {
        return $this->checkoutService;
    }

    /**
     * Get the associated OrderService.
     *
     * @return \SpeckOrder\Service\OrderService
     */
    public function getOrderService()
    {
        return $this->orderService;
    }
}
