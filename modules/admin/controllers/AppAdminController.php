<?php
namespace app\modules\admin\controllers;


use yii\web\Controller;
use yii\filters\AccessControl;


/**
 * Class AppAdminController
 *
 * @package app\modules\admin\controllers
 */
class AppAdminController  extends Controller
{

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