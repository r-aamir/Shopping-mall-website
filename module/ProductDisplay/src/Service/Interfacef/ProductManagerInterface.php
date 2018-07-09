<?php
/**
 * Created by PhpStorm.
 * User: isling
 * Date: 23/11/2017
 * Time: 00:30
 */

namespace ProductDisplay\Service\Interfacef;


interface ProductManagerInterface
{
    public function addComment($product, $data);
    public function addReview($product, $data);
    public function deleteComment($data);
}
