<?php

namespace Search\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Search\Controller\SearchController;
use ProductDisplay\Service\CategoryManager;
use ProductDisplay\Service\ProductManager;
use Search\Service\ElasticSearchManager;
use Search\Service\ProductElasticSearchManager;

/**
 * This is the factory for HomeController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class SearchControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $categoryManager = $container->get(CategoryManager::class);
        $productManager = $container->get(ProductManager::class);
        $elasticSearchManager = $container->get(ElasticSearchManager::class);
        $productElasticSearchManager = $container->get(ProductElasticSearchManager::class);
        $sessionContainer = $container->get('UserLogin');
        // Instantiate the controller and inject dependencies
        return new SearchController(
            $entityManager,
            $categoryManager,
            $productManager,
            $elasticSearchManager,
            $productElasticSearchManager,
            $sessionContainer
        );
    }
}
