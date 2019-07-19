<?php
namespace app\controllers;


use app\models\Category;
use app\models\Product;
use Yii;


/**
 * Class ProductController
 *
 * @package app\controllers
 */
class ProductController extends AppController
{

    /**
     * Action index
     *
     * @param $id
     * @return string
     */
     public function actionView($id)
     {
          $id = Yii::$app->request->get('id');

          // ленивая загрузка
          $product = Product::findOne($id);

          /*
          // Жадная загрузка
          $product = Product::find()->with('category')
                                   ->where(['id' => $id])
                                   ->limit(1)
                                   ->one();
          */

          // Рекоммендуемые товары
          $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();

          // установить метаданных
          $this->setMeta('E-SHOPPER | ' . $product->name, $product->keywords, $product->description);


          return $this->render('view', compact('product', 'hits'));
     }
}