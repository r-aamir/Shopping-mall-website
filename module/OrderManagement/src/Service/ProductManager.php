<?php
/**
 * Created by PhpStorm.
 * User: isling
 * Date: 23/11/2017
 * Time: 00:35
 */

namespace OrderManagement\Service;


use OrderManagement\Service\Interfacef\ProductManagerInterface;
use ProductDisplay\Entity\Product;

class ProductManager extends \ProductDisplay\Service\ProductManager
    implements ProductManagerInterface
{
    public function __construct($entityManager)
    {
        parent::__construct($entityManager);
    }

    public function getNewProduct($limit)
    {
        // TODO: Implement getNewProduct() method.
        $newProducts = $this->getEntityManager()->getRepository(Product::class)
            ->findBy(['status' => Product::STATUS_PUBLISHED],
                ['date_created' => 'DESC'], $limit);
        return $newProducts;
    }
}
