<?php
namespace app\models;


use yii\db\ActiveRecord;


/**
 * Class Cart
 *
 * @package app\models
 */
class Cart extends ActiveRecord
{

    /**
     * Add to cart
     * @param $product
     * @param int $qty [ отвечает за количество добавление товаров ]
     */
     public function addToCart($product, $qty = 1)
     {

     }
}