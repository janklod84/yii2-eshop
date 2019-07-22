<?php
namespace app\components;


use yii\base\Widget;
use app\models\Category;
use Yii;


/**
 * Class MenuWidget
 *
 *  Includes js files
 * /js/jquery.accordion.js
 * /js/jquery.cookie.js
 *
 * Accordion
 * Write inside file /js/main.js
 * $('.catalog').dcAccordion();
 *
 * @package app\components
 */
class MenuWidget extends Widget
{

       /**
        * @var string $tpl [ string template ]
        * @var array $data [ array data ]
        * @var object $model
        * @var array $tree [ created tree array ]
        * @var string $menuHtml
       */
       public $tpl;
       public $model;
       public $data;
       public $tree;
       public $menuHtml;




       /**
        * @return
       */
       public function init()
       {
            parent::init();

            // если не передан парам tpl тогда используем шаблон по умолчанию
            if($this->tpl == null)
            {
                $this->tpl = 'menu';
            }

            $this->tpl .= '.php';
       }

       /**
        * @return string
       */
        public function run()
        {

            # Попытаемся получить меню из кэша
            # чтобы не работать с кешированием в админ составим условие
            if($this->tpl == 'menu.php')
            {
                $menu = Yii::$app->cache->get('menu');

                # Если получили данные с кэша то его возврашаем
                if($menu) { return $menu; }
            }


            /*
               получаем данных ввиде объект
               $this->data = Category::find()->all();
               debug($this->data);
            */

             // получаем данные ввиде массив, indexBy(): указывает какое поле должен совпасть с ключом массива
            $this->data = Category::find()->indexBy('id')->asArray()->all(); // debug($this->data);

            // получаем массив дерьево
            $this->tree = $this->getTree(); // debug($this->tree);

            // получить готовый код html
            $this->menuHtml = $this->getMenuHtml($this->tree);

            if($this->tpl == 'menu.php')
            {
                // установить кэш (set cache)
                Yii::$app->cache->set('menu', $this->menuHtml, 60); // 1 minute
            }

            // вернем готовый HTML код
            return $this->menuHtml;
        }


        /**
         * Get Tree Format
         *
         * @return array
        */
        protected function getTree()
        {
            $tree = [];

            foreach($this->data as $id => &$node)
            {
                 if(!$node['parent_id'])
                 {
                     $tree[$id] = &$node;

                 }else{
                     $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
                 }
            }

            return $tree;
        }


    /**
     * Get Menu Html
     *
     * @param array $tree
     * @param string $tab
     * @return string
     */
        protected function getMenuHtml($tree, $tab = '')
        {
            $str = '';

            foreach($tree as $category)
            {
                $str .= $this->catToTemplate($category, $tab);
            }

            return $str;
        }


        /**
         * @param array $category
         * @param string $tab
         * @return false|string
        */
        protected function catToTemplate($category, $tab)
        {
            ob_start();
            include __DIR__. '/menu_tpl/'. $this->tpl;
            return ob_get_clean();
        }
}