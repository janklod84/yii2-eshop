<?php
namespace app\controllers;


use yii\web\Controller;



/**
 * Class AppController
 *
 * @package app\controllers
 */
class AppController extends Controller
{

     /**
      * Set Meta
      *
      * @param null $title
      * @param null $keywords
      * @param null $description
     */
     protected function setMeta($title = null, $keywords = null, $description = null)
     {
         $this->view->title = $title;
         $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => "$keywords"
         ]);
         $this->view->registerMetaTag([
             'name' => 'description',
             'content' => "$description"
         ]);
     }
}