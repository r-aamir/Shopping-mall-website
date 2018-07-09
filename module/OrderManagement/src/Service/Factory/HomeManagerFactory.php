<?php
namespace OrderManagement\Service\Factory;

use Interop\Container\ContainerInterface;
use OrderManagement\Service\ProductManager;
use OrderManagement\Service\HomeManager;

/**
 * This is the factory class for CategoryManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class HomeManagerFactory
{
    /**
     * This method creates the CategoryManager service and returns its instance. 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $productManager = $container->get(ProductManager::class);
        return new HomeManager($productManager);
    }
}
