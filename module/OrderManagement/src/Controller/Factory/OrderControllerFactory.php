<?php

namespace OrderManagement\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use OrderManagement\Controller\OrderController;
use OrderManagement\Service\OrderManager;

class OrderControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $sessionContainer = $container->get('UserLogin');
        $orderManager = $container->get(OrderManager::class);
        
        return new OrderController($entityManager, $sessionContainer, $orderManager);
    }
}
