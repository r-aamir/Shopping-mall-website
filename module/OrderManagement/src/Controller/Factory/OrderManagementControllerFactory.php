<?php
namespace OrderManagement\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use OrderManagement\Controller\OrderManagementController;
use OrderManagement\Service\OrderManagementManager;

class OrderManagementControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,	$requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $orderManager = $container->get(OrderManagementManager::class);
		
        return new OrderManagementController($entityManager, $orderManager);
    }
}
