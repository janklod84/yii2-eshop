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

          return $this->render('view', compact('product'));
     }
}