<?php
namespace app\controllers;


use Yii;
use app\models\Product;
use app\models\Cart;
use app\models\OrderItems;
use app\models\Order;




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


         // получаем qty через request
         $qty = (int) Yii::$app->request->get('qty');

         $qty = !$qty ? 1 : $qty;


         // получаем product по id
         $product = Product::findOne($id);

         // если нет продукта, то вернем false
         if(empty($product)) { return false; }

         // открыт сессию
         $session = Yii::$app->session;
         $session->open();

         // создадим новую корзину
         $cart = new Cart();
         $cart->addToCart($product, $qty);

         /*
         debug($session['cart']);
         debug($session['cart.qty']);
         debug($session['cart.sum'], true);
         */

         // если запрос не Ajax
         if( !Yii::$app->request->isAjax)
         {
             // перенаправим пользователь от туда куда он пришел
             return $this->redirect(Yii::$app->request->referrer);
         }

         // убераем layout
         $this->layout = false;

         // вид
         return $this->render('cart-modal', compact('session'));
     }


     /**
      * Action clear
      *
      *
     */
     public function actionClear()
     {
         // Удаляем items корзины
         $session = Yii::$app->session;
         $session->open();
         $session->remove('cart');
         $session->remove('cart.qty');
         $session->remove('cart.sum');

         // убераем layout
         $this->layout = false;

         // вид
         return $this->render('cart-modal', compact('session'));
     }


     /**
      * Action Del Item
      *
     */
     public function actionDelItem()
     {
         // получаем id через request
         $id = Yii::$app->request->get('id');

         // открыт сессию
         $session = Yii::$app->session;
         $session->open();

         // метод для пересчета корзины
         $cart = new Cart();
         $cart->recalc($id); # пересчет корзины

         // Hide layout
         $this->layout = false;

         // Вид
         return $this->render('cart-modal', compact('session'));
     }


    /**
     * Action Show
     *
     */
     public function actionShow()
     {
         // открыт сессию
         $session = Yii::$app->session;
         $session->open();

         // Hide layout
         $this->layout = false;

         // Вид
         return $this->render('cart-modal', compact('session'));
     }


    /**
     * Action view
     *
     * Отвечает за показа корзину
     */
     public function actionView()
     {
         // Open session
         $session = Yii::$app->session;
         $session->open();
         $this->setMeta('Корзина');
         $order = new Order();

         // принимем ли данные
         if( $order->load(Yii::$app->request->post()))
         {
             /* debug(Yii::$app->request->post(), true); */
             // заполняем поле qty, sum нашего таблицы по скольку они не заполняются в поле $form
             $order->qty = $session['cart.qty'];
             $order->sum = $session['cart.sum'];

             // если заказ сохранен
             // Для больших проектов можно испльзовать Транзакции через ActiveRecord
             if($order->save())
             {
                  $this->saveOrderItems($session['cart'], $order->id);

                  // установливаем Flash сообщение
                  Yii::$app->session->setFlash('success', 'Ваш заказ принят. Менежер вскорое свяжется с Вами');

                  // отправляем письмо клиенту [ сообщение ] о новом заказе [ order : mail/order.php ]
                  Yii::$app->mailer->compose('order', ['session' => $session])
                                   ->setFrom(['username@mail.ru' => 'yii.loc']) // From : "yii.loc"
                                   ->setTo($order->email)
                                   ->setSubject('Заказ')
                                   ->send();

                 // отправляем письмо администратору
                 Yii::$app->mailer->compose('order', ['session' => $session])
                     ->setFrom(['admin@mail.ru' => 'admin']) // From : "admin"
                     ->setTo($order->email)
                     ->setSubject('Заказ')
                     ->send();


                  // очишаем корзину
                  $session->remove('cart');
                  $session->remove('cart.qty');
                  $session->remove('cart.sum');

                  // редирект
                  return $this->refresh();
             }else{

                  Yii::$app->session->setFlash('error', 'Ошибка оформления заказа');
             }
         }
         return $this->render('view', compact('session', 'order'));
     }


    /**
     * Save order items
     *
     * @param $items
     * @param $order_id
     */
     protected function saveOrderItems($items, $order_id)
     {
         // При каждый цыл создаем новый объект OrderItems
         foreach($items as $id => $item)
         {
              $order_items = new OrderItems();
              $order_items->order_id = $order_id;
              $order_items->product_id = $id;
              $order_items->name  = $item['name'];
              $order_items->price = $item['price'];
              $order_items->qty_item  = $item['qty'];
              $order_items->sum_item  = $item['qty'] * $item['price'];
              $order_items->save();
         }
     }
}