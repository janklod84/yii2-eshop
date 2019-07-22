<?php

namespace app\modules\admin;

use yii\filters\AccessControl;


/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }


    /**
     * только для ['login', 'logout', 'signup']
     * 'only' => ['login', 'logout', 'signup'],
     * мы используем следующее правило
     * 'rules' => [
     *
     * ]
     * @return array
     */
    public function behaviors()
    {
        return [
            // Ограничим доступ
            'access' => [
                'class' => AccessControl::className(),
                'rules'  => [
                    [
                        'allow' => true, // разрешаем все контроллеры
                        'roles' => ['@'], // все ролы с авторизоваными пользователями с такими ролями
                    ]
                ]
            ]
        ];
    }
}
