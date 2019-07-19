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
      * @return string
     */
     public function actionIndex()
     {
         // получаем все продукты из БД где hit равен 1 (hit = 1) и ограничем вывод на 6 продуктов по странице
         $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();

         // вывод страницу
         return $this->render('index', compact('hits'));
     }
}