<?php
namespace UserManagement\Controller\Factory;

use Interop\Container\ContainerInterface;
use UserManagement\Controller\AuthController;
use Zend\ServiceManager\Factory\FactoryInterface;
use UserManagement\Service\AuthManager;
use UserManagement\Service\UserManager;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class AuthControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {   
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $authManager = $container->get(AuthManager::class);
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        $userManager = $container->get(UserManager::class);
        
        return new AuthController($entityManager, $authManager, $authService, $userManager);
    }
}
