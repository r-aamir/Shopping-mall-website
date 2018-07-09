<?php
/**
 * Created by PhpStorm.
 * User: isling
 * Date: 26/09/2017
 * Time: 21:33
 */

namespace Search;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'search' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/search/[:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\SearchController::class,
                        'action' => 'search',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\SearchController::class => Controller\Factory\SearchControllerFactory::class,
        ],
    ],
    'access_filter' => [
        'controllers' => [
            Controller\SearchController::class => [
                ['actions' => ['search'], 'allow' => '*'],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\ElasticSearchManager::class => Service\Factory\ElasticSearchManagerFactory::class,
            Service\ProductElasticSearchManager::class => Service\Factory\ElasticSearchManagerFactory::class,
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'application/layout' => __DIR__ . '/../view/layout/layout.phtml',
        ],
    ],
];
