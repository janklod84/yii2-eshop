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
     * @throws \yii\web\HttpException
     */
    // [Вариант 1:] получить $id из параметры ЧПУ
     public function actionView($id)
     {
         // [ Вариант 2: ] Получаем id категории через GET parametre
         // $id = Yii::$app->request->get('id');

         // Получаем категория
         $category = Category::findOne($id);

         // обработаем ошибки в случае если не будет категория по текушем id
         if(empty($category))
         {
             throw new \yii\web\HttpException(404, 'такой категории нет.');
         }


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


         // установить метаданных
         $this->setMeta('E-SHOPPER | ' . $category->name, $category->keywords, $category->description);


         // Вид
         return $this->render('view', compact('products', 'pages', 'category'));
     }


     /**
      * Action Search
      *
      *  URL
      *  Ex: http://yii.loc/search?q=сумка
      *  Ex: http://yii.loc/search?q=Блузка
      *
      * @return  string
      */
     public function actionSearch()
     {
         // Получаем q через GET parametre
         $q = trim(Yii::$app->request->get('q'));


         // установить метаданных
         $this->setMeta('E-SHOPPER | Поиск: ' . $q);


         // если не найден
         if(!$q)
         {
             return $this->render('search');
         }

         $query = Product::find()->where(['like', 'name', $q]);

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


         return $this->render('search', compact('products', 'pages', 'q'));

     }
}