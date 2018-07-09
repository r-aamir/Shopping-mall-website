<?php

namespace OrderManagement\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use UserManagement\Entity\User;

/**
 * This controller is responsible for cart management (adding, editing,
 * viewing cart and changing user's password).
 */
class CartController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var
     */
    private $entityManager;

    private $sessionContainer;
    private $orderManager;
    /**
     * Constructor.
     */
    public function __construct($entityManager, $orderManager)
    {
        $this->entityManager = $entityManager;
        $this->orderManager = $orderManager;
        $this->sessionContainer = new Container('UserLogin');

    }

    /**
     * The "view" action displays a page allowing to view cart's details.
     */
    public function viewAction()
    {
        
            // $data_formated = [
            //     'full_name' => 'truong',
            //     'phone_number' => '0999999999',
            //     'email' => 'truong@gmail.com',
            //     'address' => 'haaaaaaa',
            //     'district' => 'Quan 1',
            //     'province' => 'Ho Chi Minh City',
            //     'total_price' => '10000',
            //     'user_id' => 3,
            // ];

        //view

        $cookie = $this->getRequest()->getCookie('Cart', 'default');
        $cart_info = json_decode($cookie["Cart"]);

        $view = new ViewModel([
            'data' => $cart_info,
        ]);
        $this->layout('application/layout');
        return $view;
    }

    public function checkoutAction()
    {
        if ($this->getRequest()->isPost()) {
            // Fill in the form with POST data
            $data = $this->getRequest()->getContent();

            $data = json_decode($data);

            $totalPrice = $data->sub_total + $data->ship_tax;

            $data_formated = [
                'full_name' => $data->ship_add->full_name,
                'phone_number' => $data->ship_add->phone_number,
                'email' => $data->ship_add->email,
                'address' => $data->ship_add->address, 
                'district' => $data->ship_add->dist,
                'province' => $data->ship_add->province,
                'total_price' => $totalPrice,
            ];


            $cookie = $this->getRequest()->getCookie('Cart', 'default');
            $cart_info = json_decode($cookie["Cart"]);

            $sessionContainer = $this->sessionContainer;
            if (isset($sessionContainer->id)) {
                $data_formated['user_id'] = $sessionContainer->id;
            }

            $order = $this->orderManager->addNewOrder($data_formated, $cart_info);

            $hash = $this->orderManager->encryptByOrderId($order->getId());

            $cookie = new \Zend\Http\Header\SetCookie(
                'Cart',
                '',
                strtotime('-1 Year', time()), // -1 year lifetime (negative from now)
                '/'
            );
             $this->getResponse()->getHeaders()->addHeader($cookie); // Xoa cookie

            // response data
            $res = [
                'status' => 'ok',
                'order_id' => $hash,
            ];


            $this->response->setContent(json_encode($res));
            return $this->response;
        } else {

        }

        $view = new ViewModel([

        ]);
        $this->layout('application/layout');
        return $view;
    }

}
