<?php
/**
 * Created by PhpStorm.
 * User: isling
 * Date: 22/11/2017
 * Time: 23:44
 */

namespace OrderManagement\Service;


use OrderManagement\Service\Interfacef\ProductManagerInterface;
use OrderManagement\Service\Interfacef\HomeManagerInterface;

class HomeManager implements HomeManagerInterface
{
    private $productManager;

    public function __construct(ProductManagerInterface $productManager)
    {
        $this->productManager = $productManager;
    }

    public function getNewProduct($limit)
    {
        // TODO: Implement getNewProduct() method.
        return $this->productManager->getNewProduct($limit);
    }

    public function getBestSellProduct($limit)
    {
        // TODO: Implement getBestSellProduct() method.
    }
}