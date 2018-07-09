<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use ProductDisplay\Entity\Product;

class SearchController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var
     */
    private $entityManager;
    private $productManager;
    private $categoryManager;

    private $elasticSearchManager;
    private $productElasticSearchManager;
    private $sessionContainer;

    public function __construct(
        $entityManager,
        $categoryManager,
        $productManager,
        $elasticSearchManager,
        $productElasticSearchManager,
        $sessionContainer
    )
    {
        $this->entityManager = $entityManager;
        $this->categoryManager = $categoryManager;
        $this->productManager = $productManager;
        $this->elasticSearchManager = $elasticSearchManager;
        $this->productElasticSearchManager = $productElasticSearchManager;
        $this->sessionContainer = $sessionContainer;
    }

    public function initAction()
    {
        $result = $this->elasticSearchManager->deleteIndex('infinishop');

        $result = $this->elasticSearchManager->createIndex('infinishop');

        $products = $this->entityManager->getRepository(Product::class)->findAll();

        foreach ($products as $p) {
            $this->productElasticSearchManager->updateProduct($p);
        }

        $this->response->setContent(json_encode($result));
        return $this->response;
    }

    public function searchAction()
    {
        $data = $this->getRequest()->getContent();
        $data = json_decode($data);
        $content = $data->content;

        $keywords = explode(' ', $content);

        $colors = [
            'purple',
            'black',
            'blue',
            'green',
            'orange',
            'grey',
            'red',
            'white',
            'yellow',
        ];

        $categories_name = $this->categoryManager->getAllCategories();

        $key_colors = [];
        $key_categories = [];
        $key_other = [];

        foreach ($keywords as $key) {
            if (in_array(strtolower($key), $categories_name)) {
                array_push($key_categories, $key);
            } else if (in_array(strtolower($key), $colors)) {
                array_push($key_colors, $key);
            } else {
                array_push($key_other, $key);
            }
        }

        $query = [
            'bool' => [
                'should' => [
                    [
                        'common' => [
                            'name' => [
                                'query' => $content,
                            ],
                        ],
                    ],
                ]
            ]
        ];

        if (count($key_colors) > 0 || count($key_categories) > 0) {
            $query['bool']['must'] = [];
        }

        if (count($key_colors) > 0) {
            foreach ($key_colors as $color) {
                array_push($query['bool']['must'], [
                    'match' => ['colors' => $color]
                ]);
            }
        }

        if (count($key_categories) > 0) {
            foreach ($key_categories as $category) {
                array_push($query['bool']['must'], [
                    'term' => ['categories' => $category]
                ]);
            }
        }

        if (count($key_other) > 0) {
            $key_other = join(" ", $key_other);
            array_push($query['bool']['should'], [
                'common' => [
                    'keywords' => [
                        'query' => $key_other,
                    ],
                ],
            ]);
            array_push($query['bool']['should'], [
                'common' => [
                    'intro' => [
                        'query' => $key_other,
                        'cutoff_frequency' => 0.001,
                        'low_freq_operator' => 'and'
                    ],
                ],
            ]);
        }

        $params = [
            'index' => 'infinishop',
            'type' => 'product',
            'body' => [
                'query' => $query
            ]
        ];

        $results = $this->elasticSearchManager->getClient()->search($params);

        $this->response->setContent(json_encode($results['hits']['hits']));

        return $this->response;
    }
}
