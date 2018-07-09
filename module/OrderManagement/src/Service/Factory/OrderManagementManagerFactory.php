<?php
namespace OrderManagement\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use OrderManagement\Service\OrderManagementManager;

class OrderManagementManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, 
        $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new OrderManagementManager($entityManager);
    }
}
