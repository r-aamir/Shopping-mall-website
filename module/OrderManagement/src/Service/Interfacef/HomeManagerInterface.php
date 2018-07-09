<?php
/**
 * Created by PhpStorm.
 * User: isling
 * Date: 22/11/2017
 * Time: 23:42
 */
namespace OrderManagement\Service\Interfacef;

interface HomeManagerInterface
{
    public function getNewProduct($limit);
    public function getBestSellProduct($limit);
}