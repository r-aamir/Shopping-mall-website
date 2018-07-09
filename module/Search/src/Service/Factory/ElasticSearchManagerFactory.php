<?php

namespace Search\Service\Factory;

use Search\Service\ElasticSearchManager;
use Search\Service\ProductElasticSearchManager;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Elasticsearch;
class ElasticSearchManagerFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = new \Zend\Config\Config(include PATH_CONFIG . '/autoload/local.php');
        $hosts = $config->elasticsearch->hosts->toArray();

        $clientBuilder = Elasticsearch\ClientBuilder::create();

        if ($requestedName == ElasticSearchManager::class) {
            return new ElasticSearchManager($clientBuilder, $hosts);
        } else {
            return new ProductElasticSearchManager($clientBuilder, $hosts);
        }
    }
}
