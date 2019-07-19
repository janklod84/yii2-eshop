<?php
namespace app\controllers;


use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;


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

         // установить метаданных
         $this->setMeta('E-SHOPPER');


         // вывод страницу
         return $this->render('index', compact('hits'));
     }


     /**
      * Action index
      * URL: http://yii.loc/category/29 [Exemple]
      *
      * Pagination : https://www.yiiframework.com/doc/api/2.0/yii-data-pagination
      *
      * @param int $id
      * @return string
     */
     public function actionView($id)
     {
         // Получаем id категории через GET parametre
         $id = Yii::$app->request->get('id');

         // Получаем все продукты по данному номеру  id категорий category_id
         # $products = Product::find()->where(['category_id' => $id])->all();

         // Погинация
         # https://www.yiiframework.com/doc/api/2.0/yii-data-pagination
         # http://yii.loc/category/29?page=1&per-page=3
         $query = Product::find()->where(['category_id' => $id]);
         $pages = new Pagination([
             'totalCount' => $query->count(), // count products
             'pageSize' => 3, // it's perpage
             'forcePageParam' => false, // отвечает за ЧПУ ссылки например чтобы убрать page=1, per-page=3
             'pageSizeParam' => false
         ]);

         // Получаем все продукты
         $products = $query->offset($pages->offset)
                           ->limit($pages->limit)
                           ->all();


         // Получаем категория
         $category = Category::findOne($id);

         // установить метаданных
         $this->setMeta('E-SHOPPER | ' . $category->name, $category->keywords, $category->description);


         // Вид
         return $this->render('view', compact('products', 'pages', 'category'));
     }
}