<?php
namespace app\components;


use yii\base\Widget;

/**
 * Class MenuWidget
 *
 * @package app\components
 */
class MenuWidget extends Widget
{

       /**
        * @var string $tpl
       */
       public $tpl;


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
            return $this->tpl;
        }
}