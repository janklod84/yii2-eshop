<?php
namespace app\controllers;


use app\models\Product;
use app\models\Cart;
use Yii;


/**
 * Class CartController
 *
 *   Array
 *  (
 *
         [1] => Array (
             [qty] => QTY, [1]
             [name] => NAME,
             [price] => PRICE, [70]
             [img]   => IMG
         ),
         [10] => Array (
            [qty] => QTY, [3]
            [name] => NAME,
            [price] => PRICE, [ 55]
            [img]   => IMG
         ),
         [qty] => QTY
         [sum] => SUM
   )
 *
 * @package app\controllers
 */
class CartController extends AppController
{

    /**
     * Action add
     *
     *  To see file web/js/main.js
     */
     public function actionAdd()
     {
         // получаем id через request
         $id = Yii::$app->request->get('id');

         // получаем product по id
         $product = Product::findOne($id);

         // если нет продукта, то вернем false
         if(empty($product)) { return false; }

         // открыт сессию
         $session = Yii::$app->session;
         $session->open();

         // создадим новую корзину
         $cart = new Cart();
         $cart->addToCart($product);
     }
}