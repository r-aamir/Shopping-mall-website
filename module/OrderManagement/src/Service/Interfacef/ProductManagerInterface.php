<?php
/**
 * Created by PhpStorm.
 * User: isling
 * Date: 23/11/2017
 * Time: 00:30
 */

namespace OrderManagement\Service\Interfacef;


interface ProductManagerInterface extends \ProductDisplay\Service\Interfacef\ProductManagerInterface
{
    public function getNewProduct($limit);
}