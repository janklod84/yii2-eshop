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
          // если товар такой есть $_SESSION['cart'][$product->id]
          if(isset($_SESSION['cart'][$product->id]))
          {
              $_SESSION['cart'][$product->id]['qty'] += $qty;

          }else{
              $_SESSION['cart'][$product->id] = [
                  'qty'   => $qty,
                  'name'  => $product->name,
                  'price' => $product->price,
                  'img'   => $product->img
              ];
          }

          // Add Quantity
          $this->addQantity($qty);

          // Add Price
          $this->addPrice($qty, $product->price);

     }


    /**
     * Add quantity product to session
     *
     * @param $qty
     * @return void
     */
    protected function addQantity($qty)
    {
        if(isset($_SESSION['cart.qty']))
        {
            $_SESSION['cart.qty'] += $qty;

        }else{

            $_SESSION['cart.qty'] = $qty;
        }
    }


    /**
     * Add sum price to session
     *
     * @param $qty
     * @param $price
     * @return void
     */
    protected function addPrice($qty, $price)
    {
        if(isset($_SESSION['cart.sum']))
        {
            $_SESSION['cart.sum'] += $qty * $price;

        }else{

            $_SESSION['cart.sum'] = $qty * $price;
        }
    }
}