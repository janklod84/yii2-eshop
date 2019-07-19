<?php
namespace app\controllers;


use app\models\Category;
use app\models\Product;
use Yii;


/**
 * Class CategoryController
 *
 * @package app\controllers
 */
class CategoryController extends AppController
{

     /**
      * Action index
      * URL: http://yii.loc [category/index]
      * Страничка отвечает за вывод полуларные товары и всякого прощего ..
      *
      * @return string
     */
     public function actionIndex()
     {
         // получаем все продукты из БД где hit равен 1 (hit = 1) и ограничем вывод на 6 продуктов по странице
         $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();

         // вывод страницу
         return $this->render('index', compact('hits'));
     }


     /**
      * Action index
      * URL: http://yii.loc/category/29 [Exemple]
      *
      *
      * @param int $id
      * @return string
     */
     public function actionView($id)
     {
         // Получаем id категории через GET parametre
         $id = Yii::$app->request->get('id');

         // Получаем все продукты по данному номеру  id категорий category_id
         $products = Product::find()->where(['category_id' => $id])->all();

         // Вид
         return $this->render('view', compact('products'));
     }
}