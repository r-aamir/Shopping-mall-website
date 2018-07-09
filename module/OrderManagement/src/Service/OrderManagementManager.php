<?php
namespace OrderManagement\Service;

use OrderManagement\Entity\Order;
use UserManagement\Entity\User;

use Zend\Filter\StaticFilter;

class OrderManagementManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    
    // Constructor is used to inject dependencies into the service.
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function updateStatus($order)
    {
        $currentDate = date('Y-m-d H:i:s');
        if ($order->getStatus() == Order::STATUS_PENDING) {
            $order->setStatus(Order::STATUS_SHIPPING);
            $order->setShipAt($currentDate);
            if ($order->getUser() != null) {
                $user = $order->getUser();
            }
        }elseif ($order->getStatus() == Order::STATUS_SHIPPING) {
            $order->setStatus(Order::STATUS_COMPLETED);
            $order->setCompletedAt($currentDate);
            if ($order->getUser() != null) {
                $user = $order->getUser();
            }
        }

        $this->entityManager->flush();
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }
}
