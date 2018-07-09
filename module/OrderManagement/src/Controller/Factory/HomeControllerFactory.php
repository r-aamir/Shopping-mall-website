<?php

namespace OrderManagement\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use OrderManagement\Controller\HomeController;
use OrderManagement\Service\HomeManager;

/**
 * This is the factory for HomeController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class HomeControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $homeManager = $container->get(HomeManager::class);
        $sessionContainer = $container->get('UserLogin');
        // Instantiate the controller and inject dependencies
        return new HomeController(
            $entityManager,
            $homeManager,
            $sessionContainer
        );
    }
}
