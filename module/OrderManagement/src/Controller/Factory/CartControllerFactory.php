<?php

namespace OrderManagement\Controller\Factory;

use OrderManagement\Service\OrderManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use OrderManagement\Controller\CartController;

/**
 * This is the factory for CartController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class CartControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $orderManager = $container->get(OrderManager::class);
        // Instantiate the controller and inject dependencies
        return new CartController($entityManager, $orderManager);
    }
}
